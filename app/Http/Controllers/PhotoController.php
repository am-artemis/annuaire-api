<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\PhotoTransformer;

use App\User;
use App\Photo;

class PhotoController extends Controller
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
        $users = Photo::with(self::$relationships)->paginate($request->input('items', 30))->appends($request->except('page'));

        return $this->response->paginator($users, new PhotoTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param    int    $id
     * @return Response
     */
    public function show($id)
    {
        $user = Photo::with(self::$relationships)->findOrFail($id);

        return $this->response->item($user, new PhotoTransformer);
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
        Photo::findOrFail($id)->delete();
    }
}
