
# 👥 Des nouveaux types

Ajout d'utilisateurs et de droits sur tout ça !

## Commandes utiles

| Requirement      |
| ------------- |
| `composer require symfony/maker-bundle --dev`|
| `composer require orm`     |
| `composer require orm-fixtures --dev`     |
| `composer require fakerphp/faker --dev` |
| `composer require symfony/serializer-pack` |
| `composer require sensio/framework-extra-bundle` |
| `composer require symfony/validator doctrine/annotations` |
| `composer require vich/uploader-bundle` |
| `composer require security` |
| `composer require lexik/jwt-authentication-bundle` |

| Commande      | Utilité       | 
| ------------- |:-------------:| 
| `openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096`     | Creer une clée Privée     | 
| `openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout`     | Creer une clée Publique     | 

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


    Cours 8
    
| Commande      | Utilité       | 
| ------------- |:-------------:| 
| `php bin/console make:subscriber`| Creer un nouveau Subscriber |

    Cours 10

| Commande      | Utilité       | 
| ------------- |:-------------:| 
| `openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096`     | Creer une clée Privée     | 
| `openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout`     | Creer une clée Publique     | 
