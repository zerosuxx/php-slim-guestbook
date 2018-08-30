<?php


use Phinx\Seed\AbstractSeed;

class MessagesSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $records = [
            [
                'name' => 'test name 1',
                'email' => 'test@test.test 1',
                'message' => 'test message 1',
                'created_at' => '2018-08-28 10:00:00',
            ],
            [
                'name' => 'test name 2',
                'email' => 'test@test.test 2',
                'message' => 'test message 2',
                'created_at' => '2018-08-29 10:00:00',
            ],
            [
                'name' => 'test name 3',
                'email' => 'test@test.test 3',
                'message' => 'test message 3',
                'created_at' => '2018-08-30 10:00:00',
            ]
        ];

        $table = $this->table('messages');
        $table
            ->insert($records)
            ->save();
    }
}
