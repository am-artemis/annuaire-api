<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Residence;
use Illuminate\Http\Request;

class UserSocialController extends Controller
{
    /**
     * List of relationships to load.
     *
     * @var array
     */
    private static $relationships = [];

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(User $user)
    {
        return $user->socials;
    }

    /**
     * Display the specified resource.
     *
     * @param Residence $residence
     *
     * @return Response
     */
    public function show(User $user, $social_id)
    {
        return $user->socials()->find($social_id);
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
        $fields = ['id', 'url'];
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

        foreach ($collection as $social) {
            $pivot = [
                'url' => $social['url'],
            ];
            $user->socials()->detach($social['id']);
            $user->socials()->attach($social['id'], $pivot);
        }

        return $this->response->created(null, $user->socials);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Residence $residence
     *
     * @return Response
     */
    public function destroy(User $user, $social_id)
    {
        $user->socials()->detach($social_id);

        return $this->response->noContent();
    }
}
