# manga-website

Pour lancer le projet il faut utiliser [**composeur**](https://getcomposer.org/download/) et [**git**](https://git-scm.com/downloads) et [**wamp server**](http://www.wampserver.com/#download) dans le cas de cette notice

### Git
+ Faire une copie du projet (_manga-website_)
```
git clone https://github.com/Fares-B/manga-website
```

### Editeur de text

_Par default sur phpmyadmin pour se connecter à mysql le nom d'utilisateur est **root** et le mot de passe est **vide**.
si vous êtes dans ce cas là alors sauté l'étape suivante._
+ Modifier la variable nous permetant de connecter l'application avec la base de données mysql

1.  Dans le fichier ***.env***, chercher la variable DATABASE_URL
2.  Modifier les variables user_name et password avec vos identifiant et mdp, donner un nom à la base de données dans name_of_database
```
DATABASE_URL=mysql://user_name:password@127.0.0.1:3306/name_of_database?serverVersion=5.7
```

### Wamp
+ Lancé wamp server et **c'est tout !**

### Terminal (powershell ou git bash)
+ Ouvrir le terminal dans le dossier cloné

_exemple de méthode: faire un maj + clic-droit dans le dossier puis ouvrir avec powershell (ou git bash)_

1.  Installer les dépendances nécessaire pour l'utilisation de l'application, grâce à la ligne de commande suivante
```
composer install
```

2.  Créer la base de données
```
php bin/console doctrine:database:create
```

3.  Créer les tables  de l'app dans la base de données
```
php bin/console doctrine:migration:migrate
```

4.  Ajouter les données nécessaire au bon fonctionnement de l'app (types, genres, status...)
```
php bin/console doctrine:fixtures:load
```

5.  Lancer le server pour pouvoir afficher l'application
```
php -S localhost:8000 -t public
```

6. _Optionnel, dans la barre de navigation, sur l'app, cliquez sur dev fixtures pour ajouter des fausses données_

#### Fin

Vous pouvez voir l'evolution du projet perso pour mon apprendtissage du framework PHP Symfony 5.
