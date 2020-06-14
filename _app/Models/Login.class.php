<?php
/**
 * Login.class [ MODEL ]
 * Responsável por autenticar, validar e checar usuários do sistema de login!
 *
 * @copyright (c) 2019, Cristovão Lira Braga Manutenção Lira
 */
class Login {

    private $Level;
    private $Email;
    private $Senha;
    private $Error;
    private $Result;

    function __construct($Level) {
        $this->Level = (int) $Level;
    }

    public function ExeLogin(array $UserData) {
        $this->Email = (string) strip_tags(trim($UserData['user']));
        $this->Senha = (string) strip_tags(trim($UserData['pass']));
        $this->setLogin();
    }

    public function getResult() {
        return $this->Result;
    }

    public function getError() {
        return $this->Error;
    }

    public function CheckLogin() {
        if (empty($_SESSION['userlogin']) || $_SESSION['userlogin']['user_level'] < $this->Level):
            unset($_SESSION['userlogin']);
            return false;
        else:
            return true;
        endif;
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    private function setLogin() {
        if (!$this->Email || !$this->Senha || !Check::Email($this->Email)):
            $this->Error = ["Informe seu E-mail e senha para efetuar o login!", WS_INFOR];
            $this->Result = false;
        elseif (!$this->getUser()):
            $this->Error = ["Os dados informados não são compatíveis!", WS_ALERT];
            $this->Result = false;
        elseif ($this->Result['user_level'] < $this->Level):
            $this->Error = ["Desculpa {$this->Result['user_name']}, você não tem permissão para acessar esta área!", WS_ERROR];
            $this->Result = false;
        else:
            $this->Execute();
        endif;
    }

    private function getUser() {
        $this->Senha = md5($this->Senha);
        $read = new Read;
        $read->ExeRead("ml_users", "WHERE user_email = :e AND user_password = :p", "e={$this->Email}&p={$this->Senha}");
        if ($read->getResult()):
            $this->Result = $read->getResult()[0];
            return true;
        else:
            return false;
        endif;
    }

    private function Execute() {
        if (!session_id()):
            session_start();
        endif;
        $_SESSION['userlogin'] = $this->Result;
        $this->Error = ["Olá <b>{$this->Result['user_name']}</b>, seja bem vindo(a). Aguarde redirecionamento!", WS_SUCCESS];
        $this->Result = true;
    }

}
