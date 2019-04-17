<?php

use App\Models\Auth\Book;
use Illuminate\Database\Seeder;

class BookTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        Book::create([
            'name'        => 'Cartea nr.1',
            'copies'        => '2',
        ]);

        Book::create([
            'name'        => 'Cartea nr.2',
            'copies'        => '4',
        ]);

        Book::create([
            'name'        => 'Cartea nr.3',
            'copies'        => '3',
        ]);

        Book::create([
            'name'        => 'Cartea nr.4',
            'copies'        => '7',
        ]);

        $this->enableForeignKeys();
    }
}
