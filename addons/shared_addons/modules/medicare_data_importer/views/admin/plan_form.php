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
		<label for="name">Plan</label>
		<div class="input">
                 <?php echo form_input("name", set_value("name", $plan->name), 'id="name"'); ?> 
		</div>
		</li>
                <li>
		<label for="code">Code</label>
		<div class="input">   
		<?php
                if(!valued($plan->code)) {
                    echo form_input("code", set_value("code", $plan->code), 'id="code"');
                    echo 'Must be unique and lowercase';
                    
                }
                else print form_input("code", set_value("code", $plan->code), 'id="code" disabled="disabled"');?> 
		</div>
		</li>
                <li>
		<label for="status">Status</label>
		<div class="input">
                  <?php 
                      $active = FALSE; $inactive = FALSE;
                      if(strtolower($plan->status) == 1)$active = TRUE;else $inactive = TRUE;
                  ?>
		<label for="status">Active</label> <input type="radio" name="status" value="1" <?php echo set_radio('status', '1', $active); ?> />
                <label for="status">Inactive</label> <input type="radio" name="status" value="0" <?php echo set_radio('status', '0', $inactive); ?> />
		</div>
		</li>
                <li>
		<label for="status">Basic Benefits</label>
		<div class="input">
                  <?php 
                      $yes = FALSE; $no = FALSE;
                      if(strtolower($plan->basic_benefits) == 1)$yes = TRUE;else $no = TRUE;
                  ?>
		<label for="status">Yes</label> <input type="radio" name="basic_benefits" value="1" <?php echo set_radio('basic_benefits', '1', $yes); ?> />
                <label for="status">No</label> <input type="radio" name="basic_benefits" value="0" <?php echo set_radio('basic_benefits', '0', $no); ?> />
		</div>
		</li>
                <li>
		<label for="status">Skilled Nursing</label>
		<div class="input">
                  <?php 
                      $yes = FALSE; $no = FALSE;
                      if(strtolower($plan->skilled_nursing) == 1)$yes = TRUE;else $no = TRUE;
                  ?>
		<label for="status">Yes</label> <input type="radio" name="skilled_nursing" value="1" <?php echo set_radio('skilled_nursing', '1', $yes); ?> />
                <label for="status">No</label> <input type="radio" name="skilled_nursing" value="0" <?php echo set_radio('skilled_nursing', '0', $no); ?> />
		</div>
		</li>
                <li>
		<label for="status">Part B Excess</label>
		<div class="input">
                  <?php 
                      $yes = FALSE; $no = FALSE;
                      if(strtolower($plan->part_b_excess) == 1)$yes = TRUE;else $no = TRUE;
                  ?>
		<label for="status">Yes</label> <input type="radio" name="part_b_excess" value="1" <?php echo set_radio('part_b_excess', '1', $yes); ?> />
                <label for="status">No</label> <input type="radio" name="part_b_excess" value="0" <?php echo set_radio('part_b_excess', '0', $no); ?> />
		</div>
		</li>
                <li>
		<label for="status">Part A Deductible</label>
		<div class="input">
                  <?php 
                      $yes = FALSE; $no = FALSE;
                      if(strtolower($plan->part_a_deductible) == 1)$yes = TRUE;else $no = TRUE;
                  ?>
		<label for="status">Yes</label> <input type="radio" name="part_a_deductible" value="1" <?php echo set_radio('part_a_deductible', '1', $yes); ?> />
                <label for="status">No</label> <input type="radio" name="part_a_deductible" value="0" <?php echo set_radio('part_a_deductible', '0', $no); ?> />
		</div>
		</li>
                <li>
		<label for="status">Part B Deductible</label>
		<div class="input">
                  <?php 
                      $yes = FALSE; $no = FALSE;
                      if(strtolower($plan->part_b_deductible) == 1)$yes = TRUE;else $no = TRUE;
                  ?>
		<label for="status">Yes</label> <input type="radio" name="part_b_deductible" value="1" <?php echo set_radio('part_b_deductible', '1', $yes); ?> />
                <label for="status">No</label> <input type="radio" name="part_b_deductible" value="0" <?php echo set_radio('part_b_deductible', '0', $no); ?> />
		</div>
		</li>
                <li>
		<label for="status">Foreign Travel Emergency</label>
		<div class="input">
                  <?php 
                      $yes = FALSE; $no = FALSE;
                      if(strtolower($plan->foreign_travel) == 1)$yes = TRUE;else $no = TRUE;
                  ?>
		<label for="status">Yes</label> <input type="radio" name="foreign_travel" value="1" <?php echo set_radio('foreign_travel', '1', $yes); ?> />
                <label for="status">No</label> <input type="radio" name="foreign_travel" value="0" <?php echo set_radio('foreign_travel', '0', $no); ?> />
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