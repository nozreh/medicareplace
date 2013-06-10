<div  class="row span3">
    <h2 class="page-title" id="page_title"><?php echo 'User Info'; ?></h2>
    <p>
        <span><?php echo 'Step 1'; ?></span>-&gt;
        <span><?php echo 'Step 2'; ?></span>-&gt;
        <span id="active_step"><?php echo 'Step 3'; ?></span>
    </p>

    <section class="title">
        <h4>Rates</h4>
    </section>

    <section class="item">

        <?php if ($rates) : ?>

            <?php echo $this->load->view('partials/filters'); ?>

            <div id="filter-stage">

                <?php echo form_open('plan/select_plan'); ?>

                <?php echo $this->load->view('tables/plans'); ?>

                <?php echo form_close(); ?>

            </div>

        <?php else : ?>
            <div class="no_data">No Available Plan</div>
        <?php endif; ?>

    </section>
    
    <div id="names_div" class="well-large">
        <!-- BEGIN APPLICANT -->
        <div class="dependants">
            <legend>Applicant*</legend>
            <div class="control-group">
                <p class="text-info">Coverage for:</p>
                <p>
                    <?php echo $user_info['last_name'] . ', ' . $user_info['first_name'] . $user_info['age'] . ' ' . strtoupper($user_info['gender']);
                    ?>
                </p>
                <p>
                    <?php echo date('M. d, Y', strtotime($user_info['birth_date'])); ?>
                </p>
            </div>
            <div class="control-group">
                <p class="text-info">State and ZIP:</p>
                <p>
                    <?php echo $user_info['state'] . ', ' . $user_info['zip_code']; ?>
                </p>
            </div>
            <div class="control-group">
                <p class="text-info">County:</p>
                <p>
                    <?php echo $user_info['county']; ?>
                </p>
            </div>
            <div class="control-group">
                <p class="text-info">City:</p>
                <p>
                    <?php echo $user_info['city']; ?>
                </p>
            </div> 
            <div class="control-group">
                <p class="text-info">Coverage Start Date:</p>
                <p>
                    <?php echo date('M. d, Y', strtotime($user_info['start_coverage'])); ?>
                </p>
            </div>
        </div>
        <!--  END APPLICANT --> 
    </div>
</div>
