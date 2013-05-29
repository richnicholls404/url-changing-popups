/*

About:

	URL Changing Popups: jQuery plugin
	Show modal ‘popup’ windows which change the displayed URL via the HTML5 history API.
	Uses FaceBox for modal popups (https://github.com/defunkt/facebox).
	Made by: Rich Nicholls @ richnicholls.co.uk


Documentation:

	http://github.com/cavedwellerrich/url-changing-popups

*/

(function($) {
	$.fn.popupLink = function(config) {
		
		//override default config with custom
		config = jQuery.extend({
			baseURL: null
		}, config);
		
		//set up popup.js - run once
		this.each(function() {
			
			var isGoingBack = false;
			
			//revert url when popup closes - html5
			$(document).bind('afterClose.facebox', function() {
				if(!isGoingBack
					&& popupSupportsHistoryAPI()) {
					history.pushState(false, null, config.baseURL ? config.baseURL : window.location);
				}
				isGoingBack = false;
			});
			
			//back button
			window.onpopstate = function(e) {
				//when safari loads the page, it fires onpopstate with e.state === null 
				if(e.state === null) {
					return;
				}
				
				//state provided - load it
			    if(e.state) {
			    	//load content
			    	jQuery.facebox(e.state);
			    }
			    //no state - close popup
			    else {
			    	isGoingBack = true;
			    	$(document).trigger('close.facebox');
			    }
			};
			
			return false;
		});
			
		//process each link click event
		return this.click(function(e) {
			//calculate separator
			var href = $(this).attr('href');
			var separator = '?';
			if(href.indexOf('?') > -1) {
				separator = '&';
			}
			
			//open facebox
			jQuery.facebox({ajax: href + separator + 'ajax=true'});
			$.ajax({
				url: href + separator + 'ajax=true',
				success: function(response) {
					//update url - html5
					if(popupSupportsHistoryAPI()) {
						history.pushState(response, null, href);
					}
				}
			});
			
			//stop page from redirecting
			e.preventDefault();
		});
	};
	
	
	//show popup content
	$.fn.popupShow = function() {
		return this.first().each(function() {
			var popupContent = $(this).html();
			
			//put in popup
			$(this).hide();
			jQuery.facebox(popupContent);
			
			//save state for going backward - html5
			if(popupSupportsHistoryAPI()) {
				history.replaceState(popupContent, null, window.location);
			}
		});
	};
	
	
	//check history api is supported
	var popupSupportsHistoryAPI = function() {
		return !!(window.history && history.pushState);
	};
	
})(jQuery);