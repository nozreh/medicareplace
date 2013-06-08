<section class="title">
	<h4><?php echo lang('medicare_data_importer:companies'); ?></h4>
</section>
<section class="item">
 		   <?php  if ( valued($companies) ): ?>

     <div id="companies">
	<table border="0" class="table-list clear-both">
		<thead>
		<tr>
                <th >Id</th>
                <th>Code</th>
                <th width="20%">Name</th>
                <th>Status</th>
                <th>Address</th>
                <th>Email</th>
                <th>Website</th>
                <th>Contact</th>
                <th></th>
                <th>Action</th>
			</tr>
		</thead>
	
		<tfoot>
			<tr>
				<td colspan="7">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
	
		<tbody>
			<?php foreach ($companies as $data => $company): ?>
					
                <tr>
					<td>
						<?php print $company->id; ?>
                    </td>
					<td>
						<?php print $company->code; ?>
					</td>
					<td>
						<?php print $company->name; ?></td>
					
					<td>
						<?php $status = $company->status == 1 ? 'Active' : 'Inactive';
                                                        print $status;?>
                    </td>
                    <td>
						<?php print $company->address;?>
                    </td>
                    <td>
						<?php print $company->website;?>
                    </td>
                    <td>
						<?php print $company->email;?>
                    </td>
                     <td>
						<?php print $company->contact;?>
                    </td>
                     <td class="actions">
                                    <?php echo anchor('admin/medicare_data_importer/edit_company/'.$company->id, lang('medicare_data_importer:edit'),  'class="button options"'); ?>
                                    
                     </td>
                     <td class="actions">
                                    <?php echo anchor('admin/medicare_data_importer/delete_company/' . $company->id, lang('medicare_data_importer:delete'), 'class="confirm button delete"'); ?>
                         
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

