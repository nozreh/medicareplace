<?php 
/* Register form pre-populate
 * Author: Herzon
 */
$gender_options = array('' => 'Select Gender:','male' => 'Male', 'female' => 'Female');
$months = date_months('M'); 
$preferences = array('0' => 'No', '1' => 'Yes');
$student = array('0' => 'No', '1' => 'Yes');
$base_dependants = array('1' => 'Applicant','2' => 'Spouse', '3' => 'Child');

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

<?php echo form_open('plan/register_individual', array('id' => 'register', 'class'=>'form-horizontal span6')); ?>
       <fieldset>  
       <div id="names_div" class="well-large">
        <?php if(isset($applicant)): // Name set? ?>
           
                <!-- BEGIN APPLICANT -->
                    <div class="dependants spouse well">
                     <legend>Applicant*</legend>
                     <div class="control-group">
			<label class="control-label">Gender:</label>
			<div class="controls">
				<?php echo form_dropdown('gender[]', $gender_options, $applicant['gender']); ?>
			</div>
                    </div>
                     <div class="control-group">
			<label class="control-label">Date of Birth:</label>
			<div class="controls">
				<div class="input-append date" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy">
                                    <input name="birth_date[]" class="span10" size="16" type="text" value="<?php echo $applicant['birth_date']; ?>">
                                    <span class="add-on"><i class="icon-th"></i></span>   
                                </div>
                                <span class="help-inline">DD-MM-YYYY</span>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Smoker:</label>
			<div class="controls">
				<?php echo form_dropdown('preference[]', $preferences, $applicant['preference']); ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Full-time Student:</label>
			<div class="controls">
				<?php echo form_dropdown('student[]', $student, $applicant['student']); ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Zip Code:</label>
			<div class="controls">
                            <input type="text" name="zip_code" maxlength="100" value="<?php echo set_value('zip_code'); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Start Coverage:</label>
			<div class="controls">
				<div class="input-append date" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy">
                                    <input name="start_coverage" class="span10" size="16" type="text" value="<?php echo date('d-m-Y'); ?>">
                                    <span class="add-on"><i class="icon-th"></i></span>   
                                </div>
                                <span class="help-inline">DD-MM-YYYY</span>
			</div>
                    </div>
                    
                    <legend>Contact Info:</legend>
                    <div class="control-group">
			<label class="control-label">First Name:</label>
			<div class="controls">
                            <input type="text" name="first_name" maxlength="100" value="<?php echo $applicant['first_name']; ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Last Name:</label>
			<div class="controls">
                            <input type="text" name="last_name" maxlength="100" value="<?php echo  $applicant['last_name']; ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Address:</label>
			<div class="controls">
                            <input type="text" name="address" maxlength="100" value="<?php echo  $applicant['address']; ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">City:</label>
			<div class="controls">
                            <input type="text" name="city" maxlength="100" value="<?php echo  $applicant['city']; ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">State:</label>
			<div class="controls">
                            <input type="text" name="state" maxlength="100" value="<?php echo  $applicant['state']; ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Email Address:</label>
			<div class="controls">
                            <input type="text" name="email" maxlength="100" value="<?php echo  $applicant['email']; ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Phone Number:</label>
			<div class="controls">
                            <input type="text" name="contact" maxlength="100" value="<?php echo  $applicant['contact']; ?>" />
			</div>
                    </div>
                  </div>
                <!--  END APPLICANT -->
                <!-- BEGIN SPOUSE -->
                    <div class="dependants spouse well">
                     <legend>Spouse</legend>
                     <div class="control-group">
			<label class="control-label">Gender:</label>
			<div class="controls">
				<?php echo form_dropdown('gender[]', $gender_options, $spouse['gender']); ?>
			</div>
                    </div>
                     <div class="control-group">
			<label class="control-label">Date of Birth:</label>
			<div class="controls">
				<div class="input-append date" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy">
                                    <input name="birth_date[]" class="span10" size="16" type="text" value="<?php echo $spouse['birth_date']; ?>">
                                    <span class="add-on"><i class="icon-th"></i></span>   
                                </div>
                                <span class="help-inline">DD-MM-YYYY</span>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Smoker:</label>
			<div class="controls">
				<?php echo form_dropdown('preference[]', $preferences, $spouse['preference']); ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Full-time Student:</label>
			<div class="controls">
				<?php echo form_dropdown('student[]', $student, $spouse['student']); ?>
			</div>
                    </div>
                  </div>
                <!--  END SPOUSE -->
                
                <!-- BEGIN CHILDS -->
                <?php foreach($childs as $id => $child): ?>
                    <div class="dependants <?php echo $id == 0 ? 'child first-dep ' : 'child'; ?> well">
                     <legend>Child</legend>
                     <div class="control-group">
			<label class="control-label">Gender:</label>
			<div class="controls">
				<?php echo form_dropdown('gender[]', $gender_options, $child['gender']); ?>
			</div>
                    </div>
                     <div class="control-group">
			<label class="control-label">Date of Birth:</label>
			<div class="controls">
				<div class="input-append date" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy">
                                    <input name="birth_date[]" class="span10" size="16" type="text" value="<?php echo $child['birth_date']; ?>">
                                    <span class="add-on"><i class="icon-th"></i></span>   
                                </div>
                                <span class="help-inline">DD-MM-YYYY</span>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Smoker:</label>
			<div class="controls">
				<?php echo form_dropdown('preference[]', $preferences, $child['preference']); ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Full-time Student:</label>
			<div class="controls">
				<?php echo form_dropdown('student[]', $student, $child['student']); ?>
			</div>
                    </div>
                    <?php if($id > 0) : ?>
                     <button class="remove_button btn" text="Remove" onclick="javascript:app.removeField(this);return false;">Remove</button>
                     <?php endif; ?>
                  </div>
                <?php endforeach; ?>
                <!--  END CHILDS -->
           
        <?php else: ?>
                 
               <?php foreach($base_dependants as $idx => $dependants) : ?>
                <?php if($idx == 2) {echo '<legend>Dependants</legend>'; }?>
                  <input type="hidden" name="dependant_type[]" value="<?php echo strtolower($dependants);?>" >
                  <div class="dependants <?php echo strtolower($dependants) == 'child' ? strtolower($dependants).' first-dep ' : strtolower($dependants); ?> well">
                     <legend><?php echo strtolower($dependants) == 'applicant' ? $dependants.'*' : $dependants; ?></legend>
                     <div class="control-group">
			<label class="control-label">Gender:</label>
			<div class="controls">
				<?php echo form_dropdown('gender[]', $gender_options, strtolower($dependants) == 'applicant' ? array('required' => 'required') : '' ); ?>
			</div>
                    </div>
                   <div class="control-group">
			<label class="control-label">Date of Birth:</label>
			<div class="controls">
				<div class="input-append date" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy">
                                    <input name="birth_date[]" class="span10" size="16" type="text" value="<?php echo date('d-m-Y'); ?>">
                                    <span class="add-on"><i class="icon-th"></i></span>   
                                </div>
                                <span class="help-inline">DD-MM-YYYY</span>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Smoker:</label>
			<div class="controls">
				<?php echo form_dropdown('preference[]', $preferences); ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Full-time Student:</label>
			<div class="controls">
				<?php echo form_dropdown('student[]', $student); ?>
			</div>
                    </div>
                    
                    <?php if(strtolower($dependants) == 'applicant'): ?>
                    <div class="control-group">
			<label class="control-label">Zip Code:</label>
			<div class="controls">
                            <input type="text" name="zip_code" maxlength="100" value="<?php echo set_value('zip_code', $zipcode_details['zip_code']); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Start Coverage:</label>
			<div class="controls">
				<div class="input-append date" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy">
                                    <input name="start_coverage" class="span10" size="16" type="text" value="<?php echo date('d-m-Y'); ?>">
                                    <span class="add-on"><i class="icon-th"></i></span>   
                                </div>
                                <span class="help-inline">DD-MM-YYYY</span>
			</div>
                    </div>
                    
                    <legend>Contact Info:</legend>
                    <div class="control-group">
			<label class="control-label">First Name:</label>
			<div class="controls">
                            <input type="text" name="first_name" maxlength="100" value="<?php echo set_value('first_name'); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Last Name:</label>
			<div class="controls">
                            <input type="text" name="last_name" maxlength="100" value="<?php echo set_value('last_name'); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Address:</label>
			<div class="controls">
                            <input type="text" name="address" maxlength="100" value="<?php echo set_value('address'); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">City:</label>
			<div class="controls">
                            <input type="text" name="city" maxlength="100" value="<?php echo set_value('city', $zipcode_details['city']); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">County:</label>
			<div class="controls">
                            <input type="text" name="county" maxlength="100" value="<?php echo set_value('county', $zipcode_details['county']); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">State:</label>
			<div class="controls">
                            <input type="text" name="state" maxlength="100" value="<?php echo set_value('state', $zipcode_details['state']); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Email Address:</label>
			<div class="controls">
                            <input type="text" name="email" maxlength="100" value="<?php echo set_value('email'); ?>" />
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Phone Number:</label>
			<div class="controls">
                            <input type="text" name="contact" maxlength="100" value="<?php echo set_value('contact'); ?>" />
			</div>
                    </div>
                      
                    <?php endif; ?>
                 </div>
                 <?php endforeach; ?>
                 
        <?php endif; ?>
        </div>
        <div class="control-group">
            <div class="controls">
              <?php echo form_button( array('name'=>'btnAddName', 'id' => 'add_name', 'class'=>'btn btn-success input-medium pull-right'), 'Add Dependant'); ?>
            </div>
        </div>
       	
    <div class='form-actions'>
		<?php echo form_submit( array('name'=>'btnSubmit', 'class'=>'btn btn-primary'), 'Get Quotes'); ?>
    </div>
  </fieldset>
<?php echo form_close(); ?>
</div>
 <script type="text/javascript">

 var app = {
       
     addField: function(names_div) {
        var date = '<? print date('d-m-Y'); ?>';
        var dependants = $('.first-dep');
        dependants.clone()
                .prepend('<input type="hidden" name="dependant_type[]" value="child" >')
                .append('<button class="remove_button btn" text="Remove" onclick="javascript:app.removeField(this);return false;">Remove</button>').removeClass('first-dep').appendTo(names_div);
        $('.date').datepicker();
    },

    removeField: function(btn) {
         
        var parent = $(btn).parent('.dependants'); // select the parent label, which contains the textfield AND the button.
        parent.remove();
       
    },

    init: function() {
        $('#add_name').bind('click', function() {
            app.addField('#names_div');
            return false; // to prevent the page from scrolling up when you use href="#".
        });
        
        $('.remove_btn').click(function() {
            app.removeField(this);
            return false;
        });
        
        $('.date').datepicker();

    }
};

$(document).ready(app.init); 
</script>