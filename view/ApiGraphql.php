<?php
// include_once "../controller/control.php";



//funcão que vai receber todas as requizições passando apenas a query;
function pipefyPost($query)
{
    $authorization = array(
        "Content-Type: application/json",
        "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJ1c2VyIjp7ImlkIjo5NDg0MDUsImVtYWlsIjoiZ2FicmllbGdzY25nQGdtYWlsLmNvbSIsImFwcGxpY2F0aW9uIjo1NjYxM319.ryDjaQ0ineAKbquQulermrlLXT9yZPiMLDyPVRP4S70uyIoagvQ10RS_jOcpm-UujOjcutJUFySmvl7HZYaCmg"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://app.pipefy.com/queries");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $authorization);

    $exec = curl_exec($ch);

    curl_close($ch);

    return $exec;
}

//$IdCard = ( isset($_POST['idcard']) ) ? $_POST['idcard'] : null;
//$nome = ( isset($_GET['nome']) ) ? $_GET['nome'] : null;

//printf($nome);

// array q vai ficar todos os dados buscados
$pipefyArray = array();

//primeiro request feito no pipefy
$firstRequest = pipefyPost("{ \"query\": \"{ cards(pipe_id: 679240, first: 50) { pageInfo { endCursor hasNextPage } edges { node { fields { name value } current_phase { name id } } } } } }\" }");


// Decodifica o formato JSON e retorna um Objeto
$decodedFirstRequest = json_decode($firstRequest, true);

// adicionando a primeira resposta do pipefy no array de dados
array_push($pipefyArray, $decodedFirstRequest);

// setando os dados da primeira página
$hasNextPage = $decodedFirstRequest['data']['cards']['pageInfo']['hasNextPage'];
$endCursor = $decodedFirstRequest['data']['cards']['pageInfo']['endCursor'];


// se a proxima pagina dessa array continuar sendo true ele vai procurar a próxima;
while ($hasNextPage) {

    $query = "{ \"query\": \"{ cards(pipe_id: 679240, first: 50, after: \\\"'$endCursor'\\\") { pageInfo { endCursor hasNextPage } edges { node { fields { name value } current_phase { name id } } } } } }\" }";

    //todos os proximos requests serao feitos aqui
    $nextRequests = pipefyPost($query);
    $decodedNextRequest = json_decode($nextRequests, true);

    // atualização do cursor e da proxima página;
    $hasNextPage = $decodedNextRequest['data']['cards']['pageInfo']['hasNextPage'];
    $endCursor = $decodedNextRequest['data']['cards']['pageInfo']['endCursor'];

    // colocando os itens dentro de uma unica array
    array_push($pipefyArray, $decodedNextRequest);
}

print_r(json_encode($pipefyArray));
