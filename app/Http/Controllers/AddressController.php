<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Dingo\Api\Contract\Http\Request;

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
        $addresses = Address::with(self::$relationships)->paginate($request->input('items', 30));

        return $addresses;
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
        return $address->load(self::$relationships);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $addressArray = $request->only(['user_id', 'name', 'address', 'zipcode', 'city',
            'country', 'lat', 'lng', 'phone', 'from', 'to', 'type']);

        $address = Address::forceCreate($addressArray);

        return $address;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Address $address
     *
     * @return Response
     */
    public function update(Request $request, Address $address)
    {
        $addressArray = $request->only(['name', 'address', 'zipcode', 'city',
            'country', 'lat', 'lng', 'phone', 'from', 'to', 'type']);

        $address->update($addressArray);

        return $address;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Address $address
     */
    public function destroy(Address $address)
    {
        $address->delete();
    }
}
