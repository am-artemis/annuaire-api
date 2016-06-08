<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Dingo\Api\Contract\Http\Request;
use App\Http\Requests\AddressStoreRequest;

class UserAddressController extends Controller
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
        return $user->addresses;
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
        return $user->addresses()->find($address_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(AddressStoreRequest $request, User $user)
    {

        $addressArray = $request->only(['name', 'address', 'zipcode', 'city',
            'country', 'lat', 'lng', 'phone', 'from', 'to', 'type']);

        $address = new Address($addressArray);

        $user->addresses()->save($address);

        return $this->response->created(null, $user->addresses);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Address $address
     *
     * @return Response
     */
    public function update(AddressStoreRequest $request, $user_id, Address $address)
    {   
         if ($address->user_id != $user_id) {
            return $this->response->errorBadRequest();
        }

        $addressArray = $request->only(['name', 'address', 'zipcode', 'city',
            'country', 'lat', 'lng', 'phone', 'from', 'to', 'type']);

        $address->update($addressArray);

        return $this->response->accepted(null, $address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Address $address
     */
    public function destroy(Address $address)
    {
        $address->delete();
        
        return $this->response->noContent();
    }
}
