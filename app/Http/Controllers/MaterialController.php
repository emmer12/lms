<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialRequest;
use App\Models\CourseMaterial;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Services\Course\MaterialService;


class MaterialController extends Controller
{

    /**
     * The service instance
     * @var materialService
     */
    private MaterialService $materialService;


    /**
     * Constructor
     */
    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }


    public function materials(Lesson $lesson)
    {
        return $this->materialService->lessonMaterials($lesson->id);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function storeMaterial(StoreMaterialRequest $request, Lesson $lesson)
    {
        $this->authorize('create', CourseMaterial::class);

        $data = $request->validated();
        if ($material = $this->materialService->createMaterial($data, $lesson->id, $lesson->course_id)) {
            return $this->responseStoreSuccess(['record' => $material]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
