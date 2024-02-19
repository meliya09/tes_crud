<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class UserCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Course::query();

    // Filter by id_user if provided
    if ($request->has('id_user')) {
        $query->where('id_user', $request->id_user);
    }

    // Filter by id_course if provided
    if ($request->has('id_course')) {
        $query->where('id_course', $request->id_course);
    }

    // Paginate the results
    $courses = $query->paginate(10);

    return response()->json([
        'data' => $courses
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'id_course' => 'required',
        ]);
    
        $course = Course::create([
            'id_user' => $request->id_user,
            'id_course' => $request->id_course,
            'course' => $request->course,
            'mentor' => $request->mentor,
            'title' => $request->title
        ]);
    
        return response()->json([
            'data' => $course
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, $id)
    {
        $course = Course::findOrFail($id);

        // Check if id_user is provided and matches the course's id_user
        if ($request->has('id_user') && $course->id_user != $request->id_user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        // Check if id_course is provided and matches the course's id_course
        if ($request->has('id_course') && $course->id_course != $request->id_course) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        return response()->json([
            'data' => $course
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $course = Course::findOrFail($id);

    // Check if id_user is provided and matches the course's id_user
    if ($request->has('id_user') && $course->id_user != $request->id_user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Check if id_course is provided and matches the course's id_course
    if ($request->has('id_course') && $course->id_course != $request->id_course) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $course->update([
        'id_user' => $request->id_user ?? $course->id_user,
        'id_course' => $request->id_course ?? $course->id_course,
        'course' => $request->course ?? $course->course,
        'mentor' => $request->mentor ?? $course->mentor,
        'title' => $request->title ?? $course->title
    ]);

    return response()->json([
        'data' => $course
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course = Course::findOrFail($id);

    // Check if id_user is provided and matches the course's id_user
    if ($request->has('id_user') && $course->id_user != $request->id_user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Check if id_course is provided and matches the course's id_course
    if ($request->has('id_course') && $course->id_course != $request->id_course) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $course->delete();

    return response()->json([
        'message' => 'Course deleted'
    ], 204);
    }

    public function getCoursesByTitle()
    {
        $courses = User::join('usercourse as uc', 'u.id', '=', 'uc.id_user')
            ->join('courses as c', 'c.id', '=', 'uc.id_course')
            ->whereIn('c.title', ['S. Kom', 'S.T.'])
            ->select('u.username', 'c.course', 'c.mentor', 'c.title')
            ->get();

        return response()->json($courses);
    }

    public function getCoursesNotInTitle()
    {
        $courses = User::join('usercourse as uc', 'u.id', '=', 'uc.id_user')
            ->join('courses as c', 'c.id', '=', 'uc.id_course')
            ->whereNotIn('c.title', ['S. Kom', 'S.T.'])
            ->select('u.username', 'c.course', 'c.mentor', 'c.title')
            ->get();

        return response()->json($courses);
    }

    public function getCourseStats()
    {
        $courses = DB::table('users as u')
            ->join('usercourse as uc', 'u.id', '=', 'uc.id_user')
            ->join('courses as c', 'c.id', '=', 'uc.id_course')
            ->select('c.course', 'c.mentor', 'c.title', DB::raw('COUNT(u.id) as jumlah_peserta'))
            ->groupBy('c.id')
            ->get();

        return response()->json($courses);
    }

    public function getMentorStats()
    {
        $mentors = DB::table('users as u')
            ->join('usercourse as uc', 'u.id', '=', 'uc.id_user')
            ->join('courses as c', 'c.id', '=', 'uc.id_course')
            ->select('c.mentor', DB::raw('COUNT(u.id) as jumlah_peserta'), DB::raw('(COUNT(u.id) * 2000000) as total_fee'))
            ->groupBy('c.mentor')
            ->get();

        return response()->json($mentors);
    }
    
}
