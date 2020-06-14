<?php
/**
 * AdminCategory.class [ MODEL ADMIN ]
 * Responsável por gerenciar as categorias do sistema no admin!
 *
 * @copyright (c) 2019, Cristovão Lira Braga MANUTENÇÃO LIRA
 */
class AdminCategory {

    private $Data;
    private $CatId;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados!
    const Entity = 'ml_categories';

    //Criar categorias e subcategorias no banco de dados
    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Result = false;
            $this->Error = ["<b>Erro ao cadastrar:</b> Para cadastrar uma categoria, preencha todos os campos!", WS_ALERT];
        else:
            $this->setData();
            $this->setName();
            $this->Create();
        endif;
    }

    //Atualizar categorias e subcategorias no banco de dados
    public function ExeUpdate($CategoryId, array $Data) {
        $this->CatId = (int) $CategoryId;
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Result = false;
            $this->Error = ["<b>Erro ao atualizar:</b> Para atualizar a categoria {$this->Data['category_title']}, preencha todos os campos!", WS_ALERT];
        else:
            $this->setData();
            $this->setName();
            $this->Update();
        endif;
    }

    //Deletar categorias e subcatgorias no banco de dados
    public function ExeDelete($CategoryId) {
        $this->CatId = (int) $CategoryId;
        $read = new Read;
        $read->ExeRead(self::Entity, "WHERE category_id = :delid", "delid={$this->CatId}");
        if (!$read->getResult()):
            $this->Result = false;
            $this->Error = ["Oppsss, você tentou remover uma categoria que não existe no sistema!", WS_INFOR];
        else:
            extract($read->getResult()[0]);
            if (!$category_parent && !$this->checkCats()):
                $this->Result = false;
                $this->Error = ["A <b>seção {$category_title}</b> possui categorias cadastradas. Para deletar, antes altere ou remova as categorias filhas!", WS_ALERT];
            elseif ($category_parent && !$this->checkPosts()):
                $this->Result = false;
                $this->Error = ["A <b>categoria {$category_title}</b> possui artigos cadastradas. Para deletar, antes altere ou remova todos os postes desta categoria!", WS_ALERT];
            else:
                $delete = new Delete;
                $delete->ExeDelete(self::Entity, "WHERE category_id = :deletaid", "deletaid={$this->CatId}");
                $tipo = (empty($category_parent) ? 'seção' : 'categoria');
                $this->Result = true;
                $this->Error = ["A <b>{$tipo} {$category_title}</b> foi removida com sucesso do sistema!", WS_SUCCESS];
            endif;
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
     * *********** PRIVATES METHODS ***********
     * ****************************************
     */
    
    //Checagem de dados no sistema!
    private function setData() {
        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);
        $this->Data['category_name'] = Check::Name($this->Data['category_title']);
        $this->Data['category_date'] = Check::Date($this->Data['category_date']);
        $this->Data['category_parent'] = ($this->Data['category_parent'] == 'null' ? null : $this->Data['category_parent']);
    }

    //Checagem do nome no sistema!
    private function setName() {
        $Where = (!empty($this->CatId) ? "category_id != {$this->CatId} AND" : '');
        $readName = new Read;
        $readName->ExeRead(self::Entity, "WHERE {$Where} category_title = :t", "t={$this->Data['category_title']}");
        if ($readName->getResult()):
            $this->Data['category_name'] = $this->Data['category_name'] . '-' . $readName->getRowCount();
        endif;
    }

    //Verificar categoria ou subcategoria na seção!
    private function checkCats() {
        $readSes = new Read;
        $readSes->ExeRead(self::Entity, "WHERE category_parent = :parent", "parent={$this->CatId}");
        if ($readSes->getResult()):
            return false;
        else:
            return true;
        endif;
    }

    //Verificar artigos da categoria ou subcategoria!
    private function checkPosts() {
        $readPosts = new Read;
        $readPosts->ExeRead("ml_posts", "WHERE post_category = :categorypost", "categorypost={$this->CatId}");
        if($readPosts->getResult()):
            return false;
        else:
            return true;
        endif;
    }

    //Criar categoria ou subcategoria no sistema!
    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(self::Entity, $this->Data);
        if ($Create->getResult()):
            $this->Result = $Create->getResult();
            $this->Error = ["<b>Sucesso:</b> A categoria {$this->Data['category_title']} foi cadastrado com sucesso no sistema!", WS_SUCCESS];
        endif;
    }

    //Atualizar categoria ou subcategoria no sistema!
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE category_id = :catid", "catid={$this->CatId}");
        if ($Update->getResult()):
            $tipo = (empty($this->Data['category_parent']) ? 'seção' : 'categoria');
            $this->Result = true;
            $this->Error = ["<b>Sucesso:</b> A {$tipo} {$this->Data['category_title']} foi atualizado com sucesso no sistema!", WS_SUCCESS];
        endif;
    }
}