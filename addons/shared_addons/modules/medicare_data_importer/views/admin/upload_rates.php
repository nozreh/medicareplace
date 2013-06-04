<section class="title">
	<h4><?php echo 'Upload data';?></h4>
</section>

<section class="item">
<?php echo form_open_multipart('admin/medicare_data_importer/upload_rate', array('class' => 'crud'));?>

	<ul>
		<li>
			<label for="userfile"><?php echo 'Upload data rates here';?></label><br/>
			<input type="file" name="userfile" class="input" />
		</li>
	</ul>
	
	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('upload') )); ?>
	</div>
<?php echo form_close();?>
</section>
