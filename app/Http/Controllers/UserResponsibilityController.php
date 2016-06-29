<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Responsibility;
use Dingo\Api\Contract\Http\Request;
use App\Http\Requests\UserResponsibilityStoreRequest;
use App\Http\Requests\UserResponsibilityUpdateRequest;

class UserResponsibilityController extends Controller
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
        return $user->responsibilities;
    }

    /**
     * Display the specified resource.
     *
     * @param Address $address
     *
     * @return Response
     */
    public function show(User $user, $address_id)
    {
        return $user->responsibilities()->find($address_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(UserResponsibilityStoreRequest $request, User $user)
    {

        $responsibilityArray = $request->intersect(['campus_id', 'title', 'strass', 'from', 'to']);

        $responsibility = new Responsibility($responsibilityArray);

        $user->responsibility()->save($responsibility);

        return $this->response->created(null, $user->responsibilities);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Responsibility $responsibility
     *
     * @return Response
     */
    public function update(UserResponsibilityUpdateRequest $request, $user_id, Responsibility $responsibility)
    {   
        if ($responsibility->user_id != $user_id) {
            return $this->response->errorBadRequest();
        }

        $responsibilityArray = $request->intersect(['campus_id', 'title', 'strass', 'from', 'to']);

        $responsibility->update($responsibilityArray);

        return $this->response->accepted(null, $responsibility);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Responsibility $responsibility
     */
    public function destroy($user_id, Responsibility $responsibility)
    {
        if ($responsibility->user_id != $user_id) {
            return $this->response->errorBadRequest();
        }

        $responsibility->delete();
        
        return $this->response->noContent();
    }
}
