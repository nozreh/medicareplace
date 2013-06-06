<div class="container">
    <h2 class="page-title" id="page_title"><?php echo 'More Info'; ?></h2>

<p>
	<span id="active_step"><?php echo 'Step 1'; ?></span> -&gt;
	<span><?php echo 'Step 2'; ?></span>
</p>

<?php if (!empty($error_string)):?>
<!-- Woops... -->
<div class="alert alert-error">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<?php echo $error_string;?>
</div>
<?php endif;?>

<?php echo form_open('plan/register_below', array('id' => 'register', 'class'=>'form-stacked')); ?>
        <?php if(isset($name)): // Name set? ?>
            <div id="names_div">
            <?php foreach($name as $count => $item): // Loop through all previous posted items ?>
                <div class="dependants">
                <label for="name">Name 
                    <input type="text" name="name[]" value="<?php echo set_value('name['.$count.']', $item); // Set it's value with the regular set_value function  ?>">
                </label>
                <label for="age">Age 
                <input type="text" name="age[]" value="<?php echo set_value('age['.$count.']', $age[$count]); // Set it's value with the regular set_value function  ?>">
                </label>
                <?php if($count > 0): ?>
                <button class="remove_btn" value="Remove this field">Remove</button>
                <?php endif; ?>
                </div>
                
            <?php endforeach; ?>
            </div>
        <?php else: ?>
             <div id="names_div">
                 <div class="dependants">
                    <input type="text" name="name[]" />
                    <input type="text" name="age[]" />
                 </div>
            </div>
        <?php endif; ?>
            
        <?php echo form_button( array('name'=>'btnAddName', 'id' => 'add_name', 'class'=>'btn btn-primary'), 'Add name'); ?>
      
	<label for="email"> Email </label>
	<input type="text" name="email" maxlength="100" value="<?php //echo set_value('email'); ?>" />
        

	
    <div class='form-actions'>
		<?php echo form_submit( array('name'=>'btnSubmit', 'class'=>'btn btn-primary'), lang('user_register_btn')); ?>
    </div>

<?php echo form_close(); ?>


<script>
 var app = {
       
     addField: function(names_div) {
        var dependants = $('<div class="dependants"></div>');
        var name = $('<input />');
        var age = $('<input />');
        var button = $('<button></button>');
        name.attr('type', 'text').attr('name','name[]').appendTo(dependants);
        age.attr('type', 'text').attr('name','age[]').appendTo(dependants);
        button.addClass('remove_btn').text('Remove').val('Remove').appendTo(dependants).click(function() {
            app.removeField(this);
            return false;
        });
        dependants.appendTo(names_div);

        // create a parent tag (label) and a button to remove it again (button)
        // create the input like this, so it's added to the dom and you are able to select them using jquery and destroy them.
    },

    removeField: function(btn) {
         
        var parent = $(btn).parent('.dependants'); // select the parent label, which contains the textfield AND the button.
        parent.remove();
       
    },

    init: function() {
        $('#add_name').bind('click', function() {
            app.addField('#names_div');
            return false; // to prevent the page from scrolling up when you use href="#".
        });
        
        $('.remove_btn').click(function() {
            app.removeField(this);
            return false;
        });

    }
};

$(document).ready(app.init); 
</script>
</div>