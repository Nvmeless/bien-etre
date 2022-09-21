
# ✨ Controllers

Comme tu l'as vu, il y a toujours moyen de se simplifier la vie avec symfony.
Creer un controller a l'aide de l'outil mit a disposition par symfony ! (`php bin/console make:controller`)

## Commandes utiles

| Requirement      |
| ------------- |
| `composer require symfony/maker-bundle --dev`|
| `composer require orm`     |
| `composer require orm-fixtures --dev`     |
| `composer require fakerphp/faker --dev` |

| Commande      | Utilité       | 
| ------------- |:-------------:| 
| `php bin/console make:controller` |

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


    Cours 4 :

| Commande      | Utilité       | 
| ------------- |:-------------:| 
| `php bin/console make:controller` | Creer un controller |





