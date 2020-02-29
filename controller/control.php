<?php
require_once "../model/conexao.php";

class control
{
    public $query;

    public function QueryInsert($id)
    {
        $con = new Conexao();
        $con->ImportsCards($id);
        $this->query = $con->getQuery();

    }

    public function QuerySelect($cnpj)
    {
        $con = new Conexao();
        $con->SelectCards($cnpj);
        //$this->query = $con->getQuery();
    }

}