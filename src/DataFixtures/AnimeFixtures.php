<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AnimeFixtures extends Fixture
{
    private $manager;
    private $encoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = \Faker\Factory::create('fr_FR');
    }

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
        // 1 admin et 1 moderateur
        $users = [['user' => 'admin', 'password' => '123456', 'roles' => ["ROLE_ADMIN"]], ['user' => 'modo', 'password' => '123456', 'roles' => ["ROLE_MODERATOR"]]];
        // ne marche pas pour la connexion car il faut passer un mot de passe cypter
        $users = $this->createUsers($users, 100);
        $this->addUsers($users, 'App\Entity\User');
        // Enregistrer les configurations | non fictif sauf pour users
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

    
    /**
     * Créer des utilisateur fictif
     * @return void
     */
    private function addUsers($users, $className): void
    {
        foreach ($users as $usr) {
            $user = new $className;
            $user->setUsername($usr['user']);
            // hash le mot de passe
            $hash = $this->encoder->encodePassword($user, $usr['password']);
            $user->setPassword($hash);
            $user->setRoles($usr['roles']);
            if(isset($usr['createdAt'])) {
                $user->setCreatedAt($usr['createdAt']);
            }
            $this->manager->persist($user);
        }
    }

    /**
     * Ajoute des utilisateur
     * @return array
     */
    private function createUsers($users = [], $userMax = 10): array
    {
        for ($i=0; $i < $userMax; $i++) { 
            $users[] = [
                'user' => $this->faker->userName(),
                'password' => '123456',
                'roles' => ["ROLE_USER"],
                'createdAt' => $this->faker->dateTimeBetween('-5 years')
            ];
        }
        return $users;
    }
}
