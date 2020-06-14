<?php
/**
 * Upload.class [ HELPER ]
 * Classe responsável por upload de imagens, arquivos e mídias no sistema! 
 * 
 * @copyright (c) 2019, Cristovão Lira Braga MANUTENÇÃO LIRA
 */
class Upload {

    private $File;
    private $Name;
    private $Send;

    /** IMAGE UPLOAD */
    private $Width;
    private $Image;

    /** RESULT SET */
    private $Result;
    private $Error;

    /** DIRETÓRIOS */
    private $Folder;
    private static $BaseDir;

    /**
     * Verifica e cria o diretório padrão de uploads no sistema!<br>
     * <b>../uploads/</b>
     */
    function __construct($BaseDir = null) {
        self::$BaseDir = ((string) $BaseDir ? $BaseDir : '../uploads/');
        if (!file_exists(self::$BaseDir) && !is_dir(self::$BaseDir)):
            mkdir(self::$BaseDir, 0777);
        endif;
    }

    /**
     * <b>Enviar imagem:</b> Basta envelopar um $_FILES de uma imagem e caso queira um nome e uma largura personalizada
     * caso não informe a largura será 1024!
     * 
     * @param FILES $Image = Enviar envelope de $_FILES
     * @param STRING $Name = Nome da imagem ( ou do artigo )
     * @param INT $Width = Largura da imagem ( 1024 padrão )
     * @param STRING $Folder = Pasta Personalizada
     */
    public function Image(array $Image, $Name = null, $Width = null, $Folder = null) {
        $this->File = $Image;
        $this->Name = ((string) $Name ? $Name : substr($Image['name'], 0, strrpos($Image['name'], '.')));
        $this->Width = ((int) $Width ? $Width : 1024);
        $this->Folder = ((string) $Folder ? $Folder : 'images');

        $this->CheckFolder($this->Folder);
        $this->setFileName();
        $this->UploadImage();
    }

    public function File(array $File, $Name = null, $Folder = null, $MaxFileSize = null) {
        $this->File = $File;
        $this->Name = ((string) $Name ? $Name : substr($File['name'], 0, strrpos($File['name'], '.')));
        $this->Folder = ((string) $Folder ? $Folder : 'files');
        //tamanho do arquivo enviado!
        $MaxFileSize = ( (int) $MaxFileSize ? $MaxFileSize : 2 );

        $FileAccept = [
            'application/msword',
            'application/pdf'
        ];

        if ($this->File['size'] > ($MaxFileSize * (1024 * 1024))):
            $this->Result = false;
            $this->Error = "Arquivo muito grande, tamanho máximo permitido de {$MaxFileSize}mb";
        elseif(!in_array($this->File['type'], $FileAccept)):
            $this->Result = false;
            $this->Error = 'Tipo de arquivo não suportado. Envie .DOCX ou .PDF!';
        else:
            $this->CheckFolder($this->Folder);
            $this->setFileName();
            $this->MoveFile();
        endif;
    }
    
    public function Media(array $Media, $Name = null, $Folder = null, $MaxFileSize = null) {
        $this->File = $Media;
        $this->Name = ((string) $Name ? $Name : substr($Media['name'], 0, strrpos($Media['name'], '.')));
        $this->Folder = ((string) $Folder ? $Folder : 'medias');
        //tamanho do arquivo enviado!
        $MaxFileSize = ( (int) $MaxFileSize ? $MaxFileSize : 40 );

        $FileAccept = [
            'audio/mp3',
            'video/mp4'
        ];

        if ($this->File['size'] > ($MaxFileSize * (1024 * 1024))):
            $this->Result = false;
            $this->Error = "Arquivo muito grande, tamanho máximo permitido de {$MaxFileSize}mb";
        elseif(!in_array($this->File['type'], $FileAccept)):
            $this->Result = false;
            $this->Error = 'Tipo de arquivo não suportado. Envie audio .MP3 ou vídeo .MP4!';
        else:
            $this->CheckFolder($this->Folder);
            $this->setFileName();
            $this->MoveFile();
        endif;
    }

    /**
     * <b>Obter Error:</b> Retorna um array associativo com um code, um title, um erro e um tipo.
     * 
     * @return ARRAY $Error = Array associativo com o erro
     */
    function getError() {
        return $this->Error;
    }

    /**
     * <b>Verificar upload:</b> Executando um getResult é possível verificar se o upload foi executado ou não.
     * uma string com o caminho e nome do arquivo ou FALSE.
     * 
     * @return STRING = Caminho e Nome do arquivo ou false.
     */
    function getResult() {
        return $this->Result;
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //VERIFICA E CRIA OS DIRETÓRIOS COM BASE EM TIPO DE ARQUIVO, ANO E MÊS!
    private function CheckFolder($Folder) {
        list($y, $m) = explode('/', date('Y/m'));
        $this->CreateFolder("{$Folder}");
        $this->CreateFolder("{$Folder}/{$y}");
        $this->CreateFolder("{$Folder}/{$y}/{$m}/");
        $this->Send = "{$Folder}/{$y}/{$m}/";
    }

    //VERIFICA E CRIA O DIRETÓRIO BASE!
    private function CreateFolder($Folder) {
        if (!file_exists(self::$BaseDir . $Folder) && !is_dir(self::$BaseDir . $Folder)):
            mkdir(self::$BaseDir . $Folder, 0777);
        endif;
    }

    //VERIFICA E MONTA O NOME DOS ARQUIVOS TRATANDO A STRING!
    private function setFileName() {
        $FileName = Check::Name($this->Name) . strrchr($this->File['name'], '.');
        if (file_exists(self::$BaseDir . $this->Send . $FileName)):
            $FileName = Check::Name($this->Name) . '-' . time() . strrchr($this->File['name'], '.');
        endif;
        $this->Name = $FileName;
    }

    //RALIZA O UPLOAD DE IMAGENS REDIMENSIONANDO A MESMA!
    private function UploadImage() {
        switch ($this->File['type']):
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->Image = imagecreatefromjpeg($this->File['tmp_name']);
                break;
            case 'image/png';
            case 'image/x-png';
                $this->Image = imagecreatefrompng($this->File['tmp_name']);
                break;
        endswitch;

        if (!$this->Image):
            $this->Result = false;
            $this->Error = 'Tipo de arquivo inválido, envie imagens JPG ou PNG!';
        else:
            $x = imagesx($this->Image);
            $y = imagesy($this->Image);
            $ImageW = ( $this->Width < $x ? $ $this->Width : $x );
            $ImageH = ( $ImageW * $y ) / $x;

            $NewImage = imagecreatetruecolor($ImageW, $ImageH);
            imagealphablending($NewImage, false);
            imagesavealpha($NewImage, true);
            imagecopyresampled($NewImage, $this->Image, 0, 0, 0, 0, $ImageW, $ImageH, $x, $y);

            switch ($this->File['type']):
                case 'image/jpg':
                case 'image/jpeg':
                case 'image/pjpeg':
                    imagejpeg($NewImage, self::$BaseDir . $this->Send . $this->Name);
                    break;
                case 'image/png';
                case 'image/x-png';
                    imagepng($NewImage, self::$BaseDir . $this->Send . $this->Name);
                    break;
            endswitch;

            if (!$NewImage):
                $this->Result = false;
                $this->Error = 'Tipo de arquivo inválido, envie imagens JPG ou PNG!';
            else:
                $this->Result = $this->Send . $this->Name;
                $this->Error = null;
            endif;

            imagedestroy($this->Image);
            imagedestroy($NewImage);
        endif;
    }

    //ENVIA ARQUIVOS E MIDIAS
    private function MoveFile() {
        if (move_uploaded_file($this->File['tmp_name'], self::$BaseDir . $this->Send . $this->Name)):
            $this->Result = $this->Send . $this->Name;
            $this->Error = null;
        else:
            $this->Result = false;
            $this->Error = 'Erro ao mover arquivo. Favor tente mais tarde!';
        endif;
    }

}