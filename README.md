Projet mis en pause, pour l'instant, je n'arrive pas à choisir la manière d'implémenter ce que je désire mettre en place ...<br>

# Prepare
Un logiciel d'aide à la gestion d'évènement, que ce soit pour la préparation, le déroulement ou l'après, il peut s'adapter à nos besoins.

## Mise en garde
Cette application est en cours de création et n'a pas encore été testée en ligne. Certaines mesures de sécurité sont encore manquantes, je vous déconseille de l'utiliser en production en l'état.

Et c'est affreusement moche pour l'instant, je n'ai ajouté que strict minimum de mise en page, le but actuel étant essentiellement d'avoir une base fonctionnelle.<br>
Cela ne veut pas dire que l'appli sera belle une fois terminée, mes choix visuels sont régulièrement jugés comme appartant à une autre époque.

## Mise en Route

### Prérequis

Il vous faut un serveur php version minimale 8.1<br>
ainsi qu'une base de données mysql.

Avant de démarrer, assurez-vous de suivre ces étapes pour préparer votre environnement.

1. Modifier le contenu du fichier de migration `Version20240216230000_insert_admin.php` en y entrant le pseudo du maitre des lieux et son mot de passe hashé. Vous pouvez récupérer le hash de votre mot de passe en entrant la commande suivante dans le terminal :

    ```bash
    php bin/console security:hash-password
    ```
    Vous pourrez ensuite vous connecter avec ce pseudo et ce mot de passe et vous aurez le rôle de Super Admin

2. Dans le fichier .env, donnez les valeurs qui vous correspondent à ces variables :

    ```dotenv
    # fichier .env
    DB_USER=root
    DB_PASSWORD=
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_NAME=prepare
    DB_VERSION=mariadb-10.4.32
    ```

3. Pour une mise en production, définissez ces deux variables d'environnement dans le fichier `.env` :

    ```dotenv
    # fichier .env
    APP_DEBUG=0
    APP_ENV=prod
    ```

### Les commandes à lancer :

Assurez-vous d'exécuter ces commandes pour que le projet soit fonctionnel.

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
yarn install
yarn run build
```

## Comment ça fonctionne

### Les utilisateurs

Lorsqu'un utilisateur non identifié visite le site, il n'a pas accès au contenu.

Une fois son compte créé, l'utilisateur voit ce message :
```
Ton compte n'est pas activé, faut voir ça avec l'admin ...
```

Si l'utilisateur est connecté et que son compte a été activé par un admin, il pourra voir la liste des projets qu'il a créés ainsi que ceux auxquels il participe.

Si un admin a attribué le rôle de contributeur à une utilisateur alors celui-ci pourra créer un nouveau projet.

### Les projets

Seul le créateur d'un projet peut gérer le choix des personnes participantes, il ne peut choisir que parmi les utilisateurs donc le compte a été activé.

Dans un projet, le créateur et les paricipants peuvent créer une catégorie.

Dans une catégorie, il est possible d'ajouter des idées.<br>
S'il s'agit d'un déménagement, alors l'idée sera un objet.
S'il s'agit d'un voyage, l'idée pourra être quelque chose à emporter ou à acheter sur place, un lieu où dormir,  une visite à effectuer ... Il n'y a pas de limite.<br>
S'il s'agit d'une liste de tâche, l'idée pourra être une des tâches à effectuer.<br>
J'ai fait le choix qu'un projet ne soit visible que par ses participants afin de donner la possibilité de gérer l'organisation d'une fête surprise. Dans ce cas, une idée peut être par exemple un cadeau ou n'importe quel évènement devant avoir lieu avant ou pendant la fête.

### Les idées

Une idée ne peut être modifiée que par son créateur et le détenteur du projet.

Lors de la création d'une idée, il y a plusieurs propriétés à renseigner:<br>
- un type : choix à effectuer entre
    - objet
    - action
- un nom
- un commentaire
- un type de mesure<br>
Le choix disponible est différent selon le type choisi.
    - poids, volume, taille ou surface
    - durée, horodatage ou distance
    - aucun : lorsque l'unité de mesure est l'objet lui-même, par exemple un balai.
- une quantité nécessaire
- l'unité de mesure associée à la quantité renseignée <span style="color: red;">(reste à faire)</span><br>
Les choix disponibles dépendent du type de mesure selectionné.
    - t, kg, hg, dag, g, dg, cg, mg
    - m, dm, cm, mm (taille)
    - km, hm, dam, m (distance)
    - m², dm², cm², mm²
    - m³, l, dl, cl, ml
    - jour, heure, minute, seconde, milliseconde
    - un champ date et heure
    - un champ texte libre en prévision de cas spéciaux, par exemple boite, paquet de 10


Les champs suivants sont également utilisés pour chaque personne désirant interagir avec l'idée après sa création.<br>
- une case à cocher différente selon qui interagit
    - participant : "Je peux fournir"
    - créateur du projet : "J'ai"
- une quantité
- une unité de mesure
- une image <span style="color: red;">(reste à faire)</span>

La partie précédente est à refaire complètemenent; Pour l'instant les champs "j'ai" et "je peux fournir" sont déjà en place, mais un seul champ quantité est disponible. On ne peut pas encore avoir plusieurs personnes interagissant avec un même objet. Une fois ceci modifié, il sera plus simple de gérer un projet.

De plus, un champ "Je m'en occupe" <span style="color: red;"> reste à mettre en place</span>.<br>
&nbsp;&nbsp;Je suppose que ce champ devrait être associé aux projets de type action uniquement, mais ce n'est pas encore tranché.

Le créateur du projet peut également valider un objet; Une fois fait on peut considérer que nous n'avons plus a nous en occuper, la seule activité possible pour les participants sera la discussion relative à cet objet.

### Les discussions <span style="color: red;">(reste à faire)</span>

Il est également possible d'ajouter des discussion aux éléments créés (projet, catégorie et idée).<br>


### Les "non vu" <span style="color: red;">(reste à faire)</span>

Je n'ai pas encore décidé quelle méthode je souhaite utiliser pour prévenir de la présence de nouveaux éléments, mais cela fait partie de mes points de réflexion. Je mettrai quelque chose en place.


## La suite

### à faire avant mise en prod

- ajouter un flashmessage à la création de compte
- les propriétés d'un item (comprendre objet) (celles de la création) ne devraient être modifiable que par le créateur du projet
- ajouter une image sur les Item
- message d'erreur en rouge dans les formulaires
- mettre en place un slug sur chaque entité de l'appli
- vérifier les controlleurs et les vues au sujet des droits d'accès : il en manque quelque uns !
- ajouter un colonne last-updated-at et by à tous les objets
- style en mode mobile first !
- modification de la table item : retirer les propriétés proposed et owned
- créer les tables :
    - own_type
    - quantity
    - image ou picture
- UI : en home page
    - coller le style de bouton sur "Nouveau projet"
    - afficher les projets en colonne

### Sera pour la livraison suivante
Todo

### Moins urgent
Todo

### idées supplémentaires
