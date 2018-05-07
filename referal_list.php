<div class="col-md-12">  
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Referal List</h3>
		</div>
       
		<div class="panel-body">
            <div class="row" id="level">
			<div class="col-md-3">
                <div class="row">

 	              <?php echo bs_form_dropdown(array('name'=>'branch','id'=>'branch','class'=>'params','width'=>'7'),$branch,'', 'Branch'); ?>
              </div>
             </div>	
             <div class="col-md-5">
                <div class="row">
 	              <?php echo bs_form_dropdown(array('name'=>'department','id'=>'department', 'class'=>'params','width'=>'8'),$department,'', 'Department'); ?>
             </div>
         </div>
              <div class="col-md-4">
                <div class ="row">
 	              <?php echo bs_form_dropdown(array('name'=>'username','id'=>'username', 'class'=>'params','width'=>'7'),$id,'', 'User'); ?>
             </div>	
        </div>
			
</div>          

            <table class="table table-bordered table-striped" id="referal_list"></table>
        </div>
    </div>
</div>


        
