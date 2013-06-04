<section class="title">
	<h4><?php echo lang('medicare_data_importer:plans'); ?></h4>
</section>
<section class="item">
 		   <?php  if ( valued($plans) ): ?>

     <div id="companies">
	<table border="0" class="table-list clear-both">
		<thead>
		<tr>
                <th >Id</th>
                <th>Code</th>
                <th width="20%">Name</th>
                <th>Status</th>
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
			<?php foreach ($plans as $data => $plan): ?>
					
                <tr>
					<td>
						<?php print $plan->id; ?>
                    </td>
					<td>
						<?php print $plan->code; ?>
					</td>
					<td>
						<?php print $plan->name; ?></td>
					
					<td>
						<?php $status = $plan->status == 1 ? 'Active' : 'Inactive';
                                                        print $status;?>
                    </td>
                    <td class="actions">
                                    <?php echo anchor('admin/medicare_data_importer/edit_plan/'.$plan->id, lang('medicare_data_importer:edit'),  'class="button options"'); ?>
                                    
                     </td>
                     <td class="actions">
                                    <?php echo anchor('admin/medicare_data_importer/delete_plan/' . $plan->id, lang('medicare_data_importer:delete'), 'class="confirm button delete"'); ?>
                         
                     </td>
         		</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>	
<?php else: ?>

	<div class="no_data">No companies record available</div>

<?php endif; ?>

</section>

