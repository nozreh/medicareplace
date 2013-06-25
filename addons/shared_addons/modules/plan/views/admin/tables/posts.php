	<table>
		<?php if( count($plan_users) > 0 ) : ?>
		<thead>
			<tr>
				<th>Name</th>
				<th class="collapse">Email</th>
				<th class="collapse">Contact</th>
				<th width="20">Age</th>
				<th width="20">Gender</th>
				<th class="collapse">Preference</th>
				<th width="40">Status</th>
				<th >Zip Code</th>
			</tr>
		</thead>
		<?php else : ?>
		<div class="no_data">No user found</div>
		<?php endif; ?>
		<tfoot>
			<tr>
				<td colspan="7">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($plan_users as $user) : ?>
				<tr>
					<td><?php echo $user->first_name.' '.$user->last_name; ?></td>
					<td class="collapse"><?php echo $user->email; ?></td>
					<td class="collapse"><?php echo $user->contact; ?></td>
					<td class="collapse"><?php echo date('Y') - date('Y', strtotime($user->birth_date)); ?></td>
					<td class="collapse"><?php echo $user->gender; ?></td>
					<td class="collapse"><?php echo $user->preference == 1 ? 'Smoker' : 'Non-Smoker'; ?></td>
					<td><?php echo $user->status == 1 ? 'Completed' : 'Incomplete'; ?></td>
					<td><?php echo $user->zip_code; ?></td>
					
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>