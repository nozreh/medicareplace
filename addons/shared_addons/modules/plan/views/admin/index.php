
<section class="title">
	<h4>Users</h4>
</section>

<section class="item">

<?php if ($plan_users) : ?>

<?php echo $this->load->view('admin/partials/filters'); ?>

<div id="filter-stage">
		<?php echo $this->load->view('admin/tables/posts'); ?>
</div>

<?php else : ?>
	<div class="no_data">No user available</div>
<?php endif; ?>

</section>
