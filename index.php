<?php
session_start();
header('Content-Type: text/html; charset=ISO-8859-1');
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
						
						<div class="col-lg-1 dropdown" id="nav-menu">
							
							<button class="btn btn-default btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="menu"><span id="list" class="glyphicon glyphicon-cog"></span></button>			
							
						
							<ul class="dropdown-menu" aria-labelledby="menu">
								<li><a>Perfil</a></li>
								<li><a>Conversas</a></li>
								<li role="separator" class="divider"></li>
								<li><a>Sair</a></li>
							</ul>
						
						</div>
						<div class="col-lg-11">
							<div id="avatar">
								<?php
								$contadorFotos = 1;
								$pessoas = "";
								$queryConv = "SELECT DISTINCT nome, u.id FROM conversa c, usuarios u WHERE (u.id=c.idReceptor OR u.id=c.idEnviador) AND u.id<>".$_SESSION['id']." ORDER BY data DESC LIMIT 18";
								$resultado = $conexao->consulta($queryConv);
								if(count($resultado)>0){
									$idLocao = $resultado[0]['id'];
									foreach($resultado as $cara){
										$contadorFotos++;
										$pessoas .= $cara['id'].",";
										$id = $cara['id'];
										echo "<img class='img hvr-buzz-out' data-toggle='tooltip' title='' data-placement='bottom' data-original-title='".$cara['nome']."' data-id=$id src='https://github.com/identicons/".($cara['nome']).".png'>";
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
										if(!isset($idLocao)){
											$idLocao = $resultado[0]['id'];
										}
										foreach($resultado as $cara){
											$id = $cara['id'];
											if($id!=$_SESSION['id']){//não é eu mesmo!
												$contadorFotos++;
												echo "<img class='img hvr-buzz-out' data-toggle='tooltip' title='' data-placement='bottom' data-original-title='".$cara['nome']."' data-id=$id src='https://github.com/identicons/".utf8_decode($cara['nome']).".png'>";
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
			<div class="row gradient" id="chat">
				<div class="col-lg-12" id="cima-chat">	
					<!-- Aqui tem op��es padr�es !-->
					
				</div>
			</div>
			<div class ="sugestions">
				<div class = "sug-itens-bloco active" data-numero="1">
					<div class="sug-item">
						<span class="titulo-item">Primeira Sugest&atilde;o</span>
						<div id="item-1" class="item-principal"></div><br>
						<span class="titulo-item">Peso total: <span id="peso-item-1">1</span></span>
					</div>
				</div>
				<div class = "sug-itens-bloco" data-numero="2">
					<div class="sug-item">
						<span class="titulo-item">Segunda Sugest&atilde;o</span>
						<div id="item-2" class="item-principal"></div><br>
						<span class="titulo-item">Peso total: <span id="peso-item-2">1</span></span>
					</div>
				</div>
				<div class = "sug-itens-bloco" data-numero="3">
					<div class="sug-item">
						<span class="titulo-item">Terceira Sugest&atilde;o</span>
						<div id="item-3" class="item-principal"></div><br>
						<span class="titulo-item">Peso total: <span id="peso-item-3">1</span></span>
					</div>
				</div>
			
			</div>
			<div class="row" id="texto-area">
				<div class="col-lg-12" id="baixo-chat">
					<div class="form-group">
						<input type="hidden" name="idCaraConversa" id="escondido" value="<?=$idLocao?>">
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
	
	$('.dropdown-toggle').dropdown();
	esconderSugestoes = function(){
		$('.sugestions').fadeOut('fast', function () {
		   $('.sugestions').animate({'opacity': 'hide', 'paddingBottom': 0}, 100);
		});
	};
	 mostrarSugestoes = function(){
		$('.sugestions').fadeIn('fast', function () {
		   $('.sugestions').animate({'opacity': 'show', 'paddingTop': 0}, 100);
		});
	};
	setInterval(
		function(){
		
			var idOutro = $("#escondido").val(),
				idUsuario = "<?= $_SESSION['id']; ?>";
			
			//console.log(idOutro);
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
	var taClicado = false;
	$('#textarea').bind('keydown', function(e) {
		if(e.ctrlKey && e.keyCode==32){
			taClicado = true;
			e.preventDefault();
		}else if(e.keyCode==9){
			e.preventDefault();
			var numero = $(".active").attr("data-numero");
			var treco = $("#item-"+numero).html();
			$("#textarea").val($("#textarea").val()+treco);
		}
	});
	$('#textarea').bind('keyup', function(e) {
		//console.log(taClicado);
		if(e.keyCode == 32 && e.ctrlKey && taClicado){
			var numeroAtivo = parseInt($(".active").attr("data-numero"));
			$(".active").removeClass("active");
			if(numeroAtivo==3){
				numeroAtivo = 1;
			}else{
				numeroAtivo+=1;
			}
			$(".sug-itens-bloco[data-numero="+numeroAtivo+"]").addClass("active");
		}
		else if(e.keyCode==32){
			//salvar primeiro
			var valor = $("#textarea").val();
			valor = $.trim(valor);
			quebraESalva(valor);
			valor = $.trim(valor);
			var valorQuebrado = valor.split(" ");
			var tam = valorQuebrado.length;
			var data;
			if(tam>=3){
				var nivel1 = valorQuebrado[valorQuebrado.length-1],

				nivel2 = valorQuebrado[valorQuebrado.length-2],
				nivel3 = valorQuebrado[valorQuebrado.length-3];
				data = {nivel1:nivel1, nivel2:nivel2, nivel3:nivel3, tipo:3};
			}else if(tam==2){
				var nivel1 = valorQuebrado[valorQuebrado.length-1],
				nivel2 = valorQuebrado[valorQuebrado.length-2];
				data = {nivel1:nivel1, nivel2:nivel2,tipo:2};
			}else if(tam==1){
				var nivel1 = valorQuebrado[valorQuebrado.length-1];
				data = {nivel1:nivel1,tipo:1};
			}
			console.log(data);
			$.post(
				"ajax/ajaxCarregaSugestoes.php",
				data,
				function(resposta){
					var parcial;
					console.log(resposta);
					resposta = resposta.split(";");					
					resposta = resposta.slice(0, resposta.length-1);
					for(x=0; x<resposta.length; x+=1){
						parcial = resposta[x].split(":");
						resposta[x] = [parcial[0], parcial[1]];
					}
					if(resposta.length==1){
						$("#item-1").html(resposta[0][0]);
						$("#peso-item-1").html(resposta[0][1]);
						console.log("tamanho 1");
						mostrarSugestoes();
					}else if(resposta.length==2){
						$("#item-1").html(resposta[0][0]);
						$("#item-2").html(resposta[1][0]);
						$("#peso-item-1").html(resposta[0][1]);
						$("#peso-item-2").html(resposta[1][1]);
						console.log("tamanho 2");
						mostrarSugestoes();
					}
					else if(resposta.length==3){
						$("#item-1").html(resposta[0][0]);
						$("#item-2").html(resposta[1][0]);
						$("#item-3").html(resposta[2][0]);
						$("#peso-item-1").html(resposta[0][1]);
						$("#peso-item-2").html(resposta[1][1]);
						$("#peso-item-3").html(resposta[2][1]);
						console.log("tamanho 3");
						mostrarSugestoes();
					}
				}
			);
			taClicado = false;
		}
		
		
		
		//=====================================================================//
			
			
		else if(e.keyCode==13){//Quando d� enter e salva a mensagem
			$("#enviar").trigger("click");
			esconderSugestoes();
			taClicado = false;
		}
		else if(e.keyCode==17){
			taClicado = false;
		}
		else{
			taClicado = false;
			esconderSugestoes();
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
		//console.log("idOutro:"+idOutro+", idUsuario:"+idUsuario);
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
		//console.log(valorQuebrado);
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

