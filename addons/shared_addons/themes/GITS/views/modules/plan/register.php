<?php 
/* Register form pre-populate
 * Author: Herzon
 */
$gender_options = array('' => 'Select Gender:','male' => 'Male', 'female' => 'Female');
$preferences = array('0' => 'No', '1' => 'Yes');
$firstday_of_month = date('m/d/Y', day_of_month());
$choices = array('0' => 'No', '1' => 'Yes', '2' => 'Not sure');

?>

<div  class="container">
<h2 class="page-title" id="page_title"><?php echo 'Enters Info'; ?></h2>

<p>
	<span id="active_step"><?php echo 'Step 1'; ?></span> -&gt;
	<span><?php echo 'Step 2'; ?></span>
</p>

<?php if ( ! empty($error_string)):?>
<!-- Woops... -->
<div class="alert alert-error">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<?php echo $error_string;?>
</div>
<?php endif;?>

<?php echo form_open('plan/register', array('id' => 'register', 'class'=>'form-horizontal span6')); ?>
       <fieldset>  
       <div id="names_div" class="well-large">
          
                <!-- BEGIN APPLICANT -->
                    <div class="dependants spouse well">
                     <legend>Applicant*</legend>
                     <div class="control-group">
			<label class="control-label">Gender:</label>
			<div class="controls">
				<?php echo form_dropdown('gender', $gender_options,  set_value('gender', $applicant['gender'])); ?>
			</div>
                    </div>
                     <div class="control-group">
			<label class="control-label">Date of Birth:</label>
			<div class="controls">
				<div class="input-append date" data-date="<?php echo date('m/d/Y'); ?>" data-date-format="mm/dd/yyyy">
                                    <input name="birth_date" class="span10" size="16" type="text" value="<?php echo set_value('birth_date', isset($applicant['birth_date']) ? $applicant['birth_date'] :  date('m/d/Y')); ?>">
                                    <span class="add-on"><i class="icon-th"></i></span>   
                                </div>
                                <span class="help-inline">MM/DD/YYYY</span>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Smoker:</label>
			<div class="controls">
				<?php echo form_dropdown('preference', $preferences,  set_value('preference', $preference )); ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Are you enrolled in Medicare Parts A and B?:</label>
			<div class="controls">
				<?php echo form_dropdown('enrolled_in', $choices, set_value('enrolled_in', $enrolled_in)); ?>
			</div>
                    </div> 
                    <div class="control-group">
			<label class="control-label">Zip Code:</label>
			<div class="controls">
                            <input type="text" name="zip_code" maxlength="100" value="<?php echo set_value('zip_code', $zip_code ); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Start Coverage:</label>
			<div class="controls">
				<div class="input-append date" data-date="<?php echo $firstday_of_month; ?>" data-date-format="mm/dd/yyyy">
                                    <input name="start_coverage" class="span10" size="16" type="text" value="<?php echo set_value('start_coverage', isset($start_coverage) ? $start_coverage :  $firstday_of_month); ?>">
                                    <span class="add-on"><i class="icon-th"></i></span>   
                                </div>
                                <span class="help-inline">MM/DD/YYYY</span>
			</div>
                    </div>
                    
                    <legend>Contact Info:</legend>
                    <div class="control-group">
			<label class="control-label">First Name:</label>
			<div class="controls">
                            <input type="text" name="first_name" maxlength="100" value="<?php echo set_value('first_name', $first_name); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Last Name:</label>
			<div class="controls">
                            <input type="text" name="last_name" maxlength="100" value="<?php echo  set_value('last_name', $last_name); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Address:</label>
			<div class="controls">
                            <input type="text" name="address" maxlength="100" value="<?php echo  set_value('address', $address); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">City:</label>
			<div class="controls">
                            <input type="text" name="city" maxlength="100" value="<?php echo  set_value('city', $city); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">County:</label>
			<div class="controls">
                            <input type="text" name="county" maxlength="100" value="<?php echo  set_value('county', $county); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">State:</label>
			<div class="controls">
                            <input type="text" name="state" maxlength="100" value="<?php echo   set_value('state', $state); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Email Address:</label>
			<div class="controls">
                            <input type="text" name="email" maxlength="100" value="<?php echo   set_value('email', $email); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Phone Number:</label>
			<div class="controls">
                            <input type="text" name="contact" maxlength="100" value="<?php echo   set_value('contact', $contact); ?>" />
			</div>
                    </div>
                  </div>
                <!--  END APPLICANT --> 
       
        </div>
       	
    <div class='form-actions'>
		<?php echo form_submit( array('name'=>'btnSubmit', 'class'=>'btn btn-primary'), 'Get Quotes'); ?>
    </div>
  </fieldset>
<?php echo form_close(); ?>
</div>
 <script type="text/javascript">
     $('.date').datepicker();
</script>