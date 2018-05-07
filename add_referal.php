<div class="col-md-12">
    <div class="col-md-6" align='center'>  
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Add Referal</h3>
			
		</div>
		<div class="panel-body ">
             <div class="levelwrapper">
		          <?php echo bs_form_input(array( 'type'=>'first_name','name'=>'first_name','width'=>'5','id'=>'first_name','class'=>'first_name','align'=>'left'),'','First Name','required'); ?>
		    </div>
		</br>
		    <div class="levelwrapper">
		          <?php echo bs_form_input(array( 'type'=>'last_name','name'=>'last_name','width'=>'5','id'=>'last_name','class'=>'last_name','align'=>'left'),'','Last Name','required'); ?>
		    </div>
		</br>
		    <div class="levelwrapper">
		          <?php echo bs_form_input(array( 'type'=>'address','name'=>'address','width'=>'5','id'=>'address','class'=>'address','align'=>'left'),'','Address','required'); ?>
		    </div>
		</br>
		    <div class="levelwrapper">
		          <?php echo bs_form_input(array( 'type'=>'phone_number_res','name'=>'phone_number_res','width'=>'5','id'=>'phone_number_res','class'=>'phone_number_res','align'=>'left'),'','Phone Number (Res.)','required'); ?>
		    </div>
		</br>
		    <div class="levelwrapper">
		          <?php echo bs_form_input(array( 'type'=>'phone_number_off','name'=>'phone_number_off','width'=>'5','id'=>'phone_number_off','class'=>'phone_number_off','align'=>'left'),'','Phone Number (Off)','required'); ?>
		    </div>
		</br>
		    <div class="levelwrapper">
		          <?php echo bs_form_input(array( 'type'=>'mobile_number','name'=>'mobile_number','width'=>'5','id'=>'mobile_number','class'=>'mobile_number','align'=>'left'),'','Mobile Number','required'); ?>
		    </div>
		</br>
		    <div class="levelwrapper">
		          <?php echo bs_form_input(array( 'type'=>'mobile_alt','name'=>'mobile_alt','width'=>'5','id'=>'mobile_alt','class'=>'mobile_alt','align'=>'left'),'','Mobile (Alternative)','required'); ?>
		    </div>
		</br>
		    <div class="levelwrapper">
		          <?php echo bs_form_input(array( 'type'=>'email','name'=>'email','width'=>'5','id'=>'email','class'=>'email','align'=>'left'),'','Email','required'); ?>
		    </div>
		</br>
		    <div class="levelwrapper">
		          <?php echo bs_form_dropdown(array( 'type'=>'location_cluster','name'=>'location_cluster','width'=>'5','id'=>'location_cluster','class'=>'location_cluster','align'=>'left'),'','Location Cluster (Show Cluster Map)','required'); ?>
		    </div>
		</br>
		    <div class="levelwrapper">
		          <?php echo bs_form_dropdown(array( 'type'=>'location','name'=>'location','width'=>'5','id'=>'location','class'=>'location','align'=>'left'),'','Location','required'); ?>
		    </div>
		</br>
		    <div class="levelwrapper">
		          <?php echo bs_form_input(array( 'type'=>'remarks','name'=>'remarks','width'=>'5','id'=>'remarks','class'=>'remarks','align'=>'left'),'','Remarks','required'); ?>
		    </div>	`
          <table class="table table-bordered table-striped referaltable" ></table>
        </div>
    </div>
</div> 
</div>