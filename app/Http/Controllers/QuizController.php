<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Quiz;
use App\Services\Course\QuizService;
use Illuminate\Http\Request;

class QuizController extends Controller
{


    /**
     * The service instance
     * @var quizService
     */
    private QuizService $quizService;


    /**
     * Constructor
     */
    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * @param  StoreQuestionRequest  $request
     * @param  Lesson  $lesson
     * Store a newly created resource in storage.
     */
    public function storeQuestion(StoreQuestionRequest $request, Lesson $lesson)
    {
        $this->authorize('create', Lesson::class);

        $data = $request->validated();
        if ($lesson = $this->quizService->createQuestion($data, $lesson->id, $lesson->course_id)) {
            return $this->responseStoreSuccess(['record' => $lesson]);
        } else {
            return $this->responseUpdateFail();
        }
    }


    public function questions(Lesson $lesson)
    {
        return $this->quizService->lessonQuestions($lesson->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        //
    }


    public function getLQuiz($lesson_id)
    {
        return $this->quizService->lessonQuiz($lesson_id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function start(Request $request)
    {
        if ($quiz = $this->quizService->start($request->all())) {
            return $this->responseStoreSuccess(['record' => $quiz]);
        } else {
            return $this->responseUpdateFail();
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function submit(Request $request)
    {
        if ($quizLog = $this->quizService->submit($request->all())) {
            return $this->responseStoreSuccess(['record' => $quizLog]);
        } else {
            return $this->responseUpdateFail();
        }
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
