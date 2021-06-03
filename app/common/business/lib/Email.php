<?php
/**
 *
 * @description: 人生五十年，与天地长久相较，如梦又似幻
 *
 * @author: Shane
 *
 * @time: 2020/9/23 16:00
 */


namespace app\common\business\lib;


use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    private $host = NULL;
    private $username = NULL;
    private $password = NULL;
    private $name = NULL;
    private $config = NULL;
    private $mailer = NULL;

    public function __construct(){
        $this -> config = new Config();
        $this -> mailer = new PHPMailer();
        $this -> host = $this -> config -> getHost();
        $this -> username = $this -> config -> getUserName();
        $this -> password = $this -> config -> getPassword();
        $this -> name = $this -> config -> getName();
    }

    public function sendEmail($target, $title, $body, $alt_body){
        $this -> mailer -> CharSet ="UTF-8";
        $this -> mailer -> SMTPDebug = 0;
        $this -> mailer -> isSMTP();
        $this -> mailer -> Host = $this -> host;
        $this -> mailer -> SMTPAuth = true;
        $this -> mailer -> Username = $this -> username;
        $this -> mailer -> Password = $this -> password;
        $this -> mailer -> SMTPSecure = 'ssl';
        $this -> mailer -> Port = 465;

        $this -> mailer -> setFrom($this -> username, $this -> name);
        $this -> mailer -> addAddress($target);
        $this -> mailer -> addReplyTo($this -> username, $this -> name);

        $this -> mailer -> isHTML(true);
        $this -> mailer -> Subject = "$title";
        $this -> mailer -> Body    = "$body";
        $this -> mailer -> AltBody = "$alt_body";

        $this -> mailer -> send();
    }

}