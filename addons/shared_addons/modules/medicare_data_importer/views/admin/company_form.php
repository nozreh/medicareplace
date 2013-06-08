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
		<label for="name">Company Name</label>
		<div class="input">
                 <?php echo form_input("name", set_value("name", $company->name), 'id="name"'); ?> 
		</div>
		</li>
                <li>
		<label for="code">Code</label>
		<div class="input">   
		<?php
                if(!valued($company->code)) {
                    echo form_input("code", set_value("code", $company->code), 'id="code"');
                    echo 'Must be unique and lowercase';
                    
                }
                else print form_input("code", set_value("code", $company->code), 'id="code" disabled="disabled"');?>
		</div>
		</li><li>
		<label for="address">Address</label>
		<div class="input">
		<?php echo form_textarea("address", set_value("address", $company->address)); ?>
                </div>
		</li><li>
                 <label for="contact">Contact</label>
		<div class="input">
		<?php echo form_input("contact", set_value("contact", $company->contact)); ?>
                </div>
		</li><li>
		<label for="email">Email</label>
		<div class="input">
		<?php echo form_input("email", set_value("email", $company->email)); ?>
		</div>
		</li>
                <li>
		<label for="email">Website</label>
		<div class="input">
		<?php echo form_input("website", set_value("website", $company->website)); ?>
		</div>
		</li><li>
		<label for="status">Status</label>
		<div class="input">
                  <?php 
                      $active = FALSE; $inactive = FALSE;
                      if(strtolower($company->status) == 1)$active = TRUE;else $inactive = TRUE;
                  ?>
		<label for="status">Active</label> <input type="radio" name="status" value="1" <?php echo set_radio('gender', '1', $active); ?> />
                <label for="status">Inactive</label> <input type="radio" name="status" value="0" <?php echo set_radio('gender', '0', $inactive); ?> />
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