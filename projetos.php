<?php
header('Access-Control-Allow-Origin: *');//permite acesso de todas as origins

header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS');//permite acesso dos metodos
//PUT é utilizado para fazer um UPDATE no banco
//DELETE é utilizado para deletar algo do banco
header('Access-Control-Allow-Headers: Content-Type');//permite com que qualquer header consiga acessar o sitema

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    exit;
}

include 'conexao.php';
//inclui os dados de conexao com o banco de dados no sistema abaixo


//rota para obter todos os projetos utilizando o get
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $stmt = $conn->prepare("SELECT * FROM projetos");
    $stmt -> execute();
    $projetos = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($projetos);
    //converter dados em json
}


//Utilizando o Post

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $Nome = $_POST['Nome'];
    $ClienteAssoc = $_POST['ClienteAssoc'];
    $DataInicio = $_POST['DataInicio'];
    $Estado = $_POST['Estado'];

    $stmt = $conn->prepare("INSERT INTO projetos (Nome, ClienteAssoc, DataInicio, Estado) values 
    (:Nome, :ClienteAssoc, :DataInicio, :Estado)");

    $stmt -> bindParam(':Nome', $Nome);
    $stmt -> bindParam(':ClienteAssoc', $ClienteAssoc);
    $stmt -> bindParam(':DataInicio', $DataInicio);
    $stmt -> bindParam(':Estado', $Estado);

    if($stmt->execute()){
        echo 'livro criado com sucesso!';
    }else{
        echo 'erro ao criar o livro';
    }
}




//rota para atualizar um livro existente

if($_SERVER['REQUEST_METHOD']==='PUT' && isset($_GET['Cod'])){
    //convertendo dados recebidos em string
    parse_str(file_get_contents("php://input"), $_PUT);


    $Cod = $_GET['Cod'];
    $novoNome = $_PUT['Nome'];
    $novoClienteAssoc = $_PUT['ClienteAssoc'];
    $novoData = $_PUT['DataInicio'];
    $novoEstado = $_PUT['Estado'];

    $stmt = $conn->prepare("UPDATE projetos SET Nome = :Nome, ClienteAssoc = :ClienteAssoc, DataInicio = :DataInicio, Estado = :Estado WHERE Cod = :Cod");
    $stmt->bindParam(':Nome', $novoNome);
    $stmt->bindParam(':ClienteAssoc', $novoClienteAssoc);
    $stmt->bindParam(':DataInicio', $novoData);
    $stmt->bindParam(':Cod', $Cod);


    if($stmt->execute()){
        echo "livro atualizado com sucesso!!";

    } else{
        echo "erro ao att livro :(";
    }

}

if($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['Cod'])){
    $Cod = $_GET['Cod'];
    $stmt = $conn->prepare("DELETE FROM projetos WHERE Cod = :Cod");
    $stmt->bindParam(':Cod', $Cod);

    if($stmt->execute()){
        echo "Livro excluido com sucesso!!";
    } else {
        echo "erro ao excluir livro";
    }
}


?>