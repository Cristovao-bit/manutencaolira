<?php
/**
 * AdminPost.class [ MODEL ADMIN ]
 * Classe responsável por gerenciar os postes no admin do sistema!
 *
 * @copyright (c) 2019, Cristovão Lira Braga MANUTENÇÃO LIRA
 */
class AdminPost {

    private $Data;
    private $Post;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados!
    const Entity = 'ml_posts';

    //Cadastra o poste no sistema!
    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Result = false;
            $this->Error = ["<b>Erro ao cadastrar:</b> Para criar um poste, favor preencha todos os campos!", WS_ALERT];
        else:
            $this->setData();
            $this->setName();

            if ($this->Data['post_cover']):
                $upload = new Upload;
                $upload->Image($this->Data['post_cover'], $this->Data['post_name'], 0, "capa-poste");
            endif;

            if (isset($upload) && $upload->getResult()):
                $this->Data['post_cover'] = $upload->getResult();
                $this->Create();
            else:
                $this->Data['post_cover'] = null;
                $_SESSION['errCapa'] = "<b>Erro ao enviar capa:</b> Tipo de arquivo inválido, envie uma imagem JPG ou PNG!";
                $this->Create();
            endif;
        endif;
    }

    //Execução do update no sistema
    public function ExeUpdate($PostId, array $Data) {
        $this->Post = (int) $PostId;
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Result = false;
            $this->Error = ["Para atualizar este poste, favor preencha todos os campos ( Capa não precisa ser enviada! )", WS_ALERT];
        else:
            $this->setData();
            $this->setName();

            if (is_array($this->Data['post_cover'])):
                $readCapa = new Read;
                $readCapa->ExeRead(self::Entity, "WHERE post_id = :post", "post={$this->Post}");
                $capa = '../uploads/' . $readCapa->getResult()[0]['post_cover'];

                if (file_exists($capa) && !is_dir($capa)):
                    unlink($capa);
                endif;

                $uploadCapa = new Upload;
                $uploadCapa->Image($this->Data['post_cover'], $this->Data['post_name'], 0, "capa-poste");
            endif;

            if (isset($uploadCapa) && $uploadCapa->getResult()):
                $this->Data['post_cover'] = $uploadCapa->getResult();
                $this->Update();
            else:
                unset($this->Data['post_cover']);
                $this->Update();
            endif;
        endif;
    }

    public function gbSend(array $Images, $PostId) {
        $this->Post = (int) $PostId;
        $this->Data = $Images;

        $ImageName = new Read;
        $ImageName->ExeRead(self::Entity, "WHERE post_id = :id", "id={$this->Post}");
        if (!$ImageName->getResult()):
            $this->Result = false;
            $this->Error = ["Erro ao enviar galeria. O índice <b>{$this->Post}</b> não foi encontrado no banco!", WS_ERROR];
        else:
            $ImageName = $ImageName->getResult()[0]['post_name'];
            $gbFiles = array();
            $gbCount = count($this->Data['tmp_name']);
            $gbKeys = array_keys($this->Data);

            for ($gb = 0; $gb < $gbCount; $gb++):
                foreach ($gbKeys as $Keys):
                    $gbFiles[$gb][$Keys] = $this->Data[$Keys][$gb];
                endforeach;
            endfor;

            $gbSend = new Upload;
            $i = 0;
            $u = 0;

            foreach ($gbFiles as $gbUpload):
                $i++;
                $ImgName = "{$ImageName}-gb-{$this->Post}-" . (substr(md5(time() + $i), 0, 5));
                $gbSend->Image($gbUpload, $ImgName, 0, "galeria-poste");

                if ($gbSend->getResult()):
                    $gbImage = $gbSend->getResult();
                    $gbCreate = ['post_id' => $this->Post, 'gallery_image' => $gbImage, 'gallery_date' => date('Y-m-d H:i:s')];
                    $insertGb = new Create;
                    $insertGb->ExeCreate("ml_posts_gallery", $gbCreate);
                    $u++;
                endif;
            endforeach;

            if ($u > 1):
                $this->Result = true;
                $this->Error = ["<b>Galeria Atualizada:</b> Foram enviadas {$u} imagens para a galeria deste poste!", WS_SUCCESS];
            endif;
        endif;
    }

    //Execução da remoção da galeria
    public function gbRemove($GbImageId) {
        $this->Post = (int) $GbImageId;
        $readGb = new Read;
        $readGb->ExeRead("ml_posts_gallery", "WHERE gallery_id = :gb", "gb={$this->Post}");
        if ($readGb->getResult()):
            $Imagem = '../uploads/' . $readGb->getResult()[0]['gallery_image'];

            if (file_exists($Imagem) && !is_dir($Imagem)):
                unlink($Imagem);
            endif;

            $Deleta = new Delete;
            $Deleta->ExeDelete("ml_posts_gallery", "WHERE gallery_id = :id", "id={$this->Post}");
            if ($Deleta->getResult()):
                $this->Result = true;
                $this->Error = ['A imagem foi removida com sucesso do sistema', WS_SUCCESS];
            endif;
        endif;
    }

    //Verificar poste cadastrado
    public function getResult() {
        return $this->Result;
    }

    //Obter erros
    public function getError() {
        return $this->Error;
    }

    /**
     * ****************************************
     * ************ PRIVTE METHODS ************
     * ****************************************
     */
    //Verificação de dados no sistema!
    private function setData() {
        $Cover = $this->Data['post_cover'];
        $Content = $this->Data['post_content'];
        unset($this->Data['post_cover'], $this->Data['post_cover']);

        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);

        $this->Data['post_name'] = Check::Name($this->Data['post_title']);
        $this->Data['post_date'] = Check::Date($this->Data['post_date']);
        $this->Data['post_type'] = 'poste';

        $this->Data['post_cover'] = $Cover;
        $this->Data['post_content'] = $Content;
        $this->Data['post_cat_parent'] = $this->getCatParent();
    }

    //Leitura de poste no sistema!
    private function getCatParent() {
        $rCat = new Read;
        $rCat->ExeRead("ml_categories", "WHERE category_id = :id", "id={$this->Data['post_category']}");
        if ($rCat->getResult()):
            return $rCat->getResult()[0]['category_parent'];
        else:
            return null;
        endif;
    }

    //Verificação do nome do poste, se existir adiciona um pós-fix -count
    private function setName() {
        $Where = (isset($this->Post) ? "post_id != {$this->Post} AND" : "");
        $readName = new Read;
        $readName->ExeRead(self::Entity, "WHERE {$Where} post_title = :t", "t={$this->Data['post_title']}");
        if ($readName->getResult()):
            $this->Data['post_name'] = $this->Data['post_name'] . '-' . $readName->getRowCount();
        endif;
    }

    //Criar poste no sistema!
    private function Create() {
        $cadastra = new Create;
        $cadastra->ExeCreate(self::Entity, $this->Data);
        if ($cadastra->getResult()):
            $this->Result = $cadastra->getResult();
            $this->Error = ["O poste <b>{$this->Data['post_title']}</b> foi cadastrado com sucesso no sistema!", WS_SUCCESS];
        endif;
    }

    //Atualização do poste no sitema!
    private function Update() {
        $update = new Update;
        $update->ExeUpdate(self::Entity, $this->Data, "WHERE post_id = :id", "id={$this->Post}");
        if ($update->getResult()):
            $this->Result = true;
            $this->Error = ["O poste <b>{$this->Data['post_title']}</b> foi atualizado com sucesso no sistema!", WS_SUCCESS];
        endif;
    }

}