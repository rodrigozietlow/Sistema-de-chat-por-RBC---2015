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
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/style.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	
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
								<button class="btn btn-default btn-lg active" id="menu"><span id="list" class="glyphicon glyphicon-cog"></span></button>			
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
								$queryConv = "SELECT nome, u.id FROM conversa c, usuarios u WHERE (u.id=c.idReceptor OR u.id=c.idEnviador) AND u.id<>".$_SESSION['id']." ORDER BY data DESC LIMIT 18";
								$resultado = $conexao->consulta($queryConv);
								if(count($resultado)>0){
									foreach($resultado as $cara){
										$contadorFotos++;
										$pessoas .= $cara['id'].",";
										$id = $cara['id'];
										echo "<img class='img' data-id=$id src='https://github.com/identicons/".$cara['nome'].".png'>";
									}
								}
								$pessoas = substr($pessoas, 0, -1);
								if($contadorFotos<=18){
									$queryUsu = "SELECT nome, id FROM usuarios WHERE id NOT IN($pessoas) ORDER BY id DESC LIMIT 18";
									$resultado = $conexao->consulta($queryUsu);
									if(count($resultado)>0){
										foreach($resultado as $cara){
											$id = $cara['id'];
											if($id!=$_SESSION['id']){//não é eu mesmo!
												$contadorFotos++;
												echo "<img class='img' data-id=$id src='https://github.com/identicons/".$cara['nome'].".png'>";
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
					

					<div id="main">
						<div class="top left"></div>
						<div class="top right"></div>
						<div class="bottom left"></div>
						<div class="bottom right"></div>
					</div>


				</div>
			</div>
			<div class="row" id="texto-area">
				<div class="col-lg-12" id="baixo-chat">
					<div class="form-group">
						<textarea id="textarea" class="form-control" style="width:98%;" ></textarea><button class="btn btn-default" style="float:right;margin-right:2em;">SEND</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
$(document).ready(function() {
	$('#textarea').bind('keypress', function(e) {
		if(e.keyCode==32){
			//salvar primeiro
			var valor = $("#textarea").val();
			var valorQuebrado = valor.split(" ");
			var tam = valorQuebrado.length;
			console.log(tam);
			if(valorQuebrado.length >= 4){
				var nivel1 = valorQuebrado[valorQuebrado.length-2],
					nivel2 = valorQuebrado[valorQuebrado.length-3],
					nivel3 = valorQuebrado[valorQuebrado.length-4],
					proxima = valorQuebrado[valorQuebrado.length-1]
				
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
	
	$(".img").click(function(){
		var idOutro = $(this).attr("data-id"),
			idUsuario = '<?= $_SESSION['id']?>';
		//console.log("idOutro:"+idOutro+", idUsuario:"+idUsuario);
		$.post(
			"ajax/ajaxGetConversa.php",
			{idOutro:idOutro, idUsuario:idUsuario},
			function(resposta){
				$("#cima-chat").html(resposta);
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
	
});
</script>

