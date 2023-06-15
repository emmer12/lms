<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Services\Course\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    /**
     * The service instance
     * @var CourseService
     */
    private CourseService $courseService;


    /**
     * Constructor
     */
    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }


    /**
     * Display a listing of the resource.
     */
    public function getAll(Request $request)
    {
        $this->authorize('list', Course::class);
        return $this->courseService->index($request->all(), true);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $this->authorize('list', User::class);
        return $this->courseService->index($request->all());
    }

    public function myCourses(Request $request)
    {
        return $this->courseService->myCourses($request->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', Course::class);
        $input = $request->validated();

        $record = $this->courseService->create($input);
        if (!is_null($record)) {
            return $this->responseStoreSuccess(['record' => $record]);
        } else {
            return $this->responseStoreFail();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $model = $this->courseService->get($course);
        return $this->responseDataSuccess(['model' => $model]);
    }
    public function showBySlug($slug)
    {
        $course = $this->courseService->getBySlug($slug);
        return $this->responseDataSuccess(['course' => $course, 'related_course' => []]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCourseRequest  $request
     * @param  Course $course
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorize('edit', Course::class);
        $data = $request->validated();
        if ($this->courseService->update($course, $data)) {
            return $this->responseUpdateSuccess(['record' => $course->fresh()]);
        } else {
            return $this->responseUpdateFail();
        }
    }


    public function edit(Course $Course)
    {
        $this->authorize('edit', Course::class);

        return $this->show($Course);
    }


    public function courseLessons(Course $course, Request $request)
    {
        $model = $this->courseService->courseLessons($course, $request->all());
        return $this->responseDataSuccess($model);
    }

    public function certificate(Course $course)
    {
        $pdf = $this->courseService->certificate($course);
        return  $pdf;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
