<?php

namespace App\Services\Course;

use App\Http\Resources\CourseResource;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuizResource;
use App\Models\User;
use App\Models\Course;
use App\Models\Question;
use App\Models\Question_Option;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\QuizLog;
use App\Services\Course\LessonService;
use App\Traits\Filterable;
use App\Utilities\Data;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Str;

class QuizService
{

    /**
     * The service instance
     * @var LessonService
     */
    protected $lessonService;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lessonService = new LessonService();
    }



    /**
     * Get resource index from the database
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function lessonQuestions($id)
    {
        $query = Question::where("lesson_id", $id);
        return QuestionResource::collection($query->get());
    }


    /**
     * Creates resource in the database
     * @param  array  $data
     * @param  number  $lesson_id
     * @param  number  $course_id
     * @return Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public function createQuestion(array $data, $lesson_id, $course_id)
    {
        $data = $this->clean($data);
        $data['createdBy'] = auth()->id();
        $data['lesson_id'] = $lesson_id;
        $data['course_id'] = $course_id;
        $record = Question::query()->create(Arr::except($data, 'options'));

        foreach (json_decode($data['options']) as $option) {
            QuestionOption::create([
                'question_id'   => $record->id,
                'question_tag'  => $option->question_tag,
                'description'   => $option->description,
                'is_correct'    => $option->is_correct->value,
            ]);
        }

        return $record->fresh();
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
     * Create Quiz
     * @param  array  $data
     * @return bool
     */
    public function start($data)
    {
        $quiz = Quiz::with('log')->where('lesson_id', $data['lesson_id'])->where('user_id', auth()->id())->first();

        if ($quiz) {
            return
                $quiz;
        } else {
            $week = date('W-Y');
            $newQuiz = Quiz::query()->create([
                "course_id" => $data['course_id'],
                "lesson_id" => $data['lesson_id'],
                "quiz_week" => $week,
                "user_id" => auth()->id()
            ]);

            return
                $newQuiz->refresh();
        }
    }


    /**
     * Create Quiz
     * @param  array  $data
     * @return bool|array
     */
    public function submit($data)
    {
        $quiz = Quiz::where('id', $data['quiz_id'])->firstOrFail();
        $questions = Question::with('options')->where('lesson_id', $quiz->lesson_id);
        $questions_ids = $questions->pluck('id')->toArray();

        $attempts = json_decode($data['answers'], true);
        $num_attempt = 0;
        $num_correct = 0;


        $question_answers = QuestionOption::whereIn('question_id', $questions_ids)
            ->where('is_correct', 1)
            ->pluck('question_tag', 'question_id')
            ->toArray();



        foreach ($attempts as $attempt) {
            if ($attempt['choice']) {
                $num_attempt++;
            }

            $isCorrect = (in_array($attempt['question'], $questions_ids)) && $attempt['choice'] == $question_answers[$attempt['question']];

            if ($isCorrect) {
                $num_correct++;
            }
        }


        $questions = collect($attempts)->map(function ($question) {
            return $question['question'];
        });

        $answers = collect($attempts)->map(function ($question) {
            return $question['choice'];
        });

        $week = date('W-Y');
        $newQuizLog = QuizLog::query()->create([
            "quiz_week" => $week,
            "quiz_id" => $quiz->id,
            "questions" => $questions,
            "answers" => $answers,
            "user_id" => auth()->id(),
            "num_attempted" => $num_attempt,
            "course_id" => $quiz->course_id,
            "total_questions"
            => count($questions_ids),
            "num_correct" => $num_correct,
            "score" => $num_correct,
            "exam_date" => time()
        ]);

        $percent_score = round(($num_correct / count($questions_ids)) * 100);

        if ($percent_score >= config('app.pass_percent')) {
            $this->lessonService->completed($quiz->lesson_id);
        }


        return
            $newQuizLog->refresh(); // ;
    }



    public function lessonQuiz($lesson_id)
    {
        $quiz = Quiz::with(['log' => function ($query) {
            $query->where('user_id', auth()->id());
        }])->where('lesson_id', $lesson_id)->where('user_id', auth()->id())->firstOrFail();
        return new QuizResource($quiz);
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
