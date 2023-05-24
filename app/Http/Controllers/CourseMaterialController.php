<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Models\CourseMaterial;
use App\Services\Course\CourseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseMaterialController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EnrollmentRequest  $request
     *
     *  @return EnrollmentResource|JsonResponse
     * @throws AuthorizationException
     */

    // public function store(EnrollmentRequest $request)
    // {
    //     $data = $request->validated();
    //     if ($record = $this->courseService->enroll($data)) {
    //         return $this->responseStoreSuccess(['record' => $record]);
    //     } else {
    //         return $this->responseUpdateFail();
    //     }
    // }

    /**
     * Display the specified resource.
     */
    public function show(CourseMaterial $courseMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseMaterial $courseMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseMaterial $courseMaterial)
    {
        //
    }
}
