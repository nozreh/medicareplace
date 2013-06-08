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
		<label for="plan_id"><?php echo lang('medicare_data_importer:plan'); ?></label>
		<div class="input">
		<?php print form_dropdown('plan_id', $plans, $rate->plan_id); ?>
		</div>
		</li><li>
		<label for="company_id"><?php echo lang('medicare_data_importer:company'); ?></label>
		<div class="input">
		<?php print form_dropdown('company_id', $companies, $rate->company_id); ?>
		</div>
		</li><li>
		<label for="zipcode"><?php echo lang('medicare_data_importer:zipcodes'); ?></label>
		<div class="input">
		<?php echo form_input("zipcode", set_value("zipcode", $rate->zipcode)); ?> Separated by colon(:)
		</div>
		</li><li>
		<label for="preference"><?php echo lang('medicare_data_importer:preference'); ?></label>
		<div class="input">
		<?php echo form_input("preference", set_value("preference", $rate->preference)); ?>
		Standard=1 | Non-tobacco=2
                </div>
		</li><li>
                 <label for="age"><?php echo lang('medicare_data_importer:age'); ?></label>
		<div class="input">
		<?php echo form_input("age", set_value("age", $rate->age)); ?>
		Below 65 = 64
                </div>
		</li><li>
		<label for="amount">Amount</label>
		<div class="input">
		<?php echo form_input("amount", set_value("amount", $rate->amount)); ?> Don't include $ symbol
		</div>
		</li><li>
		<label for="addon_amount">Add-on amount</label>
		<div class="input">
		<?php echo form_input("addon_amount", set_value("addon_amount", $rate->addon_amount)); ?>Don't include $ symbol
		</div>
		</li><li>
		<label for="comment">Remarks</label>
		<div class="input">
		<?php echo form_textarea("remarks", set_value("remarks", $rate->remarks)); ?>
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