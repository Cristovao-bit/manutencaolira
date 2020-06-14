<?php

/**
 * AdminUser.class [ MODEL ADMIN ]
 * Classe responsável por gerenciar os usuários no admin do sistema!
 *
 * @copyright (c) 2019, Cristovão Lira Braga MANUTENÇÃO LIRA
 */
class AdminUser {

    private $Data;
    private $User;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados
    const Entity = "ml_users";

    //Executar a criação do usuário no sistema!
    public function ExeCreate(array $Data) {
        $this->Data = $Data;
        $this->checkData();

        if ($this->Result):
            $this->Create();
        endif;
    }

    public function ExeUpdate($UserId, array $Data) {
        $this->User = (int) $UserId;
        $this->Data = $Data;

        if (!$this->Data['user_password']):
            unset($this->Data['user_password']);
        endif;

        $this->checkData();

        if ($this->Result):
            $this->Update();
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
    private function checkData() {
        if (in_array('', $this->Data)):
            $this->Result = false;
            $this->Error = ["Existem campos em branco. Favor preencha todos os campos!", WS_ALERT];
        elseif (!Check::Email($this->Data['user_email'])):
            $this->Result = false;
            $this->Error = ["O e-mail informado não parece ter um formato válido!", WS_ALERT];
        elseif (isset($this->Data['user_password']) && (strlen($this->Data['user_password']) < 6 || strlen($this->Data['user_password']) > 12)):
            $this->Result = false;
            $this->Error = ["A senha senha deve ter entre 6 a 12 caracteres!", WS_INFOR];
        else:
            $this->checkEmail();
        endif;
    }

    private function checkEmail() {
        $Where = (isset($this->User) ? "user_id != {$this->User} AND" : '');

        $readUser = new Read;
        $readUser->ExeRead(self::Entity, "WHERE {$Where} user_email = :email", "email={$this->Data['user_email']}");

        if ($readUser->getRowCount()):
            $this->Result = false;
            $this->Error = ["O e-mail informado foi cadastrado no sistema por outro usuário. Informe outro e-mail!", WS_ERROR];
        else:
            $this->Result = true;
        endif;
    }

    private function Create() {
        $Create = new Create;
        $this->Data['user_registration'] = date['Y-m-d H:i:s'];
        $this->Data['user_password'] = md5($this->Data['user_password']);

        $Create->ExeCreate(self::Entity, $this->Data);

        if ($Create->getResult()):
            $this->Result = $Create->getResult();
            $this->Error = ["O usuário <b>{$this->Data['user_name']}</b> foi cadastrado com sucesso no sistema!", WS_SUCCESS];
        endif;
    }

    private function Update() {
        $Update = new Update;
        if (isset($this->Data['user_password'])):
            $this->Data['user_password'] = md5($this->Data['user_password']);
        endif;

        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE user_id = :id", "id={$this->User}");
        if ($Update->getResult()):
            $this->Result = true;
            $this->Error = ["O usuário <b>{$this->Data['user_name']}</b> foi atualizado com sucesso no sistema!", WS_SUCCESS];
        endif;
    }

}
