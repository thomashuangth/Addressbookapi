<?php

require("models/database.php");

$db = new Database("127.0.0.1", "addressbook", "root", "");

?>

<html>
	<head>
		<title>AB API</title>
	</head>
	<body>
		<h1>Address Book API</h1>

		<h2>Création de l'utilisateur John Doe POST</h2>
		<form action="api/index.php" method="POST">
			<button name="newuser">Créer</button>
		</form>

		<h2>Création d'une adresse pour John POST</h2>
		<form action="api/index.php" method="POST">
			<input type="text" name="street" placeholder="Rue">
			<input type="number" name="zipcode" placeholder="Code Postal" required>
			<input type="text" name="city" placeholder="Ville" required>
			<input type="text" name="token" placeholder="Jeton">
			<button type="submit" name="add">Valider</button>
		</form>

		<h2>Modification d'une adresse pour John POST</h2>
		<form action="api/index.php" method="POST">
			<input type="number" name="id" placeholder="ID de l'adresse">
			<input type="text" name="street" placeholder="Rue">
			<input type="number" name="zipcode" placeholder="Code Postal">
			<input type="text" name="city" placeholder="Ville">
			<input type="text" name="token" placeholder="Jeton">
			<button type="submit" name="edit">Modifier</button>
		</form>

		<h2>Suppression d'une adresse pour John POST</h2>
		<form action="api/index.php" method="POST">
			<input type="number" name="id" placeholder="ID de l'adresse">
			<input type="text" name="token" placeholder="Jeton">
			<button type="submit" name="delete">Supprimer</button>
		</form>
	</body>
</html>