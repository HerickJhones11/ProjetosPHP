<!DOCTYPE html>
<html>
<head>
	<title>Imprimir Nota</title>
</head>
<body>

	<section>
		<div style="background: #DCDCDC; width: 350px;">
			<div>
				<h2>Nota Fiscal - Email</h2>
			</div>
			<div>
				*********************************<br>
				Nome: <?= $notafiscal->nomeCliente ?><br>
				Email: <?= $notafiscal->emailCliente ?><br>
				Produto: <?= $notafiscal->produto ?><br>
				Quantidade: <?= $notafiscal->quantidade ?><br>
				Valor do produtor: <?= $notafiscal->valorProduto ?><br>
				Valor total: <?= $notafiscal->valorNota ?><br>
				*********************************<br>
			</div>
		</div>
	</section>
</body>
</html>