<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
	include 'database/conexao.php';
	$nome = $_POST["nome"];
	$valor = $_POST["valor"];

	$sql = "INSERT INTO produto (nome, valor)
	VALUES ('".$nome."',".$valor.")";
	if ($conn->query($sql) === TRUE) {
		 //echo "<script>alert('Registro inserido com sucesso.');</script>";
		 echo "<script>window.location = '../web/listar.php';</script>";
	} else {
		echo "Erro: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
?>
</body>
</html>