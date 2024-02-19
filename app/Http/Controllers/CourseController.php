<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::paginate(10);
        return response()->json([
            'data' => $courses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $course = Course::create([
            'id' => $request->id,
            'course' => $request->course,
            'mentor'=> $request->mentor,
            'title'=> $request->title
            ]);
            return response()->json([
                'data'=> $course
                ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return response()->json([
            'data'=> $course
            ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $course->id = $request->id;
        $course->course = $request->course;
        $course->mentor = $request->mentor;
        $course->title = $request->title;
        $course->save();
        return response()->json([
            'data'=> $course
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json([
            'message' => 'course deleted'
            ], 204);
    }

   
    
}
