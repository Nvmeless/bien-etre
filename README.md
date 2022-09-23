
# ✨ Relations & Groups

Certaines données ne sont pas aussi simple qu'un event a load, essayes de mettre en relation deux données grace à l'ORM doctrine.

Creer ensuite pour Author, le controller adéquat pour avoir les entités par auteur.
## Commandes utiles

| Requirement      |
| ------------- |
| `composer require symfony/maker-bundle --dev`|
| `composer require orm`     |
| `composer require orm-fixtures --dev`     |
| `composer require fakerphp/faker --dev` |
| `composer require symfony/serializer-pack` |
| `composer require sensio/framework-extra-bundle` |

    Cours 1 & 2 :

| Commande      | Utilité       | 
| ------------- |:-------------:| 
| `symfony new [nom] `| Creer un projet symfony |
| `symfony serve`     | Démarre le projet      | 

| Commande  Doctrine    | Utilité       | 
| ------------- |:-------------:| 
| `php bin/console doctrine:database:create`     | Creer la bdd      | 
| `php bin/console doctrine:schema:update --force`| Adapte le schéma de bdd (developpement seulement ! ) |
| `php bin/console make:entity`     | Creer une entitée avec l'aide de Doctrine    | 


    Cours 3 :

| Commande      | Utilité       | 
| ------------- |:-------------:| 
| `php bin/console doctrine:fixtures:load `| Execute les fixtures |


    Cours 4 & 5 :

| Commande      | Utilité       | 
| ------------- |:-------------:| 
| `php bin/console make:controller` | Creer un controller |





