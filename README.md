# Address Book API

## Installation

- Importer dans phpmyadmin la base de donnée : addressbook.sql

## Utilisation

- La page d'accueil index.php dans root permet de créer un user (John Doe) et de tester des requêtes POST
- Les requêtes sont envoyé à index.php dans le dossier api


### Méthodes

#### GET

**Contacts**

	/api/index.php?contacts=(all/[firstname])}

**Adresse**

	/api/index.php?(contact_id=[contact_id]/id=[id])

#### POST

Les méthodes **Add**, **Edit**, **Delete** requièrent tous un token d'authentification

### Options

#### JSON
Par défaut la réponse est sous format JSON

#### XML
Pour une réponse sous format XML, il suffit de rajouter le paramètre GET "xml" lors d'une requête GET

Example :

	/api/index.php?contacts=all&xml