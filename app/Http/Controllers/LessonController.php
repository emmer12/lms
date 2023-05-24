<?php

namespace App\Http\Controllers;

use App\Constants\AppConstants;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Services\Course\LessonService;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    /**
     * The service instance
     * @var LessonService
     */
    private LessonService $lessonService;

    /**
     * Constructor
     */
    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }



    /**
     * @param Course $course
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        return $this->lessonService->index($course->id);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLessonRequest  $request
     *
     *  @return LessonResource|JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreLessonRequest $request, Course $course)
    {
        $this->authorize('create', Lesson::class);

        $data = $request->validated();
        if ($lesson = $this->lessonService->create($data, $course->id)) {
            return $this->responseStoreSuccess(['record' => $lesson]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Display the specified resource.
     * @param Lesson $lesson
     */
    public function show(Lesson $lesson)
    {
        return $this->lessonService->get($lesson);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Get lessons form data
     */
    public function formData()
    {
        $data['content_type'] = collect(AppConstants::CONTENT_TYPE)->values();
        return $this->responseStoreSuccess(['formData' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}
