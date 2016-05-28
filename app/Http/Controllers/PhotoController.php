<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\PhotoTransformer;

use App\Models\User;
use App\Models\Photo;
use Cloudder;
use Illuminate\Support\Facades\DB;
use JD\Cloudder\CloudinaryWrapper;

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
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $users = Photo::with(self::$relationships)->paginate($request->input('items', 30));

        return $users;
    }

    /**
     * Display the specified resource.
     *
     * @param Photo $photo
     *
     * @return Response
     */
    public function show(Photo $photo)
    {
        return $photo->load(self::$relationships);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CloudinaryWrapper $cloudder
     */
    public function store(Request $request, CloudinaryWrapper $cloudder)
    {
        $tags = ['env_' . env('APP_ENV')];

        DB::beginTransaction();

        $photoArray = [
            'title'   => $request->input('title'),
            'type'    => $request->input('type'),
            'user_id' => $request->input('user_id'),
        ];
        $photo = Photo::forceCreate($photoArray);

        $result = $cloudder->upload($request->get('photo'), null, [], $tags)->getResult();

        $photo->src = $result['secure_url'];
        $photo->cloudinary_id = $result['public_id'];
        $photo->save();

        DB::commit();

        return $photo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Photo $photo
     *
     * @return Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Photo $photo
     *
     * @return Response
     */
    public function destroy(Photo $photo)
    {
        $photo->delete();

        return $this->response->accepted('Resource was deleted.');
    }
}
