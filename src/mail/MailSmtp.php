<?php 

namespace marksync_libs\mail;

use PHPMailer\PHPMailer\PHPMailer;

abstract class MailSmtp {

    private PHPMailer $mail;

    protected string $host;
    protected string $port;
    protected string $secure;
    protected bool $auth;
    
    
    protected ?string $fromName = null;

    protected string $login;
    protected string $password;



    final function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();

        $this->mail->Host = $this->host;
        $this->mail->Port = $this->port;
        $this->mail->SMTPSecure = $this->secure;
        $this->mail->SMTPAuth = $this->auth;
        $this->mail->Username = $this->login;
        $this->mail->Password = $this->password;
        $this->mail->CharSet = "UTF-8";

        $this->mail->setFrom($this->login, $this->fromName ? $this->fromName : $this->login);
        $this->mail->isHTML(true);
    }



    function send(array | string $to, string $header, Letter $letter)
    {
        $this->mail->clearAddresses();

        foreach ((array)$to as $email) {
            $this->mail->addAddress($email);
        }

        $this->mail->Body = $letter->getHtml();
        $this->mail->Subject = $header;
        $this->mail->send();
    }

}