
# ✨ Première entitée

On Avance, maintenant il suffit de creer tes premieres entitées
avec `php bin/console make:entity`.  puis `php bin/console doctrine:schema:update --force`  pour creer la table en base de données.


## Commandes utiles
Cours 1 :

| Requirement      |
| ------------- |
| `composer require symfony/maker-bundle --dev`|
| `composer require orm`     |

| Commande      | Utilité       | 
| ------------- |:-------------:| 
| `symfony new [nom] `| Creer un projet symfony |
| `symfony serve`     | Démarre le projet      | 

| Commande  Doctrine    | Utilité       | 
| ------------- |:-------------:| 
| `php bin/console doctrine:database:create`     | Creer la bdd      | 
| `php bin/console doctrine:schema:update --force`| Adapte le schéma de bdd (developpement seulement ! ) |
| `php bin/console make:entity`     | Creer une entitée avec l'aide de Doctrine    | 



