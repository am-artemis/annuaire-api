<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Residence;


class UserResidenceController extends Controller
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
        $residences = $user->residences()->with(self::$relationships)->get();

        return $residences;
    }

    /**
     * Display the specified resource.
     *
     * @param Residence $residence
     *
     * @return Response
     */
    public function show(User $user, $residence_id)
    {
        $residence = $user->residences()->find($residence_id);

        return $residence->load(self::$relationships);
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
            $collection = [$request->only($fields)];
        } else {
            $collection = [];
            foreach ($request->all() as $item) {
                $collection[] = array_filter($item, function ($field) use ($fields) {
                    return in_array($field, $fields);
                }, ARRAY_FILTER_USE_KEY);
            }
        }

        foreach ($collection as $residence) {
            $pivot = [
                'room' => $residence['room'],
                'from' => $residence['from'],
                'to'   => $residence['to'],
            ];
            $user->residences()->detach($residence['id']);
            $user->residences()->attach($residence['id'], $pivot);
        }

        return $this->response->created(null, $user->residences);
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
    public function destroy(Request $request, User $user, $residence_id)
    {
        $user->residences()->detach($residence_id);

        return $this->response->noContent();
    }
}
