<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Residence;


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
        $socials = $user->socials()->with(self::$relationships)->get();

        return $socials;
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
        $social = $user->socials()->find($social_id);

        return $social->load(self::$relationships);
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
            $collection = [$request->only($fields)];
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
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param    int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Residence $residence
     *
     * @return Response
     */
    public function destroy(Request $request, User $user, $social_id)
    {
        $user->socials()->detach($social_id);

        return $this->response->noContent();
    }
}
