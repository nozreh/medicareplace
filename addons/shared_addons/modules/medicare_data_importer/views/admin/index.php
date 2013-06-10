<section class="title">
	<h4><?php echo lang('medicare_data_importer:rates_title'); ?></h4>
</section>
<section class="item">
 		   <?php  if ( valued($rates) ): ?>

     <div id="rates">
	<table border="0" class="table-list clear-both">
		<thead>
		<tr>
                <th>Company</th>
                <th>Plan Type</th>
                <th>Zip Codes</th>
                <th  width="10%">Preference</th>
                <th>Age</th>
                <th>Segment</th>
                <th>Price</th>
                <th>Misc</th>
                <th>Date <br />(H:m:s)</th>
                <th>Remarks</th>
                <th>Action</th>
			</tr>
		</thead>
	
		<tfoot>
			<tr>
				<td colspan="10">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
	
		<tbody>
			<?php foreach ($rates as $data => $rate): ?>
					
                <tr>
                        <td>
                                <?php print $rate->company_name; ?>
                        </td>
                        <td>
                                <?php print $rate->plan_type_name; ?>
                        </td>
                        <td>
                                <?php print $rate->zipcode; ?>
                        </td>

                       <td width="10%">
                                <?php $preference = $rate->preference == 1 ? 'Standard/Tobacco' : 'Non-tobacco';
                                        print $preference;?>
                        </td>
                        <td>
                                <?php $age = $rate->age < 65 ? 'Below 65' : $rate->age;
                                      print $age;
                                ?>
                        </td>
                        <td>
                                <?php $segment = $rate->segment == 0 ? 'A' : 'B';
                                      print $segment;
                                ?>
                        </td>
                        <td>
                                <?php print '$'.$rate->amount;?>
                        </td>
                        <td>
                                <?php print '$'.$rate->addon_amount;?>
                        </td>
                        <td>
                                <?php print date('H:m:s', $rate->created_on);?>
                        </td>
                        <td alt="<?php print $rate->remarks;?>">
                                <?php print word_limiter($rate->remarks, 4);?>
                        </td>
                        <td class="actions">
                                    <?php echo anchor('admin/medicare_data_importer/edit_rate/'.$rate->id, lang('medicare_data_importer:edit'),  'class="button options"'); ?> <br /> <br />
                                       <?php echo anchor('admin/medicare_data_importer/delete_rate/' . $rate->id, lang('medicare_data_importer:delete'), 'class="confirm button delete"'); ?>

                        </td>
		</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>	
<?php else: ?>

	<div class="no_data">No rates record available</div>

<?php endif; ?>

</section>

