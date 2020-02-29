<?php include_once "../controller/control.php";

$cont = new control();
$cont->QueryInsert(55824259);
//printf($cont->query);

   $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://app.pipefy.com/queries");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, $cont->query);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJ1c2VyIjp7ImlkIjo5NDg0MDUsImVtYWlsIjoiZ2FicmllbGdzY25nQGdtYWlsLmNvbSIsImFwcGxpY2F0aW9uIjo1NjYxM319.ryDjaQ0ineAKbquQulermrlLXT9yZPiMLDyPVRP4S70uyIoagvQ10RS_jOcpm-UujOjcutJUFySmvl7HZYaCmg"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    echo $response;


