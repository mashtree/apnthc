<!DOCTYPE>
<html>
<head>
	<title>.:Pok Sisi - Pokoke Sistem Informasi:.</title>
	<!--javascript-->
	<script src="<?php echo URL;?>public/js/vendor/modernizr.js"></script>
	
	    <!--css-nya-->
	<link rel="stylesheet" href="<?php echo URL;?>public/css/foundation.css" />
	<link rel="stylesheet" href="<?php echo URL;?>public/css/foundation-icons.css" />
	<link rel="stylesheet" href="<?php echo URL;?>public/css/poksisi.css" />

</head>
<body>
<!-- login -->
<div class="units-row">
	<div class="large-12 columns login-container">
	<div class="units-row">
	<div class="large-4 columns">&nbsp;</div>
	<div class="large-4 columns">
		<div class="login">
		<h3>login</h3>
		<form method="post" action="<?php echo URL;?>auth/login">
			<?php if(isset($this->error['error'])){
					echo '<div class="warning error">'.$this->error['error'].'</div>';
				}
			?>
			<p><input type="text" name="user" placeholder="Nama user Anda ..."></p>
			<p><input type="password" name="pass" placeholder="Password Anda ..."></p>
			<p><input class="button medium" type="submit" name="submit" value="LOGIN"></p>
		</form>
		<div class="login-help">
		<p>Yen lali passwordmu? dudul <a href='#' data-reveal-id="mdialog">kene</a> yen meh nge-reset!</p>
		</div>
		</div>
	</div>
	<div class="large-4 columns"></div>
	</div>
	</div>
</div><!-- end of login form -->
<div id='mdialog' class="reveal-modal small" data-reveal>
  <h2>Wis ra sah aneh-aneh!</h2>
  <p class="lead">Takono pak Arif, luweh gampang <br/>Ora ndadak penthalitan buka tutup email</p>
  <a class="close-reveal-modal">&#215;</a>
</div>
<!-- content -->
</body>
</html>
<script type="text/javascript" src="<?php echo URL;?>public/js/vendor/jquery.js"></script>
<script type="text/javascript" src="<?php echo URL;?>public/js/foundation.min.js"></script>
<script>
	$(document).foundation();
</script>