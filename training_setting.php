	<style type="text/css">
	.setting_tab li{
		list-style: none;
		float: left;
	}

	</style>
  <?php echo bs_panel_open('Training settings','panel-info');?>
  <!--   <div id="header_sec">
	   
	    <div class="toolbar-list" id="toolbar">
	      <ul>
	        <li>
	          <a href="<?php echo site_url('trainings/Initial_file_trainings/training_form');?>" class="btn btn-success"><i class="fa fa-cross"></i>Cancel</a>&nbsp;
	        </li>
	      </ul>
	    </div>
	</div> -->

  <ul>
       <a href="<?php echo site_url('trainings/Initial_file_trainings');?>" class="btn btn-success"><i class="fa fa-cross"></i>Back</a>&nbsp;
      </ul>

	 <div class="col-md-12 training_dashboard">
	 		<div class="tab-pane" id="global">
           <a href="<?php echo site_url('trainings/settings_dashboard/global_training_setting');?>">
           </div>
            <div class="col-lg-3 col-xs-3">
              <div class="small-box bg-gray">
                <div class="inner">
                  <div>Global/Performance/Budget Setting</div>
                  <p>&nbsp;</p>
                </div>
                <div class="icon">
                  <i class="ion-gear-b"></i>
                </div>
                <div class="small-box-footer">Go Now! <i class="fa fa-arrow-circle-right"></i></div>
              </div>
            </div>
          </a>                  
    </div>
 


	   <div class="col-md-12 training_dashboard">

           <a href="<?php echo site_url('trainings/settings_dashboard/training_venue');?>">
            <div class="col-lg-3 col-xs-3">
              <div class="small-box bg-blue">
                <div class="inner">
                  <div>Venue</div>
                  <p>&nbsp;</p>
                </div>
                <div class="icon">
                  <i class="ion-ios-home"></i>
                </div>
                <div class="small-box-footer">Go Now! <i class="fa fa-arrow-circle-right"></i></div>
              </div>
            </div>
          </a>                  
    </div>

    <div class="col-md-12 training_dashboard">

           <a href="<?php echo site_url('trainings/Skills');?>">
            <div class="col-lg-3 col-xs-3">
              <div class="small-box bg-green">
                <div class="inner">
                  <div>Skills</div>
                  <p>&nbsp;</p>
                </div>
                <div class="icon">
                  <i class="ion-clipboard"></i>
                </div>
                <div class="small-box-footer">Go Now! <i class="fa fa-arrow-circle-right"></i></div>
              </div>
            </div>
          </a>                  
    </div>
 <?php echo bs_panel_close();?>

