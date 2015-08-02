<?php
session_start();
require_once("MySQL.class.php");
if(!isset($_SESSION['id'])){
	header("location: login.php");
}
$conexao = new MySQL();
?>
<html>
	<head>
	<!-- Latest compiled and minified CSS -->
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<meta charset="ISO-8859-1">
	<!-- Optional theme -->
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/style.css">
	

	<!-- Latest compiled and minified JavaScript -->
	<script src="js/bootstrap.min.js"></script>
	
	
	<script>
		/*$(document).ready(function(){
			$('#textarea').bind('keypress', function(e) {
				if(e.keyCode==32){
					var valor = $("#textarea").val();
					alert(valor);
				}
			});
		});*/
	</script>
	
	</head>
	
	<body>
	
		<div class="container-fluid">
		
			<div class="row" id="topo">
				<div class="col-lg-12" id="menu-topo">
					<div class="row" id="content-topo" style="margin-top:1em;">
						
						<div class="col-lg-1" id="nav-menu">
							<div id="icon-click">
								<button class="btn btn-default btn-lg" id="menu"><span id="list" class="glyphicon glyphicon-cog"></span></button>			
							</div>
							
							<div id="nav-opcoes" style="width:40%;">
								<ul class="">
									<li class="">Perfil</li>
									<li class="">Conversas</li>
									<li class="">Sair</li>
								</ul>
							</div>
						</div>
						<div class="col-lg-11">
							<div id="avatar">
								<?php
								$contadorFotos = 1;
								$pessoas = "";
								$queryConv = "SELECT DISTINCT nome, u.id FROM conversa c, usuarios u WHERE (u.id=c.idReceptor OR u.id=c.idEnviador) AND u.id<>".$_SESSION['id']." ORDER BY data DESC LIMIT 18";
								$resultado = $conexao->consulta($queryConv);
								if(count($resultado)>0){
									foreach($resultado as $cara){
										$contadorFotos++;
										$pessoas .= $cara['id'].",";
										$id = $cara['id'];
										echo "<img class='img hvr-buzz-out' data-toggle='tooltip' title='' data-placement='bottom' data-original-title='".$cara['nome']."' data-id=$id src='https://github.com/identicons/".$cara['nome'].".png'>";
									}
								}
								if(strlen($pessoas)>0){
									$pessoas = substr($pessoas, 0, -1);
								}else{
									$pessoas = "''";
								}
								if($contadorFotos<=18){
									$queryUsu = "SELECT nome, id FROM usuarios WHERE id NOT IN($pessoas) ORDER BY id DESC LIMIT 18";
									$resultado = $conexao->consulta($queryUsu);
									if(count($resultado)>0){
										foreach($resultado as $cara){
											$id = $cara['id'];
											if($id!=$_SESSION['id']){//nÃ£o Ã© eu mesmo!
												$contadorFotos++;
												echo "<img class='img hvr-buzz-out' data-toggle='tooltip' title='' data-placement='bottom' data-original-title='".$cara['nome']."' data-id=$id src='https://github.com/identicons/".$cara['nome'].".png'>";
											}
										}
									}
								}
								?>	
								
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="chat">
				<div class="col-lg-12" id="cima-chat">	
					<!-- Aqui tem opções padrões !-->
					
				</div>
			</div>
			<div class="row" id="texto-area">
				<div class="col-lg-12" id="baixo-chat">
					<div class="form-group">
						<input type="hidden" name="idCaraConversa" id="escondido">
						<textarea id="textarea" placeholder="Digite sua mensagem aqui!" class="form-control"></textarea>
						<div class='bloco'>
							<a class="hvr-wobble-horizontal" id="enviar"><span class="glyphicon glyphicon-arrow-right glyphicon-lg" ></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
$(document).ready(function() {
	$(function () {//inicializar as tooltips - bootstrap
		$('[data-toggle="tooltip"]').tooltip()
	});
	
	setInterval(
		function(){
		
			var idOutro = $("#escondido").val(),
				idUsuario = "<?= $_SESSION['id']; ?>";
			
			console.log(idOutro);
			$.post(
				"ajax/ajaxGetConversa.php",
				{idOutro:idOutro, idUsuario:idUsuario},
				function(resposta){
					$("#cima-chat").html(resposta);
					updateScroll();
				}
			);
		}
	, 2000);
	
	
	$('#textarea').bind('keyup', function(e) {
		if(e.keyCode==32){
			//salvar primeiro
			var valor = $("#textarea").val();
			quebraESalva(valor);
		}
		
		//=====================================================================//
			
			
		else if(e.keyCode==13){//Quando dá enter e salva a mensagem
			$("#enviar").trigger("click");
		}
	});
	
	$("#enviar").click(function(){
		var texto = $("#textarea").val();
			quebraESalva(texto);
			$("#textarea").val("");
			var idUsuario = '<?= $_SESSION['id'] ?>',
				idOutro = $("#escondido").val();
			//console.log(idUsuario+" | "+idOutro);
			
			$("#numeroMsgs").val($("#numeroMsgs").val()+1);
			
			if($.trim(texto).length>0){
				$.post(
					"ajax/ajaxSalvaMensagem.php",
					{mensagem:texto, idUsuario:idUsuario, idOutro:idOutro},
					function(resposta){
						$("#cima-chat").append(resposta);
						updateScroll();
					}
				);
			}
	});
	
	
	$(".img").click(function(){
		var idOutro = $(this).attr("data-id"),
			idUsuario = '<?= $_SESSION['id']?>';
		$("#escondido").val(idOutro);
		console.log("idOutro:"+idOutro+", idUsuario:"+idUsuario);
		$.post(
			"ajax/ajaxGetConversa.php",
			{idOutro:idOutro, idUsuario:idUsuario},
			function(resposta){
				$("#cima-chat").html(resposta);
				updateScroll();
			});
	});
	
	var cont = 0;
	$("#nav-opcoes").slideUp(10);
	$('#menu').click(function() {
		if(cont % 2 == 0){
			$("#nav-opcoes").slideDown();
		}else{
			$("#nav-opcoes").slideUp();
		}
		cont++
	});
	

	function updateScroll(){	
		var element = document.getElementById("cima-chat");
		element.scrollTop = element.scrollHeight;
	}
	
	function quebraESalva(valor){
		valor = $.trim(valor);
		var valorQuebrado = valor.split(" ");
		var tam = valorQuebrado.length;
		console.log(valorQuebrado);
		if(valorQuebrado.length >= 4){
			var nivel1 = valorQuebrado[valorQuebrado.length-2],

				nivel2 = valorQuebrado[valorQuebrado.length-3],
				nivel3 = valorQuebrado[valorQuebrado.length-4],
				proxima = valorQuebrado[valorQuebrado.length-1];
			
			$.post(
				"ajax/ajaxSalvaCasos.php",
				{tipo:3, nivel3:nivel3, nivel2:nivel2, nivel1:nivel1, proxima:proxima}
			);
		}
		else if(valorQuebrado.length == 3){
			var proxima = valorQuebrado[valorQuebrado.length-1],
				nivel1 = valorQuebrado[valorQuebrado.length-2],
				nivel2 = valorQuebrado[valorQuebrado.length-3]
				
			$.post(
				"ajax/ajaxSalvaCasos.php",
				{tipo:2, nivel2:nivel2, nivel1:nivel1, proxima:proxima}
			);
		}
		else if(valorQuebrado.length == 2){
			var proxima = valorQuebrado[valorQuebrado.length-1],
				nivel1 = valorQuebrado[valorQuebrado.length-2]
									
			$.post(
				"ajax/ajaxSalvaCasos.php",
				{tipo:1, nivel1:nivel1, proxima:proxima},
				function(resposta){
					//alert(resposta);
				}
			);
		}
	}
	
});
</script>

