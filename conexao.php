<?php

$host = "localhost";
$dbname ="ProjetoEngenharia";
$username ="root";
$password ="sucesso";

try{
    $conn = new PDO("mysql: host=$host; dbname=$dbname", $username,$password);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error){
    echo "Erro de conexão".$error->getMenssage(); 
}

?>