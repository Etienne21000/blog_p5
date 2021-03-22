# Installation projet 5
## Formation DA php / Symfony

### 1. Base de donnée
- Créer une nouvelle table dans phpMyAdmin
- Clicquer sur l'onglet import
- choisir le fichier correspondant à la bdd du projet
- executer l'import

### 2. Installation du projet à partir de GitHub
- Copier le lien du repository sur GitHub
- Initialiser Git dans le nouveau projet `git init`
- lancer la commande `git clone dans le terminal à la racine du projet en ajoutant l'url du repository`
- `git clone https://github.com/Etienne21000/projet_5.git`


### 3. Configuration du projet
- Dans le structure MVC du projet ouvrir la class /src/Model/Core/AbstractManager.php
- Aller à la methode ```DbConnect()```
- Dans `$this->db = new \PDO()` changer les identifiants de connexion à la base de donnéé
