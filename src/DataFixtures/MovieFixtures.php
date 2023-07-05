<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie -> setTitle('The Dark Night');
        $movie -> setReleaseYear(2008);
        $movie -> setDescription('This is description of the Dark Night');
        $movie -> setImagePath('https://cdn.pixabay.com/photo/2021/06/18/11/22/batman-6345897_960_720.jpg');
        //add data to pivot table
        $movie -> addActor($this -> getReference('actor_1'));
        $movie -> addActor($this -> getReference('actor_2'));
        $manager -> persist($movie);

        $movie2 = new Movie();
        $movie2 -> setTitle('Avengers: Endgame');
        $movie2 -> setReleaseYear(2019);
        $movie2 -> setDescription('This is description of the Avengers: Endgame');
        $movie2 -> setImagePath('https://pixabay.com/illustrations/captain-america-avengers-marvel-5692937/');
        //add data to pivot table
        $movie2 -> addActor($this -> getReference('actor_3'));
        $movie2 -> addActor($this -> getReference('actor_4'));
        $manager -> persist($movie2);
        $manager -> flush();
    }
}
