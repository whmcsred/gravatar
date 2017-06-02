<?php
//Desenvolvido por Luciano Zanita :: http://whmcs.red
//Capturando Session
use WHMCS\Session;
//Laravel DataBase
use WHMCS\Database\Capsule;

//Bloqueia o acesso direto ao arquivo
if (!defined("WHMCS")){
	die("Acesso restrito!");
}

function gravatar($vars){
	//Pegando variaveis do usuário
	$id_usuario = $_SESSION["uid"];
	
	//Pega o email do usuario no banco de dados
	foreach (Capsule::table('tblclients')->WHERE('id', $id_usuario)->get() as $cliente) {
    	$email_usuario = $cliente->email;
	}

	//Transformar em MD5
	$hash = md5($email_usuario);

	//Formação da URL
	$urlgravatar = 'https://www.gravatar.com/avatar/'.$hash.'?s=48&d=mm';
	$urlgravatar_email = 'https://www.gravatar.com/avatar/'.$hash.'?s=96&d=mm';

	//Cria a variavel usavel
	$variavel = array();
	$variavel['gravatar'] = $urlgravatar;
	$variavel['gravatar_email'] = $urlgravatar_email;

	//Retorno da Função
	return $variavel;
}
add_hook("ClientAreaPage", 1, "gravatar");
add_hook("EmailPreSend",1,"gravatar");
?>