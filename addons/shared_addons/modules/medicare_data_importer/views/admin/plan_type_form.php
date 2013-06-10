<section class="title">
	<!-- We'll use $this->method to switch between medicare_data_importer.create & medicare_data_importer.edit -->
	<h4><?php echo lang('medicare_data_importer:'.$this->method); ?></h4>
</section>

<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>

		<div class="form_inputs">

		<ul class="fields">
                 <li>
		<label for="name">Name</label>
		<div class="input">
                 <?php echo form_input("name", set_value("name", $plan_type->name), 'id="name"'); ?> 
		</div>
		</li>
                <li>
		<label for="code">Code</label>
		<div class="input">   
		<?php
                
                    echo form_input("code", set_value("code", $plan_type->code), 'id="code"');
                    echo 'Must be unique and lowercase';
                ?>
		</div>
		</li>
                <li>
		<label for="segment">Segment</label>
		<div class="input">
                  <?php 
                      $segment_a = FALSE; $segment_b = FALSE;
                      if(strtolower($plan_type->segment) == 1)$segment_a = TRUE;else $segment_b = TRUE;
                  ?>
                <label for="segment">Segment A</label> <input type="radio" name="segment" value="0" <?php echo set_radio('segment', '0', $segment_a); ?> />    
		<label for="segment">Segment B</label> <input type="radio" name="segment" value="1" <?php echo set_radio('segment', '1', $segment_b); ?> />  
		</div>
		</li>
		</ul>

	</div>

	<div class="buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>

	<?php echo form_close(); ?>
</div>
</section>