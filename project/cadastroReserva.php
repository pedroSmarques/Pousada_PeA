<?php 
    include('conexao.php');
    include('dialogo.php');

    /* CADASTRAR */
if (isset($_POST['submit'])) {

    $dataEntrada = $_POST['dataEntrada'];
    $dataSaida = $_POST['dataSaida'];
    $quantidade = $_POST['quantidade'];
    $valorTotal = $_POST['valorTotal'];
    $situacao = $_POST['situacao'];
    
   
    $sql = "INSERT INTO reservas
            (data_entrada, data_saida, quantidade, valor_total, situacao)
            VALUES
            ('$dataEntrada','$dataSaida','$quantidade','$valorTotal','$situacao')";

    $result = mysqli_query($conexao, $sql);
    if ($result) {
        mostrarDialogo('sucesso', "reservas cadastrado com sucesso!");
    } else {
        mostrarDialogo('erro', "Erro ao cadastrar: " . mysqli_error($conexao));
    }
}
/* VOLTAR  */

if (isset($_POST["voltar"])) {
    $id = $_POST["idReserva"];
    if ($id == "") {

    $sql = "SELECT * FROM reservas ORDER BY idReserva DESC LIMIT 1";
    } else {
    $sql = "SELECT * FROM reservas WHERE idReserva < $id ORDER BY idReserva DESC LIMIT 1";
    }

    $resultado = $conexao->query($sql);
    if ($resultado->num_rows > 0) {

        $reserva = $resultado->fetch_assoc();
        $idReserva = $reserva["idReserva"];
        $dataEntrada = $reserva["data_entrada"];
        $dataSaida = $reserva["data_saida"];
        $quantidade = $reserva["quantidade"];
        $valorTotal = $reserva["valor_total"];
        $situacao = $reserva["situacao"];

    } else {
        mostrarDialogo('aviso', "Não existe reservas anterior.");
    }
}

/*  AVANÇAR */

if (isset($_POST["avancar"])) {
    $id = $_POST["idReserva"];
    if ($id == "") {

       

        $sql = "SELECT * FROM reservas ORDER BY idReserva LIMIT 1";
    } else {
    $sql = "SELECT * FROM reservas WHERE idReserva > $id ORDER BY idReserva LIMIT 1"; }

    $resultado = $conexao->query($sql);
    if ($resultado->num_rows > 0) {
        $reserva = $resultado->fetch_assoc();
        $idReserva = $reserva["idReserva"];
        $dataEntrada = $reserva["data_entrada"];
        $dataSaida = $reserva["data_saida"];
        $quantidade = $reserva["quantidade"];
        $valorTotal = $reserva["valor_total"];
        $situacao = $reserva["situacao"];

    } else {
        mostrarDialogo('aviso', "Não existe próximo reservas.");
    }
}
/* PRIMEIRO ACESSO */

if (!isset($idReserva)) {

    $idReserva = "";
    $dataEntrada = "";
    $dataSaida = "";
    $quantidade = "";
    $valorTotal = "";
    $situacao = "";
}

/* EXCLUIR */

if (isset($_POST["excluir"])) { 

    $id = $_POST["idReserva"]; 

    if ($id != "") { 

        $sql = "DELETE FROM reservas WHERE idReserva = $id"; 
        
        $resultado = $conexao->query($sql); 

        if ($resultado) {

            mostrarDialogo('sucesso', "reservas excluído com sucesso!"); 

           
            $idReserva = "";
            $dataEntrada = "";
            $dataSaida = "";
            $quantidade = "";
            $valorTotal = "";
            $situacao = "";

        } else { 

            mostrarDialogo('erro', "Erro ao excluir reservas: " . $conexao->error); 
        }

    } else { 

        mostrarDialogo('aviso', "Nenhum reservas selecionado para excluir."); 
    } 
}

/* ALTERAR */
if (isset($_POST["alterar"])) {
    $id = $_POST["idReserva"];

    $dataEntrada = $_POST['dataEntrada'];
    $dataSaida = $_POST['dataSaida'];
    $quantidade = $_POST['quantidade'];
    $valorTotal = $_POST['valorTotal'];
    $situacao = $_POST['situacao'];
    if ($id != "") {
        $sql = "UPDATE reservas SET
                data_entrada = '$dataEntrada',
                data_saida = '$dataSaida',
                quantidade = '$quantidade',
                valor_total = '$valorTotal',
                situacao = '$situacao'
                WHERE idReserva = $id";

        $resultado = $conexao->query($sql);

        if ($resultado) {
            mostrarDialogo('sucesso', "reservas alterado com sucesso!");
        } else {
            mostrarDialogo('erro', "Erro ao alterar reservas: " . $conexao->error);
        }
    } else {
        mostrarDialogo('aviso', "Nenhum reservas selecionado para alterar.");
    }
}

/* CONSULTAR */

if (isset($_POST["consultar"])) {
    $id = $_POST["idConsultar"];
    if ($id != "") {

        $sql = "SELECT * FROM reservas WHERE idReserva = $id";
        
        $resultado = $conexao->query($sql);

        if ($resultado->num_rows > 0) {

            $reserva = $resultado->fetch_assoc();

            $idReserva = $reserva["idReserva"];
            $dataEntrada = $reserva["data_entrada"];
            $dataSaida = $reserva["data_saida"];
            $quantidade = $reserva["quantidade"];
            $valorTotal = $reserva["valor_total"];
            $situacao = $reserva["situacao"];
        } else {

            mostrarDialogo('aviso', "reservas não encontrado.");

        }

    } else {

        mostrarDialogo('aviso', "Informe o ID do reservas.");

    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas - POUSADA P&A</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>
<body class="reservas">
    <header>
        <a class="voltar" href="index.html">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
            Página Inicial
        </a>
        <h1>Gerenciar Reservas</h1>
        <p class="subtitulo">Cadastre, altere, consulte ou exclua uma reserva</p>
    </header>
    <main>
        <div id="containerGeral">
            <form action="cadastroReserva.php" method="post">
                <input type="hidden" name="idReserva" value = "<?php echo $idReserva ?>">

                <div class="campos">
                    <label for="dataEntrada">Data de Entrada</label>
                    <input type="date" name="dataEntrada" id="dataEntrada" value = "<?php echo $dataEntrada ?>">
                </div>
                <div class="campos">
                    <label for="dataSaida">Data de Saída</label>
                    <input type="date" name="dataSaida" id="dataSaida" value = "<?php echo $dataSaida ?>">
                </div>
                <div class="campos">
                    <label for="quantidade">Quantidade</label>
                    <input type="number" name="quantidade" id="quantidade" value = "<?php echo $quantidade ?>">
                </div>
                <div class="campos">
                    <label for="valorTotal">Valor Total</label>
                    <input type="number" name="valorTotal" id="valorTotal" value = "<?php echo $valorTotal ?>">
                </div>
                <div class="campos larga">
                    <label for="situacao">Situação</label>
                    <select name="situacao" id="situacao">
                        <option selected disabled>Selecione</option>
                        <option value="Confirmada" <?php if ($situacao == "Confirmada") {echo "selected";}?>>Confirmada</option>
                        <option value="Cancelada" <?php if ($situacao == "Cancelada") {echo "selected";}?>>Cancelada</option>
                        <option value="Finalizada" <?php if ($situacao == "Finalizada") {echo "selected";}?>>Finalizada</option>
                    </select>
                </div>

                <div class="campos consulta">
                    <label for="consultar">Consultar reserva</label>
                    <input type="number" name="idConsultar" id="consultar" placeholder="Digite o número da reserva">
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