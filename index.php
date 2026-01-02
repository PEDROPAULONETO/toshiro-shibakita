<html>

<head>
<title>Exemplo PHP</title>
<title>Gerenciamento de Produtos</title>
<style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; margin: 0; padding: 20px; }
    .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    h1 { color: #333; text-align: center; }
    form { display: grid; gap: 10px; margin-bottom: 30px; padding: 20px; background: #f9f9f9; border-radius: 8px; }
    input[type="text"] { padding: 10px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box; }
    input[type="submit"] { background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px; }
    input[type="submit"]:hover { background-color: #0056b3; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
    th { background-color: #343a40; color: white; }
    tr:hover { background-color: #f1f1f1; }
    .btn-delete { background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
    .btn-delete:hover { background-color: #c82333; }
    .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
    .success { background-color: #d4edda; color: #155724; }
    .error { background-color: #f8d7da; color: #721c24; }
</style>
</head>
<body>

<div class="container">
    <h1>📦 Catálogo de Supermercado</h1>

<?php
ini_set("display_errors", 0); // Em produção, manter 0. Para debug, usar 1.
header('Content-Type: text/html; charset=iso-8859-1');

// Configuração do Banco de Dados via Variáveis de Ambiente
$servername = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASSWORD");
$database = getenv("DB_NAME");

$link = new mysqli($servername, $username, $password, $database);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    printf("<div class='alert error'>Falha na conexão com o Banco de Dados: %s</div>", mysqli_connect_error());
    exit();
}

// 1. Garantir que a tabela existe
$sql_create = "CREATE TABLE IF NOT EXISTS dados (
    ProdutoID int AUTO_INCREMENT PRIMARY KEY,
    Nome varchar(50),
    Categoria varchar(50),
    Preco varchar(50),
    Fornecedor varchar(50),
    Host varchar(50)
)";
$link->query($sql_create);

// 2. Processar Formulário (Inserir ou Deletar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Deletar
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $stmt = $link->prepare("DELETE FROM dados WHERE ProdutoID = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<div class='alert success'>Produto removido com sucesso!</div>";
        }
        $stmt->close();
    } 
    // Inserir
    elseif (isset($_POST['nome'])) {
        $nome = $_POST['nome'];
        $categoria = $_POST['categoria'];
        $preco = $_POST['preco'];
        $fornecedor = $_POST['fornecedor'];
        $host_name = gethostname();

        $stmt = $link->prepare("INSERT INTO dados (Nome, Categoria, Preco, Fornecedor, Host) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nome, $categoria, $preco, $fornecedor, $host_name);

        if ($stmt->execute()) {
            echo "<div class='alert success'>Produto cadastrado com sucesso!</div>";
        } else {
            echo "<div class='alert error'>Erro: " . $link->error . "</div>";
        }
        $stmt->close();
    }
}

?>

    <!-- Formulário de Cadastro -->
    <form action="index.php" method="POST">
        <h3>Novo Produto</h3>
        <input type="text" name="nome" placeholder="Nome do Produto" required>
        <input type="text" name="categoria" placeholder="Categoria (ex: Bebidas)" required>
        <input type="text" name="preco" placeholder="Preço (ex: R$ 10,00)" required>
        <input type="text" name="fornecedor" placeholder="Fornecedor" required>
        <input type="submit" value="Cadastrar Produto">
    </form>

    <!-- Tabela de Listagem -->
    <h3>Estoque Atual</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Produto</th>
            <th>Categoria</th>
            <th>Preço</th>
            <th>Fornecedor</th>
            <th>Container ID</th>
            <th>Ação</th>
        </tr>
        <?php
        $result = $link->query("SELECT * FROM dados ORDER BY ProdutoID DESC");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ProdutoID"] . "</td>";
                echo "<td>" . htmlspecialchars($row["Nome"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Categoria"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Preco"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Fornecedor"]) . "</td>";
                echo "<td><small>" . $row["Host"] . "</small></td>";
                echo "<td>
                        <form method='POST' style='display:inline; margin:0; padding:0; background:none;'>
                            <input type='hidden' name='delete_id' value='" . $row["ProdutoID"] . "'>
                            <button type='submit' class='btn-delete'>X</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7' style='text-align:center'>Nenhum produto cadastrado.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
