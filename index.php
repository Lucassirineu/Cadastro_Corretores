<?php
session_start();
if (isset($_SESSION['mensagem'])) {
  echo "<div class='alert alert-success'>" . $_SESSION['mensagem'] . "</div>";
  unset($_SESSION['mensagem']); // Limpa a mensagem após exibi-la
}
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
?>
<!DOCTYPE html>
<html>

<head>
  <title>Cadastro de Corretores</title>
  <style>
    body {
      font-family: sans-serif;
      background-color: blanchedalmond;
    }

    table {
      width: 80%;
      border-collapse: collapse;
    }

    th,
    td {
      text-align: left;
      padding: 8px;
      border: 1px solid #ddd;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    /* Centraliza o título */
    h2 {
      text-align: center;
    }
  </style>
</head>

<body>

  <div style="text-align: center;">
    <h1>Cadastro de Corretores</h1>
  </div>

  <div class="campos-form">
    <form id="form-corretor" method="post" action="processar.php">
      <div style="text-align: center; margin-bottom: 15px; justify-content: center;">
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required pattern="[0-9]{11}">
      </div>
      <div style="text-align: center; margin-bottom: 15px; justify-content: center;">
        <label for="creci">CRECI:</label>
        <input type="text" id="creci" name="creci" required minlength="2">
      </div>
      <div style="text-align: center; margin-bottom: 15px; justify-content: center;">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required minlength="2">
      </div>
      <div style="text-align: center;">
        <button type="submit">Enviar</button>
      </div>
    </form>

    <div id="mensagem">
      <?php
      if (isset($_GET["sucesso"]) && $_GET["sucesso"] == "true") {
        echo "<p style='color: green; text-align: center;'>Operação realizada com sucesso!</p>"; // Adiciona o estilo aqui
      }
      if (isset($_GET["erro"])) {
        echo "<p style='color: red; text-align: center;'>Erro: " . urldecode($_GET["erro"]) . "</p>"; // Adiciona o estilo aqui
      }
      ?>
    </div>

    <h3>Corretores Cadastrados:</h3>
    <table id="tabela-corretores">
      <thead>
        <tr>
          <th>ID</th>
          <th>CPF</th>
          <th>CRECI</th>
          <th>Nome</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody><!-- Dados dos corretores serão adicionados aqui -->
        <?php
        // Conexão com o banco de dados (mesmo código do processar.php)
        // ...

        // Consultando os dados da tabela
        $sql = "SELECT * FROM corretores";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
          // Exibindo os dados na tabela
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>"; // Adiciona a coluna ID
            echo "<td>" . $row["cpf"] . "</td>";
            echo "<td>" . $row["creci"] . "</td>";
            echo "<td>" . $row["nome"] . "</td>";
            echo "<td>";
            echo "<a href='editar.php?id=" . $row["id"] . "'>Editar</a> | ";
            echo "<a href='excluir.php?id=" . $row["id"] . "'>Excluir</a>";
            echo "</td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='5'>Nenhum corretor cadastrado.</td></tr>"; // Ajusta o colspan para 5
        }

        // Fechando a conexão com o banco de dados
        $conn->close();
        ?>

      </tbody>
    </table>

    <script>
      // JavaScript para validações adicionais (opcional)
      // Exemplo:
      // document.getElementById("form-corretor").addEventListener("submit", function(event) {
      //   // Validar CPF, CRECI e Nome usando JavaScript
      //   // ...
    </script>

</body>

</html>