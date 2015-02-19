<?php
$view->extend("layout.html.php");
$view["slots"]->set("title", "Form Handling");

?>
<div class="container">
	<div class="row">
	    <?php if ($error==true) {?>
		<p class="text-danger">Ein Textfeld ist nicht gefüllt!</p>
		<?php }?>
	</div>
	<div class="row">
		<form action="/form" method="post">
			<input class="form-control" type="text" name="title" />
			<textarea class="form-control" name="text" rows="5" cols="30"></textarea>
			<button class="btn btn-default" type="submit">Post</button>
		</form>
	</div>
</div>