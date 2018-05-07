<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Referal_m extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		ci()->iopsdb=$this->iopsdb = $this->load->database('iopsdb', true);
		ci()->roiopsdb=$this->roiopsdb = $this->load->database('iopsdb', true);		
		ci()->hrdb=$this->hrdb = $this->load->database('hrdb', true);

		
	}
	public function getBranches(){
		$result = $this->roiopsdb->select('id, name as branch')
								->get('branches')
								->result();
		$toreturn = array();
		foreach ($result as $value) {
			$toreturn[$value->id] = $value->branch;
		}
		return $toreturn;
	}

	public function getEmpTotalCount(){
		$branches = $this->getBranches();
		$toreturn = array();
		foreach($branches as $key=>$branch){
			if($key==6){ //headoffice
				$hoempcount = $this->roiopsdb->select('count(emp.employee_id) as cnt, emp.department_id, group_concat(DISTINCT  dep.department) as department, depgr.dep_group, emp.branch_id')
								->from('employee as emp')
								->join('departments as dep','dep.id=emp.department_id','left')
								->join ('department_group as depgr','depgr.id=dep.id')
								->where(array('emp.branch_id'=>$key, 'emp.active'=>'Y'))
								->group_by('depgr.dep_group')
								->order_by('dep.department')
								//->order_by('depgr.dep_group')

								->get()
								->result();
								//echo '<pre>';print_r($hoempcount);exit;
								//echo $this->iopsdb->last_query();exit;
				foreach ($hoempcount as $value) {
					// $toreturn[$branches[$key].'-'.$value->]
					$toreturn[$branches[$key].' - '.$value->dep_group]['emp_count']=$value->cnt;
					$toreturn[$branches[$key].' - '.$value->dep_group]['emp_quota'] = $value->cnt*5;
					$toreturn[$branches[$key].' - '.$value->dep_group]['branch_id']=$value->branch_id;
					$toreturn[$branches[$key].' - '.$value->dep_group]['dep_group']=$value->dep_group;
					$toreturn[$branches[$key].' - '.$value->dep_group]['department']=$value->department;

					
				}
								//echo '<pre>';print_r($toreturn);exit;
				//exit;	
				$horeferalcount = $this->roiopsdb->select ('count(si.id) as cnt,count(emp.employee_id) as empcnt, dep.department,emp.department_id,emp.branch_id, group_concat(first_name," ",last_name," ")as empname,group_concat(DISTINCT  dep.department) as department, depgr.dep_group')
									 ->from('sales_inquiry as si')
									 ->join('employee as emp','si.referred_by=emp.employee_id','left')
									 ->join('departments as dep','emp.department_id=dep.id','left')
							         ->join ('department_group as depgr','depgr.id=dep.id')
								     ->where(array('emp.branch_id'=>$key, 'emp.active'=>'Y','si.inquiry_source'=>'6','si.current_status'=>'6','si.inquiry_date>='=>'2018-04-15'))
								     ->group_by('depgr.dep_group')
								     ->order_by('emp.employee_id')
								     // ->group_by('emp.employee_id')
								     // ->order_by('depgr.dep_group')
								     ->get()
								     ->result();
								     //echo '<pre>';print_r($horeferalcount);exit;
						    //echo $this->roiopsdb->last_query();exit;
				foreach ($horeferalcount as $value) {

					$toreturn[$branches[$key].' - '.$value->dep_group]['referal_count']=$value->cnt;
					$toreturn[$branches[$key].' - '.$value->dep_group]['referal_per'] = ($value->cnt/$toreturn[$branches[$key].' - '.$value->dep_group]['emp_quota'])*100;
					$toreturn[$branches[$key].' - '.$value->dep_group]['employee_name']=$value->empname;
					$toreturn[$branches[$key].' - '.$value->dep_group]['employee_referal']=$value->empcnt;		
				}
				//echo '<pre>';print_r($toreturn);exit;
			}else{
				$others = $this->roiopsdb->select('count(emp.employee_id) as cnt,emp.branch_id')
							   ->from('employee as emp')
							   ->where(array('emp.branch_id'=>$key, 'emp.active'=>'Y'))	
							   ->group_by('emp.branch_id')
							   ->get()
							   ->result();
							   //print_r($others);
				foreach ($others as $value) {
				  	if(isset($branches[$key])){
				  		$toreturn[$branches[$key]]['emp_count']=$value->cnt;
						$toreturn[$branches[$key]]['emp_quota']=$value->cnt*5;
						$toreturn[$branches[$key]]['branch_id']=$value->branch_id;

				  	}
						
				}
				$others = $this->iopsdb
    				   ->select ('count(si.id) as cnt,count(emp.employee_id) as empcnt, b.name,dep.department,emp.branch_id,concat(first_name," ",last_name," ")as empname')
					   ->from('sales_inquiry as si')
					   ->join('employee as emp','si.referred_by=emp.employee_id','left')
					   ->join ('branches as b','emp.branch_id=b.id','left')
					   ->join('departments as dep','dep.id=emp.department_id','left')
					   ->group_by ('b.name')
				        ->where(array('emp.branch_id'=>$key, 'emp.active'=>'Y','si.inquiry_source'=>'6','si.current_status'=>'6','si.inquiry_date>='=>'2018-04-15'))
					   ->get()
					   ->result();
					   //echo'<pre>';print_r($others);exit;
					   //echo $this->iopsdb->last_query();exit;
				 foreach ($others as $value) {
					$toreturn[$branches[$key]]['referal_count']=$value->cnt;
					$toreturn[$branches[$key]]['referal_per'] = ($value->cnt/$toreturn[$branches[$key]]['emp_quota'])*100;
					$toreturn[$branches[$key]]['employee_name']=$value->empname;
					$toreturn[$branches[$key]]['employee_referal']=$value->empcnt;
				}   

			}
				//echo'<pre>';print_r($toreturn);
		}
		//exit;
		return $toreturn;

	}

public function get_customer_list($params=null){
		$where = array();

	   	if (isset($params['department']) && $params['department'] ){
			if ($params['department'] != -1) {
				$where['emp.department_id'] = $params['department'];
			}
		}
			if (isset($params['username']) && $params['username'] ){
			if ($params['username'] != -1) {
				$where['si.referred_by'] = $params['username'];
		
			}
		}
		if(isset($params['branch']) && $params['branch']){
			if($params['branch'] != -1){
				$where['emp.branch_id'] = $params['branch'];
			}
		}
		
		$select = array('concat(pcust.first_name," ",pcust.last_name,"") as customer_name', 'si.customer_id', 'si.service_type', 'i_status.status', 'dep.department','br.name','emp.first_name');

		 $sort = array(
				'first_name',	
				'service_type',
				'name',
				'department'


			);
	    $_field = $sort[$params['_sort_field']];

		$result = $this->iopsdb
				   ->select($select)
				   ->from('sales_inquiry as si')
				   ->join('task_service as ts','si.id=ts.inquiry_id','left')
				   ->join('customer as pcust', 'si.customer_id=pcust.customer_id','left' )
				   ->join('inquiry_status as i_status','si.current_status = i_status.id','left')
			  	   ->join('employee as emp','si.referred_by=emp.employee_id','left')
			  	   ->join ('branches as br','br.id=emp.branch_id')
			  	   ->join ('departments as dep','dep.id=emp.department_id','left')
				   ->where(array('si.inquiry_source'=>'6','si.current_status'=>'6','si.inquiry_date>='=>'2018-04-15'))
				   ->where($where)
				   ->order_by( $_field, $params['_sort_direction'])
				   ->limit($params['_limit'], $params['_offset'])

				   ->get()
				   ->result();
 			if ( $params['_search_string'] != "") {

	          $toSearch = array(
	          'first_name','department'
	          );
	          $orLikeQuery = "(";

            foreach ($toSearch as $field) {
                    $orLikeQuery .= "{$field} LIKE '%{$params['_search_string']}%' OR ";
            }

            $orLikeQuery = rtrim($orLikeQuery, ' OR ');
            $orLikeQuery .= ")";

            $this->iopsdb->where($orLikeQuery);
	      }
	 	$log_query= $this->db->last_query();
		$_total_records = $this->count_without_limit('iopsdb');
	  

	            return array(
	              'aaData'        =>  $result,
	              'iTotalRecords' => count( $result),
	              'iTotalDisplayRecords' => $_total_records,
	              'last_query'         => $log_query,
	            );

}

public function get_department_dropdown(){
	$result = $this->iopsdb
				   ->select('id,department')
				   ->from ('departments')
				   ->get()
				   ->result();
	$array = json_decode(json_encode($result), True);
 	   $toreturn = array();
	   foreach($array as $key => $item){
	   	$toreturn[$item['id']] = $item['department'];
	  }
	  return $toreturn;

}		

public function get_branch_dropdown(){
	$result = $this->iopsdb
				   ->select('id,name')
				   ->from ('branches')
				   ->get()
				   ->result();
	$array = json_decode(json_encode($result), True);
 	   $toreturn = array();
	   foreach($array as $key => $item){
	   	$toreturn[$item['id']] = $item['name'];
	  }
	  return $toreturn;

}

public function getEmpListCount(){
		$branches = $this->getBranches();
		$toreturn = array();
		foreach($branches as $key=>$branch){
			if($key==6){ //headoffice
				$horeferalcount = $this->roiopsdb->select ('count(si.id) as cnt,count(emp.employee_id) as empcnt, dep.department,emp.department_id,emp.branch_id, concat(first_name," ",last_name," ")as empname,group_concat(DISTINCT  dep.department) as department, depgr.dep_group')
									 ->from('sales_inquiry as si')
									 ->join('employee as emp','si.referred_by=emp.employee_id','left')
									 ->join('departments as dep','emp.department_id=dep.id','left')
					   				 ->join ('department_group as depgr','depgr.id=dep.id')
								     ->where(array('emp.branch_id'=>$key, 'emp.active'=>'Y','si.inquiry_source'=>'6','si.current_status'=>'6','si.inquiry_date>='=>'2018-04-15'))
								     ->group_by('emp.employee_id')
								     ->get()
								     ->result();
						    //echo $this->roiopsdb->last_query();exit;   
						    //echo '<pre>';print_r($horeferalcount);exit; 
				foreach ($horeferalcount as $value) {
					//$toreturn[] = array($value->empname, $value->empcnt);
					 $toreturn[$branches[$key].' - '.$value->dep_group]['employee_name'][]=$value->empname;					
					 $toreturn[$branches[$key].' - '.$value->dep_group]['employee_referal'][]=$value->empcnt;	
				}
				//echo '<pre>';print_r($toreturn);exit;
			}else{
				$others = $this->iopsdb
    				   ->select ('count(si.id) as cnt,count(emp.employee_id) as empcnt, b.name,dep.department,emp.branch_id,concat(first_name," ",last_name," ")as empname')
					   ->from('sales_inquiry as si')
					   ->join('employee as emp','si.referred_by=emp.employee_id','left')
					   ->join ('branches as b','emp.branch_id=b.id','left')
					   ->join('departments as dep','dep.id=emp.department_id','left')
					   ->group_by ('emp.employee_id')
				        ->where(array('emp.branch_id'=>$key, 'emp.active'=>'Y','si.inquiry_source'=>'6','si.current_status'=>'6','si.inquiry_date>='=>'2018-04-15'))
					   ->get()
					   ->result();
					   //echo'<pre>';print_r($others);exit;
					   //echo $this->iopsdb->last_query();exit;
				 foreach ($others as $value) {
					$toreturn[$branches[$key]]['employee_name'][]=$value->empname;
					$toreturn[$branches[$key]]['employee_referal'][]=$value->empcnt;
				}   

			}
		}
				//echo'<pre>';print_r($toreturn);
		//exit;
		return $toreturn;

	}
}?>	