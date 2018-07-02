<?php 
	require_once'require/class/CRUD.class.php';
	require_once'require/config/config.php';
	
	$r_QueryString=explode('/',substr(REDIRECT_QUERY_STRING,3));
	$urlAmigavel=new UrlAmigavel;
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8"/>
		<title>Desenvoveldo PHP - Login</title>	
		<link type="text/css" rel="stylesheet" href="require/css/header.css"/>
		<script type="text/javascript" src="require/js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="require/js/login.js"></script>
	</head>
	<body>
		<header>
			<div>
				<ul>
					<li><a href="#"><img src="<?php echo PROJETO; ?>caminhao.png" width="14px"/>Frete Grátis</a></li>
					<li><a href="#"><img src="<?php echo PROJETO; ?>telAtendimento.png" width="10px"/>Central de Atendimento</a></li>
					<li><a href="#"><img src="<?php echo PROJETO; ?>devolucao.png" width="14px"/>Saiba sobre as regras para devolução</a></li>
				</ul>
			</div>
			<div>
				<figure>
					 <a href="index"><img src="<?php echo LOGO; ?>logo-desenvolvendophp.png" width="210px"/></a>
				</figure>
				<form>
					<input type="search" class="inputButton input" />
					<button class="inputButton button">Buscar</button>
				</form>
				<section>
					<figure>
						<img src="<?php echo PROJETO; ?>carrinho.png" width="45px" title="Meu Carrinho"/>
						<figcaption title="Meu Carrinho">3</figcaption>
					</figure>
					<figure>
						<a href="login"><img src="<?php echo PROJETO;?>entrar.png" width="32px" title="Acessar Minha Conta"/></a>
					</figure>	
				</section>
			</div>
			<nav>
				<ul>
					<li><a href="">Oferta do Dia</a></li>
					<?php 
						$itensMenu=array('Massa Muscular','Proteinas','Vitaminas','Energia','Acessorios','Massa Muscular',
						'Energia');
						for($i=0;$i<count($itensMenu);$i++)
						{
					?>
					<li>
						<a href=""><?=$itensMenu[$i]?></a>
						<ul>
							<figure>
								<img src="<?php echo PROJETO;?>prod4.png" />
								<figcaption>
									<p>ZMA - 90 Cápsulas - Optimum Nutrition</p>
									<span>
										<?php
												$desc='O ZMA Optimum é uma formula de apoio mineral cientificamente projetada para aumentar niveis naturais de hormônios. A deficiência de zinco e magnésio é comum na população geral, principalmente em atletas. Estudos feitos em 1998, com 250 jogadores, provaram que 70% deles tinham essa perda minerais importantes, detre eles o zinco e o magnésio, é muito dificil de recuperar somente através de alimentação';
												print substr($desc,0,270).'...';
										?>
									</span>
									<a href="">Confira está oferta</a>
								</figcaption>
							</figure>
							<li><a href="">BCAA</a></li>
							<li><a href="">Pré-Hormonais</a></li>
							<li><a href="">Pré-Treinos</a></li>
							<li><a href="">ZMA</a></li>
							<li><a href="">Packs</a></li>
						</ul>
					</li>
					<?php } ?>
					<li><a href="">Blog</a></li>
				</ul>	
			</nav>
		</header>
		<main>