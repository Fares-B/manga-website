<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AnimeFixtures extends Fixture
{
    private $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        // Kind
        $kinds = ["Action","Aventure","Combat","Comédie","Drama","Ecchi","École","Enfant","Fantastique","Harem","Historique","Horreur","Josei","Magique","Mecha","Militaire","Musique","Mystère","Policier","Psychologique","Romance","Science-fiction","Sport","Super Pouvoir","Thriller","Tranche de vie"];
        $this->addConfig($kinds, 'App\Entity\Kind');

        // Type
        $types = ["Shonen","Shojo","Seinen","Kodomo"];
        $this->addConfig($types, 'App\Entity\Type');

        // Status
        $status = ["En cours","Fini","Abandonné"];
        $this->addConfig($status, 'App\Entity\Status');

        // Voice
        $voices = ["Vostfr","VF"];
        $this->addConfig($voices, 'App\Entity\Voice');

        // Formats
        $formats = ["Episode","Film","OAV","Spécial","Chapitre","Opening","Ending","PV"];
        $this->addConfig($formats, 'App\Entity\Format');

        // Enregistrer les configurations | non fictif
        $this->manager->flush();
    }

    /**
     * Données de configuration
     * @return void
     */
    private function addConfig($array, $className): void
    {
        foreach ($array as $value) {
            $obj = new $className;

            $obj->setName($value);

            $this->manager->persist($obj);
        }
    }
}
