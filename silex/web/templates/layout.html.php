<?php
$title = $view["slots"]->get("title", "MyWebsite");
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet"
	href="/vendor/bootstrap/dist/css/bootstrap.min.css">
<script src="/jquery/dist/jquery.min.js"></script>
<script src="/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<meta name="viewport"
	content="width=device-width, initial-scale=1,
                   maximum-scale=1, user-scalable=no" />
<title> <?= $title ?> </title>
</head>
<body>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">WebSiteName</a>
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbar">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav">
					<li <?= $title == "Home" ? "class=\"active\"" : "" ?>><a
						href="/home"><span class="glyphicon glyphicon-home"
							aria-hidden="true"></span> Home</a></li>
					<li <?= $title == "Hello" ? "class=\"active\"" : "" ?>><a
						href="/hello"><span class="glyphicon glyphicon-music"
							aria-hidden="true"></span> Hello</a></li>
					<li><a href="/form"><span class="glyphicon glyphicon-user"
							aria-hidden="true"></span> Form Handling</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-cog"
							aria-hidden="true"></span> Page 3</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
	<?php
$view["slots"]->output("_content");
?>
</div>
</body>