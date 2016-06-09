<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\DB;


class UserCourseController extends Controller
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
     *
     * @return Response
     */
    public function index(User $user)
    {
        return $user->courses()->with(self::$relationships)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param Course $course
     *
     * @return Response
     */
    public function show(User $user, $user_course_id)
    {
        // On utilise l'id du pivot pour retrouver la bonne relation
        $course = $user->courses()->where('user_course.id', $user_course_id)->get();

        return $course->load(self::$relationships);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request, User $user)
    {
        $fields = ['id', 'room', 'from', 'to'];
        // Regarde si on nous envoie un objet unique ou une collection
        if ($request->has('id')) {
            $collection = [$request->intersect($fields)];
        } else {
            $collection = [];
            foreach ($request->all() as $item) {
                $collection[] = array_filter($item, function ($field) use ($fields) {
                    return in_array($field, $fields);
                }, ARRAY_FILTER_USE_KEY);
            }
        }

        foreach ($collection as $course) {
            $pivot = [
                'room' => $course['room'],
                'from' => $course['from'],
                'to'   => $course['to'],
            ];
            $user->courses()->attach($course['id'], $pivot);
        }

        return $this->response->created(null, $user->courses);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     *
     * @return Response
     */
    public function destroy($user_id, $user_course_id)
    {
        // On utilise l'id du pivot pour retrouver la bonne relation
        DB::table('user_course')->where('user_id', $user_id)->delete($user_course_id);

        return $this->response->noContent();
    }
}
