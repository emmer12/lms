<?php

namespace App\Services\Page;

use App\Http\Resources\CourseResource;
use App\Models\Course;

class PageService
{

    /**
     * Get resource index from the database
     * @param $query
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|array
     */
    public function index()
    {
        $courses = Course::withCount('lessons', 'users')->orderBy('created_at', 'desc')->take(3)->get();
        $featuredCourse = Course::withCount('lessons', 'users')->where('featured', 1)->first();

        return [
            'courses' => $courses,
            'featured' => $featuredCourse
        ];
    }

    public function dashboardData()
    {

        // $courses = Course::withCount('lessons', 'users')->where('user_id',)->orderBy('created_at', 'desc')->take(2)->get();

        $courses = auth()->user()->courses;


        return [
            'courses' => $courses,
            'certificate' => 4
        ];
    }
}
