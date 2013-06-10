<style>
#plan_details{
background-color: #FFF;
padding: 15px 15px 0 40px;
display: none;
position: relative;
width: 630px;
height: 465px;

overflow-y:auto;
overflow-x:hidden;

border:1px solid #999 \9;

-webkit-border-radius:4px;
-moz-border-radius:4px;
border-radius:4px;

-webkit-background-clip:padding-box;
-moz-background-clip:padding;
background-clip:padding-box;

-webkit-box-shadow:0 4px 12px rgba(0,0,0,.4),inset 0 1px 0 rgba(255,255,255,.5);
-moz-box-shadow:0 4px 12px rgba(0,0,0,.4),inset 0 1px 0 rgba(255,255,255,.5);
box-shadow:0 4px 12px rgba(0,0,0,.4),inset 0 1px 0 rgba(255,255,255,.5);

}
</style>

    <table>
		<thead>
			<tr>
				<th width="20"><?php //echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th>Company</th>
				<th class="collapse">Plan</th>
				<th class="collapse">Date</th>
				<th class="collapse">Amount</th>
				<th>Details</th>
				<th width="180"></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
					<div class="inner"><?php $this->load->view('partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($rates as $rate) : ?>
				<tr>
					<td><?php //echo form_checkbox('action_to[]', $rate->id); ?></td>
					<td><?php echo $rate->company_name; ?></td>
					<td class="collapse"><?php echo $rate->plan_name; ?></td>
					<td class="collapse"><?php echo format_date($rate->created_on); ?></td>
					<td>$ <?php echo $rate->amount; ?></td>
					<td>
                                            <a class="btn btn-success input-medium" href="javascript:void(0);" onclick="javascript: show_plan_details(<?php echo $rate->segment.','.$rate->plan_type_id.','.$rate->company_id; ?>);" >View Details</a>
						
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

        <div id="plan_details" class="span10">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h1>Plan<font color="sky blue">Details</font></h1>
           <div id="detail_info">
           </div>    
           
       </div>

<script type="text/javascript">

function show_plan_details(segment, plan_type_id, company_id){

    //add some ajax get plan details here
        var $data_info = $('#detail_info');
        $data_info.html('loading..');
        var ajax_data = {
                        ajax: '1',
                        segment : segment,
                        plan_type_id : plan_type_id,
                        company_id : company_id

      }
      $.ajax({
              url: 'plan/ajax_plan_details',
              type: 'POST',
              data: ajax_data,
              success: function(data) 
                              {
                                      data = jQuery.parseJSON(data);
                                      if( data.success ) //submitted
                                      {
                                            $data_info.html(data.result); 
                                      }
                                      else
                                      {
                                            $data_info.html(data.result);
                                      }


                              }		
      });	
    
    
    
    
    $('#plan_details').lightbox_me({
            centered: false,
            overlayCSS: {background: '#000',opacity: .5},
            modalCSS: {top: '60px', left: '20%'},
            closeClick: false
     });
     
     
     


}

</script>