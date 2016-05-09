<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\UserTransformer;

use Illuminate\Support\Collection;

use App\Models\User;

class SearchController extends Controller
{
    /**
     * List of relationships to load.
     *
     * @var array
     */
    private static $relationships = ['campus', 'gadz', 'photos', 'addresses', 'resams', 'cursus', 'degrees', 'bouls', 'jobs', 'socials'];

    /**
     * Search users and display results
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $q = $request->input('q');

        // Temporaire, renvoi tous les users
        if ($q == "***") {
            return User::all();
        }

        // relations dans lesquelles chercher
        $where = ['firstname', 'lastname', 'mail', 'phone', 'gadz.buque', 'gadz.fams', 'gadz.famsSearch', 'campus.city','year'];
        
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
                    $query->orwhere($w, 'like', "%$term%");
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
