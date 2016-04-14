<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\AddressTransformer;

use App\Address;

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
     * @return Response
     */
    public function index(Request $request)
    {
        $addresses = Address::with(self::$relationships)->paginate($request->input('items', 30))->appends($request->except('page'));

        return $this->response->paginator($addresses, new AddressTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param    int    $id
     * @return Response
     */
    public function show($id)
    {
        $address = Address::with(self::$relationships)->findOrFail($id);

        return $this->response->item($address, new AddressTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    int    $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int    $id
     * @return Response
     */
    public function destroy($id)
    {
        Address::findOrFail($id)->delete();
    }
}
