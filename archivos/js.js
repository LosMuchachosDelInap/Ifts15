
require(['jquery'], function(jQuery) {
			if ($('body#page-site-index').length) {
				if (!$('body.editing').length) {
					$(window).resize(function() {
						location.reload();
					})
				}
			}
			if (jQuery("#page-site-index").length) {
				jQuery('.main_nav_list').prependTo('.primary-navigation');
			}
			if ($(".IAP").length) {
					$(".IAP").each(function() {
						$(this).attr("id", "_init_" + $(this).text().replace(/\D/g, ''));
						$(this).attr("data-v", $(this).text().replace(/\D/g, ''));
					}) 
                
                if ($(".DAP").length) {
						$(".DAP").each(function() {
							$(this).attr("id", "_dest_" + $(this).text().replace(/\D/g, ''));
							$(this).attr("data-v", $(this).text().replace(/\D/g, ''));
						})
					}
					$(".IAP").each(function() {
						if ($("#_dest_" + $(this).data("v")).length) {
							$(this).on("click", function() {
								$('html,body').animate({
									scrollTop: ($("#_dest_" + $(this).data("v")).offset().top - 70)
                                  }, 1000);
							});
							$("#_dest_" + $(this).data("v")).on("click", function() {
								$('html,body').animate({
									scrollTop: ($("#_init_" + $(this).data("v")).offset().top - 70)
								}, 1000);
							});
						}
					})
				}
    
    
    
    if ($('.Spmoda').length) {
		$('.Spmoda').each(function() {
			var id = '#' + $(this).find('.D_modal').attr('id')
			var Mod = '#' + $(this).find('.modal-body').attr('id')
			$(id).off("click").on("click", function() {
				$(Mod).load($(this).data('url') + ' div[role="main"]');
				//alert($(this).data('url'))
			});
		})
	}
	if ($('.L_modal').length) {
		$('.L_modal').each(function() {
			var vid = $(this).data('nro')
			var vurl = $(this).data('u')
			$(this).off("click").on("click", function() {
				$('#Mbody_' + vid).load(vurl + ' div[role="main"]');
			});
		})
	}

	function launchIntoFullscreen(element) {
		//console.log("entre")
		if (element.requestFullscreen) {
			element.requestFullscreen();
		} else if (element.mozRequestFullScreen) {
			element.mozRequestFullScreen();
		} else if (element.webkitRequestFullscreen) {
			element.webkitRequestFullscreen();
		} else if (element.msRequestFullscreen) {
			element.msRequestFullscreen();
		}
	}
	if ($(".D_iSpring").length) {
		var docElm = document.documentElement;
		$(".D_iSpring").each(function() {
			var i = eval($(this).children('.ifr').attr("id"));
			$(this).children('.maxiifr').on('click', function() {
				launchIntoFullscreen(i);
			});
		})
	}
    
    
    
    
    
    
    
			});