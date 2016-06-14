<?php

namespace App\Http\Controllers;

use App\Services\AlgoliaService;
use Illuminate\Http\Request;

use DB;
use App\Models\User;
use App\Models\Gadz;

class UserController extends Controller
{
    /**
     * List of relationships to load.
     *
     * @var array
     */
    private static $relationships = ['campus', 'gadz', 'photos', 'addresses', 'residences', 'courses',
        'degrees', 'responsibilities', 'jobs', 'socials'];

    protected $algolia;

    public function __construct(AlgoliaService $algolia)
    {
        $this->algolia = $algolia;
    }

    public function index(Request $request)
    {
        $users = User::with(self::$relationships)->paginate($request->input('items', 30));

        return $users;
    }


    public function show(User $user)
    {
        return $user->load(self::$relationships);
    }


    public function store(Request $request)
    {
        $fields = array_keys($request->all());

        if (!in_array('contact', $fields) or !in_array('promo', $fields)) {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException("User must have `contact` and `promo` fields.");
        }

        // Prepare rules
        $rules = [
            // Contact
            'contact.firstname' => 'required|alpha',
            'contact.lastname'  => 'required|alpha',
            'contact.gender'    => 'in:m,f,null',
            'contact.email'     => 'required|email',
            'contact.phone'     => 'required|string|regex:#^0[1-9][0-9]{8}$#',

            // Promo
            'promo.campus.id'   => 'exists:campuses,id',
            'promo.year'        => 'required|regex:#^20[0-9]{2}$#',
        ];

        if ($request->has('gadz')) {
            $gadz_rules = [
                'gadz.buque'      => 'required|alpha',
                'gadz.fams'       => 'required',
                'gadz.famsSearch' => 'required|regex:#^[0-9]{1,3}(,[0-9]{1,3})*$#',
            ];
            $rules = array_merge($rules, $gadz_rules);
        }

        // Validation
        $v = app('validator')->make($request->all(), $rules);

        if ($v->fails()) {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException('Validation error(s) : ' . $v->errors());
        }

        // Regroupe les infos correctement
        $user_data = $request->input('contact');
        $user_data['campus_id'] = $request->input('promo.campus.id');
        $user_data['year'] = $request->input('promo.year');

        // Crée les objets et les sauvegarde en base
        DB::beginTransaction();

        $user = new User($user_data);
        $user->save();

        $gadz = new Gadz($request->input('gadz'));
        $user->gadz()->save($gadz);

        DB::commit();

        $this->algolia->addUser($user);

        // Retourne le nouvel user
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     *
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function update(Request $request, User $user)
    {
        // Prepare rules
        $rules = [];

        // Démarre la transaction

        if ($request->has('contact')) {
            $rules = array_merge($rules, [
                'contact.firstname' => 'required|alpha',
                'contact.lastname'  => 'required|alpha',
                'contact.gender'    => 'in:m,f,null',
                'contact.email'     => 'required|email',
                'contact.phone'     => 'required|string|regex:#^0[1-9][0-9]{8}$#',
            ]);

            $user_data = $request->input('contact');
        } else {
            $user_data = [];
        }

        if ($request->has('promo')) {
            $rules = array_merge($rules, [
                'promo.campus.id' => 'exists:campuses,id',
                'promo.year'      => 'required|regex:#^20[0-9]{2}$#',
            ]);

            $user_data['campus_id'] = $request->input('promo.campus.id');
            $user_data['year'] = $request->input('promo.year');
        }

        if ($request->has('gadz')) {
            $rules = array_merge($rules, [
                'gadz.buque'      => 'required|alpha',
                'gadz.fams'       => 'required',
                'gadz.famsSearch' => 'required|regex:#^[0-9]{1,3}(,[0-9]{1,3})*$#',
            ]);
        }

        // Validation
        $v = app('validator')->make($request->all(), $rules);

        if ($v->fails()) {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException('Validation error(s) : ' . $v->errors());
        }

        // Crée les objets et les sauvegarde en base
        DB::beginTransaction();

        if ($request->has('gadz')) {
            $user->gadz->update($request->input('gadz'));
        }

        if ($request->has('contact') or $request->has('promo')) {
            $user->update($user_data);
        }

        DB::commit();

        $this->algolia->updateUser($user);

        // Retourne le nouvel user
        return $user;
    }


    public function destroy(User $user)
    {
        $user->delete();
        $this->algolia->deleteUser($user);

    }
}
