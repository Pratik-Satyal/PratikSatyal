<div class="col-md-12">  
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Department Employee List</h3>
		</div>
		
		<div class="panel-body">
         
			        <table class="table table-bordered employee_list" id="department_employee_list">
			        	
			        	<tbody>
		 	
							<tr>
								<th> Employee Name </th>
								<th> Sucessful Referred </th>
							</tr>
							 <?php foreach ($result as $key => $val) {
								//print_r($value);exit;
						if ($key==$branch){
								$i=0;
								foreach ($val['employee_name'] as $value){
								//print_r($i);
																
							 ?>
							 	
								 <tr class="info">
								 	<td><?php echo $value; ?></td>
								 	<td><?php echo $val['employee_referal'][$i] ?></td>
								 </tr>
							
							<?php $i++;?>	
							<?php } ?>
							<?php } ?>		 
							 <?php } ?>
						</tbody>	
			        </table>
        </div>
    </div>
</div>