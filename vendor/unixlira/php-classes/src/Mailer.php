<?php

namespace Lira;

use PHPMailer\PHPMailer\PHPMailer;
use Rain\Tpl;

class Mailer {

	const HOST = "smtp.hostinger.com.br";
	const USERNAME = "contato@digplay.tech";
	const PASSWORD = "#Fibra13";
	const NAME_FROM = "Lira Store";
	const NOREPLY = "no-reply@digplay.tech";

	private $mail;

	public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
	{

		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/",
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"         => false
	    );

		Tpl::configure( $config );

		$tpl = new Tpl;

		foreach ($data as $key => $value) {
			$tpl->assign($key, $value);
		}

		$html = $tpl->draw($tplName, true);

		$this->mail = new PHPMailer();

        $this->mail->isSMTP(); 
        $this->mail->Host       = Mailer::HOST;
        $this->mail->SMTPAuth   = true; 
        $this->mail->Username   = Mailer::USERNAME;
        $this->mail->Password   = Mailer::PASSWORD;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = 587;   
		$this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);
		$this->mail->addAddress($toAddress,utf8_decode($toName) );
		$this->mail->Subject = $subject;
		$this->mail->msgHTML($html);
		$this->mail->AltBody = 'This is a plain-text message body';
		
		//$mail->addAttachment('images/phpmailer_mini.png');

	}

	public function send()
	{

		return $this->mail->send();

	}

}

?>