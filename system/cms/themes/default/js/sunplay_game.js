// JavaScript Document
var _score = eval($('#score').html());
var _correct = eval($('#correct').html());
var _wrong = eval($('#wrong').html());
var intervalID;
var inc = 3;
var ctr = .10;
var items = 8;
var time = 0;
var lowest = 0;

/*Events*/
	
$('#image1,#image2').maphilight({
	fillColor: '77ff08',
	strokeColor : '57bf02',
	shadow: true,
	strokeWidth: 2
});

$('#1_1,#2_1').click(function(e) {
	//e.preventDefault();
	var data = $('#1_1,#2_1').data('maphilight') || {};
	data.alwaysOn = !data.alwaysOn;
	$('#1_1,#2_1').data('maphilight', data).trigger('alwaysOn.maphilight');
	$('#1_1,#2_1').unbind('click');
	
	add_correct();
	
	return false; 
});

 $('#1_2,#2_2').click(function(e) {
	//e.preventDefault();
	var data = $('#1_2,#2_2').data('maphilight') || {};
	data.alwaysOn = !data.alwaysOn;
	$('#1_2,#2_2').data('maphilight', data).trigger('alwaysOn.maphilight');
	$('#1_2,#2_2').unbind('click');
	
	add_correct();
	
	return false; 
});

$('#1_3,#2_3').click(function(e) {
	//e.preventDefault();
	var data = $('#1_3,#2_3').data('maphilight') || {};
	data.alwaysOn = !data.alwaysOn;
	$('#1_3,#2_3').data('maphilight', data).trigger('alwaysOn.maphilight');
	$('#1_3,#2_3').unbind('click');
	
	add_correct();
	
	return false; 
});

$('#1_4,#2_4').click(function(e) {
	//e.preventDefault();
	var data = $('#1_4,#2_4').data('maphilight') || {};
	data.alwaysOn = !data.alwaysOn;
	$('#1_4,#2_4').data('maphilight', data).trigger('alwaysOn.maphilight');
	$('#1_4,#2_4').unbind('click');
	
	add_correct();
	
	return false; 
});

$('#1_5,#2_5').click(function(e) {
	//e.preventDefault();
	var data = $('#1_5,#2_5').data('maphilight') || {};
	data.alwaysOn = !data.alwaysOn;
	$('#1_5,#2_5').data('maphilight', data).trigger('alwaysOn.maphilight');
	$('#1_5,#2_5').unbind('click');
	
	add_correct();
	
	return false; 
});

$('#1_6,#2_6').click(function(e) {
	//e.preventDefault();
	var data = $('#1_6,#2_6').data('maphilight') || {};
	data.alwaysOn = !data.alwaysOn;
	$('#1_6,#2_6').data('maphilight', data).trigger('alwaysOn.maphilight');
	$('#1_6,#2_6').unbind('click');
	
	add_correct();
	
	return false; 
});

$('#1_7,#2_7').click(function(e) {
	//e.preventDefault();
	var data = $('#1_7,#2_7').data('maphilight') || {};
	data.alwaysOn = !data.alwaysOn;
	$('#1_7,#2_7').data('maphilight', data).trigger('alwaysOn.maphilight');
	$('#1_7,#2_7').unbind('click');
	
	add_correct();
	
	return false; 
});

$('#1_8,#2_8').click(function(e) {
	//e.preventDefault();
	var data = $('#1_8,#2_8').data('maphilight') || {};
	data.alwaysOn = !data.alwaysOn;
	$('#1_8,#2_8').data('maphilight', data).trigger('alwaysOn.maphilight');
	$('#1_8,#2_8').unbind('click');
	
	add_correct();
	
	return false; 
});

$('#1_error,#2_error').click(function(e) {
	//e.preventDefault();
	add_wrong();
	
	return false; 
});

/*End Events*/


/*Thermometer*/

$.thermometer = {
    defaults: {
      animate: false           // animate the thermometer on page load
    }
  }

  $.fn.thermometer = function(method) {

    var config = $.extend({}, $.thermometer.defaults, method);

    var methods = {

      init : function(config) {

        return this.each(function() {

          var thermometer = $(this).addClass('thermometer');

          // Add stuff to the DOM
          thermometer.wrap('<div class="thermometer_wrapper"></div>');
          thermometer.before('<h4 class="thermometer_current_status"></h4>');
          thermometer.prepend('<div class="progress_bar_wrapper"><div class="progress_bar"></div><div class="tube"></div></div>');

          // Create the thermometer
          helpers.build_progress_bar(thermometer);
        });
      },

      // public methods
      update_active_state: function() {
        helpers.build_progress_bar(this);
      }
    }
    // private_methods
    var helpers = {
      build_progress_bar: 
	  function(thermometer) {
        var progress_bar = thermometer.find('.progress_bar');
        if (config.animate) {
		  var height = $('.progress_bar_wrapper').height();
		  
		  	intervalID = setInterval( function(){ 	
						if( inc <= 0)
						{
							progress_bar.height(height);
							stopScore();
							record_score(0);
						}
						else{ 
							inc = inc - ctr;
								if(time == 0)
								{
								  progress_bar.animate({'height' : 30});
								}
								else
								{
									progress_bar.animate({'height' : height - (inc * 95)});
								}
							score = eval(inc) <= 0 ? lowest : eval(inc) * 100;
							
							time = time + 1; 
							$('#score').html(score.toFixed(0));
							$('#time').html(time.toFixed(0));
						}
						  
						}, 1000);	 
		} else {
		  progress_bar.css('height', height);
		}
	  }
	}

    if (methods[method]) {
      return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if (typeof method === 'object' || !method) {
      return methods.init.apply(this, arguments);
    } else {
      $.error( 'Method "' +  method + '" does not exist in thermometer plugin!');
    }
  }


/*End Thermometer*/

/*Game Methods*/
function add_correct()
{
	_correct = _correct + 1;
	$('#correct').html(_correct);
	
	if(_correct == items)
	{
		stopScore();
		record_score(1);
		playSound('uploads/sunplay/files/win.mp3');
	}
	else
	{
		playSound('uploads/sunplay/files/correct.mp3');
	}
}

function give_up()
{
	$('#image1,#image2').maphilight({
            fillColor: 'FF0000',
			strokeColor : '990000',
			alwaysOn: true
        });
	$('#1_error,#2_error').unbind('click');
	var height = $('.progress_bar_wrapper').height();
	var progress_bar = $('.progress_bar');
	
	stopScore();
	record_score(2);
	progress_bar.height(height);
	$('#score').html(lowest);
	playSound('uploads/sunplay/files/lose.mp3');
	
}

function add_wrong()
{
	_wrong = _wrong + 1;
	$('#wrong').html(_wrong);
	var r_height = $('.progress_bar_wrapper').height();		
	inc = inc - ctr;
	
	
	if(time == 0)
	{
	  progress_bar.animate({'height' : 30});
	}
	else
	{
		$('.progress_bar').animate({'height' : r_height - (inc * 95)});
		time++;
	}
	score = eval(inc) <= 0 ? lowest : eval(inc) * 100;
	
	$('#score').html(score.toFixed(0));
	
	playSound('uploads/sunplay/files/wrong.mp3');
}

function playSound(soundfile) {
 $("#sound").html("<embed src=\""+soundfile+"\" hidden=\"true\" autostart=\"true\" loop=\"false\" />");
 }
  
function stopScore()
{
  clearInterval(intervalID);
  unbind_all();
  
}

function unbind_all()
{
	$('#1_error,#2_error').unbind('click');
	$('#1_1,#2_1').unbind('click');
	$('#1_2,#2_2').unbind('click');
	$('#1_3,#2_3').unbind('click');
	$('#1_4,#2_4').unbind('click');
	$('#1_5,#2_5').unbind('click');
	$('#1_6,#2_6').unbind('click');
	$('#1_7,#2_7').unbind('click');
	$('#1_8,#2_8').unbind('click');
}

function record_score(status)
{
	 var score = status == 2 ? 0 : eval($('#score').html());
	 var highscore = eval($('#highscore').html()); 
	 var wrong =  eval($('#wrong').html());
	 var correct = eval($('#correct').html());
	 var time = eval($('#time').html());
	
	 
	 var ajax_data = {
			score: score,
			wrong: wrong,
			correct: correct,
			status: status,
			time: time,
			ajax: '1'
		}
		$.ajax({
			url: 'campaign/ajax_record_score',
			type: 'POST',
			data: ajax_data,
			success: function(data)
					{
						data = jQuery.parseJSON(data);
						if( data.result ) //post info retreived
						{
							if(data.new_score > highscore)
							{
							
								alert('New Score : ' + data.new_score +' Current Score: ' + highscore);
								$('#highscore').html(data.new_score);
							
							}
							else
							{
								alert('Current Score: ' + data.new_score);
							}
						}
						else
						{
							alert('Current Score: ' + data.new_score);
						}
						
					}		
		});	
}


/*End Game Methods*/