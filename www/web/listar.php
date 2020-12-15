<!DOCTYPE html>
<html>
<head>
<title>Gn-Vendas</title>
<meta charset="utf-8">
<style>
	label{
		display: inline-block;
		width: 100px;
	}
</style>
</head>
<script type="text/javascript">
	function retornaValor(elemento) {
	  var x = elemento.id;
	  document.getElementById('id_produto').value = x;
	}

	function valida_CPF() {
		var strCPF = document.getElementById('cpf').value;

		if(strCPF.includes('.','-')){
	  		alert('O campo CPF deve conter somente números');
      		return false;
      	} 


		var Soma;
	    var Resto;
	    Soma = 0;
	  	if (strCPF == "00000000000"){
	  		alert('O CPF informado é invalido!');
      		return false;
      	} 

	  	for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
	  	Resto = (Soma * 10) % 11;

	    if ((Resto == 10) || (Resto == 11))  Resto = 0;
	    if (Resto != parseInt(strCPF.substring(9, 10)) ){
	  		alert('O CPF informado é invalido!');
      		return false;
      	} 

	  	Soma = 0;
	    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
	    Resto = (Soma * 10) % 11;

	    if ((Resto == 10) || (Resto == 11))  Resto = 0;
	    if (Resto != parseInt(strCPF.substring(10, 11) ) ){
	  		alert('O CPF informado é invalido!');
      		return false;
      	} 

	    return true;
	}

	function valida_telefone(){
		var strTelefone = document.getElementById('telefone').value;
		if(strTelefone.length != 11){
	  		alert('O Telefone informado é invalido!');
      		return false;
      	} 
      	return true;
	}

	function valida_form(){
		if(!valida_CPF()) return false;
		else if(!valida_telefone()) return false;

		return true;
	}
</script>
	<body style="background: lightgray">
		<div id="interface">
			<br>
			<a href="index.php"><button type="button">Voltar para a tela de Cadastro</button></a>
			<br><br><br>
			<fieldset>
				<legend>Dados Comprador</legend>
				<form action="../backend/comprar.php" method="post" onsubmit="return valida_form();">
					<label>Nome:</label><input type="text" name="nome"
					required="required"><br><br>
					<label>CPF:</label><input type="text" id="cpf" name="cpf"
					required><br><br>
					<label>Telefone:</label><input type="text" id="telefone" name="telefone"
					required><br><br>
					<input type="hidden" id="id_produto" name="id_produto">
				
					<?php
					    include '../backend/database/conexao.php';

						$sql = "SELECT * FROM produto";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
					?>

			</fieldset>

			<fieldset>
					<legend>Produtos Cadastrados</legend>
					<table class="table table-hover">
						<tr> 
							<th>Nome</th> 
							<th>Valor</th>
							<th></th>
						</tr>
						<?php
							while ($exibir = $result->fetch_assoc()){
						?>
						<tr>
							<td><?php echo $exibir["nome"] ?> </td>
						    <td><?php echo $exibir["valor"] ?> </td>
							<td><button type="submit" id="<?php echo $exibir["id_produto"] ?>" onclick="retornaValor(this)">Comprar</button></td>
						 </tr>
						<?php
						 	}
						?>
					</table>
					<?php
						}
						else {
							echo "Nenhum registro encontrado.";
						}
						$conn->close();
					?>
				</form>
			</fieldset>
		</div>

	</body>
</html>