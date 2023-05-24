<?php

namespace App\Services\Course;

use App\Http\Resources\CourseResource;
use App\Http\Resources\EnrollmentResource;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\CourseUser;
use App\Models\Enrollment;
use App\Models\Question;
use App\Services\Media\MediaService;
use App\Traits\Filterable;
use App\Utilities\Data;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Str;

class CourseService
{

    /**
     * The service instance
     * @var MediaService
     */
    protected $mediaService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mediaService = new MediaService();
    }

    /**
     * Get a single resource from the database
     * @param  Course  $course
     * @return CourseResource
     */
    public function get(Course $course)
    {
        return new CourseResource($course);
    }

    /**
     * Get a single resource from the database
     * @param  string  $slug
     * @return CourseResource
     */
    public function getBySlug($slug)
    {
        $course = Course::query()->with(['lessons' => function ($query) {
            $query->select('id', 'course_id', 'is_preview', 'title', 'content_type');
        }])->where('slug', $slug)->firstOrFail();

        return new CourseResource($course);
    }


    /**
     * Get resource index from the database
     * @param $query
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($data)
    {
        $query = Course::query();
        if (!empty($data['search'])) {
            $query = $query->search($data['search']);
        }
        if (!empty($data['filters'])) {
            $this->filter($query, $data['filters']);
        }
        if (!empty($data['sort_by']) && !empty($data['sort'])) {
            $query = $query->orderBy($data['sort_by'], $data['sort']);
        }

        $query = $query->where('published', true);

        return CourseResource::collection($query->paginate(10));
    }

    /**
     * Get resource index from the database
     * @param $query
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function myCourses($data)
    {

        $query = User::where('id', auth()->id())->first();
        $courses = $query->courses();
        return CourseResource::collection($courses->paginate(10));
    }

    public function courseLessons($course, $query)
    {
        $currentLesson = new \stdClass();
        $questions = array();
        // $courses = $query->courses();
        $lessons = $course->lessons()->select('id', 'title', 'sortOrder')->get();
        if (!empty($query['lesson_id'])) {
            $currentLesson = $course->lessons()->where('id', $query['lesson_id'])->first();

            if ($currentLesson->content_type == 'quiz') {
                $questions =  Question::with('options')->where('lesson_id', $currentLesson->id)->get();
            }
        } else {
            $currentLesson = $course->lessons()->orderBy('sortOrder', 'asc')->first();
        }

        $completedLessons = Auth::user()->lessons()->where('completed', 1)->get()->pluck('id')->toArray();

        $prevLesson = $course->lessons()
            ->whereIn('id', $completedLessons)
            ->orderBy('id', 'desc')
            ->first();

        $nextLesson = $course->lessons()
            ->whereNotIn('id', $completedLessons)
            ->orderBy('id', 'asc')
            ->first();

        return [
            'lessons' => $lessons,
            'course' => $course,
            'lesson' => $currentLesson,
            'completed_lessons' => $completedLessons,
            'completed_prev' => !$prevLesson || in_array($prevLesson->id, $completedLessons),
            'next_id' => $nextLesson->id,
            'questions' => $questions
        ];
    }


    /**
     * Creates resource in the database
     * @param  array  $data
     * @return Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public function create(array $data)
    {
        $data = $this->clean($data);
        $data['slug'] = Str::slug($data['title']);
        $data['featured'] = $data['featured'] == 'true' ? 1 : 0;
        $data['user_id'] = auth()->id();

        $preview = Data::take($data, 'preview');

        $record = Course::query()->create($data);
        if (!empty($record)) {
            // Set avatar
            if (!empty($preview)) {
                $preview = $this->mediaService->storePreview($preview, 'public', 'course');
                if (!empty($preview)) {
                    $record->update(['preview' => $preview]);
                }
            }
            return $record->fresh();
        } else {
            return null;
        }
    }


    /**
     * Creates resource in the database
     * @param  array  $data
     * @return Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public function enroll($data)
    {
        $course = Course::findOrFail($data['course_id'])->first();
        $data['user_id'] = auth()->id();

        if ($course) {
            if ($course->price == 0) {
                $record = $this->storeData($data, $course);
                return $record->fresh();
            } else {
                $isVerified =  $this->verifyPayment();
                if ($isVerified) {
                    $record = $this->storeData($data, $course);
                    return $record->fresh();
                } else {
                    return null;
                }
            }
        } else {
            return null;
        }
    }

    private function storeData($data, $course)
    {
        $record =  Enrollment::query()->create($data);
        $ce = CourseUser::query()->create([
            'course_id' => $data['course_id'],
            'user_id' => $data['user_id']
        ]);
        $course_id = $course->id;
        $lessons =  collect($course->lessons->pluck('id')->toArray())->map(function ($entry) use ($course_id) {
            return [
                'course_id' => $course_id,
                'lesson_id' => $entry
            ];
        });

        $cl = Auth::user()->lessons()->sync($lessons);

        return $record;
    }

    public function verifyPayment()
    {
        return true;
    }

    /**
     * Updates resource in the database
     * @param  Course|Model  $course
     * @param  array  $data
     * @return bool
     */
    public function update(Course $course, array $data)
    {
        $data = $this->clean($data);
        return $course->update($data);
    }

    /**
     * Update avatar for the specified resource
     * @param  User  $user
     * @param  array  $data
     * @return bool
     */
    public function updateAvatar(User $user, array $data)
    {

        if (isset($data['avatar']) && $data['avatar']) {
            $entry = $this->mediaService->storeAvatar($data['avatar'], $user);
            if ($entry) {
                $data['avatar_id'] = $entry->id;
                if (!empty($user->avatar)) {
                    $user->avatar->delete(); // Delete old avatar.
                }
            }
            unset($data['avatar']);
        }
        if (!empty($data)) {
            return $user->update($data);
        } else {
            return false;
        }
    }

    /**
     * Deletes resource in the database
     * @param  User|Model  $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->delete();
    }

    /**
     * Clean the data
     * @param  array  $data
     * @return array
     */
    private function clean(array $data)
    {
        foreach ($data as $i => $row) {
            if ('null' === $row) {
                $data[$i] = null;
            }
        }
        return $data;
    }

    /**
     * Filter resources
     * @return void
     */
    private function filter(Builder &$query, $filters)
    {
        $query->filter(Arr::except($filters, ['role']));

        if (!empty($filters['role'])) {
            $roleFilter = Filterable::parseFilter($filters['role']);
            if (!empty($roleFilter)) {
                if (is_array($roleFilter[2])) {
                    $query->whereIs(...$roleFilter[2]);
                } else {
                    $query->whereIs($roleFilter[2]);
                }
            }
        }
    }
}
