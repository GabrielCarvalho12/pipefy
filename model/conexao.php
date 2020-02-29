<?php


class conexao
{

    private $servidor;
    private $usuario;
    private $senha;
    private $nomeBanco;
    private $banco;
    private $query;


    function Construct($servidor = "127.0.0.1:3308", $usuario = "root", $senha = "root", $nomeBanco = "pipefy")
    {
        $this->setServidor($servidor);
        $this->setUsuario($usuario);
        $this->setSenha($senha);
        $this->setNomeBanco($nomeBanco);
        $this->Conectar();
    }

    public function setServidor($servidor)
    {
        $this->servidor = $servidor;
    }

    public function getServidor()
    {
        return $this->servidor;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setNomeBanco($nomeBanco)
    {
        $this->nomeBanco = $nomeBanco;
    }

    public function getNomeBanco()
    {
        return $this->nomeBanco;
    }

    public function Conectar()
    {
        $this->banco = new MySQLi
        (
            $this->getServidor(),
            $this->getUsuario(),
            $this->getSenha(),
            $this->getNomeBanco()
        );
        if ($this->banco->connect_error) {
            die('Erro de conexão(' . $this->banco->connect_errno . '):'
                . $this->banco->connect_error);
        }

    }

    public function ImportsCards($id)
    {
        $this->Construct();

        $query = "Select *
                  From clientes 
                  WHERE idcard = '$id'";

        $result = mysqli_query($this->getBanco(),$query);

        while ( $row = mysqli_fetch_assoc($result) ) {
            $this->query = "{\"query\": \"mutation{createCard( input: { pipe_id: 1204878 fields_attributes: [{field_id: \\\"cnpj\\\", field_value: \\\"".$row['cnpj']."\\\"} {field_id: \\\"data\\\", field_value: \\\"".$row['data_cadastro']."\\\"} {field_id: \\\"email\\\", field_value: \\\"".$row['email']."\\\"} {field_id: \\\"telefone\\\", field_value: \\\"".$row['telefone']."\\\"} {field_id: \\\"cliente\\\", field_value: \\\"".$row['cliente']."\\\"}] }) {card {id title}}}\"}";
        }
    }

    public function SelectCards($Graphcnpj)
    {
        $this->Construct();

        $query = "Select cnpj From clientes";

        $result = mysqli_query($this->getBanco(),$query);

        $BDcnpj = array();

        $i=0;
        while ( $row = mysqli_fetch_assoc($result) ) {
            $BDcnpj[$i] = $row['cnpj'];
            $i++;
        }

        $diff = array_diff($BDcnpj, $Graphcnpj);
        print_r($diff);
/*        for ($i = 0; $i <= count($Graphcnpj); $i++) {
            //$remove = array("/", ".", "-");
            if (isset($Graphcnpj[$i]['node']['fields'][3]['value'])) {
                $val[$i] = $Graphcnpj[$i]['node']['fields'][3]['value'];
                if ( $val[$i] == $diff) {
                    print_r($Graphcnpj[$i]['node']);
                }
            }
        }*/

    }


    public function getQuery()
    {
        return $this->query;
    }

    public function getBanco()
    {
        return $this->banco;
    }
}