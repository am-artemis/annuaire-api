<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use JD\Cloudder\CloudinaryWrapper;
use App\Http\Requests\PhotoStoreRequest;
use App\Http\Requests\PhotoUpdateRequest;
use Illuminate\Support\Facades\DB;


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
        return Photo::paginate($request->input('items', 30));
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
        return $photo;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CloudinaryWrapper $cloudder
     */
    public function store(PhotoStoreRequest $request, CloudinaryWrapper $cloudder)
    {
        // Tag la photo avec l'environnement
        $tags = ['env_' . env('APP_ENV')];

        DB::beginTransaction();

        $photoArray = [
            'title'   => $request->input('title'),
            'type'    => $request->input('type'),
            'user_id' => $request->input('user_id'),
            'src'     => '',
        ];
        $photo = Photo::forceCreate($photoArray);

        $result = $cloudder->upload($request->input('photo'), null, [], $tags)->getResult();

        $photo->src           = $result['secure_url'];
        $photo->cloudinary_id = $result['public_id'];
        $photo->save();

        DB::commit();

        return $this->response->created(null, $photo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Photo $photo
     *
     * @return Response
     */
    public function update(PhotoUpdateRequest $request, Photo $photo)
    {
        $photo->update($request->intersect(['title', 'type']));

        return $photo;
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

        return $this->response->noContent();
    }
}
