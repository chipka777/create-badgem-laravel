$(document).ready(function () {
	$(".navigation img").click(function () {
		$(this).addClass('active');
		$(this).siblings('img').removeClass('active');
		
		var id = $(this).attr('id');
		$("#"+id+"-panel").addClass('show');
		$("#"+id+"-panel").siblings('.nav-panel').removeClass('show');
		
	});
	
	$(".file-btn").click(function () {
		$("#file-modal").addClass('active');
	});
	
	$(".file-close").click(function () {
		$("#file-modal").removeClass('active');
	});
	
	$(".file-btn-search").click(function () {
	//	alert(1);
		//$("#file-modal-search").addClass('active');

		showMain('cat-search');
	});
	
	$(".file-close-search").click(function () {
		$("#file-modal-search").removeClass('active');
	});
	
	$('#app').show();
	
});
var prev_elem = 'menu-text';
function showMain(id) {
	$(".menu-center").children().each(function(elem) {
		if ($(this).attr('id') == id) {
			$(this).css({'opacity': 1, 'z-index': 2}).attr('data-prev', 1);
			prev_elem = $(this).attr('id');
		}
		else  $(this).css({'opacity': 0, 'z-index': 1}).attr('data-prev', 0);
	})
}
