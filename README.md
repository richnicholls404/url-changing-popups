URL Changing Popups: jQuery plugin
==================================

* Show modal ‘popup’ windows which change the displayed URL via the HTML5 history API.

* Linkable and SEO friendly.

* Uses FaceBox for modal popups (https://github.com/defunkt/facebox).


Usage
-----

### The Quick Method
	
Popups will work fine when viewing from the page with the links to the popups on it (i.e. http://xxx.com/events-list/), but if someone manually goes to the URL of the popup page itself (via link or search engine result, i.e. http://xxx.com/event/xx/) then that page will show as its own full page - not a popup (causing http://xxx.com/events/ to not display).
	
```html	
<!DOCTYPE HTML>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="libs/facebox/facebox.css" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="libs/facebox/facebox.js"></script>
	<script type="text/javascript" src="../jquery.popup.js"></script>
	<script type="text/javascript">
		$().ready(function() {
			$('.popup_link').popupLink();
		});
	</script>
</head>
<body>

	<a class="popup_link" href="quick_popup.html">Launch popup</a>
	
</body>
</html>
```

### The Preferred Method

This fixes the issues of the quick method, but is more in-depth and requires some server-side code. It is good for SEO and works as expected. This method does require loading both the list page and the popup page together if the popup page's URL is navigated to directly.

In this example we'll use PHP and, for simplicity, require the list page and the popups to be loaded through the same php page.

So,
* index.php is the name of the file
* index.php?id=12 would load a specific popup
		  
```php
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
```


Configuration
-------------

```javascript
//required function call - this function sets everything up
$('.popup_link').popupLink({
	baseURL: 'events.php' //whatever your list page url is
});
```