
# ✨ Fixtures


Pour l'instant ça va vite, mais trouve une manière de remplir ces données Rapidement grâce aux fixtures.
Pour se faire jette un oeil du coté des Requirements, et reproduis l'arborecence du projet. A partir de [./src/AppFixtures.php](./src/AppFixtures.php) 

## Commandes utiles

| Requirement      |
| ------------- |
| `composer require symfony/maker-bundle --dev`|
| `composer require orm`     |
| `composer require orm-fixtures --dev`     |

| Commande      | Utilité       | 
| ------------- |:-------------:| 
| `php bin/console doctrine:fixtures:load `| Execute les fixtures |


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




