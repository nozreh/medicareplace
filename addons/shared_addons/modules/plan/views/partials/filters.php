<fieldset id="filters">
    <legend>Filter:</legend>

    <?php echo form_open('plan/ajax_filter'); ?>
    <?php echo form_hidden('f_module', $module_details['slug']); ?>
    <ul style="list-style-type: none;">  
        <li class="white-panel insurance-companies">
            <h5>INSURANCE COMPANIES:</h5>
            <?php foreach ($company_list as $id => $company): ?>
                <input type="checkbox" name="f_company[]" id="f_company" checked="checked" value="<?php echo $company->id; ?>" style="margin:10px" /><?php echo $company->name; ?></br>
            <?php endforeach; ?>
                <button class="btn btn-small btn-primary">CLEAR ALL</button>
        </li>
        <li class="white-panel plan-selection">
            <h5>PLAN SELECTION:</h5>
            <?php foreach ($plan_list as $plan): ?>
                <input type="checkbox" name="f_plan[]" id="f_plan" value="<?php echo $plan->id; ?>" text="<?php echo $plan->name; ?>" checked="checked" style="margin:10px" /><?php echo $plan->name; ?></br>
            <?php endforeach; ?>
                <button class="btn btn-small btn-primary">CLEAR ALL</button>
                <button class="btn btn-small btn-success">PLAN F ONLY</button>
        </li>
    </ul>
    <?php echo form_close(); ?>
</fieldset>