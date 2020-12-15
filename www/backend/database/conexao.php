<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>
<?php
	//Parâmetros de conexão
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "bdGnVendas";
	// Cria a conexão
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check a conexão
	if ($conn->connect_error) {
	 die("Falha na conexão: " . $conn->connect_error);
	}
?>
</body>
</html>