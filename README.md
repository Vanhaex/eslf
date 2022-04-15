# ESLF

### ESLF est un simple framework pour écrire des applications web

## Qu'est ce que ESLF ?

**ESLF** est le diminutif de **E**asy, **S**imple and **L**ightweight **F**ramework
C'est un framework permettant de créer des applications web en PHP qui se veut facile à utiliser et léger. C'est un framework qui peut évoluer avec le temps et s'adapte à toutes les utilisations.
Son architecture repose sur le principe du MVC pour Modèle, Vue, Controlleur. Il sépare donc le traitement de l'affichage en utilisant le moteur de templating **Smarty**.
Certaines classes ont été créées afin de sécuriser le traitement des données utilisateur par les méthodes POST ou GET par exemple. Elles permettent aussi de contrôler plus facilement les données passées par les utilisateurs.

## Pourquoi un framework fait à la main ? Pourquoi ne pas utiliser un framework plus connu ?

Mon objectif dès le départ était de créer un framework par moi-même en m'inspirant de mon expérience dans le domaine du développement web. Je voulais surtout quelque chose de léger avec le strict minimum. Cela me permet de créer des applications web beaucoup plus facilement et d'ajouter des fonctionnalités si nécessaire.
Je m'inspire du framework **Laravel** pour certaines parties. Le second objectif est de permettre au développeur d'être à l'aide avec ce framework, de par des outils en ligne de commande ou des librairies.
Par exemple, ESLF est fourni sans framework CSS tel que Bootstrap par exemple. On peut donc utiliser celui que l'on souhaite.

## ESbuilder

ESbuilder est une interface en ligne de commande inclue dans le framework. Elle fournit des commandes qui peuvent vous aider à construire votre projet. Elle permet par exemple de créer des controlleurs, des modèles, générer des clefs, vider le cache, etc...
Pour lancer une commande pour obtenir la version du framework, il suffit de taper

`php esbuilder version`

Ce qui vous permettra d'obtenir en sortie :

``ESLF v1.0.0``

## Dépendences utilisées

ESLF nécessite PHP 7.1 au minimum ainsi que les autres dépendances ci-dessous :

* PHPMailer 6.4
* Smarty 3.1
