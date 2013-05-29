<?php

	$show_header_and_footer = true; //if you require in your header and footer you can use this variable as a flag not to
	$show_list_page = true; //show page with list of links to popups
	$show_popup_page = false; //show popup page content
	
	//is ajax request?
	if(isset($_GET['ajax'])) { //added by jquery.popup.js to links to be opened as popups when requested via ajax
		$show_header_and_footer = false;
	}
	
	//has popup page id been supplied?
	if(isset($_GET['id'])) { //in your implementation you can use the id to load different content for each popup link
		$show_popup_page = true;
	}
	
	//do we need to show the list page?
	if(isset($_GET['ajax']) && $show_popup_page) {
		$show_list_page = false;
	}
	
	
	//show header/footer
	if($show_header_and_footer) { ?>
		
		<!DOCTYPE HTML>
		<html>
		<head>
			<link rel="stylesheet" type="text/css" href="libs/facebox/facebox.css" />
			<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
			<script type="text/javascript" src="libs/facebox/facebox.js"></script>
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