<?php

namespace App\Services\Course;

use App\Http\Resources\LessonResource;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Services\Media\MediaService;
use App\Traits\Filterable;
use App\Utilities\Data;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Str;

class LessonService
{

    /**
     * The service instance
     * @var MediaService
     */
    protected $mediaService;

    /**
     * The service instance
     * @var CourseService
     */
    protected $courseService;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mediaService = new MediaService();
        $this->courseService = new CourseService();
    }

    /**
     * Get a single resource from the database
     * @param  Lesson  $lesson
     * @return LessonResource
     */
    public function get(Lesson $lesson)
    {
        return new LessonResource($lesson);
    }

    /**
     * Get resource index from the database
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($id)
    {
        $query = Lesson::where("course_id", $id);
        return LessonResource::collection($query->get());
    }

    /**
     * Creates resource in the database
     * @param  array  $data
     * @param  int  $course_id
     * @return Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public function create(array $data, $course_id)
    {
        $data = $this->clean($data);
        $data['course_id'] = $course_id;
        $preview = Data::take($data, 'preview');

        $record = Lesson::query()->create($data);
        if (!empty($record)) {
            // Set preview
            if (!empty($preview)) {
                $preview = $this->mediaService->storePreview($preview, 'public', 'lesson');
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
