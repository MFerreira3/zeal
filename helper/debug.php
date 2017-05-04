<?php
if (!defined('INCL_FILE')) die('HTTP/1.0 403 Forbidden');

/**
* Recebe uma variável e imprime informações sobre ela.
*
* @param  mixed  &$valor   Variável a ser debugada. É importante
*                          que seja utilizado uma variável nesse
*                          parâmetro e não um dado.
* @param  boolean $popup   Define se as informações devem ser
*                          ou não exibidas dentro de um pop-up.
* @param  boolean $exit    Define se a execução do código
*                          deve ser parada no fim dessa função
*/
function debug(&$valor, $popup = false, $exit = false, $titulo = null) {
	global $perfil;
	$header = "";
	if ($perfil != 'production') {
		// Define o texto de acordo com o tipo de dado.
		if (isset($valor)) {
			if (is_array($valor)) {
				$header = 'A variável contém um Array:';
			} else if (is_object($valor)) {
				$header = 'A variável contém um Objeto:';
			} else if (is_string($valor)) {
				$header = 'A variável contém uma String:';
			} else if (is_integer($valor) || is_numeric($valor)) {
				$header = 'A variável contém um número:';
			}
			$texto = print_r($valor, true);
		} else {
			$texto = "<div class='red'><i class='icon Remove'></i>A variável não contém nenhum dado atribuido a ele.</div>";
		}
		// Define o titulo personalizado caso algum tenha sido especificado.
		$header = isset($titulo) ? $titulo : $header;
		// Organiza a mensagem caso não seja exibido o modal.
		$corpo = "<div class='ui message' style='font-size:10px; width:90%; margin-left: 50px;'><pre><hr size='0'>";
		$corpo = isset($header) ? $corpo . '<div class="header">' . $header . '</div><hr size="0">': $corpo;
		$corpo = $corpo . $texto;
		$corpo = $corpo . "<hr size='0'/></pre></div>";
		// Verifica se houve a chamada do modal.
		if ($popup) {
			echo <<<END
			<script>
			$(document).ready(function() {
				$('.ui.modal') .modal('show');
			});
			</script>
			<div class="ui modal">
				<div class="header">
					$header
				</div>
				<div class="content">
					<div class="description">
						<pre>$texto</pre>
					</div>
				</div>
				<div class="actions">
					<div class="ui black deny button">
						Fechar
					</div>
				</div>
			</div>
END;
		} else {
			echo $corpo;
		}
		// Finaliza a execução do código se for pedido.
		if ($exit) {
			exit();
		}
	}
}
/**
 * Função padrão para a exibição de erros no Ataque Divino.
 * Abre um modal com uma mensagem definida. Opcionalmente
 * a função poderá parar a execução do código.
 * @param  string  $mensagem          Mensagem de erro a ser exibida
 * @param  boolean $finalizarExecucao Define se é um erro comum ou
 *                                    erro fatal.
 */
function exibirErro($mensagem = "", $finalizarExecucao = false) {
	echo <<<END
			<script>
			$(document).ready(function() {
				$('#modalErro').modal({
					closable: false,
					onDeny: function(){
						history.back(1);
					}
				});
				$('#modalErro').modal('show');
			});
			</script>
			<div class="ui modal large" id="modalErro">
				<div class="header">
					<i class="icon Bug"></i> The developers took an arrow to the knee
				</div>
				<div class="content">
					<div class="description">
						Error message: <br /><b>$mensagem</b>
					</div>
				</div>
				<div class="actions">
					<div class="ui black deny button">
						<i class="icon Reply"></i> Voltar para a página anterior
					</div>
				</div>
			</div>
END;
	if ($finalizarExecucao) {
		die($mensagem);
	}
}
/**
* Retorna uma notificação específica para evitar a repetição de texto
* no código
* @param String          $indice Identificador da notificação.
* @return  String         Mensagem correspondente ao identificador.
*/
function notificacoes($indice) {
	$mensagem[0] = "Operação realizada com sucesso";

	// Erros de configuração
	$mensagem['z0'] = "Não foi possível se conectar ao servidor";
	$mensagem['z1'] = "Arquivo de credenciais não encontrado";
	$mensagem['z2'] = "Environment inválido";

	// Erros de conta
	$mensagem['c0'] = "Dados insuficientes";
	$mensagem['c1'] = "Usuário inexistente";
	$mensagem['c2'] = "Senha incorreta";
	$mensagem['c3'] = "Usuário já cadastrado";
	$mensagem['c4'] = "Usuário não informado";
	$mensagem['c5'] = "Senha não informada";
	$mensagem['c6'] = "O nome de usuário deve conter entre 3 e 32 caracteres";
	$mensagem['c7'] = "A senha deve conter no mínimo 8 caracteres";

	// Erros especiais
	$mensagem['json'] = json_last_error_msg();
	return $mensagem[$indice];
}
/*
* Em algumas versões do PHP não é encontrada a função json_last_error_msg(),
* o teste condicional abaixo verifica se a função existe,
* caso não, a função será recriada.
*/
if (!function_exists('json_last_error_msg')) {
	function json_last_error_msg() {
		static $ERRORS = array(
		JSON_ERROR_NONE => 'No error',
		JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
		JSON_ERROR_STATE_MISMATCH => 'State mismatch (invalid or malformed JSON)',
		JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
		JSON_ERROR_SYNTAX => 'Syntax error',
		JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
		);
		$error = json_last_error();
		return isset($ERRORS[$error]) ? $ERRORS[$error] : 'Unknown error';
	}
}
?>
