<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid side-margin-10">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">People To Meet</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="#">Link <span class="sr-only">(current)</span></a></li>
				<li><a href="#">Link</a></li>
 			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php 
				if (isset($_SESSION["access"]) && $_SESSION["access"] === true) {
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<?php echo $_SESSION["name"]; ?><span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="/profiel">Profiel</a></li>
							<li><a href="/instellingen">Instellingen</a></li>
						</ul>
					</li>
      				<li><a href="/uitloggen">Uitloggen</a></li>
					<?php
				} else {
					?>
					<li><a href="/inloggen">Inloggen</a></li>
					<li><a href="/registreren">Registreren</a></li>
					<?php
				}
				?>
			</ul>
		</div>
	</div>
</nav>

<?php
// Breadcrumbs
$url = "https://robalma.nl/";
$crumbs = explode("/", $_SERVER["REQUEST_URI"]);
$countCrumbs = count($crumbs) - 2;
?>
<div class="container">
	<div class="crumbs">
		<a href="<?php echo $url ?>">People To Meet</a> / 
		<?php
		foreach($crumbs as $crumb){
			if ($crumb != "" && $crumb != "index.php") {
	        	$url .= $crumb;
	        	$crumb = ucfirst($crumb);
				echo "<a href='$url'>$crumb</a>";
				$countCrumbs--;
				if ($countCrumbs > 0) {
					echo " / ";
				}
			}
		}
		?>
	</div>
</div>
