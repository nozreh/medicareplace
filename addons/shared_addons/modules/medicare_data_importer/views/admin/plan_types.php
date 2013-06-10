<section class="title">
	<h4><?php echo lang('medicare_data_importer:plans'); ?></h4>
</section>
<section class="item">
 		   <?php  if ( valued($plan_types) ): ?>

     <div id="companies">
	<table border="0" class="table-list clear-both">
		<thead>
		<tr>
                <th >Id</th>
                <th>Code</th>
                <th width="20%">Name</th>
                <th>segment</th>
                <th></th>
                <th>Action</th>
		</tr>
		</thead>
	
		<tfoot>
			<tr>
				<td colspan="6">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
	
		<tbody>
			<?php foreach ($plan_types as $data => $plan_type): ?>
					
                <tr>
					<td>
						<?php print $plan_type->id; ?>
                    </td>
					<td>
						<?php print $plan_type->code; ?>
					</td>
					<td>
						<?php print $plan_type->name; ?></td>
					
					<td>
						<?php $segment = $plan_type->segment == 1 ? 'Segment B' : 'Segment A';
                                                        print $segment;?>
                    </td>
                    <td class="actions">
                                    <?php echo anchor('admin/medicare_data_importer/edit_plan_type/'.$plan_type->id, lang('medicare_data_importer:edit'),  'class="button options"'); ?>
                                    
                     </td>
                     <td class="actions">
                                    <?php echo anchor('admin/medicare_data_importer/delete_plan_type/' . $plan_type->id, lang('medicare_data_importer:delete'), 'class="confirm button delete"'); ?>
                         
                     </td>
         		</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>	
<?php else: ?>

	<div class="no_data">No Plan Type record available</div>

<?php endif; ?>

</section>

