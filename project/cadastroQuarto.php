<?php 
    include('conexao.php');
    include('dialogo.php');

    /* CADASTRAR */
if (isset($_POST['submit'])) {

    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $capacidade = $_POST['capacidade'];
    $valorDiaria = $_POST['valorDiaria'];
    $descricao = $_POST['descricao'];
    $situacao = $_POST['situacao'];
   
    $sql = "INSERT INTO quartos
            (nome, tipo, capacidade, valor_diaria, descricao, situacao)
            VALUES
            ('$nome','$tipo','$capacidade','$valorDiaria','$descricao','$situacao')";

    $result = mysqli_query($conexao, $sql);
    if ($result) {
        mostrarDialogo('sucesso', "Quarto cadastrado com sucesso!");
    } else {
        mostrarDialogo('erro', "Erro ao cadastrar: " . mysqli_error($conexao));
    }
}
/* VOLTAR  */

if (isset($_POST["voltar"])) {
    $id = $_POST["idQuarto"];
    if ($id == "") {

    $sql = "SELECT * FROM quartos ORDER BY idQuarto DESC LIMIT 1";
    } else {
    $sql = "SELECT * FROM quartos WHERE idQuarto < $id ORDER BY idQuarto DESC LIMIT 1";
    }

    $resultado = $conexao->query($sql);
    if ($resultado->num_rows > 0) {

        $quarto = $resultado->fetch_assoc();
        $idQuarto = $quarto["idQuarto"];
        $nome = $quarto["nome"];
        $tipo = $quarto["tipo"];
        $capacidade = $quarto["capacidade"];
        $valorDiaria = $quarto["valor_diaria"];
        $descricao = $quarto["descricao"];
        $situacao = $quarto["situacao"];

    } else {
        mostrarDialogo('aviso', "Não existe fornecedor anterior.");
    }
}

/*  AVANÇAR */

if (isset($_POST["avancar"])) {
    $id = $_POST["idQuarto"];
    if ($id == "") {

       

        $sql = "SELECT * FROM quartos ORDER BY idQuarto LIMIT 1";
    } else {
    $sql = "SELECT * FROM quartos WHERE idQuarto > $id ORDER BY idQuarto LIMIT 1"; }

    $resultado = $conexao->query($sql);
    if ($resultado->num_rows > 0) {
        $quarto = $resultado->fetch_assoc();
        $idQuarto = $quarto["idQuarto"];
        $nome = $quarto["nome"];
        $tipo = $quarto["tipo"];
        $capacidade = $quarto["capacidade"];
        $valorDiaria = $quarto["valor_diaria"];
        $descricao = $quarto["descricao"];
        $situacao = $quarto["situacao"];


    } else {
        mostrarDialogo('aviso', "Não existe próximo quarto.");
    }
}
/* PRIMEIRO ACESSO */

if (!isset($idQuarto)) {

    $idQuarto = "";
    $nome = "";
    $tipo = "";
    $capacidade = ""; 
    $valorDiaria = "";
    $descricao = "";
    $situacao = "";

}

/* EXCLUIR */

if (isset($_POST["excluir"])) { 

    $id = $_POST["idQuarto"]; 

    if ($id != "") { 

        $sql = "DELETE FROM quartos WHERE idQuarto = $id"; 
        
        $resultado = $conexao->query($sql); 

        if ($resultado) {

            mostrarDialogo('sucesso', "Quarto excluído com sucesso!"); 

            $idQuarto = ""; 
            $nome = "";
            $tipo = "";
            $capacidade = ""; 
            $valorDiaria = "";
            $descricao = "";
            $situacao = ""; 

        } else { 

            mostrarDialogo('erro', "Erro ao excluir quarto: " . $conexao->error); 
        }

    } else { 

        mostrarDialogo('aviso', "Nenhum quarto selecionado para excluir."); 
    } 
}

/* ALTERAR */
if (isset($_POST["alterar"])) {
    $id = $_POST["idQuarto"];

    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $capacidade = $_POST['capacidade'];
    $valorDiaria = $_POST['valorDiaria'];
    $descricao = $_POST['descricao'];
    $situacao = $_POST['situacao'];

    if ($id != "") {
        $sql = "UPDATE quartos SET
                nome = '$nome',
                tipo = '$tipo',
                capacidade = '$capacidade',
                valor_diaria = '$valorDiaria',
                descricao = '$descricao',
                situacao = '$situacao'
                WHERE idQuarto = $id";

        $resultado = $conexao->query($sql);

        if ($resultado) {
            mostrarDialogo('sucesso', "Quarto alterado com sucesso!");
        } else {
            mostrarDialogo('erro', "Erro ao alterar quarto: " . $conexao->error);
        }
    } else {
        mostrarDialogo('aviso', "Nenhum quarto selecionado para alterar.");
    }
}

/* CONSULTAR */

if (isset($_POST["consultar"])) {
    $id = $_POST["idConsultar"];
    if ($id != "") {

        $sql = "SELECT * FROM quartos WHERE idQuarto = $id";
        
        $resultado = $conexao->query($sql);

        if ($resultado->num_rows > 0) {

            $quarto = $resultado->fetch_assoc();

            $idQuarto = $quarto["idQuarto"];
            $nome = $quarto["nome"];
            $tipo = $quarto["tipo"];
            $capacidade = $quarto["capacidade"];
            $valorDiaria = $quarto["valor_diaria"];
            $descricao = $quarto["descricao"];
            $situacao = $quarto["situacao"];

        } else {

            mostrarDialogo('aviso', "Quarto não encontrado.");

        }

    } else {

        mostrarDialogo('aviso', "Informe o ID do quarto.");

    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quartos - POUSADA P&A</title>

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
        <h1>Gerenciar Quartos</h1>
        <p class="subtitulo">Cadastre, altere, consulte ou exclua um quarto</p>
    </header>
    <main>
        <div id="containerGeral">
            <form action="cadastroQuarto.php" method="post">
                <input type="hidden" name="idQuarto" value = "<?php echo $idQuarto ?>">

                <div class="campos">
                    <label for="nome">Nome do Quarto</label>
                    <input type="text" name="nome" id="nome" placeholder="nome" value = "<?php echo $nome ?>">
                </div>
                <div class="campos">
                    <label for="tipo">Tipo de Quarto</label>
                    <select name="tipo" id="tipo">
                        <option selected disabled>Selecione</option>
                        <option <?php if ($tipo == "Simples") {echo "selected";}?> value="Simples">Simples</option>
                        <option <?php if ($tipo == "Duplo") {echo "selected";}?> value="Duplo">Duplo</option>
                        <option <?php if ($tipo == "Suíte") {echo "selected";}?> value="Suíte">Suíte</option>
                    </select>
                </div>
                <div class="campos">
                    <label for="capacidade">Capacidade</label>
                    <input type="number" name="capacidade" id="capacidade" value = "<?php echo $capacidade ?>">
                </div>
                <div class="campos">
                    <label for="valorDiaria">Valor da Diária</label>
                    <input type="number" name="valorDiaria" id="valorDiaria" step="0.01" value = "<?php echo $valorDiaria ?>">
                </div>
                <div class="campos">
                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" id="descricao" placeholder = "Opcional" value = "<?php echo $descricao ?>">
                </div>
                <div class="campos">
                    <label for="situacao">Situação</label>
                    <select name="situacao" id="situacao">
                        <option selected disabled>Selecione</option>
                        <option <?php if ($situacao == "Disponível") {echo "selected";}?> value="Disponível">Disponível</option>
                        <option <?php if ($situacao == "Ocupado") {echo "selected";}?> value="Ocupado">Ocupado</option>
                        <option <?php if ($situacao == "Manutenção") {echo "selected";}?> value="Manutenção">Manutenção</option>
                    </select>
                </div>

                <div class="campos consulta">
                    <label for="consultar">Consultar quarto</label>
                    <input type="number" name="idConsultar" id="consultar" placeholder="Digite o número do quarto">
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