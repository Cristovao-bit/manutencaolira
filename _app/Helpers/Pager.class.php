<?php
/**
 * Pager.class [ HELPER ]
 * classe responsável por realização de gestão e a paginação de resultados no sistema!
 * 
 * @copyright 2019, Cristovão Lira Braga MANUTENÇÃO LIRA
 */
class Pager {

    /** DEFINE O PAGER */
    private $Page;
    private $Limit;
    private $offset;

    /** REALIZA A LEITURA */
    private $Tabela;
    private $Termos;
    private $Places;

    /** DEFINE UM PAGINATOR */
    private $Rows;
    private $Link;
    private $MaxLinks;
    private $First;
    private $Last;

    /** RENDERIZA O PAGINATOR */
    private $Paginator;

    function __construct($Link, $First = null, $Last = null, $MaxLinks = null) {
        $this->Link = (string) $Link;
        $this->First = ( (string) $First ? $First : 'Primeira Página' );
        $this->Last = ( (string) $Last ? $Last : 'Última Página' );
        $this->MaxLinks = ( (int) $MaxLinks ? $MaxLinks : 5 );
    }

    public function ExePager($Page, $Limit) {
        $this->Page = ( (int) $Page ? $Page : 1 );
        $this->Limit = (int) $Limit;
        $this->offset = ( $this->Page * $this->Limit ) - $this->Limit;
    }

    public function returnPage() {
        if ($this->Page > 1):
            $nPage = $this->Page - 1;
            header("Location: {$this->Link}{$nPage}");
        endif;
    }

    public function getPage() {
        return $this->Page;
    }

    public function getLimit() {
        return $this->Limit;
    }

    public function getOffset() {
        return $this->offset;
    }

    public function ExePaginator($Tabela, $Termos = null, $ParseString = null) {
        $this->Tabela = (string) $Tabela;
        $this->Termos = (string) $Termos;
        $this->Places = (string) $ParseString;
        $this->getSyntax();
    }

    public function getPaginator() {
        return $this->Paginator;
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    private function getSyntax() {
        $read = new Read;
        $read->ExeRead($this->Tabela, $this->Termos, $this->Places);
        $this->Rows = $read->getRowCount();

        if ($this->Rows > $this->Limit):
            $Paginas = ceil($this->Rows / $this->Limit);
            $MaxLinks = $this->MaxLinks;
            $this->Paginator = "<ul class=\"paginator\">";
            $this->Paginator .= "<li><a title=\"{$this->First}\" href=\"{$this->Link}1\">{$this->First}</a></li>";

            for ($iPag = $this->Page - $MaxLinks; $iPag <= $this->Page - 1; $iPag++):
                if ($iPag >= 1):
                    $this->Paginator .= "<li><a title=\"Página {$iPag}\" href=\"{$this->Link}{$iPag}\">{$iPag}</a></li>";
                endif;
            endfor;
            
            $this->Paginator .= "<li><span class=\"active\">{$this->Page}</span></li>";
            
            for ($dPag = $this->Page + 1; $dPag <= $this->Page + $MaxLinks; $dPag++):
                if ($dPag <= $Paginas):
                    $this->Paginator .= "<li><a title=\"Página {$dPag}\" href=\"{$this->Link}{$dPag}\">{$dPag}</a></li>";
                endif;
            endfor;

            $this->Paginator .= "<li><a title=\"{$this->Last}\" href=\"{$this->Link}{$Paginas}\">{$this->Last}</a></li>";
            $this->Paginator .= "</ul>";
        endif;
    }

}
