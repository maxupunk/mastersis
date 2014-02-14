<?php

/**
 * String $URL
 * URL para onde deve ser enviada a requisição XML via post para emissão de boleto.
 */
$url = "https://integracao.gerencianet.com.br/xml/boleto/emite/xml";

/**
 * String $token
 * Variável que armazena o token de integração utilizado na geração do boleto.
 * Gere o token em sua conta Gerêncianet e atribua à variável.
 */
$token = '';

/**
 * String $XML
 * XML com os dados necessários para emissão de um boleto pelo sistema Gerêncianet.
 */
$xml = "<?xml version='1.0' encoding='utf-8'?>
<boleto>
	<token>$token</token>
	<clientes>
		<cliente>
			<nomeRazaoSocial>Nome ou Razao Social</nomeRazaoSocial>
			<cpfcnpj>50481946160</cpfcnpj>
			<opcionais>
				<email></email>
				<cep>35400000</cep>
				<rua>Rua Jose</rua>
				<numero>75</numero>
				<bairro>Piedade</bairro>
				<complemento>casa</complemento>
				<estado>MG</estado>
				<cidade>Ouro Preto</cidade>
			</opcionais>
		</cliente>
	</clientes>
	<itens>
		<item>
			<descricao>Produto 2</descricao>
			<valor>1030</valor>
			<qtde>2</qtde>
			<desconto>500</desconto>
		</item>
	</itens>
	<vencimento>15/07/2057</vencimento>
	<opcionais>
		<contra>s</contra>
		<btaxa>n</btaxa>
		<enviarParaMim>s</enviarParaMim>
        <continuarCobrando>0</continuarCobrando>
        <correios>n</correios>
	</opcionais>
</boleto>";

/**
 * O XML enviado não pode conter quebras de linha e tabulações.
 */
$xml = str_replace("\n", '', $xml);
$xml = str_replace("\r",'',$xml);
$xml = str_replace("\t",'',$xml);

/**
 * Handle $ch : Manipulador de comunicação para transferência de dados, via CURL.
 */
$ch = curl_init();

/**
 * Atualiza a URL de destino da variável $ch para a URL definida pela variável $url.
 */
curl_setopt($ch, CURLOPT_URL, $url);

/**
 * Configura a variável $ch para retornar o resultado da comunicação, ao invés de exibir diretamente.
 */
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

/**
 * Configura o máximo de redirecionamentos permitido.
 */
curl_setopt($ch, CURLOPT_MAXREDIRS, 2);

/**
 * Configura para que seja inserido automaticamente o campo Referer: nas requisições que seguem um redirecionamento Location:
 */
curl_setopt($ch, CURLOPT_AUTOREFERER, true);

/**
 * Array $data: Armazena o xml a ser enviado($data['entrada']=$xml)
 */
$data = array('entrada' => $xml);

/**
 * Configura para que a requisição seja enviada via POST
 */
curl_setopt($ch, CURLOPT_POST, true);

/**
 * Define os dados a serem enviados na requisição via POST
 */
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

/**
 * Define o tempo limite de tentativa de conexão
 */
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

/**
 * Configura o USERAGENT da requisição
 */
curl_setopt($ch, CURLOPT_USERAGENT, 'seu agente');

/**
 * Envia a requisição via POST com o XML e retorna o resultado da requisição
 * String $resposta: Resposta da requisição
 */
$resposta = curl_exec($ch);

/**
 * Encerra a ponte de comunicação
 */
curl_close($ch);

/**
 * Imprime a resposta da requisição.
 */
echo $resposta;