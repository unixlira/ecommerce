<?php

namespace Lira\Model;

use \Lira\DB\Sql;
use  \Lira\Model;

class User extends Model {


	const SESSION = "User";

	public static function login($login, $senha)
	{
		
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN ", array(
			":LOGIN"=>$login
		));

		if(count($results) === 0){

			throw new \Exception('Usuário ou Senha inválida');
		}

		$data = $results[0];

		if(password_verify($senha, $data["despassword"]) === true) {

			$user = new User();

			$user->setData($data);

			$_SESSION[User::SESSION] = $user->getValues();

			return $user;


		}else{

			throw new \Exception('Usuário ou Senha inválida');

		}
	
	}


	public function verifyLogin($inadmin = true)
	{
		if
		( 
			!isset($_SESSION[User::SESSION]) 
			|| 
			!$_SESSION[User::SESSION] 
			|| 
			!(int)$_SESSION[User::SESSION]["iduser"] > 0 
			|| 
			(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin	
		) {
			header("Location: /admin/login");
			exit;
		}
	}


	public function logout()
	{
		//$_SESSION[User::SESSION] == NULL;
		session_destroy();

	}
}



?>