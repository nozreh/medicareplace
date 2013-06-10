<fieldset id="filters">
	
	<legend>Filter:</legend>
	
	<?php echo form_open('plan/ajax_filter'); ?>
        <?php echo form_hidden('f_module', $module_details['slug']); ?>
		<ul>  
			<li>
        		Companies<br />
                        <?php foreach($company_list as $id => $company): ?>
                            <input type="checkbox" name="f_company[]" id="f_company" checked="checked" value="<?php echo $company->id; ?>" style="margin:10px" /><?php echo $company->name; ?></br>
                        <?php endforeach; ?>
                        </li>
                        <li>
        		Plans<br />
                        <?php foreach($plan_list as $plan): ?>
                            <input type="checkbox" name="f_plan[]" id="f_plan" value="<?php echo $plan->id; ?>" text="<?php echo $plan->name; ?>" checked="checked" style="margin:10px" /><?php echo $plan->name; ?></br>
                        <?php endforeach; ?>
                        </li>
		</ul>
	<?php echo form_close(); ?>
</fieldset>