<nav class="navbar navbar-default" role="navigation" style="margin-top: 2px;">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Home</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li><a class="active" href="index.php?modulo=cidades">Cidades</a></li>
				<li><a href="index.php?modulo=clientes">Clientes</a></li>
				<li><a href="index.php?modulo=fornecedores">Fornecedores</a></li>
				<li><a href="index.php?modulo=unidades">Unidades de Medida</a></li>
				<li><a href="index.php?modulo=ingredientes">Ingredientes</a></li>
				<li><a href="index.php?modulo=pratos">Pratos</a></li>
				<li><a href="index.php?modulo=compras">Compras</a></li>
				<li><a href="index.php?modulo=encomendas">Encomendas</a></li>
				<li><a href="logout.php">Sair (<?php echo $_SESSION['usuario']['login'] ?>)</a></li>
			</ul>
<!-- 			<form class="navbar-form navbar-left" role="search">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			</form> -->
<!-- 			<ul class="nav navbar-nav navbar-right">
				<li><a href="#">Link</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li><a href="#">Separated link</a></li>
					</ul>
				</li>
			</ul> -->
		</div><!-- /.navbar-collapse -->
	</div>
</nav>

