<?php

namespace App\Http\Controllers;

use App\Services\AlgoliaService;
use Illuminate\Http\Request;

use Illuminate\Support\Collection;

use App\Models\User;

class SearchController extends Controller
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
        if (!$request->has('q')) {
            return $this->response->noContent();
        }

        $q = $request->input('q');

        return $this->algolia($q);
    }



    public function algolia($q)
    {
        $parameters['attributesToRetrieve'] = 'user_id';
        $results = $this->algolia->searchUsers($q, $parameters);
        $users_id = [];
        foreach ($results['hits'] as $elt) {
            array_push($users_id, $elt['user_id']);
        }
        return User::findMany($users_id);
    }

    public function standard($q)
    {
        // Temporaire, renvoi tous les users
        if ($q == "***") {
            return User::all();
        }

        // relations dans lesquelles chercher
        $where = ['firstname', 'lastname', 'email', 'phone', 'gadz.buque', 'gadz.fams', 'gadz.famsSearch', 'campus.city','year'];
        
        $users = new Collection();

        foreach (explode(' ', $q) as $index => $term) {
            $query = User::with(self::$relationships);

            foreach ($where as $w) {
                // Niveau 1
                $parts = explode('.', $w, 2);
                if (count($parts) == 2) {
                    $w = $parts[1];
                    $query->orWhereHas($parts[0], function ($query) use ($term, $w) {
                        $query->where($w, 'like', "%$term%");
                    });
                } else {
                    $query->orWhere($w, 'like', "%$term%");
                }
            }

            $results = $query->get();
            if ($index == 0) {
                $users = $results;
            } else {
                $users = $users->intersect($results);
            }
            $users = $users->unique();
        }

        // Retourne la collection d'utilisateurs transformée (Le fields est compris dedans)
        return $users;
    }
}
