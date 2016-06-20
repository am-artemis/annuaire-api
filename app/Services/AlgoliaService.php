<?php

namespace App\Services;

use App\Models\User;
use Vinkla\Algolia\AlgoliaManager;

class AlgoliaService
{
    /** @var \AlgoliaSearch\Client $algolia*/
    public $algolia;

    /** @var \AlgoliaSearch\Index $index*/
    public $index;

    public $settings = [
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
        'attributeForDistinct' => 'user_id',
        'allowTyposOnNumericTokens' => false,
    ];

    public function __construct(AlgoliaManager $algolia)
    {
        $this->algolia = $algolia;
        $this->index = $this->algolia->initIndex(config('algolia.index'));

    }

    /**
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->index->addObjects($this->userToObjects($user));
    }

    /**
     * @param User $user
     */
    public function deleteUser(User $user)
    {
        $this->index->deleteByQuery(
            $user->id,
            [
                'restrictSearchableAttributes' => 'user_id',
                'typoTolerance'                => false,
                'queryType'                    => 'prefixNone',
            ]
        );
    }

    /**
     * @param User $user
     */
    public function updateUser(User $user)
    {
        $this->deleteUser($user);
        $this->addUser($user);
    }

    /**
     * Turn this item object into a generic array
     *
     * @param User $user
     *
     * @return array
     */
    public function userToObjects(User $user)
    {
        $obj_user = [
            'user_id'   => $user->id,
            'firstname' => $user->firstname,
            'lastname'  => $user->lastname,
            'birthday'  => (int)$user->birthday->timestamp,
            'email'     => explode('@', $user->email)[0],
            'phone'     => $user->phone,
            'year'      => (string)$user->year,
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
     * @param bool $refresh
     */
    public function reIndexUsers($refresh = true)
    {
        $indexTmp = $refresh ? $this->algolia->initIndex($this->index->indexName.'_tmp') : $this->index;

        User::chunk(100, function ($users) use ($indexTmp, $refresh) {
            $records = [];

            foreach ($users as $user) {
                $records = array_merge($records, $this->userToObjects($user));
            }

            $indexTmp->addObjects($records);
        });

        if ($refresh) {
            $this->algolia->moveIndex($indexTmp->indexName, $this->index->indexName);
            $this->index->setSettings($this->settings);
        }
    }

    public function searchUsers($query, $parameters = [])
    {
        $user = new User();
        $result = $this->index->search($query, $parameters);

        return $result;
    }
}
