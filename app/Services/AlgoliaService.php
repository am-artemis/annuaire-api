<?php

namespace App\Services;

use App;
use App\Models\ApiModel;
use App\Models\User;

class AlgoliaService
{

    public static $settings = [
        'attributesToIndex' => [
            'lastname',
            'buque',
            'famsPromsTBK',
            'fams',
            'email',
            'phone',
            'campus',
            'year',
            'proms',
            'promsTBK',
            'firstname',
            'tags',
            'user_id'
        ],
        'customRanking' => [
            'desc(rank.isStudent)',
            'desc(rank.isGadz)',
            'desc(rank.year)',
            'asc(lastname)'
        ],
        'allowTyposOnNumericTokens' => false,
    ];
    /**
     * @param User $user
     */
    public static function pushUser(User $user)
    {
        /** @var \AlgoliaSearch\Laravel\ModelHelper $modelHelper */
        $modelHelper = App::make('\AlgoliaSearch\Laravel\ModelHelper');

        $indices = $modelHelper->getIndices($user);

        /** @var \AlgoliaSearch\Index $index */
        foreach ($indices as $index) {
            if ($modelHelper->indexOnly($user, $index->indexName)) {
                $index->deleteByQuery(
                    $user->id,
                    [
                        'restrictSearchableAttributes' => 'user_id',
                        'typoTolerance'                => false,
                        'queryType'                    => 'prefixNone',
                    ]
                );
                $index->addObjects(static::userToObjects($user));
            }
        }
    }

    /**
     * Turn this item object into a generic array
     *
     * @param User $user
     *
     * @return array
     */
    public static function userToObjects(User $user)
    {
        $obj_user = [
            'user_id'   => $user->id,
            'firstname' => $user->firstname,
            'lastname'  => $user->lastname,
            'birthday'  => (int)$user->birthday->timestamp,
            'email'     => explode('@', $user->email)[0],
            'phone'     => $user->phone,
            'year'      => (string)$user->year,
//            'addresses'        => null,
//            'residences'       => null,
//            'courses'          => null,
//            'tags'             => $user->tags,
//            'degrees'          => null,
//            'responsibilities' => null,
//            'jobs'             => null,
//            'socials'          => null,
        ];


        if ($campus = $user->campus) {
            $obj_user['campus'][] = $campus->city;
            $obj_user['campus'][] = $campus->short;
            if (ends_with($campus->short, "'s")) {
                $obj_user['campus'][] = $campus->short . 's';
                $obj_user['campus'][] = $campus->short . 'ss';
                $obj_user['campus'][] = $campus->short . 'sss';
            }
        }

        if ($gadz = $user->gadz) {
            $obj_user['buque'] = $gadz->buque;
            $obj_user['proms'] = (string)$gadz->proms;
            $obj_user['promsTBK'] = $user->campus->prefix . $gadz->proms;
            foreach (explode(',', $gadz->famsSearch) as $fams) {
                $obj_user['fams'][] = $fams;
                $obj_user['famsPromsTBK'][] = $fams . $user->campus->prefix . $gadz->proms;
            }
            $obj_user['famsPromsTBK'][] = implode('-', $obj_user['fams']) . $user->campus->prefix . $gadz->proms;
        }

        if ($tags = $user->tags) {
            foreach (explode(',', $tags) as $tag) {
                $obj_user['tags'][] = $tag;
            }
        }

        $obj_user['rank'] = [
            'isStudent' => ($user->degrees()->where('am', true)->count()) ? 0 : 1,
            'isGadz'    => (is_null($gadz)) ? 0 : 1,
            'year'  => (int)$user->year,
        ];

        return [
            $obj_user,
        ];
    }

    /**
     * Re index all users
     *
     * @param bool $erase
     */
    public static function reIndexUsers($erase = true)
    {
        /** @var \AlgoliaSearch\Laravel\ModelHelper $modelHelper */
        $modelHelper = App::make('\AlgoliaSearch\Laravel\ModelHelper');
        $user = new User;
        $indices = $modelHelper->getIndices($user);
        $indicesTmp = $erase ? $modelHelper->getIndicesTmp($user) : $indices;

        User::chunk(100, function ($users) use ($indicesTmp, $modelHelper, $erase) {
            /** @var \AlgoliaSearch\Index $index */
            foreach ($indicesTmp as $index) {
                $records = [];

                foreach ($users as $user) {
                    if ($modelHelper->indexOnly($user, $index->indexName)) {
                        $records = array_merge($records, static::userToObjects($user));
                    }
                }

                $index->addObjects($records);
            }

        });

        if ($erase) {
            for ($i = 0; $i < count($indices); $i++) {
                $modelHelper->algolia->moveIndex($indicesTmp[$i]->indexName, $indices[$i]->indexName);
                if (count(array_keys(static::$settings)) > 0) {
                    $indices[$i]->setSettings(static::$settings);
                }
            }
        }
    }
}
