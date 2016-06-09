<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Dingo\Api\Contract\Http\Request;
use App\Http\Requests\AddressStoreRequest;
use App\Http\Requests\AddressUpdateRequest;

class AddressController extends Controller
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
    public function index(Request $request)
    {
        return Address::paginate($request->input('items', 30));
    }

    /**
     * Display the specified resource.
     *
     * @param Address $address
     *
     * @return Response
     */
    public function show(Address $address)
    {
        return $address;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(AddressStoreRequest $request)
    {
        $addressArray = $request->intersect(['user_id', 'name', 'address', 'zipcode', 'city',
            'country', 'lat', 'lng', 'phone', 'from', 'to', 'type']);

        $address = Address::forceCreate($addressArray);

        return $this->response->created(null, $address);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Address $address
     *
     * @return Response
     */
    public function update(AddressUpdateRequest $request, Address $address)
    {
        $addressArray = $request->intersect(['name', 'address', 'zipcode', 'city',
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
