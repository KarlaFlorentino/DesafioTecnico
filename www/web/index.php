<!DOCTYPE html>
<html>
<head>
<title>Gn-Vendas</title>
<style>
	label{
		display: inline-block;
		width: 100px;
	}
</style>
</head>
<script type="text/javascript">
function valida_numero() {
   var valor = document.getElementById('valor').value.replace(",", ".");

   if ( isNaN( valor ) ) { 
      alert('O valor informado é invalido!');
      return false; 
   }
   document.getElementById('valor').value = valor;
   return true;
}
</script>
<body>
	<body style="background: lightgray">
	<div id="interface">
		<fieldset> <legend>Cadastro de Produtos</legend>
			<form action="../backend/cadastro.php" method="post" onsubmit="return valida_numero();">
				<label>Nome:</label><input type="text" name="nome"
				required="required"><br><br>
				<label>Valor:</label><input id="valor"  type="text" name="valor"
				required><br><br>
				<a href="listar.php"><button type="button">Listar Produtos</button></a>
				<label></label>
				<input type="submit" name="btnCadastrar" value="Cadastrar">
			</form>
		</fieldset>
	</div>
	</body>
</html>