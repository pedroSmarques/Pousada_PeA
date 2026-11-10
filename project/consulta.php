<?php
$dbHost='localhost';
$dbUsername='root';
$dbPassword='alunolab';
$dbName='loja_eletronico';
$conexao=new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

if ($conexao->connect_errno) {
    die("Erro na conexão: " . $conexao->connect_error);
}

/* CADASTRAR */
if (isset($_POST['submit'])) {

    $razao_social = $_POST['razao_social'];
    $nome_fantasia = $_POST['nome_fantasia'];
    $cnpj = $_POST['cnpj'];
    $email = $_POST['email'];
    $cidade = $_POST['cidade'];
    $contato = $_POST['contato'];
   
    $sql = "INSERT INTO fornecedores
            (razao_social,nome_fantasia,cnpj,email,cidade,contato)
            VALUES
            ('$razao_social','$nome_fantasia','$cnpj','$email','$cidade','$contato')";

    $result = mysqli_query($conexao, $sql);
    if ($result) {
        echo "Fornecedor cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }
}
/* VOLTAR  */

if (isset($_POST["voltar"])) {
    $id = $_POST["idfornecedor"];
    if ($id == "") {

    $sql = "SELECT * FROM fornecedores ORDER BY idfornecedor DESC LIMIT 1";
    } else {
    $sql = "SELECT * FROM fornecedores WHERE idfornecedor < $id ORDER BY idfornecedor DESC LIMIT 1";
    }

    $resultado = $conexao->query($sql);
    if ($resultado->num_rows > 0) {

        $fornecedor = $resultado->fetch_assoc();
        $idfornecedor = $fornecedor["idfornecedor"];
        $razao_social = $fornecedor["razao_social"];
        $nome_fantasia = $fornecedor["nome_fantasia"];
        $cnpj = $fornecedor["cnpj"];
        $email = $fornecedor["email"];
        $cidade = $fornecedor["cidade"];
        $contato = $fornecedor["contato"];

    } else {
        echo "Não existe fornecedor anterior.";
    }
}

/*  AVANÇAR */

if (isset($_POST["avancar"])) {
    $id = $_POST["idfornecedor"];
    if ($id == "") {

       

        $sql = "SELECT * FROM fornecedores ORDER BY idfornecedor LIMIT 1";
    } else {
    $sql = "SELECT * FROM fornecedores WHERE idfornecedor > $id ORDER BY idfornecedor LIMIT 1"; }

    $resultado = $conexao->query($sql);
    if ($resultado->num_rows > 0) {
        $fornecedor = $resultado->fetch_assoc();
        $idfornecedor = $fornecedor["idfornecedor"];
        $razao_social = $fornecedor["razao_social"];
        $nome_fantasia = $fornecedor["nome_fantasia"];
        $cnpj = $fornecedor["cnpj"];
        $email = $fornecedor["email"];
        $cidade = $fornecedor["cidade"];
        $contato = $fornecedor["contato"];

    } else {
        echo "Não existe próximo fornecedor.";
    }
}
/* PRIMEIRO ACESSO */

if (!isset($idfornecedor)) {

    $idfornecedor = "";
    $razao_social = "";
    $nome_fantasia = "";
    $cnpj = "";
    $email = "";
    $cidade = "";
    $contato = "";
}

/* EXCLUIR */

if (isset($_POST["excluir"])) { 

    $id = $_POST["idfornecedor"]; 

    if ($id != "") { 

        $sql = "DELETE FROM fornecedores WHERE idfornecedor = $id"; 
        
        $resultado = $conexao->query($sql); 

        if ($resultado) {

            echo "Fornecedor excluído com sucesso!"; 

            $idfornecedor = ""; 
            $razao_social = ""; 
            $nome_fantasia = ""; 
            $cnpj = ""; 
            $email = ""; 
            $cidade = ""; 
            $contato = ""; 

        } else { 

            echo "Erro ao excluir fornecedor: " . $conexao->error; 
        }

    } else { 

        echo "Nenhum fornecedor selecionado para excluir."; 
    } 
}

/* ALTERAR */
if (isset($_POST["alterar"])) {
    $id = $_POST["idfornecedor"];

    $razao_social = $_POST["razao_social"];
    $nome_fantasia = $_POST["nome_fantasia"];
    $cnpj = $_POST["cnpj"];
    $email = $_POST["email"];
    $cidade = $_POST["cidade"];
    $contato = $_POST["contato"];

    if ($id != "") {
        $sql = "UPDATE fornecedores SET
                razao_social = '$razao_social',
                nome_fantasia = '$nome_fantasia',
                cnpj = '$cnpj',
                email = '$email',
                cidade = '$cidade',
                contato = '$contato'
                WHERE idfornecedor = $id";

        $resultado = $conexao->query($sql);

        if ($resultado) {
            echo "Fornecedor alterado com sucesso!";
        } else {
            echo "Erro ao alterar fornecedor: " . $conexao->error;
        }
    } else {
        echo "Nenhum fornecedor selecionado para alterar.";
    }
}

/* CONSULTAR */

if (isset($_POST["consultar"])) {
    $id = $_POST["idconsulta"];
    if ($id != "") {

        $sql = "SELECT * FROM fornecedores WHERE idfornecedor = $id";
        
        $resultado = $conexao->query($sql);

        if ($resultado->num_rows > 0) {

            $fornecedor = $resultado->fetch_assoc();

            $idfornecedor = $fornecedor["idfornecedor"];
            $razao_social = $fornecedor["razao_social"];
            $nome_fantasia = $fornecedor["nome_fantasia"];
            $cnpj = $fornecedor["cnpj"];
            $email = $fornecedor["email"];
            $cidade = $fornecedor["cidade"];
            $contato = $fornecedor["contato"];

        } else {

            echo "Fornecedor não encontrado.";

        }

    } else {

        echo "Informe o ID do fornecedor.";

    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Fornecedores</title>
     <link href="fornecedores.css" rel="stylesheet">
</head>

<body>
<div id="geral">
    <header>
        <h1>⚡ TechStore</h1>
        <p>Cadastro de Fornecedores</p>
    </header>
    <main>
        <form action="fornecedores.php" method="post">

       <input type="hidden" name="idfornecedor" value="<?php echo $idfornecedor; ?>">


     <div class="campo">
     <label for="razao_social">Razão Social: </label>
     <input type="text" id="razao_social" name="razao_social"value="<?php echo $razao_social; ?>">
     </div>

     <div class="campo">
     <label for="nome_fantasia"> Nome Fantasia:</label>
     <input type="text" id="nome_fantasia" name="nome_fantasia"value="<?php echo $nome_fantasia; ?>">
     </div>

    <div class="campo">
    <label for="cnpj"> CNPJ: </label>
    <input type="text" id="cnpj" name="cnpj" placeholder="00.000.000/0000-00" value="<?php echo $cnpj; ?>">
    </div>

    <div class="campo">
    <label for="email"> E-mail:</label>
    <input type="email" id="email" name="email" placeholder="exemplo@email.com" value="<?php echo $email; ?>">
    </div>

   <div class="campo">
  <label for="cidade"> Cidade: </label>
  <select id="cidade" name="cidade"> <option value=""> Selecione a cidade </option>
  <option value="Duque de Caxias" <?php if ($cidade == "Duque de Caxias") {echo "selected";}?>>Duque de Caxias </option>
  <option value="Rio de Janeiro" <?php if ($cidade == "Rio de Janeiro") {echo "selected";}?>> Rio de Janeiro </option>
  <option value="Niterói" <?php if ($cidade == "Niterói") {echo "selected";}?>> Niterói </option>
  <option value="São Gonçalo" <?php if ($cidade == "São Gonçalo") {echo "selected";}?>>São Gonçalo</option> 
</select>
 </div>

<div class="campo">
<label for="contato">Contato Responsável:</label>
<input type="text" id="contato" name="contato" value="<?php echo $contato; ?>">
</div>


<div class="campo">
<label for="idconsulta">Informe o Id do fornecedor que deseja consultar:</label>
<input type="number" placeholder="id de consulta" id="txtconsulta" name="idconsulta">
</div>

<button type="submit"name="voltar"> ◀️ Voltar </button>
<input type="submit" name="submit" value="Cadastrar">
<button type="submit" name="avancar"> ▶️Avançar → </button>
<button type="submit" name="excluir">🗑️ Excluir</button>
<button type="submit" name="alterar">✏️ Alterar</button>
<button type="submit" name="consultar">🔎 Consultar</button>

<button type="reset">Limpar </button>
</div>
</form>
</main>
<footer>
<p>TechStore - Sistema de Gerenciamento</p>
</footer>
</div>
</body>
</html>
<?php
$conexao->close();
?>

















