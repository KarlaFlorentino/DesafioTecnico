<?php 
  require __DIR__ . '../../../vendor/autoload.php'; // caminho relacionado a SDK

   use Gerencianet\Exception\GerencianetException;
   use Gerencianet\Gerencianet;

  include("database/conexao.php");


  $sql = "SELECT * FROM produto WHERE id_produto = " . $_POST["id_produto"];
  $result = $conn->query($sql); 
  $exibir = $result->fetch_assoc();

  $nome_produto = $exibir["nome"];
  $valor = $exibir["valor"];

  $nome = $_POST["nome"]; 
  $cpf = $_POST["cpf"]; 
  $telefone = $_POST["telefone"];
  $expire_at = date('Y-m-d', strtotime('+2 days', strtotime(date('Y-m-d'))));
  $until_date = date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))));

   $clientId = 'Client_Id_4e4327e045ceb277ed5f62db8c46c399c309e0bf';// insira seu Client_Id, conforme o ambiente (Des ou Prod)
   $clientSecret = 'Client_Secret_bb1ad596c70e1c17089cd27ec860816670412681'; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

    $options = [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'sandbox' => true // altere conforme o ambiente (true = desenvolvimento e false = producao)
    ];

   $item_1 = [
       'name' => $nome_produto, // nome do item, produto ou serviço
       'amount' => 1, // quantidade
       'value' => $valor * 100 // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
   ];
   $items = [
       $item_1
   ];
   //$metadata = array('notification_url'=>'sua_url_de_notificacao_.com.br'); //Url de notificações
   $customer = [
       'name' => $nome, // nome do cliente 
       'cpf' => $cpf, // cpf válido do cliente
       'phone_number' => $telefone, // telefone do cliente
   ];
   $discount = [ // configuração de descontos
       'type' => 'currency', // tipo de desconto a ser aplicado
       'value' => 599 // valor de desconto 
   ];
   $configurations = [ // configurações de juros e mora
       'fine' => 200, // porcentagem de multa
       'interest' => 33 // porcentagem de juros
   ];
   $conditional_discount = [ // configurações de desconto condicional
       'type' => 'percentage', // seleção do tipo de desconto 
       'value' => 500, // porcentagem de desconto
       'until_date' => $until_date // data máxima para aplicação do desconto
   ];
   $bankingBillet = [
       'expire_at' => $expire_at, // data de vencimento do titulo
       'message' => 'teste\nteste\nteste\nteste', // mensagem a ser exibida no boleto
       'customer' => $customer,
       'discount' =>$discount,
       'conditional_discount' => $conditional_discount
   ];
   $payment = [
       'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
   ];
   $body = [
       'items' => $items,
       //'metadata' =>$metadata,
       'payment' => $payment
   ];
   try {
     $api = new Gerencianet($options);
     $pay_charge = $api->oneStep([],$body);

     //echo '<pre>';
     //print_r($pay_charge);
     //echo '<pre>';

    $pdfCharge = $pay_charge["data"]["pdf"]["charge"];
    $chargeId = $pay_charge["data"]["charge_id"];

    $sql = "INSERT INTO compras (link_PDF, id_boleto)
    VALUES ('".$pdfCharge."',".$chargeId.")";
    if ($conn->query($sql) === TRUE) {
      echo "<script>window.open('".$pdfCharge."', '_blank');</script>";
      echo "<script>window.location = '../web/listar.php';</script>";
    } else {
      echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close(); 
       
    } catch (GerencianetException $e) {
       print_r($e->code);
       print_r($e->error);
       print_r($e->errorDescription);
   } catch (Exception $e) {
       print_r($e->getMessage());
   }