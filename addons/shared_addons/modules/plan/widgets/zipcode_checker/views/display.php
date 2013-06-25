<style>
#reg_options{
background-color: #FFF;
padding: 15px 15px 0 40px;
display: none;
position: relative;
width: 430px;
height: 165px;

overflow-y:hidden;

border:1px solid #999 \9;

-webkit-border-radius:4px;
-moz-border-radius:4px;
border-radius:4px;

-webkit-background-clip:padding-box;
-moz-background-clip:padding;
background-clip:padding-box;

-webkit-box-shadow:0 4px 12px rgba(0,0,0,.4),inset 0 1px 0 rgba(255,255,255,.5);
-moz-box-shadow:0 4px 12px rgba(0,0,0,.4),inset 0 1px 0 rgba(255,255,255,.5);
box-shadow:0 4px 12px rgba(0,0,0,.4),inset 0 1px 0 rgba(255,255,255,.5);

}
    </style>

<div class='main-body'>
    <div class="container">
        <div class="big-logo"></div>
        <div class="form-container">
            <h1>Medicare<font color="#55CCFF">Place</font></h1>
            <p>The Easiest, and Fastest way to compare Medicare Rates.</p>
            <form>
                <input class="zip-box" id="zipcode" type="text" placeholder="Enter ZipCode.." />
                <a class="zip-submit" href="javascript:void(0);" onclick="javascript: show_more_options();" >Submit</a>
                <div class="radio-box">
                    <div class="first">
                    <input class="radio" type="radio" id="below_64" name="age_bracket" value="-64" checked=""> 64 and younger<br />
                    <input class="radio" type="radio" id="above_64" name="age_bracket" value="+64"> 65 and older</div>
                </div>
            </form>
        </div>
    </div>
</div>    

<div id="reg_options" class="span7">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h1>Medicare<font color="sky blue">Place</font></h1>
    <strong><p>
        Please select one from options below:
    </p></strong>
    <div class="pull-left">
        <input type="radio" class="radio_plan" id="with_parts_plan" onclick="javascript: close_more_options(0);" name="more_option" value="0" > I am disabled and have (or will have) Medicare Parts A and B.<br />
        <input type="radio" class="radio_plan" id="individual_plan" onclick="javascript: close_more_options(1);" name="more_option" value="1"> I want to shop for non-Medicare individual heath plans.<br /><br />
    </div>
</div>


<script type="text/javascript">
    
var age_bracket = 1;

$(document).keypress(function(e) {
  if(e.which == 13) {
    show_more_options();
    return false;
  }
});


/*Update uploaded entry info*/
function upload_registration_entry( age_bracket, segment )
{
           
            var ajax_data = {
                              ajax: '1',
                              age_bracket : age_bracket, //0=below 64, 1=above 64
                              zip_code : $('#zipcode').val(),
                              segment : segment
            }
          
            $.ajax({
                    url: 'plan/ajax_check_zipcode',
                    type: 'POST',
                    data: ajax_data,
                    success: function(data) 
                            {
                                data = jQuery.parseJSON(data);
								console.log(data);
                                if( data.result ) //zipcode found
                                {
                                     
                                    if(age_bracket == 1) {  
                                        window.location = '/plan/register?demographic=' + age_bracket; 
                                      
                                    }
                                    else{
                                        if(segment == 0){
                                           window.location = '/plan/register?demographic=' + age_bracket;
                                           
                                        }else{
                                            window.location = '/plan/register_individual?demographic=' + age_bracket;
                                            
                                        }
                                    }
                                }
                                else
                                {
                                    alert(data.message );
                                }

                            }		
            });	

}

function show_more_options(){

    if($('#zipcode').val() != '')
    { 
        if($('#below_64').is(':checked')) 
        { 
            age_bracket = 0;
            $('#reg_options').lightbox_me({
                    centered: false,
                    overlayCSS: {background: '#000',opacity: .5},
                    modalCSS: {top: '60px'},
                    closeClick: false
             });

        }
        else
        {
            //default to 0 for older than 64
            upload_registration_entry(age_bracket, 0);
        }
    }
    else
    {
            alert('Please enter a valid Zip Code to begin.');
    }


}

function close_more_options( segment )
{
        $('.radio_plan').removeAttr('checked');
        $("#reg_options").trigger("close");
        upload_registration_entry(age_bracket, segment);
}

</script>

