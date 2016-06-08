<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\CourseStoreRequest;
use Illuminate\Http\CourseUpdateRequest;

class CourseController extends Controller
{
    /**
     * List of relationships to load.
     *
     * @var array
     */
    private static $relationships = ['campus'];

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return Course::with(self::$relationships)->paginate($request->input('items', 30));
    }

    /**
     * Display the specified resource.
     *
     * @param Course $course
     * @return Response
     */
    public function show(Course $course)
    {
        return $course->load(self::$relationships);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CourseStoreRequest $request)
    {
        $courseArray = $request->only(['title', 'description', 'campus_id', 'school']);

        $course = Course::forceCreate($courseArray);

        return $this->response->created(null, $course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Course $course
     * @return Response
     */
    public function update(CourseUpdateRequest $request, Course $course)
    {
        $courseArray = $request->only(['title', 'description', 'campus_id', 'school']);

        $course->update($courseArray);

        return $this->response->accepted(null, $course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     * @return Response
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return $this->response->noContent();
    }
}
