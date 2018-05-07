
 
    <div class="col-md-12 training_dashboard">
  <?php echo bs_panel_open('Training Dashboard','panel-info');?>
  <div id="header_sec">
    <div class="training-title"></div>
</div>


           <a href="<?php echo site_url('trainings/training_list');?>">
            <div class="col-lg-3 col-xs-3">
              <div class="small-box bg-teal">
                <div class="inner">
                  <h4>Trainings</h4>
                  <p>&nbsp;</p>
                </div>
                <div class="icon">
                  <i class="ion-ios-home"></i>
                </div>
                <div class="small-box-footer">Go Now! <i class="fa fa-arrow-circle-right"></i></div>
              </div>
            </div>
          </a>

          <a href="<?php echo site_url('trainings/trainers');?>">
          <div class="col-lg-3 col-xs-3">
            <div class="small-box bg-amethyst">
              <div class="inner">
                <h4>Trainers</h4>
                <p>&nbsp;</p>
              </div>
              <div class="icon">
                <i class="ion-android-contact"></i>
              </div>
              <div class="small-box-footer">Go Now! <i class="fa fa-arrow-circle-right"></i></div>
            </div>
          </div>
          </a>

          <!-- <a href="<?php echo site_url('trainings/#/');?>" >
          <div class="col-lg-3 col-xs-3">
            <div class="small-box bg-green">
              <div class="inner">
                <h4>Procurements</h4>
                <p>&nbsp;</p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-cart"></i>
              </div>
              <div class="small-box-footer">View Now <i class="fa fa-arrow-circle-right"></i></div>
            </div>
          </div>
          </a> -->

          <a href="trainings/settings_dashboard/training_settings">
            <div class="col-lg-3 col-xs-3">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h4>Settings</h4>
                  <p>&nbsp;</p>
                </div>
                <div class="icon">
                  <i class="fa fa-cog"></i>
                </div>
                <div class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></div>
              </div>
            </div>
          </a>
     <?php echo bs_panel_close();?>            
                  
    </div>

 <!--  <div class="col-md-6">
     <?php echo bs_panel_open('<i class="fa fa-tachometer" aria-hidden="true"></i>Training Calendar','panel-info');?>
     <?php echo bs_panel_close();?>
  </div>


<div class="col-md-6">
<?php echo bs_panel_open('<i class="fa fa-overview" aria-hidden="true"></i>OVERVIEW','panel-info');?>
    <div class="block_content">
        <table class="sortable" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <th>Total Trainings: </th>
            <th><?php echo "";?></th>
          </tr>
          <tr>
            <th>Past Trainings: </th>
            <th><?php echo "$"; ?></th>
          </tr> 
          <tr>
            <th>Ongoing Trainings: </th>
            <th><?php echo "$"; ?></th>
          </tr> 
          <tr>
            <th>Future Trainings: </th>
            <th><?php echo "$";?></th>
          </tr>                 
        </table>
    </div>
   <?php echo bs_panel_close();?>
</div> -->