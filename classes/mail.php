<html>
<head>
<title>Recuperação de Senha</title>
</head>
<body>

<?php

date_default_timezone_set('America/Toronto');
include($_SERVER['DOCUMENT_ROOT'].'/lib/phpmailer/class.phpmailer.php');
include($_SERVER['DOCUMENT_ROOT'].'/classes/conexao.php'); 

//configura idioma
header('Content-Type:text/html;charset=utf-8');


if (isset($_REQUEST['mat']) && strlen($_REQUEST['mat']) >0){
	
	$matricula = $_REQUEST['mat'];
	$sistema = "Portal TOEFVM";
	
	
	mysqli_select_db($con, 'USUARIOS');
	$query_user = "SELECT TBL_USUARIOS.ID_USUARIO, TBL_USUARIOS.NM_USUARIO, TBL_USUARIOS.CD_MATRICULA, TBL_USUARIOS.DS_SENHA, TBL_USUARIOS.DS_EMAIL FROM TBL_USUARIOS WHERE TBL_USUARIOS.CD_MATRICULA = '$matricula'";
	$user = mysqli_query($con, $query_user) or die(mysqli_error());
	$row_user = mysqli_fetch_assoc($user);
	
	//verifica se não existe o usuário com a matrícula passada.
	if (strlen($row_user['NM_USUARIO']) < 2 ){
		echo '<script type="text/javascript">alert("' . "Sua matrícula não foi encontrada($matricula).\\nSe a matrícula estiver correta clique no botão 'NÃO TENHO CADASTRO' na tela de login, para se cadastrar." . '")</script>';
		echo '<script type="text/javascript">window.location ="/classes/login.php"</script>';				
		
	}else{
		//verifica se não há email cadastrado.
		if (strlen($row_user['DS_EMAIL']) < 2 ){
			echo '<script type="text/javascript">alert("' . "Você não possui e-mail cadastrado para o informe automático de sua senha. \\n\\nSolicite suporte atrávés do e-mail 'Suporte.Tovm@Vale.com', passando também sua matrícula." . '")</script>';
			echo '<script type="text/javascript">window.location ="/classes/login.php"</script>';
		}
	}
	
	
	
}else	{
	echo '<script type="text/javascript">alert("' . "Matrícula inválida!" . '")</script>';
	echo '<script type="text/javascript">window.location ="/classes/login.php"</script>';	
}

//se estiver tudo certo, define uma senha temporária para o usuário.

//gera senha randomica nos padrões de segurança definidos pela TI Vale.
function gerasenha($tamanho = 10){

    //letras minusculas embaralhadas
    $letrasP = str_shuffle('abcdefghijklmnopqrstuvwxyz');

    //letras maiusculas embaralhadas
    $letrasG = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');

    //numeros randomicos embaralhados
    $numeros = str_shuffle(1234567890);

    //caracteres especiais embaralhados
    $caracteres = str_shuffle('!@#$%&*()[]{}/_-\|?');
    
    //pega os primeiros caracteres de cada tipo
    $maiusculas = substr($letrasG, 0, 3);
    $minusculas = substr($letrasP, 0, 3);
    $numeros = substr($numeros, 0, 2);
    $especiais = substr($caracteres, 0, 2);

    // junta tudo em uma string
    $tudo = $maiusculas.$minusculas.$numeros.$especiais;
  
    //embaralha tudo
    $senha = str_shuffle($tudo);

    return $senha;

}
//******************************************************** */

$novaSenha = gerasenha();

mysqli_select_db($con, 'USUARIOS');
$sql = "UPDATE TBL_USUARIOS SET DS_SENHA = "."'".$novaSenha."'"." WHERE CD_MATRICULA =".$_REQUEST['mat'];

$result = mysqli_query($con, $sql); 

if($result){

    $id = $row_user['ID_USUARIO'];
	$nome = $row_user['NM_USUARIO'];
	$email = $row_user['DS_EMAIL'];
	$senha = $novaSenha;

	$mail = new PHPMailer();
	$body = utf8_decode('
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<body>
		Olá,
		<br><br>
		Você está recebendo esta mensagem porque o(a) '.$nome.' cadastrou esse e-mail no portal TOVM.
		<br><br>
		Se é você, basta acessar o portal com os dados abaixo.
		<br>
		Se não for você, favor encaminhar esse e-mail ao usuário(a) acima.
		<br><br>
		O usuário para acesso ao portal TOVM e subsistemas é a mátricula ('.$matricula.').<br>
		A nova senha é: <strong style="color:red;" >'.$senha.'</strong><br>
		Lembrando que você deverá definir uma nova senha ao se logar.
		<br><br>
		
		Acesse os sitemas do portal através dos links:<br><br>
		Central de Kaizens: <a href="http://tovm/kaizens">http://tovm/kaizens</a><br>
		SGM: <a href="http://tovm/sgm">http://tovm/sgm</a>
		
		<br><br><br>
		Para dúvidas ou sugestões envie um e-mail para "Suporte.Tovm@Vale.com".
		<br><br>
		Att.<br>
		<strong>Tecnologia Operacional</strong>
	</body>
	</html>
	');


	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host       = "mail.yourdomain.com"; 	// SMTP server
	$mail->SMTPDebug  = 0;                     	// enables SMTP debug information (for testing)
	$mail->SMTPAuth   = true;                  	// enable SMTP authentication
	$mail->Host       = "172.26.102.30"; 		// sets the SMTP server
	$mail->Port       = 25;                    	// set the SMTP port for the GMAIL server
	$mail->Username   = "yourname@yourdomain"; 	// SMTP account username
	$mail->Password   = "yourpassword";        	// SMTP account password

	$mail->SetFrom('Suporte.Tovm@Vale.com', utf8_decode($sistema));
	$mail->AddReplyTo('Suporte.Tovm@Vale.com', utf8_decode($sistema));
	$mail->Subject    = utf8_decode("Recuperação de senha");
	$mail->AltBody    = "Caso tenha dificuldade em visualizar, envie um e-mail para 'Suporte.Tovm@Vale.com'."; // optional, comment out and test
	$mail->MsgHTML($body);
	$address = $email;
	$mail->AddAddress($address, "Usuário");
	$mail->AddAttachment(""); // attachment
	$mail->AddAttachment(""); // attachment


	if(!$mail->Send()) {
		echo "Erro ao enviar e-mail: " . $mail->ErrorInfo;
	} else {

        mysqli_select_db($con, 'USUARIOS');
        $sql = "INSERT INTO TBL_RESETS_SENHAS (ID_USUARIO) VALUES (".$id.")";
        
        $result = mysqli_query($con, $sql); 
        
		echo '<script type="text/javascript">alert("' . "Você receberá em breve um e-mail contendo sua senha de acesso.\\n\\nEmail cadastrado: $email" . '")</script>';
		echo '<script type="text/javascript">window.location ="/index.php"</script>';
	}
}else{
	echo '<script type="text/javascript">alert("' . "Falha ao redefinir sua senha. \\n\\nSolicite suporte atrávés do e-mail 'Suporte.Tovm@Vale.com', passando também sua matrícula." . '")</script>';
	echo '<script type="text/javascript">window.location ="/classes/login.php"</script>';
}

?>

</body>
</html>