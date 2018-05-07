
 
<div class="col-md-12 referal_dashboard">
  <?php echo bs_panel_open('Referal Dashboard','panel-info');?>
  <div id="header_sec">
    <div class="training-title"></div>
  </div>


           <a href="<?php echo site_url('employee/iops/?ref=https://iops.vianet.com.np/admin/employee_referrals/referrals.cgi?action=add');?>">
            <div class="col-lg-3 col-xs-3">
              <div class="small-box bg-teal">
                <div class="inner">
                  <h4>Add Referal</h4>
                  <p>&nbsp;</p>
                </div>
                <div class="icon">
                  <i class="ion-ios-home"></i>
                </div>
                <div class="small-box-footer">Go Now! <i class="fa fa-arrow-circle-right"></i></div>
              </div>
            </div>
          </a>

          <a href="<?php echo site_url('referal/customer_list_table');?>">
          <div class="col-lg-3 col-xs-3">
            <div class="small-box bg-amethyst">
              <div class="inner">
                <h4>Referal List</h4>
                <p>&nbsp;</p>
              </div>
              <div class="icon">
                <i class="ion-android-contact"></i>
              </div>
              <div class="small-box-footer">Go Now! <i class="fa fa-arrow-circle-right"></i></div>
            </div>
          </div>
          </a>

          <a href="<?php echo site_url('referal/my_referal');?>">
          <div class="col-lg-3 col-xs-3">
            <div class="small-box bg-green">
              <div class="inner">
                <h4>My Referal</h4>
                <p>&nbsp;</p>
              </div>
              <div class="icon">
                <i class="ion-android-contact"></i>
              </div>
              <div class="small-box-footer">Go Now! <i class="fa fa-arrow-circle-right"></i></div>
            </div>
          </div>
          </a>
     <?php echo bs_panel_close();?>            
                  
    </div>
<div class="col-md-12 scoreboard_dashboard">
  <?php echo bs_panel_open('Department Scoreboard','panel-info');?>
  <h3 style="margin-top: 10px">Overview</h3> <br/>
		<div class="responsive table table-striped table-bordered dataTable"> 

		<table class="table table-striped branch">

			<tbody>
		 	
			<tr>
				<th> Department Group </th>
				<th> Sucessful Referred </th>
				<th> Staff Count </th>
				<th> Total Quota </th>
				<th> Percentage Attained(%) </th>
        <th> Department  </th>

      </tr>
        <?php foreach($result as $key=>$value){
            //echo '<pre>';print_r($value);
            $branch = $key;
            $emp_count = isset($value['emp_count'])?$value['emp_count']:'0';
            $emp_quota = isset($value['emp_quota'])?$value['emp_quota']:'0';
            $referal_count = isset($value['referal_count'])?$value['referal_count']:'0';
            $referal_per = isset($value['referal_per'])?$value['referal_per']:'0';
            $dep_group = isset($value['department'])?$value['department']:'N/A';
            

            $branch_id = isset($value['branch_id'])?$value['branch_id']:'0';
       
          ?>
      <tr class="info">
        <td> <button class="btn btn-info key" branch = "<?php echo $key ?>" type="button" id="depart"><?php echo $key; ?></button></td>
    		<td><?php echo $referal_count ?></td>
				<td><?php echo $emp_count ?></td>
				<td><?php echo $emp_quota?></td>
				<td><?php echo number_format($referal_per,2)  ?></td>
        <td><?php echo $dep_group ?>
			  <?php } ?> 
      </tr>
			
			</tbody>
		</table>
		</div>
  <?php echo bs_panel_close();?>


</div>