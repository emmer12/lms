<?php

namespace App\Services\Course;

use App\Http\Resources\MaterialResource;
use App\Http\Resources\QuizResource;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseMaterial;
use App\Services\Media\MediaService;
use App\Traits\Filterable;
use App\Utilities\Data;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Str;

class MaterialService
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
     * Get resource index from the database
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function lessonMaterials($id)
    {
        $query = CourseMaterial::where("lesson_id", $id);
        return MaterialResource::collection($query->get());
    }


    /**
     * Creates resource in the database
     * @param  array  $data
     * @param  number  $lesson_id
     * @param  number  $course_id
     * @return Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public function createMaterial(array $data, $lesson_id, $course_id)
    {
        $data = $this->clean($data);
        $data['lesson_id'] = $lesson_id;
        $data['course_id'] = $course_id;

        $file = Data::take($data, 'file');

        if (!empty($file)) {
            $path = 'course/' . $data['content_type'];
            $file = $this->mediaService->storeFile($file, 'public', $path);

            if (!empty($file)) {
                $data['path'] = $file;
                $data['storage'] = 'local';
            }
        }

        $record = CourseMaterial::query()->create($data);
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
