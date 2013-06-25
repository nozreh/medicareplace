<fieldset id="filters">
	
	<legend><?php echo lang('global:filters'); ?></legend>
	
	<?php echo form_open('admin/plan/ajax_filter'); ?>

	<?php echo form_hidden('f_module', $module_details['slug']); ?>
		<ul>  
			<li>
        		Status
        		<?php echo form_dropdown('f_status', array('all' => 'All', 0 => 'Incomplete', 1 => 'Complete' )); ?>
    		</li>
		
			<li>
        		Company
        		<?php echo form_dropdown('f_company', array(0 => 'All') + $companies); ?>
    		</li>
			
			<li><?php echo form_input('f_zipcode'); ?></li>
			<li><?php echo anchor(current_url() . '#', lang('buttons.cancel'), 'class="cancel"'); ?></li>
		</ul>
	<?php echo form_close(); ?>
</fieldset>