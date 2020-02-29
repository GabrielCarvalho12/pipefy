<?php
include_once "../controller/control.php";

//$IdCard = ( isset($_POST['idcard']) ) ? $_POST['idcard'] : null;
//$cnpj = ( isset($_POST['cnpj']) ) ? $_POST['cnpj'] : null;


$cont = new control();

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://app.pipefy.com/queries");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, "{
  \"query\": \"{ cards(pipe_id: 1204878) { edges { node { fields { name value } } } } } }\"
}");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJ1c2VyIjp7ImlkIjo5NDg0MDUsImVtYWlsIjoiZ2FicmllbGdzY25nQGdtYWlsLmNvbSIsImFwcGxpY2F0aW9uIjo1NjYxM319.ryDjaQ0ineAKbquQulermrlLXT9yZPiMLDyPVRP4S70uyIoagvQ10RS_jOcpm-UujOjcutJUFySmvl7HZYaCmg"
));

$response = curl_exec($ch);
curl_close($ch);

// Decodifica o formato JSON e retorna um Objeto
$json = json_decode($response, true);

$list = $json['data']['cards'];

//printf($list);
//var_dump($json);

$cnpj = array();

for($i=0; $i<=count($json); $i++){
    $remove = array("/", ".", "-");
    $cnpj[$i] = str_replace($remove, "", $list['edges'][$i]['node']['fields'][4]['value']);

/*    if($cnpj[$i] == "12345678123400")
    {
        // Array encontrado.
        print_r($list['edges'][$i]['node']);
    }*/

}
$cont->QuerySelect($cnpj);