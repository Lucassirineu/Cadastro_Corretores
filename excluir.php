<?php

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "corretores";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}

// Conexão com o banco de dados
// ...

// Verificando se o ID do corretor foi passado
if (isset($_GET["id"])) {
  $id = $_GET["id"];

  // Excluindo o corretor do banco de dados
  $sql = "DELETE FROM corretores WHERE id = $id";
  $result = $conn->query($sql);

  if ($conn->query($sql) === TRUE) {
    // Redirecionando para a página inicial com mensagem de sucesso
    header("Location: index.php?sucesso=true");
  } else {
    // Erro na exclusão
    echo "Erro: " . $sql . "<br>" . $conn->error;
  }
} else {
  // ID do corretor não foi passado
  echo "ID do corretor inválido.";
}

// Fechando a conexão com o banco de dados
$conn->close();
