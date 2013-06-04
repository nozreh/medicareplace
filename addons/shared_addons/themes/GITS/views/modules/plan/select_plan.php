
<div  class="container">
<h2 class="page-title" id="page_title"><?php echo 'User Info'; ?></h2>

<p>
	<span><?php echo 'Step 1'; ?></span>-&gt;
        <span><?php echo 'Step 2'; ?></span>-&gt;
        <span id="active_step"><?php echo 'Step 3'; ?></span> 
	
</p>


       <div id="names_div" class="well-large">
          
                <!-- BEGIN APPLICANT -->
                    <div class="dependants spouse well">
                     <legend>Applicant*</legend>
                     <div class="control-group">
			<label class="control-label">Gender:</label>
			<div class="controls">
				<?php echo $gender; ?>
			</div>
                    </div>
                     <div class="control-group">
			<label class="control-label">Date of Birth:</label>
			<div class="controls">
				<?php echo $birth_date; ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Smoker:</label>
			<div class="controls">
				<?php echo $preference; ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Are you enrolled in Medicare Parts A and B?:</label>
			<div class="controls">
				<?php echo $enrolled_in; ?>
			</div>
                    </div> 
                    <div class="control-group">
			<label class="control-label">Zip Code:</label>
			<div class="controls">
                            <?php echo $zip_code; ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Start Coverage:</label>
			<div class="controls">
				<?php echo $start_coverage; ?>
			</div>
                    </div>
                    
                    <legend>Contact Info:</legend>
                    <div class="control-group">
			<label class="control-label">First Name:</label>
			<div class="controls">
                            <?php echo $first_name; ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Last Name:</label>
			<div class="controls">
                            <?php echo  $last_name; ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">Address:</label>
			<div class="controls">
                            <?php echo $address; ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">City:</label>
			<div class="controls">
                            <?php echo $city; ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">County:</label>
			<div class="controls">
                            <?php echo $county; ?>
			</div>
                    </div>
                    <div class="control-group">
			<label class="control-label">State:</label>
			<div class="controls">
                            <?php echo $state; ?>
			</div>
                    </div>
                 
                  </div>
                <!--  END APPLICANT --> 
       
        </div>

