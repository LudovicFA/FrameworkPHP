# README

Realisation d'un Framework PHP Basic

## Execution du projet
php -S localhost:8000 -t .\public\

## Execution des tests
.\vendor\bin\phpunit

## Application des regle des develepplement
.\vendor\bin\phpcs

Pour les fixer:
.\vendor\bin\phpcbf

## Commit sur Github
git status
git add .
git commit -m 'mon message'
git push origin master


## OUtisl utiliser
zend-expressive-fastroute POur la gestion des routes
Twig pour la gestion des templates des vues
PHP-DI pour l'injection de dépendance
Phinx pour les migrations
