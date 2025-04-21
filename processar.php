<?php
session_start();
?>
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

// Função para validar os dados
function validarDados($cpf, $creci, $nome)
{
  $erros = [];

  // Validação do CPF
  if (strlen($cpf) != 11 || !is_numeric($cpf)) {
    $erros[] = "CPF inválido.";
  }

  // Validação do CRECI
  if (strlen($creci) < 2) {
    $erros[] = "CRECI deve ter pelo menos 2 caracteres.";
  }

  // Validação do Nome
  if (strlen($nome) < 2) {
    $erros[] = "Nome deve ter pelo menos 2 caracteres.";
  }

  return $erros;
}

// Processando o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $cpf = $_POST["cpf"];
  $creci = $_POST["creci"];
  $nome = $_POST["nome"];

  // Validação dos dados
  $erros = validarDados($cpf, $creci, $nome);

  if (empty($erros)) {
    // Inserindo os dados no banco de dados
    $sql = "INSERT INTO corretores (cpf, creci, nome) VALUES ('$cpf', '$creci', '$nome')";

    if ($conn->query($sql) === TRUE) {
      // Redirecionando para a página inicial com mensagem de sucesso
      header("Location: index.php?sucesso=true");
    } else {
      // Erro na inserção
      echo "Erro: " . $sql . "<br>" . $conn->error;
    }
  } else {
    // Exibindo mensagens de erro
    $mensagemErro = implode("<br>", $erros);
    header("Location: index.php?erro=" . urlencode($mensagemErro));
  }
}

// Fechando a conexão com o banco de dados
$conn->close();
?>
