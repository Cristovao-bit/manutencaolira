<?php

require('_app/Library/PHPMailer/class.phpmailer.php');

/**
 * Email [ MODEL ]
 * Classe responsável por configurar o PHPMailer, validar os dados e disparar e-mails do sistema.
 * 
 * @copyright 2019, Cristovão Lira Braga MANUTENÇÃO LIRA
 */
class Email {

    /** @var PHPMailer */
    private $Mail;

    /** EMAIL DATA */
    private $Data;

    /** CORPO DO EMAIL */
    private $Assunto;
    private $Mensagem;

    /** REMETENTE */
    private $RemetenteNome;
    private $RemetenteEmail;

    /** DESTINO */
    private $DestinoNome;
    private $DestinoEmail;

    /** CONTROLE */
    private $Error;
    private $Result;

    public function __construct() {
        $this->Mail = new PHPMailer;
        $this->Mail->Host = MAILHOST;
        $this->Mail->Port = MAILPORT;
        $this->Mail->Username = MAILUSER;
        $this->Mail->Password = MAILPASS;
        $this->Mail->CharSet = 'UFT-8';
    }

    public function Enviar(array $Data) {
        $this->Data = $Data;
        $this->Clear();

        if (in_array('', $this->Data)):
            $this->Result = false;
            $this->Error = ["<b>Erro ao enviar mensagem:</b> Para enviar esse e-mail, preencha os campos requisitados!", WS_ALERT];
        elseif (!Check::Email($this->Data['RemetenteEmail'])):
            $this->Result = false;
            $this->Error = ["<b>Erro ao enviar mensagem:</b> O e-mail que você informou não tem um formato válido. Informe seu email!", WS_ALERT];
        else:
            $this->setMail();
            $this->setConfig();
            $this->sendMail();
        endif;
    }

    public function getResult() {
        return $this->Result;
    }

    public function getError() {
        return $this->Error;
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    private function Clear() {
        array_map('strip_tags', $this->Data);
        array_map('trim', $this->Data);
    }

    private function setMail() {
        $this->Assunto = $this->Data['Assunto'];
        $this->Mensagem = $this->Data['Mensagem'];
        $this->RemetenteNome = $this->Data['RemetenteNome'];
        $this->RemetenteEmail = $this->Data['RemetenteEmail'];
        $this->DestinoNome = $this->Data['DestinoNome'];
        $this->DestinoEmail = $this->Data['DestinoEmail'];

        $this->Data = null;
        $this->setMsg();
    }

    private function setMsg() {
        $this->Mensagem = "{$this->Mensagem}<hr><small>Recebida em: " . date('d/m/Y H:i') . "</small>";
    }

    private function setConfig() {
        //SMTP AUTH
        $this->Mail->IsSMTP();
        $this->Mail->SMTPAuth = true;
        $this->Mail->IsHTML();

        //REMETENTE E RETORNO
        $this->Mail->From = MAILUSER;
        $this->Mail->FromName = $this->RemetenteNome;
        $this->Mail->AddReplyTo($this->RemetenteEmail, $this->RemetenteNome);

        //ASSUNTO, MENSAGEM E DESTINO
        $this->Mail->Subject = $this->Assunto;
        $this->Mail->Body = $this->Mensagem;
        $this->Mail->AddAddress($this->DestinoEmail, $this->DestinoNome);
    }

    private function sendMail() {
        if ($this->Mail->Send()):
            $this->Result = true;
            $this->Error = ["<b>Obrigado por entrar em contato:</b> Recebemos sua mensagem e estaremos respondendo em breve!", WS_SUCCESS];
        else:
            $this->Result = false;
            $this->Error = ["<b>Erro ao enviar:</b> Entre em contato com o Administrador ( {$this->Mail->ErrorInfo} )!", WS_ERROR];
        endif;
    }

}
