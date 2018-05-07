<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Trainings_m extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		ci()->hrdb=$this->hrdb = $this->load->database('hrdb', true);
		
	}

	public function getList_trainings($params){
		// $select = array('train.id', 'train.training_name', 'train.start_date', 'train.end_date', 'train.training_duration', 'train.type_id', 'level_id', 'train.venue', 'type.description', 'skill_id', 'cat_id', 'total_trainee','ven.venue_name','lel.training_level','type.training_type');

		// $venue_name = $this->hrdb->select($select)
		// 						 ->from('training_venue as ven')
		// 						 ->join('trainings as train','ven.id=train.venue','left')
		// 						 ->join('training_level as lel','lel.id=train.level_id','left')
		// 						 ->join('training_type as type','type.id=train.type_id','left');

								 //print_r($venue_name);exit;
		$venue_name = $params['venue'];
		$training_type = $params['type_id'];
		$training_level = $params['level_id'];
		//print_r($training_level);exit;

		$select = array('id','training_name','start_date','end_date','training_duration','type_id','level_id','venue','description','skill_id','cat_id','total_trainee','month_breakdown');

	      if ( $params['_search_string'] != "") {

	          $toSearch = array(
	            'training_name',
	            'venue',
	          );
	          $orLikeQuery = "(";

            foreach ($toSearch as $field) {
                    $orLikeQuery .= "{$field} LIKE '%{$params['_search_string']}%' OR ";
            }

            $orLikeQuery = rtrim($orLikeQuery, ' OR ');
            $orLikeQuery .= ")";

            $this->hrdb->where($orLikeQuery);
	      }
	      $result = $this->hrdb
	                     ->select($select)
	                     ->get('trainings')
	                     ->result();
	      // $result = $venue_name->get()
	      // 					   ->result();
	      					  //print_r($result);exit; 	

	                   //echo $this->hrdb->last_query();exit;
   
foreach($result as $value ){

	$value->venue = $venue_name[$value->venue];
	$value->type_id = $training_type[$value->type_id];
	$value->level_id = $training_level[$value->level_id];

}
	      $log_query= $this->db->last_query();

	            return array(
	              'aaData'        =>  $result ,
	              'iTotalRecords' => count( $result),
	              'query'         => $log_query,
	              'iTotalDisplayRecords' => count( $result),
	            );

	    
    }
 
 #########performance##############
   
    public function performancesetting_list($params){
    	$skills = $params['_skills'];
    	
   		$select = array('id','skill_id','field');
   		$sort = array('field');
    	$_field = $sort[$params['_sort_field']];
	      if ( $params['_search_string'] != "") {

	          $toSearch = array('field');
	         $orLikeQuery = "(";

            foreach ($toSearch as $field) {
                    $orLikeQuery .= "{$field} LIKE '%{$params['_search_string']}%' OR ";
            }

            $orLikeQuery = rtrim($orLikeQuery, ' OR ');
            $orLikeQuery .= ")";

            $this->hrdb->where($orLikeQuery);
	      }
	      $result = $this->hrdb
	                     ->select($select)
	                     ->order_by($_field, $params['_sort_direction'])
                         ->limit($params['_limit'], $params['_offset'])
	                     ->get('training_evaluation_fields')
	                     ->result();
       	  foreach ($result as $value) {
	          $value->skill_id=$skills[$value->skill_id];
	        }
   
        $_total_records = $this->count_without_limit('hrdb');
	     $log_query= $this->db->last_query();

	            return array(
	              'aaData'        =>  $result ,
	              'iTotalRecords' => count($result),
	             'query' => $log_query,
	              'iTotalDisplayRecords' => $_total_records,
	            );

	    
    }


    public function save_training_data($params){
     
     $result = $this->hrdb->insert("trainings", $params); 
           //echo $this->hrdb->last_query();exit;
     if($result){
       return $result;
     }else{
       return false;
     }
    }


    public function gettraining_level($params){
    	 if ( $params['_search_string'] != "") {

	          $toSearch = array(
	            'training_level'
	          );
	           $orLikeQuery = "(";

            foreach ($toSearch as $field) {
                    $orLikeQuery .= "{$field} LIKE '%{$params['_search_string']}%' OR ";
            }

            $orLikeQuery = rtrim($orLikeQuery, ' OR ');
            $orLikeQuery .= ")";

            $this->hrdb->where($orLikeQuery);
	      }
	      $result = $this->hrdb
	                     ->select('id, training_level')
	                     ->get('training_level')
	                     ->result();

	                   //echo $this->hrdb->last_query();exit;
   
	      $log_query= $this->db->last_query();

	            return array(
	              'aaData'        =>  $result ,
	              'iTotalRecords' => count( $result),
	              'query'         => $log_query,
	              'iTotalDisplayRecords' => count( $result),
	            );
    }


	public function set_training_level(){

		$params = array(
			'row_id'=>$this->input->post('pk'),
			'training_level'=>$this->input->post('value')
		);
		if($params['row_id'] && $params['row_id']!=null){
			$id= $params['row_id'];
            unset($params['row_id']);
			$result = $this->hrdb->where('id',$id)
								 ->update('training_level',$params);
		}else{
			unset($params['row_id']);
			$result = $this->hrdb->insert("training_level", $params);
		}
		if($result){
			return $result;
		}else{
			return false;
		}
	}


	 #########Settings/Global Training Settings/Training Grade##############

    public function getList_grade($params){

    	$select = array ('id','trainer_grade','daily_wage','description');
       if ( $params['_search_string'] != "") {

	          $toSearch = array(
	            'trainer_grade',
	            'daily_wage',
	          );
	           $orLikeQuery = "(";

            foreach ($toSearch as $field) {
                    $orLikeQuery .= "{$field} LIKE '%{$params['_search_string']}%' OR ";
            }

            $orLikeQuery = rtrim($orLikeQuery, ' OR ');
            $orLikeQuery .= ")";

            $this->hrdb->where($orLikeQuery);
	      }
	      $result = $this->hrdb
	                     ->select($select)
	                     ->get('trainer_grades')
	                     ->result();
	              // print_r($result);exit;   
	                   //echo $this->hrdb->last_query();exit;
   
	      $log_query= $this->db->last_query();

	            return array(
	              'aaData'        =>  $result ,
	              'iTotalRecords' => count( $result),
	              'query'         => $log_query,
	              'iTotalDisplayRecords' => count( $result),
	            );
    }


 public function submit_grade($params){
 //print_r($params);exit;
  if($params['row_id'] && $params['row_id']!=null){
			$id= $params['row_id'];
            unset($params['row_id']);
			$result = $this->hrdb->where('id',$id)
								 ->update('trainer_grades',$params);
		}else{
			unset($params['row_id']);
			$result = $this->hrdb->insert("trainer_grades", $params);
		}
		if($result){
			return $result;
		}else{
			return false;
		}

 }

 public function get_skill_grade(){

 	$skill_grade = $this->hrdb->get('skill_grades')
 	                          ->result();
 	              $skillgrade = array();
 	          foreach ($skill_grade as  $value) {
 	          	 $skillgrade[$value->id] = $value->grade;
 	          }
 	     return $skillgrade;
 }

 public function dropdown_training_level(){
 	$training_level = $this->hrdb->get('training_level')
 	                          ->result();
 	              $traininglevel = array();
 	          foreach ($training_level as  $value) {
 	          	 $traininglevel[$value->id] = $value->training_level;
 	          }
 	     return $traininglevel;
 }

public function submit_training_field($params){
//print_r($params);exit;
if($params['row_id'] && $params['row_id']!=null){
			$id= $params['row_id'];
            unset($params['row_id']);
			$result = $this->hrdb->where('id',$id)
								 ->update('training_evaluation_fields',$params);
		}else{
			unset($params['row_id']);
			$result = $this->hrdb->insert("training_evaluation_fields", $params);
		}
		if($result){
			return $result;
		}else{
			return false;
		}

}

#########Settings/Training Budget Heading/##############

    public function budget_heading_list($params){
   //print_r($params);exit;
    	$select = array ('id','budget_heading','remarks','cost');
       if ( $params['_search_string'] != "") {

	          $toSearch = array(
	            'budget_heading'
	          );
	          $orLikeQuery = "(";

            foreach ($toSearch as $field) {
                    $orLikeQuery .= "{$field} LIKE '%{$params['_search_string']}%' OR ";
            }

            $orLikeQuery = rtrim($orLikeQuery, ' OR ');
            $orLikeQuery .= ")";

            $this->hrdb->where($orLikeQuery);
	      }
	      $result = $this->hrdb
	                     ->select($select)
	                     ->get('training_budget_head')
	                     ->result();
	              // print_r($result);exit;   
	                   //echo $this->hrdb->last_query();exit;
   
	      $log_query= $this->db->last_query();

	            return array(
	              'aaData'        =>  $result ,
	              'iTotalRecords' => count( $result),
	              'query'         => $log_query,
	              'iTotalDisplayRecords' => count( $result),
	            );
    }

    public function submit_budget_field($params){
//print_r($params);exit;
if($params['row_id'] && $params['row_id']!=null){
			$id= $params['row_id'];
            unset($params['row_id']);
			$result = $this->hrdb->where('id',$id)
								 ->update('training_budget_head',$params);
		}else{
			unset($params['row_id']);
			$result = $this->hrdb->insert("training_budget_head", $params);
		}
		if($result){
			return $result;
		}else{
			return false;
		}

}

#########/Skills/##############

public function get_skills ($params){

$select = array ('id','skills');
//$select2 = array('id','training_type');

// $trainingtype=$this->hrdb->select($select)
// 						 ->from('training_type as type')
// 						 ->join('training_skills as sk','type.id=sk.id','left');	

       if ( $params['_search_string'] != "") {

	          $toSearch = array(
	            'skills'
	          );
	           $orLikeQuery = "(";

            foreach ($toSearch as $field) {
                    $orLikeQuery .= "{$field} LIKE '%{$params['_search_string']}%' OR ";
            }

            $orLikeQuery = rtrim($orLikeQuery, ' OR ');
            $orLikeQuery .= ")";

            $this->hrdb->where($orLikeQuery);
	      }
	      $result = $this->hrdb
	                     ->select($select)
	                     ->get('training_skills')
	                     ->result();

	      // $resultB = $this->hrdb
	      //                ->select($select2)
	      //                ->get('training_type')
	      //                ->result();             

	      // $result = $trainingtype->get()
	      // 						 ->result();	
	              // print_r($result);exit;   
	                   //echo $this->hrdb->last_query();exit;
   			
	      //$result = array($resultA,$resultB);               	
	      $log_query= $this->db->last_query();

	            return array(
	              'aaData'        =>  $result ,
	              'iTotalRecords' => count( $result),
	              'query'         => $log_query,
	              'iTotalDisplayRecords' => count( $result),
	            );

}

	public function set_training_skills(){

			$params = array(
				'row_id'=>$this->input->post('pk'),
				'skills'=>$this->input->post('value')
			);
			if($params['row_id'] && $params['row_id']!=null){
				$id= $params['row_id'];
	            unset($params['row_id']);
				$result = $this->hrdb->where('id',$id)
									 ->update('training_skills',$params);
			}else{
				unset($params['row_id']);
				$result = $this->hrdb->insert("training_skills", $params);
			}
			//print_r($result);exit;
			if($result){
				return $result;
			}else{
				return false;
			}
	}


#########/Procurements/##############

public function procurements ($params){

	   // $select = array ('','');
    //    if ( $params['_search_string'] != "") {

	   //        $toSearch = array(
	   //          ''
	   //        );
	   //        $orLikeQuery = "(";

	   //        foreach ($toSearch as $field) {
	   //          $orLikeQuery .= "{$field} LIKE '%{$params['_search_string']}%' OR ";
	   //        }

	   //        $orLikeQuery = rtrim($orLikeQuery, ' OR ');
	   //        $orLikeQuery .= ")";

	   //        $this->db->where($orLikeQuery);
	   //    }
	   //    $result = $this->hrdb
	   //                   ->select($select)
	   //                   ->get('')
	   //                   ->result();
	   //            // print_r($result);exit;   
	   //                 //echo $this->hrdb->last_query();exit;
   
	   //    $log_query= $this->db->last_query();

	   //          return array(
	   //            'aaData'        =>  $result ,
	   //            'iTotalRecords' => count( $result),
	   //            'query'         => $log_query,
	   //            'iTotalDisplayRecords' => count( $result),
	   //          );

}

#########/Venue/##############

public function gettraining_venue($params){
		$select = array('id', 'longitude', 'latitude', 'venue_name', 'contact_person', 'type', 'contact_mobile');
	      if ( $params['_search_string'] != "") {

	          $toSearch = array(
	            'contact_person',
	            'venue_name',
	          );
	          $orLikeQuery = "(";

            foreach ($toSearch as $field) {
                    $orLikeQuery .= "{$field} LIKE '%{$params['_search_string']}%' OR ";
            }

            $orLikeQuery = rtrim($orLikeQuery, ' OR ');
            $orLikeQuery .= ")";

            $this->hrdb->where($orLikeQuery);
	      }
	      $result = $this->hrdb
	                     ->select($select)
	                     ->get('training_venue')
	                     ->result();

	                   //echo $this->hrdb->last_query();exit;
   
	      $log_query= $this->db->last_query();

	            return array(
	              'aaData'        =>  $result ,
	              'iTotalRecords' => count( $result),
	              'query'         => $log_query,
	              'iTotalDisplayRecords' => count( $result),
	            );

	    
    }

public function save_training_venue($params){
if($params['row_id'] && $params['row_id']!=null){
			$id= $params['row_id'];
            unset($params['row_id']);
			$result = $this->hrdb->where('id',$id)
								 ->update('training_venue',$params);
		}else{
			unset($params['row_id']);
			$result = $this->hrdb->insert("training_venue", $params);
		}
		if($result){
			return $result;
		}else{
			return false;
		}

}


public function get_type_venue( ){
    	
          $type = $this->hrdb->get('training_venue')
                             ->result();
                              //print_r($type);exit;
          $type_dropdown   = array();

          foreach ($type as $type_training ) {
              $type_dropdown[$type_training->id] = $type_training->venue_name;
          }  
         // print_r($type_dropdown);exit;

          return $type_dropdown;
    	}

// public function get_type_venue_name( ){
//     	  $select = array('ven.venue_name','lel.training_level');
//           $venue_name = $this->hrdb->select($select)
// 								 ->from('training_venue as ven')
// 								 ->join('trainings as train','ven.id=train.venue','left')
// 								 ->join('training_level as lel','lel.id=train.level_id','left')
// 								 ->join('training_type as type','type.id=train.type_id','left')
// 								 ->get()
// 								 ->result();
// 								 //echo '<pre>'; print_r($venue_name);exit;

//           return $venue_name;
//     }

public function get_lat($row_id){

   	$result=$this->hrdb->select(array('latitude','longitude'))
   					   ->where('id',$row_id)
   					   ->get('training_venue')
   					   ->result();
   			return $result['0'];
   }
  	
public function get_training_type( ){
    	
          $trainingtype = $this->hrdb->get('training_type')
                             ->result();
                              //print_r($type);exit;
          $type_dropdown   = array();

          foreach ($trainingtype as $type_training ) {
              $type_dropdown[$type_training->id] = $type_training->training_type;
          }  
         // print_r($type_dropdown);exit;

          return $type_dropdown;
    	}

public function get_training_level( ){	
    	
          $traininglevel = $this->hrdb->get('training_level')
                                      ->result();
                              //print_r($type);exit;
          $level_dropdown   = array();

          foreach ($traininglevel as $level_training ) {
              $level_dropdown[$level_training->id] = $level_training->training_level;
          }  
         // print_r($type_dropdown);exit;

          return $level_dropdown;
    	}    	

// public function get_training_type_name(){
//     	  $select = array('type.training_type');
//           $trainingtype = $this->hrdb->select($select)
// 								 ->from('training_type as type')
// 								 ->join('trainings as train','type.id=train.type_id','left')
// 								 //->where('type_id',$type_id)
// 								 ->get()
// 								 ->result();
// 								 // echo '<pre>'; print_r($trainingtype);exit;

//           return $trainingtype;
//     }

    public function edit_training($row_id=null){

    $select = array('id','training_name','start_date','end_date','training_duration','type_id','level_id','venue','description','skill_id','cat_id','total_trainee','month_breakdown');
    
     $result = $this->hrdb->select($select)
                          ->where('id',$row_id)
                          ->get('trainings')
                          ->row();
                          //->result();
              //print_r($result);exit;

    // foreach ($result as  $value) {
    // if($value){
    //   return $value;
    // }else{
    //   return false;
    // }
                                            
   return $result;

}

public function export_training_data(){

	 $result = $this->hrdb->select('*')
                          ->from('trainings')
                          ->get()
                          ->result();
      $venue_name      = $this->get_type_venue();
      $trainingtype    = $this->get_training_type();
      $traininglevel    = $this->get_training_level();
         foreach($result as $value ){

				$value->venue = $venue_name[$value->venue];
				$value->type_id = $trainingtype[$value->type_id];
				$value->level_id = $traininglevel[$value->level_id];

		}
		//print_r($result);exit;		
     return $result;                     
}



}?>