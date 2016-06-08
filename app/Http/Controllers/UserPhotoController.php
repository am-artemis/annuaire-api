<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Photo;
use Illuminate\Http\Request;
use JD\Cloudder\CloudinaryWrapper;
use Illuminate\Http\PhotoStoreRequest;
use Illuminate\Support\Facades\DB;


class UserPhotoController extends Controller
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
        return $user->photos;;
    }

    /**
     * Display the specified resource.
     *
     * @param Photo $photo
     *
     * @return Response
     */
    public function show(User $user, $photo_id)
    {
        return $user->photos()->find($photo_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CloudinaryWrapper $cloudder
     */
    public function store(PhotoStoreRequest $request, CloudinaryWrapper $cloudder, User $user)
    {
        // Tag la photo avec l'environnement
        $tags = ['env_' . env('APP_ENV')];

        DB::beginTransaction();

        $photoArray = [
            'title'   => $request->input('title'),
            'type'    => $request->input('type'),
            'src'     => '',
        ];
        $photo = new Photo($photoArray);

        $result = $cloudder->upload($request->get('photo'), null, [], $tags)->getResult();

        $photo->src = $result['secure_url'];
        $photo->cloudinary_id = $result['public_id'];

        $user->photos()->save($photo);

        DB::commit();

        return $this->response->created(null, $user->photos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Photo $photo
     *
     * @return Response
     */
    public function update(PhotoStoreRequest $request, Photo $photo)
    {
        $photo->update($request->only(['title', 'type']));

        return $this->response->accepted(null, $photo);
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
