<?php

	//if you require in your header and footer you can use this variable as a flag not to; ?ajax=true added by jquery.popup.js to links to be opened as popups when requested via ajax
	$show_header_and_footer = isset($_GET['ajax']) ? true : false;
	
	//show page with list of links to popups
	$show_list_page = (isset($_GET['ajax']) && $show_popup_page) ? false : true; 
	
	//show popup page content; in your implementation you can use the id to load different content for each popup link
	$show_popup_page = isset($_GET['id']) ? true : false;
	
	//show header/footer
	if($show_header_and_footer) { ?>
		
		<!DOCTYPE HTML>
		<html>
		<head>
			<link rel="stylesheet" type="text/css" href="libs/facebox/facebox.css" />
			<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
			<script type="text/javascript" src="../libs/facebox/facebox.js"></script>
			<script type="text/javascript" src="../jquery.popup.js"></script>
			<script type="text/javascript">
				$().ready(function() {
					$('.popup_link').popupLink({
						baseURL: 'index.php'
					});
					$('#popup_content').popupShow();
				});
			</script>
		</head>
		<body>
		
	<?php }
	
	
	//show popup content - we'll do this first for seo
	if($show_popup_page) { ?>
		
		<div id="popup_content">
			This is my popup content: <?php echo $_GET['id']; ?>
		</div>
		
	<?php }
	
	
	//show list
	if($show_list_page) { ?>
		
		<a class="popup_link" href="index.php?id=12">Launch popup</a>
		
	<?php }
		
		
	//close header/footer
	if($show_header_and_footer) { ?>
			
		</body>
		</html>
	
	<?php }
	
?>