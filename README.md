Pour créer la base de données, il vous faut dans un premier temps installer Composer ainsi que la CLI de Symfony si ce n'est déjà fait.

Vous pouvez ensuite exécuter la commande "symfony check:requirements" pour s'assurer des prérequis (cela peut poser problème s'il en manque).

Ensuite : "symfony console doctrine:database:create" -> crée la BDD sans les tables.

Puis : "symfony console make:migration" -> crée les commandes SQL à exécuter à partir des entités présentes.

Enfin : "symfony console doctrine:migrations:migrate" -> exécute les commandes.

Vous avez également la possibilité de pré-remplir la base grâce aux data fixtures. Cela n'ajoute pas tout, vous aurez peut-être des choses à rajouter à la main : "symfony console doctrine:fixtures:load".
