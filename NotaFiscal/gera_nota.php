<?php
	
	require "./biblioteca/PHPMailer/Exception.php";
	require "./biblioteca/PHPMailer/OAuth.php";
	require "./biblioteca/PHPMailer/PHPMailer.php";
	require "./biblioteca/PHPMailer/POP3.php";
	require "./biblioteca/PHPMailer/SMTP.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	class NotaFiscal {

		private $produto = null;
		private $quantidade = null;
		private $valorProduto = null;
		private $nomeCliente = null;
		private $emailCliente = null;
		private $valorNota = null;
		public $notaQueVaiSerEnviada = null;
		public $status = array('codigo_status'=> null, 'descricao_status'=>'');

		#Gettes e Setters
		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $novo_valor){
			$this->$atributo = $novo_valor;
		}


		//Métodos
		public function verificaCampos(){
			if(empty($this->produto) || empty($this->quantidade) || empty($this->valorProduto) || empty($this->nomeCliente)){
                return false;
            }else{
            	return true;
            }
		}

		public function calculaValorNota(){
			$this->valorNota = $this->valorProduto * $this->quantidade;
			return $this->valorNota;
		}

	}
	//echo "entramos aqui";
	//echo $_POST[''];

	$notafiscal  = new NotaFiscal();
	$notafiscal->__set('produto', $_POST['produto']);
	$notafiscal->__set('quantidade', $_POST['quantidade']);
	$notafiscal->__set('valorProduto', $_POST['valorProduto']);
	$notafiscal->__set('nomeCliente', $_POST['nomeCliente']);
	$notafiscal->__set('emailCliente', $_POST['emailCliente']);

	if(!$notafiscal->verificaCampos()){
		header('Location: index.php');
	}


	$notafiscal->calculaValorNota();

	$notafiscal->notaQueVaiSerEnviada = '<div style="background: #DCDCDC; width: 350px;"><div><h2>Nota Fiscal - Email</h2></div><div><strong>***************************************</strong><br><strong>Nome:</strong> '.$notafiscal->nomeCliente.'<br><strong>Produto:</strong> '.$notafiscal->produto.'<br><strong>Quantidade:</strong> '.$notafiscal->quantidade.'<br><strong>Valor do Produto:</strong> '.$notafiscal->valorProduto.'<br><strong>Valor total:</strong> '.$notafiscal->valorNota.'<br><strong>***************************************</strong></div></div>';


	echo $notafiscal->notaQueVaiSerEnviada;

	$mail = new PHPMailer(true);
	try {
	    //Server settings
	    $mail->SMTPDebug = false;                                 // Enable verbose debug output
	    $mail->isSMTP();                                      // Set mailer to use SMTP
	    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    $mail->Username = 'testphpppp@gmail.com';                 // SMTP username
	    $mail->Password = '1234$#@!';                           // SMTP password
	    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = 587;                                    // TCP port to connect to

	    //Recipients
	    $mail->setFrom('testphpppp@gmail.com', 'Nota Fiscal');
	    $mail->addAddress($notafiscal->emailCliente);     // Add a recipient
               // Name is optional
	    //$mail->addReplyTo('info@example.com', 'Information');
	    //$mail->addCC('cc@example.com');
	    //$mail->addBCC('bcc@example.com');

	    //Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Nota Fiscal';
	    $mail->Body    = $notafiscal->notaQueVaiSerEnviada;
	    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $mail->send();
	    $notafiscal->status['codigo_status'] = 1;
	    $notafiscal->status['descricao_status'] = 'E-mail enviado com sucesso';
	} catch (Exception $e) {

		$notafiscal->status['codigo_status'] = 2;

	    $notafiscal->status['descricao_status'] = 'Não foi possivel enviar esse email. Tente novamente mais tarde.';
	    echo 'Detalhes do erro: ' . $mail->ErrorInfo;
	}


?>

<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Nota fiscal</title>
</head>
<body>

	<div class="">
		<div>
			<? if($notafiscal->status['codigo_status'] == 1){ ?>
				<div class="">
					<h1 class="display-4 text-success">Nota Fiscal enviada</h1>
					<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
				</div>

			<? } ?>

			<? if($notafiscal->status['codigo_status'] == 2){ ?>
				<div class="">
					<h1 class="display-4 text-success">Erro ao enviar nota fiscal</h1>
					<a href="index.php" class="btn btn-danger btn-lg mt-5 text-white">Voltar</a>
				</div>

			<? } ?>
		</div>
	</div>
</body>
</html>