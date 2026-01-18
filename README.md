# Vite-Gourmand
Application web Symfony pour la gestion et l’affichage de menus gastronomiques. Architecture MVC, Doctrine ORM (XML), Twig, Bootstrap et Docker. Projet académique orienté bonnes pratiques et structuration logicielle.

## Stratégie de branches

Le projet suit une stratégie de branches simple et professionnelle.

### Branches principales
- **main** : branche stable, protégée, représentant une version livrable
- **develop** : branche d’intégration des fonctionnalités

### Branches de fonctionnalités
- **feature/*** : une branche par fonctionnalité ou tâche

### Workflow

- feature → develop → main
  
### Règles
- Aucun commit direct sur `main`
- Toute fonctionnalité doit être développée dans une branche `feature/*`
- Les branches `feature/*` sont fusionnées dans `develop`
- Seule une version stable de `develop` peut être fusionnée dans `main`
