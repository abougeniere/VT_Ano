<?php

//
// Anonymistaion de la base VT
//

//Composer autoload
require __DIR__ . '/vendor/autoload.php';


$faker = Faker\Factory::create('fr_FR'); // create a French faker
for ($i=0; $i < 10; $i++) {
    echo $faker->name, "\n";
}