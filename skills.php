<div class="col-md-12">
           
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Skills</h3>
			
		</div>
		<div class="panel-body ">
	  	<ul>
	  	 <a href="<?php echo site_url('trainings/settings_dashboard/training_settings');?>" class="btn btn-success"><i class="fa fa-cross"></i>Back</a>&nbsp;
            </ul>
             <div class="levelwrapper">
		          <?php echo form_input(array('name'=>'skills', 'id'=>'training_skills', 'placeholder'=>"Add Training Skills", 'class'=>'training_skills form-control'), '') ?>
            <div class="addwrapper">		 
		             <?php echo form_submit(array('class'=>'btn  btn-xs btn-info', 'value'=>'Add', 'id'=>'add-skills','name'=>'button-approve'))?>
            </div>
		    </div>
          <table class="table table-bordered table-striped skillstable" ></table>
        </div>
    </div>
</div> 
</div>