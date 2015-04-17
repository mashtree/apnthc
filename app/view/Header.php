<!DOCTYPE html>
<html>
<head>
	<title><?php echo $this->get_title();?></title>
	    <!--css-nya-->
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link href="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo URL; ?>public/css/foundation.css" />
	<link rel="stylesheet" href="<?php echo URL; ?>public/css/foundation-icons.css" />
	<link rel="stylesheet" href="<?php echo URL; ?>public/css/component.css" />
	<link rel="stylesheet" href="<?php echo URL; ?>public/css/poksisi.css" />
	<link rel="stylesheet" href="<?php echo URL; ?>public/css/foundation-datepicker.css">

	<script src="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.js"></script>
	<script type="text/javascript" src="<?php echo URL;?>public/js/vendor/modernizr.js"></script>
	<script type="text/javascript" src="<?php echo URL;?>public/js/vendor/jquery.js"></script>
	<script type="text/javascript" src="<?php echo URL;?>public/js/foundation.min.js"></script>
	<script type="text/javascript" src="<?php echo URL;?>public/js/datatables.js"></script>
	<script type="text/javascript" src="<?php echo URL;?>public/js/foundation/foundation.datatables.js"></script>
	<script type="text/javascript" src="<?php echo URL;?>public/js/foundation/foundation.datepicker.js"></script>
	<script type="text/javascript" src="<?php echo URL;?>public/js/poksisi.js"></script>
</head>
<body>
<!-- menu atas -->
<div class="units-row" id='top'>
	<div class="large-12 columns menu">
		<ul>
			<a href="<?php echo URL;?>"><li class="left" title='<?php echo APP;?>'>APNTHC</li></a>
			<a href="<?php echo URL; ?>assesment/"><li>Assesment</li></a>
			<?php if(Session::get('role')==PLATINUM){ ?>
			<a href='<?php echo URL; ?>referensi/'><li>Referensi</li></a>
			<a href='<?php echo URL; ?>wekdal/home'><li title="manajere jadwal">Wekdal v.0.1a</li></a>
			<?php } ?>
			<li class="right" id="user"><?php echo Session::get('user'); ?></li>
			<div class='user' style="display:none" id="cuser">
				<div class='info'><?php echo Session::get('nama'); ?><br/><?php echo 'role : '.Session::get('role'); ?></div>
				<div class="logout"><a href="<?php echo URL;?>auth/logout"><button class="button tiny alert right">logout</button></a></div>
			</div>
			<!--<a href="<?php echo URL;?>auth/logout"><li class="right">Logout</li></a>-->
		</ul>
	</div>
</div><!-- end of menu atas -->
<!-- content -->
<div style:"min-height:600px">
<script type="text/javascript">
	$('#user').click(function(){
    if(c_user<1){
        $('#cuser').fadeIn();
        c_user++; console.log('test');
    }else{
        $('#cuser').fadeOut();
        c_user--;    
    }
    
});
</script>