<?php

namespace App\Http\Resources;

use App\Models\CourseUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->resource->toArray();
        $data['created_at'] = !empty($this->resource->created_at) ? $this->resource->created_at->format("d/m/Y") : null;
        $data['course_log'] = CourseUser::where('user_id', auth()->id())->where('course_id', $this->resource->id)->first();
        return $data;
    }
}
