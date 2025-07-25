# MaxitSA - Portefeuille 

Une application web de portefeuille mobile développée en PHP natif .

##  Installation

### 1. Cloner le projet
```bash
git clone https://github.com/papesembene/Maxit_project.git
cd Maxit_project
```

### 2. Configuration base de données
Créez votre base  et configurez le fichier `.env` :

```env
DB_HOST=localhost
DB_PORT=5432
DB_NAME=maxit_db
DB_USER=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

### 3. Migrations et données
```bash
php migrations/migrate.php
php seeders/seed.php
```

### 4. Permissions
```bash
chmod -R 777 public/images/



```
##  Utilisation

1. **Inscription** : `/register`
2. **Connexion** : `/`
3. **Dashboard** : `/client/dashboard`

##  Routes principales

| Route | Description |
|-------|-------------|
| `/` | Connexion |
| `/register` | Inscription |
| `/client/dashboard` | Dashboard |
| `/client/depot-transfert` | Dépôt par transfert |
| `/client/acountsList` | Gestion comptes |

##  Auteur
**Pape Sembene** - [GitHub](https://github.com/papesembene)