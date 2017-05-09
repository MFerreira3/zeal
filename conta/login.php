<?php
if (!defined(INCL_FILE)) die('HTTP/1.0 403 Forbidden');
$def_time=time();
$def_endTime = 1496880000;
$def_remainingTime = $def_endTime - $def_time;
?>

<style>
body {
    overflow: hidden;
	background: black;
}

#pagina {
	background: black;
}

#loginsegment {
    max-width: 30rem;
    margin: 0 auto;
    margin-top: 5%;
}
</style>

<div id="loginsegment">
    <br />
    <form class="ui inverted form" id="loginForm" method="POST">
        <img src='assets/z.png' style="width: 100%; height: auto;"/>
        <p>
          <div class="ui center aligned grey header" id="timer"></div>
          <div class="ui labeled fluid input" id="campoUsuario">
            <div class="ui <?= $def_secColorClass ?> label" style="width: 5rem;">
              <center>Usuário</center>
            </div>
            <input name="usuario" type="text">
          </div>
        </p>
        <p>
          <div class="ui labeled fluid input">
            <div class="ui <?= $def_secColorClass ?> label" style="width: 5rem;">
              <center>Senha</center>
            </div>
            <input name="senha" type="password">
          </div>
        </p>
		<div class="ui fluid <?= $def_secColorClass ?> inverted basic buttons">
			<button class="ui button" id="botaoEntrar">Entrar</button>
			<button class="ui button" id="botaoRegistrar">Registrar-se</button>
		</div>

		<div class="ui horizontal inverted divider">Ou</div>

		<button class="ui fluid inverted <?= $def_secColorClass ?> button" id="botaoFacebook">
			<i class="facebook icon"></i>Entrar com Facebook
		</button>
    </form>
</div>

<script>
function countdown(intervalo, update, complete) {
    var timeNow = <?= $def_remainingTime ?>;
    var interval = setInterval(function() {
        timeNow--;

        if (timeNow <= 0) {
            clearInterval(interval);
            complete();
        } else update(timeNow);
    }, intervalo);
};

countdown(
    1000,
    function(timeLeft) {
        $("#timer").text(Math.floor(timeLeft/60/60/24) + ':' + Math.floor(timeLeft/60/60%24) + ':' + Math.floor(timeLeft/60%60) + ':' + Math.floor(timeLeft%60));
    },
    function() {
        alert("Timer complete!");
    }
);

function submit() {
    $(".submit.button").addClass("loading");
    $("#loginForm").off("submit").on("submit", false);
    $.post("<?= $def_cred->rootURL ?>conta/autenticar.php", $("#loginForm").serializeArray(), function(response) {
        if (response != 0) {
            // Print error alert
            errorAlert(response);
        } else {
            $("#loginsegment").popup("hide");
            location.reload();
        }
	}).fail(function() {
        errorAlert("c0");
	}).always(function() {
        $(".submit.button").removeClass("loading");
        $("#loginForm").on("submit", submit);
    })
    // Prevent form from being submitted
    return false;
}

function errorAlert(erro) {
    $("#campoUsuario").popup({
        on: "manual",
        position: "top center",
        variation: "inverted",
        content: erro
    }).popup("show");
}
$("#botaoEntrar").on("click", submit);
</script>
