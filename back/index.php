<?php

require "config.php";

$rota = $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"] === "POST" ? "lojati" : "teste");

function teste() {
    echo "API respondendo com sucesso!";
}

function readClientes($con){
    header("Content-Type: application/json; charset-utf-8");
    $stmt = $con->query("SELECT * FROM clientes");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}


function createClientes($con){
    $nome = $_POST["nome"] ?? "";
    $telefone = $_POST["telefone"] ?? "";
    $email = $_POST["email"] ?? "";
    $endereco = $_POST["endereco"] ?? "";

    try {
        $stmt = $con->prepare("INSERT INTO Clientes (nome, telefone, email, endereco) VALUES (?,?,?,?)");
        $stmt -> execute([$nome, $telefone, $email, $endereco]); 
        header("Location: ../front/index.html");
    }catch(PDOException $e){
       header("Location: ../front/erro.html");
    }
    exit;
}
if($_SERVER["REQUEST_METHOD"] === "POST"){
    createClientes($con);
}
elseif($rota === "clientes"){
    readClientes($con);
}else{
    teste();
}

?>