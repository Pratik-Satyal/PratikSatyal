  <?php echo bs_panel_open('Training Form','panel-info');?>

    <!-- <div class="training-title">Capacity Building : Training </div> -->
<!--     <div class="toolbar-list" id="toolbar">
      <ul>
      	<li>
      		<a href="javascript:window.location='<?php echo site_url('trainings/Initial_file_trainings/');?>';" class="btn btn-success">Back</a>
      	</li>
        <li class="button" id="toolbar-new"> 
          <a onclick="javascript:window.location='<?php echo site_url('trainings/Initial_file_trainings/');?>';" href="javascript:void(0);" class="btn btn-danger"> Cancel </a>
       </li>
      </ul>
    </div> -->
<!-- </div> -->



<div class="toolbar">            
  <div class="toolbar-info">
    <div class="toolbar-body  col-md-6 ">
 <?php echo form_open(site_url('trainings/training_list/save_training_form'),array('id'=>"form-save-training",'class'=>'form-horizontal')); ?>
      <?php echo form_hidden('id', isset($result->id) ? $result->id:null);?>

      
          <?php if($result): ?>
         <?php echo bs_form_input(array('name'=>'training_name','width'=>'8', 'id'=>'training_name', 'class'=>'training_name'),$result->training_name, 'Training name','required') ?>  

          <?php echo bs_form_input(array('name'=>'start_date', 'width'=>'8', 'class'=>'start_date', 'id'=>'start_date'),$result->start_date,'Start Date'); ?>

          <?php echo bs_form_input(array('name'=>'end_date', 'width'=>'8', 'class'=>'end_date', 'id'=>'end_date'),$result->end_date,'End Date'); ?>

         
      <!--    
         <?php echo bs_form_input(array( 'type'=>'date','name'=>'start_date','width'=>'8','id'=>'start_date','class'=>'start_date','pickertype'=>'datetimepicker'),'','Start Date','required'); ?> -->
         
       <!--   <?php echo bs_form_input(array('name'=>'end_date','width'=>'8','id'=>'end_date', 'class'=>'end_date','pickertype'=>'datetimepicker'), '','End Date','required') ?> -->
        
         <?php echo bs_form_dropdown(array('name'=>'level_id','width'=>'8','id'=>'level', 'class'=>'level'),$training_level,$result->level_id,'Training Level','required') ?>
            
         <?php echo bs_form_input(array('name'=>'training_duration','width'=>'8','id'=>'training_duration', 'class'=>'training_duration'), $result->training_duration ,'Training Days','required') ?>
         
          <?php echo bs_form_dropdown(array('name'=>'type_id','width'=>'8','id'=>'type_id', 'class'=>'type_id'),$trainingtype,$result->type_id,'Training Type') ?> 
      
      </div>
      
      <div class="toolbar-body col-md-6"> 

        <?php echo bs_form_input(array('name'=>'total_trainee','width'=>'8','id'=>'total_trainee','class'=>'total_trainee'),$result->total_trainee,'NO. of Trainee','required'); ?>
      
        <?php echo bs_form_textarea(array('name'=>'description','width'=>'8','id'=>'description','class'=>'description'),$result->description,'Training Description','required'); ?>
      
        <?php echo bs_form_dropdown(array('name'=>'venue','width'=>'8','id'=>'venue','class'=>'venue'),$type,$result->venue,'Venue'); ?>                                          
       <!--  <?php echo bs_form_dropdown(array('name'=>'month_breakdown','width'=>'8','id'=>'month_breakdown', 'class'=>'params_payroll'),'', '','Installments') ?>      -->




<?php else: ?>

<?php echo bs_form_input(array('name'=>'training_name','width'=>'8', 'id'=>'training_name', 'class'=>'training_name'),'', 'Training name','required') ?>  

          <?php echo bs_form_input(array('name'=>'start_date', 'width'=>'8', 'class'=>'start_date', 'id'=>'start_date'),'','Start Date'); ?>

          <?php echo bs_form_input(array('name'=>'end_date', 'width'=>'8', 'class'=>'end_date', 'id'=>'end_date'),'','End Date'); ?>

         
      <!--    
         <?php echo bs_form_input(array( 'type'=>'date','name'=>'start_date','width'=>'8','id'=>'start_date','class'=>'start_date','pickertype'=>'datetimepicker'),'','Start Date','required'); ?> -->
         
       <!--   <?php echo bs_form_input(array('name'=>'end_date','width'=>'8','id'=>'end_date', 'class'=>'end_date','pickertype'=>'datetimepicker'), '','End Date','required') ?> -->
        
         <?php echo bs_form_dropdown(array('name'=>'level_id','width'=>'8','id'=>'level', 'class'=>'level'),$training_level,'','Training Level','required') ?>
            
         <?php echo bs_form_input(array('name'=>'training_duration','width'=>'8','id'=>'training_duration', 'class'=>'training_duration'), '','Training Days','required') ?>
         
          <?php echo bs_form_dropdown(array('name'=>'type_id','width'=>'8','id'=>'type_id', 'class'=>'type_id'),$trainingtype,'','Training Type') ?> 
      
      </div>
      
      <div class="toolbar-body col-md-6"> 

        <?php echo bs_form_input(array('name'=>'total_trainee','width'=>'8','id'=>'total_trainee','class'=>'total_trainee'),'','NO. of Trainee','required'); ?>
      
        <?php echo bs_form_textarea(array('name'=>'description','width'=>'8','id'=>'description','class'=>'description'),'','Training Description','required'); ?>
      
        <?php echo bs_form_dropdown(array('name'=>'venue','width'=>'8','id'=>'venue','class'=>'venue'),$type,'','Venue'); ?>                                          
       <!--  <?php echo bs_form_dropdown(array('name'=>'month_breakdown','width'=>'8','id'=>'month_breakdown', 'class'=>'params_payroll'),'', '','Installments') ?>      -->


  <?php endif; ?>
        
        <div class="btn-action col-md-offset-5">
          <div class="form-group ">
            <?php echo form_submit('save','Save','class="btn btn-success" id="save_btn"') ?>          
            <?php echo form_reset('clear','Clear','class="btn btn-danger" id="reset_btn"') ?>
          </div>
        </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>  
 <?php echo bs_panel_close();?> 