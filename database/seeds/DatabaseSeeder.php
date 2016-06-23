<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $faker = Faker\Factory::create();

        //Utworzenie roli UsersManagementPanel i user
        $roleAdmin = new \App\Role;
        $roleAdmin->role_name = "Admin";
        $roleAdmin->save();

        $roleUser = new \App\Role;
        $roleUser->role_name = "User";
        $roleUser->save();

        $roleUser = new \App\Role;
        $roleUser->role_name = "Accountant";
        $roleUser->save();

        $roleUser = new \App\Role;
        $roleUser->role_name = "Storekeeper";
        $roleUser->save();

        //Utworzenie przykładowych urzytkowników
        $user = new \App\User;
        $user->name = "Jan";
        $user->surname = "Kowalski";
        $user->phone_number = 394384883;
        $user->email = "jankowalski@przyklad.com";
        $user->password = Hash::make('haslo');
        $user->save();
        $user->roles()->save($roleAdmin);
        $user->roles()->save($roleUser);


        for($i = 0; $i < 40; $i++) {

            $user = new \App\User;
            $user->name = $faker->firstName;
            $user->surname = $faker->lastName;
            $user->phone_number = $faker->phoneNumber;
            $user->email = $faker->email;
            $user->password = Hash::make('haslo');
            $user->save();
            $user->roles()->save($roleUser);

        }

        $categories = ['Powieść','Przygodowa','Historyczna','Podręcznik','Romans','Science-Fiction','Fantasy','Kryminał','Horror','Kucharska'];

        for($i = 0 ; $i < count($categories) ; $i++)
        {
            $category = new \App\Category;
            $category->category = $categories[$i];
            $category->save();
        }


        for($i = 0 ; $i < 20 ;$i++)
        {
            $author = new \App\Author;
            $author->name = $faker->firstName;
            $author->surname=$faker->lastName;
            $author->save();

            $x = rand(1,8);
            for($j = 0 ; $j < $x ; $j++)
            {
                $book = new \App\Book;
                $book->title = ucfirst($faker->word);
                $book->description = $faker->text;
                $book->series = ucfirst($faker->word);
                $book->pages = $faker->numberBetween(50,1000);
                $book->price = $faker->numberBetween(10,100);
                $book->cover = $faker->boolean();
                $book->available = 1;
                $book->img = 'http://placehold.it/450x350';
                $author->books()->save($book);

                $categoryId = rand(1,count($categories));
                $category = \App\Category::find($categoryId);
                $category->books()->save($book);

                $rand = rand(0,1);

                if($rand == 1)
                {
                    $NextcategoryId = rand(1,count($categories));
                    if($categoryId != $NextcategoryId )
                    {
                        $category = \App\Category::find($NextcategoryId);
                        $category->books()->save($book);
                    }
                }

            }

        }

    }
}
