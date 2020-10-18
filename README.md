# creation-api

Groupe: Kevin Zhang, Alexandre Duval, Julien Da Costa, Xavier Lami, Axel Guillon, Mael Bourdeleix.

# Utilisation de l'API - Exemples

Lire les informations : http://localhost/creation-api/banque/user/lire.php en GET.

Lire une information : http://localhost/creation-api/banque/user/lire_un.php en GET.

Inserer des informations dans la BDD : http://localhost/creation-api/banque/user/creer.php en POST.

Supprimer un élément de la BDD : http://localhost/creation-api/banque/user/supprimer.php en DELETE.

Modifier un élément de la BDD : http://localhost/creation-api/banque/user/modifier.php en PUT.

# Utilisation de l'API - A savoir

Les valeurs sont à entrer en raw JSON sur Postman dans l'onglet body.

Nous pouvons remplacer "user" par "cb", "compte", "transaction" ou "client" en fonction de la table que l'on souhaite modifier.

Nous pouvons remplacer "banque" par "externe" en fonction du rôle que l'on souhaite avoir.
