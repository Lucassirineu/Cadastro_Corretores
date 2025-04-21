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

// Verificando se o ID do corretor foi passado
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Consultando os dados do corretor
    $sql = "SELECT * FROM corretores WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Carregando os dados no formulário
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Atualizando os dados no banco de dados
            $cpf = $_POST["cpf"];
            $creci = $_POST["creci"];
            $nome = $_POST["nome"];

            $sql = "UPDATE corretores SET cpf='$cpf', creci='$creci', nome='$nome' WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                // Redirecionando para a página inicial com mensagem de sucesso
                header("Location: index.php?sucesso=true");
                exit; // Certifique-se de usar exit após redirecionar
            } else {
                // Erro na atualização
                echo "Erro ao atualizar: " . $conn->error;
            }
        } else {
            // Exibindo o formulário com os dados do corretor
?>
            <!DOCTYPE html>
            <html>

            <head>
                <title>Editar Corretor</title>
                <style>
                    body {
                        font-family: sans-serif;
                        background-color: blanchedalmond;
                    }
                </style>
            </head>

            <body>
                <h1 style="text-align: center;">Editar Corretor</h1>
                <form id="form-corretor" method="post" action="editar.php?id=<?php echo $id; ?>">
                    <div style="text-align: center; margin-bottom: 15px; justify-content: center;">
                        <label for="cpf">CPF:</label>
                        <input type="text" id="cpf" name="cpf" value="<?php echo $row["cpf"]; ?>" required pattern="[0-9]{11}">
                    </div>
                    <div style="text-align: center; margin-bottom: 15px; justify-content: center;">
                        <label for="creci">CRECI:</label>
                        <input type="text" id="creci" name="creci" value="<?php echo $row["creci"]; ?>" required minlength="2">
                    </div>
                    <div style="text-align: center; margin-bottom: 15px; justify-content: center;">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" value="<?php echo $row["nome"]; ?>" required minlength="2">
                    </div>
                    <div style="text-align: center;">
                        <button type="submit">Salvar</button>
                    </div>
                </form>
            </body>

            </html>
<?php
        }
    } else {
        // Corretor não encontrado
        echo "Corretor não encontrado.";
    }
} else {
    // ID do corretor não foi passado
    echo "ID do corretor inválido.";
}

// Fechando a conexão com o banco de dados
$conn->close();
?>