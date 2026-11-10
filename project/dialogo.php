<?php
/*
 * dialogo.php
 * Caixa de diálogo estilizada para mostrar as mensagens do sistema.
 *
 * Como usar:
 *   include('dialogo.php');
 *   mostrarDialogo('sucesso', 'Cliente cadastrado com sucesso!');
 *
 * Tipos disponíveis: sucesso | erro | aviso | info
 */

function mostrarDialogo($tipo, $mensagem)
{
    static $estiloJaImpresso = false;

    $tipos = array(
        'sucesso' => array(
            'cor'    => '#1f8a5b',
            'titulo' => 'Tudo certo!',
            'icone'  => '<path d="M5 12.5l4.5 4.5L19 7.5"/>'
        ),
        'erro' => array(
            'cor'    => '#c8372d',
            'titulo' => 'Ops, algo deu errado',
            'icone'  => '<path d="M6.5 6.5l11 11M17.5 6.5l-11 11"/>'
        ),
        'aviso' => array(
            'cor'    => '#b7791f',
            'titulo' => 'Atenção',
            'icone'  => '<path d="M12 7v6.5M12 17.2h.01"/>'
        ),
        'info' => array(
            'cor'    => '#2b6cb0',
            'titulo' => 'Informação',
            'icone'  => '<path d="M12 11v6M12 7.2h.01"/>'
        )
    );

    if (!isset($tipos[$tipo])) {
        $tipo = 'info';
    }

    $cor    = $tipos[$tipo]['cor'];
    $titulo = $tipos[$tipo]['titulo'];
    $icone  = $tipos[$tipo]['icone'];
    $texto  = htmlspecialchars($mensagem, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $id     = 'dlg_' . uniqid();

    /* O estilo é impresso só uma vez por página */
    if (!$estiloJaImpresso) {
        $estiloJaImpresso = true;
        echo '
<style>
.dlg-fundo {
    position: fixed;
    top: 0; right: 0; bottom: 0; left: 0;
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(20, 24, 31, .55);
    font-family: "Segoe UI", system-ui, -apple-system, Roboto, Arial, sans-serif;
    animation: dlgFundo .18s ease-out;
}
.dlg-caixa {
    box-sizing: border-box;
    width: 100%;
    max-width: 400px;
    padding: 28px 26px 24px;
    border-top: 5px solid var(--dlg-cor);
    border-radius: 14px;
    background: #ffffff;
    color: #1d2330;
    text-align: center;
    box-shadow: 0 20px 50px rgba(0, 0, 0, .28);
    animation: dlgCaixa .22s cubic-bezier(.2, .9, .3, 1.2);
}
.dlg-icone {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 56px;
    height: 56px;
    margin: 0 auto 14px;
    border-radius: 50%;
    background: var(--dlg-cor);
}
.dlg-icone svg {
    width: 28px;
    height: 28px;
    fill: none;
    stroke: #ffffff;
    stroke-width: 2.6;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.dlg-titulo {
    margin: 0 0 8px;
    font-size: 20px;
    font-weight: 700;
    color: #1d2330;
}
.dlg-msg {
    margin: 0 0 22px;
    font-size: 15px;
    line-height: 1.5;
    color: #4a5262;
    word-break: break-word;
}
.dlg-btn {
    min-width: 120px;
    padding: 11px 24px;
    border: 0;
    border-radius: 8px;
    background: var(--dlg-cor);
    color: #ffffff;
    font-family: inherit;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: filter .15s;
}
.dlg-btn:hover { filter: brightness(.92); }
.dlg-btn:focus-visible {
    outline: 3px solid var(--dlg-cor);
    outline-offset: 3px;
}
@keyframes dlgFundo { from { opacity: 0; } to { opacity: 1; } }
@keyframes dlgCaixa {
    from { opacity: 0; transform: translateY(12px) scale(.96); }
    to   { opacity: 1; transform: none; }
}
@media (prefers-reduced-motion: reduce) {
    .dlg-fundo, .dlg-caixa { animation: none; }
}
</style>';
    }

    echo '
<div class="dlg-fundo" id="' . $id . '" role="alertdialog" aria-modal="true"
     aria-labelledby="' . $id . '_t" aria-describedby="' . $id . '_m"
     style="--dlg-cor: ' . $cor . ';">
    <div class="dlg-caixa">
        <div class="dlg-icone">
            <svg viewBox="0 0 24 24" aria-hidden="true">' . $icone . '</svg>
        </div>
        <h2 class="dlg-titulo" id="' . $id . '_t">' . $titulo . '</h2>
        <p class="dlg-msg" id="' . $id . '_m">' . $texto . '</p>
        <button type="button" class="dlg-btn">Ok</button>
    </div>
</div>
<script>
(function () {
    var caixa = document.getElementById("' . $id . '");
    var botao = caixa.querySelector(".dlg-btn");

    function fechar() {
        document.removeEventListener("keydown", aoTeclar);
        if (caixa.parentNode) { caixa.parentNode.removeChild(caixa); }
    }
    function aoTeclar(e) {
        if (e.key === "Escape") { fechar(); }
    }

    botao.addEventListener("click", fechar);
    caixa.addEventListener("click", function (e) {
        if (e.target === caixa) { fechar(); }
    });
    document.addEventListener("keydown", aoTeclar);
    botao.focus();
})();
</script>';
}
?>
