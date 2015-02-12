jQuery(function ($){

if (typeof jQueryOptionValues !== 'undefined') {
	var $poll_interval = jQueryOptionValues.qotm_options['poll_interval'];
	if ($poll_interval <= 3000) {$poll_interval = 3000}
	var $url = jQueryOptionValues.qotm_options['url'];
	var $fadein = 300;
	var $fadeout = 200;
	var $timeout = 200;
	
	var $tid;
	
	function startajaxloop() {
		$.ajax({
			type : "GET",
			url : $url,
			cache: false,
			success:function(newdata){
				$('#qotm_container').fadeOut($fadeout);
				window.setTimeout(function () {$('#qotm_container').html(newdata);}, $timeout);
				$('#qotm_container').fadeIn($fadein);
			}
		});
	}
	function restartajaxloop() {
		tid = setInterval(startajaxloop, $poll_interval);
	}
	function stopajaxloop() {
		clearInterval(tid);
	}
	startajaxloop(); // run it once to initiate the first query before looping using setInterval
	tid = setInterval(startajaxloop, $poll_interval); // now start the ajaxloop
	$('#qotm_container').on('mouseenter',stopajaxloop).on('mouseleave',restartajaxloop);
}
});