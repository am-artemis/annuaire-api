<?php

use Illuminate\Database\Seeder;


class CustomUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'user' => [
                    'id' => '000001',
                    'firstname' => 'Mathieu',
                    'lastname' => 'TUDISCO',
                    'birthday' => '1991-05-08',
                    'gender' => 'm',
                    'email' => 'mathieu.tudisco@gadz.org',
                    'phone' => '0625690445',
                    'year' => 2012,
                    'campus_id' => 1,
                    'tags' => 'zaru, charue',
                ],
                'gadz' => [
                    'buque' => 'Iwazaru',
                    'fams' => '134μ169',
                    'famsSearch' => '134, 169',
                    'proms' => 212,
                ],
                'residences' => [
                    [
                        'id' => 1,
                        'room' => 'S206',
                        'from' => '2012-09-10',
                        'to' => '2013-07-31',
                    ],
                    [
                        'id' => 1,
                        'room' => 'E105',
                        'from' => '2013-09-10',
                        'to' => '2014-01-23',
                    ],
                    [
                        'id' => 2,
                        'room' => '35',
                        'from' => '2014-01-23',
                        'to' => '2014-07-23',
                    ],
                    [
                        'id' => 1,
                        'room' => 'E105',
                        'from' => '2014-09-01',
                        'to' => '2015-01-10',
                    ],
                    [
                        'id' => 3,
                        'room' => '703',
                        'from' => '2015-01-20',
                        'to' => '2016-04-30',
                    ],
                ],
                'degree' => [
                    [
                        'title' => 'Ingénieur',
                        'school' => 'Arts et Métiers',
                        'am' => true,
                        'year' => 2016,
                    ],
                    [
                        'title' => 'DUT GMP',
                        'school' => 'IUT GMP AIX',
                        'am' => false,
                        'year' => 2012,
                    ],
                ],
            ],
            [
                'user' => [
                    'id' => '000002',
                    'firstname' => 'Corentin',
                    'lastname' => 'GITTON',
                    'birthday' => '1993-05-28',
                    'gender' => 'm',
                    'email' => 'corentin.gitton@gadz.org',
                    'phone' => '0600000002',
                    'year' => 2013,
                    'campus_id' => 1,
                    'tags' => null,
                ],
                'gadz' => [
                    'buque' => 'Tarmak',
                    'fams' => '154',
                    'famsSearch' => '89,154',
                    'proms' => 213,
                ],
                'residences' => [
                    [
                        'id' => 1,
                        'room' => 'O103',
                        'from' => '2013-09-10',
                        'to' => '2013-12-31',
                    ],
                    [
                        'id' => 1,
                        'room' => 'O105',
                        'from' => '2014-01-01',
                        'to' => '2014-07-31',
                    ],
                    [
                        'id' => 2,
                        'room' => '23',
                        'from' => '2015-09-05',
                        'to' => '2016-04-31',
                    ],
                    [
                        'id' => 3,
                        'room' => '456',
                        'from' => '2015-09-05',
                        'to' => '2016-04-31',
                    ],
                ],
                'degree' => []
            ],
        ];

        foreach ($data as $user_data) {
            $user = App\Models\User::forceCreate($user_data['user']);
            $gadz = new App\Models\Gadz($user_data['gadz']);
            $user->gadz()->save($gadz);

            foreach ($user_data['residences'] as $res_data) {
                $id = $res_data['id'];
                unset($res_data['id']);
                $user->residences()->attach($id, $res_data);
            }
            foreach ($user_data['degree'] as $deg_data) {
                $deg = \App\Models\Degree::create(array_except($deg_data,'year'));
                $user->degrees()->attach($deg->id, array_only($deg_data, 'year'));
            }

            factory(App\Models\Photo::class, 3)->make()->each(function ($photo) use ($user) {
                $user->photos()->save($photo);
            });
        }
    }
}
