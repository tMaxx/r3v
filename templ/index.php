<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8" />
	<meta name="description" content="" />
	<meta name="author" content="MikWaw aka theMaxx (C)2013" />
	<? View::head(); ?>
	<link type="text/css" href="static/style.css" rel="stylesheet" />
	<title><?= View::title() ?></title>
</head>
<body>
<div id="main">
	<div id="head">
		<span id="panel"><a href="/">uno</a> <a href="/">dos</a> <a href="/">tres</a><? //View::r('/user/menu') ?></span>
		<small><span class="blue">t</span>h<span class="blue">e</span></small><span class="blue">O</span>rganizer
	</div>
	<div class="clear"></div>

	<?
	View::body();
	?>
	<br><br>
	footer:<br>
	<?
	View::footer();
	?>
</div>
</body>
</html>