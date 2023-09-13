# ECF Back - Part 1 - Projet bibliothèque - BDD

Ce repository contient une application web dynamique qui peut être utilisée par une bibliothèque pour parcourir leur base de données.


## Prérequis

- Linux, Mac OS ou Windows
- Bash
- PHP 8
- Composer
- Symfony-cli
* MariaDB 10
* Docker (optionnel)


## Installation

```
git clone https://github.com/SegoleneH/symfony_ecf_1
cd symfony
composer install
```

Créez une base de données & un utilisateur dédié pour cette base de données.


## Configuration

Créez un fichier `.env.local` à la racine du projet :

```
APP_ENV=dev
APP_DEBUG=true

APP_SECRET=123

DATABASE_URL="mysql://ecf-symfony1:123@127.0.0.1:3306/ecf-symfony1?serverVersion=mariadb-10.6.128&charset=utf8mb4"
```

Pensez à changer la variable `APP_SECRET` & les codes d'accès `123` dans la variable `DATABASE_URL`.

**ATTENTION : `APP_SECRET` doit être une chaîne de caractères de 32 caractères en hexadécimal.**


## Migration & Fixtures

Pour que l'application soit utilisable, vous devez créer le schéma de la base de données & charger des données :

```
bin/dofilo.sh
```


## Utilisation

Lancez le serveur web de développement

```
symfony serve
```

Puis ouvrez la page suivante : [https://localhost:8001](https://localhost:8001)


## Mentions légales

Ce projet est sous licence MIT.

La licence est disponible ici [LICENCE](LICENCE).