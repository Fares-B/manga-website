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
        $this->addConfig($kinds, 'App\Entity\Anime\Kind');

        // Type
        $types = ["Shonen","Shojo","Seinen","Kodomo"];
        $this->addConfig($types, 'App\Entity\Anime\Type');

        // Status
        $status = ["En cours","Fini","Abandonné"];
        $this->addConfig($status, 'App\Entity\Anime\Status');

        // Voice
        $voices = ["Vostfr","VF"];
        $this->addConfig($voices, 'App\Entity\Episode\Voice');

        // Formats
        $formats = ["Episode","Film","OAV","Spécial","Chapitre","Opening","Ending","PV"];
        $this->addConfig($formats, 'App\Entity\Episode\Format');

        // User
        // ne marche pas pour la connexion car il faut passer un mot de passe cypter
        $users = [['user' => 'admin', 'password' => '123456', 'roles' => ["ROLE_ADMIN"]], ['user' => 'modo', '123456' => 'moderateur', 'roles' => ["ROLE_MODERATOR"]]];
        foreach ($users as $usr) {
            $user = new \App\Entity\User;
            $user->setUsername($usr['user']);
            $user->setPassword($usr['password']);
            $user->setRoles($usr['roles']);
            $this->manager->persist($user);
        }
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
