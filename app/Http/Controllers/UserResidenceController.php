<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Residence;
use Illuminate\Support\Facades\DB;

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
        return $user->residences()->with(self::$relationships)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param Residence $residence
     *
     * @return Response
     */
    public function show(User $user, $user_residence_id)
    {
        // On utilise l'id du pivot pour retrouver la bonne relation
        $residence = $user->residences()->where('user_residence.id', $user_residence_id)->get();

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
            $collection = [$request->intersect($fields)];
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

            $user->residences()->attach($residence['id'], $pivot);
        }

        return $this->response->created(null, $user->residences);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Residence $residence
     *
     * @return Response
     */
    public function destroy($user_id, $user_residence_id)
    {
        // On utilise l'id du pivot pour retrouver la bonne relation
        DB::table('user_residence')->where('user_id', $user_id)->delete($user_residence_id);

        return $this->response->noContent();
    }
}
