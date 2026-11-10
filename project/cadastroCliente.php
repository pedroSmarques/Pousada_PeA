<?php 
    include('conexao.php');
    include('dialogo.php');

/* CADASTRAR */
if (isset($_POST['submit'])) {

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
   
    $sql = "INSERT INTO clientes
            (nome, cpf, email, telefone, cidade, estado)
            VALUES
            ('$nome','$cpf','$email','$telefone','$cidade','$estado')";

    $result = mysqli_query($conexao, $sql);
    if ($result) {
        mostrarDialogo('sucesso', "Cliente cadastrado com sucesso!");
    } else {
        mostrarDialogo('erro', "Erro ao cadastrar: " . mysqli_error($conexao));
    }
}
/* VOLTAR  */

if (isset($_POST["voltar"])) {
    $id = $_POST["idCliente"];
    if ($id == "") {

    $sql = "SELECT * FROM clientes ORDER BY idCliente DESC LIMIT 1";
    } else {
    $sql = "SELECT * FROM clientes WHERE idCliente < $id ORDER BY idCliente DESC LIMIT 1";
    }

    $resultado = $conexao->query($sql);
    if ($resultado->num_rows > 0) {

        $cliente = $resultado->fetch_assoc();
        $idCliente = $cliente["idCliente"];
        $nome = $cliente["nome"];
        $cpf = $cliente["cpf"];
        $email = $cliente["email"];
        $telefone = $cliente["telefone"];
        $cidade = $cliente["cidade"];
        $estado = $cliente["estado"];

    } else {
        mostrarDialogo('aviso', "Não existe cliente anterior.");
    }
}

/*  AVANÇAR */

if (isset($_POST["avancar"])) {
    $id = $_POST["idCliente"];
    if ($id == "") {
        $sql = "SELECT * FROM clientes ORDER BY idCliente LIMIT 1";
    } else {
        $sql = "SELECT * FROM clientes WHERE idCliente > $id ORDER BY idCliente LIMIT 1"; 
    }

    $resultado = $conexao->query($sql);
    if ($resultado->num_rows > 0) {
        $cliente = $resultado->fetch_assoc();
        $idCliente = $cliente["idCliente"];
        $nome = $cliente["nome"];
        $cpf = $cliente["cpf"];
        $email = $cliente["email"];
        $telefone = $cliente["telefone"];
        $cidade = $cliente["cidade"];
        $estado = $cliente["estado"];

    } else {
        mostrarDialogo('aviso', "Não existe próximo cliente.");
    }
}
/* PRIMEIRO ACESSO */

if (!isset($idCliente)) {

    $idCliente = "";
    $nome = "";
    $cpf = "";
    $email = "";
    $telefone = "";
    $cidade = "";
    $estado = "";
}

/* EXCLUIR */

if (isset($_POST["excluir"])) { 

    $id = $_POST["idCliente"]; 

    if ($id != "") { 

        $sql = "DELETE FROM clientes WHERE idCliente = $id"; 
        
        $resultado = $conexao->query($sql); 

        if ($resultado) {

            mostrarDialogo('sucesso', "Cliente excluído com sucesso!"); 

            $idCliente = ""; 
            $nome = ""; 
            $cpf = ""; 
            $email = ""; 
            $telefone = ""; 
            $cidade = ""; 
            $estado = ""; 

        } else { 

            mostrarDialogo('erro', "Erro ao excluir cliente: " . $conexao->error); 
        }

    } else { 

        mostrarDialogo('aviso', "Nenhum cliente selecionado para excluir."); 
    } 
}

/* ALTERAR */
if (isset($_POST["alterar"])) {
    $id = $_POST["idCliente"];

    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estado"];

    if ($id != "") {
        $sql = "UPDATE clientes SET
                nome = '$nome',
                cpf = '$cpf',
                email = '$email',
                telefone = '$telefone',
                cidade = '$cidade',
                estado = '$estado'
                WHERE idCliente = $id";

        $resultado = $conexao->query($sql);

        if ($resultado) {
            mostrarDialogo('sucesso', "Cliente alterado com sucesso!");
        } else {
            mostrarDialogo('erro', "Erro ao alterar cliente: " . $conexao->error);
        }
    } else {
        mostrarDialogo('aviso', "Nenhum cliente selecionado para alterar.");
    }
}

/* CONSULTAR */

if (isset($_POST["consultar"])) {
    $id = $_POST["idConsultar"];
    if ($id != "") {

        $sql = "SELECT * FROM clientes WHERE idCliente = $id";
        
        $resultado = $conexao->query($sql);

        if ($resultado->num_rows > 0) {

            $cliente = $resultado->fetch_assoc();

            $idCliente = $cliente["idCliente"];
            $nome = $cliente["nome"];
            $cpf = $cliente["cpf"];
            $email = $cliente["email"];
            $telefone = $cliente["telefone"];
            $cidade = $cliente["cidade"];
            $estado = $cliente["estado"];

        } else {

            mostrarDialogo('aviso', "Cliente não encontrado.");

        }

    } else {

        mostrarDialogo('aviso', "Informe o ID do cliente.");

    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - POUSADA P&A</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/cadastros.css">
</head>
<body class="formulario">
    <header>
        <a class="voltar" href="index.html">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
            Página Inicial
        </a>
        <h1>Gerenciar Clientes</h1>
        <p class="subtitulo">Cadastre, altere, consulte ou exclua um cliente</p>
    </header>
    <main>
        <div id="containerGeral">
            <form action="cadastroCliente.php" method="post">
                <input type="hidden" name="idCliente" value="<?php echo $idCliente; ?>">

                <div class="campos larga">
                    <label for="nome">Nome Completo</label>
                    <input type="text" name="nome" id="nome" placeholder="nome" value="<?php echo $nome; ?>">
                </div>
                <div class="campos">
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" id="cpf" placeholder="000.000.000-00" value="<?php echo $cpf; ?>">
                </div>
                <div class="campos">
                    <label for="telefone">Telefone</label>
                    <input type="tel" name="telefone" id="telefone" placeholder="(00)99999-9999" value="<?php echo $telefone; ?>">
                </div>
                <div class="campos larga">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="xxxxx@gmail.com" value="<?php echo $email; ?>">
                </div>
                <div class="campos">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" id="cidade" value="<?php echo $cidade; ?>">
                </div>
                <div class="campos">
                    <label for="estado">Estado</label>
                    <input type="text" name="estado" id="estado" value="<?php echo $estado; ?>">
                </div>

                <div class="campos consulta">
                    <label for="consultar">Consultar cliente</label>
                    <input type="number" name="idConsultar" id="consultar" placeholder="Digite o número do cliente">
                </div>

                <div id="btns">
                    <div class="btnsGerenciar">
                        <input type="submit" value="Cadastrar" name="submit">
                    </div>
                    <div class="btnsGerenciar">
                        <button type="submit" name="alterar">Alterar</button>
                    </div>
                    <div class="btnsGerenciar">
                        <button type="submit" name="excluir">Excluir</button>
                    </div>
                    <div class="btnsGerenciar">
                        <button type="submit" name = "voltar">Voltar Registro</button>
                    </div>
                    <div class="btnsGerenciar">
                        <button type="reset">Limpar</button>
                    </div>
                    <div class="btnsGerenciar">
                        <button type="submit" name="avancar">Próximo Registro</button>
                    </div>
                    <div class="btnsGerenciar">
                        <button type="submit" name="consultar">Consultar</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <footer>
        &copy; 2026 - TODOS OS DIREITOS RESERVADOS
    </footer>
</body>
</html>