<?php

use Illuminate\Database\Seeder;

class Poststableseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB:table('posts')->insert([
            'title' => 'post1',
            'content' => 'passage1'
        ]);
    }
}
