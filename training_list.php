<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class training_list extends Public_Controller{
    public function __construct(){

      parent::__construct();
        $this->load->helper('uri');
		$this->load->helper('my_form');
        $this->load->model('trainings_m');
		$this->load->library('session');
    
    }

 public function ajax(){
    $token = uri_assoc('token',5);
    $action = uri_assoc('action',4);
    try{
      if(!$this->input->is_ajax_request()){
        throw new Exception('Invalid Request Made');
        exit();
      }else{
        switch ($action){

       case 'delete_training_list':
         $this->_prep_delete_training_list();
         break; 
       
        default:
          echo 'Nothing to return';
        break;
        }
      }
      }catch ( Exception $e ) {
        echo $e->getMessage();
      exit();
    }
  }

// public function field_enums_venue($table = 'training_venue', $field = ''){
//         $enums = array();
//         if ($table == '' || $field == '') return $enums;
//         preg_match_all("/'(.*?)'/", $this->hrdb->query("SHOW COLUMNS FROM {$table} LIKE '{$field}'")->row()->Type, $matches);
//         foreach ($matches[1] as $key => $value) {
//             $enums[$value] = $value; 
//         }
//         return $enums;
//     }

public function index(){
  if ($this->input->is_ajax_request()) {
        $_limit          = (int) $this->input->post('iDisplayLength');
        $_offset         = (int) $this->input->post('iDisplayStart');
        $_sort_field     = (int) $this->input->post('iSortCol_0');
        $_sort_direction = $this->input->post('sSortDir_0');
        $_search_string  = $this->input->post('sSearch');
        //$venue_name      = $this->trainings_m->get_type_venue_name();
        //$trainingtype    = $this->trainings_m->get_training_type_name();
       // print_r($trainingtype);exit;
        $venue_name      = $this->trainings_m->get_type_venue();
        $trainingtype    = $this->trainings_m->get_training_type();
        $traininglevel    = $this->trainings_m->get_training_level();
       
       // print_r($traininglevel);exit;
        //$trainingtype =  $this->field_enums('training_type','training_type');    


      $params=array(
        '_limit'          => $_limit,
        '_offset'         => $_offset,
        '_sort_field'     => $_sort_field,
        '_search_string'  => $_search_string,
        '_sort_direction' => $_sort_direction,
        'venue'           => $venue_name,
        'type_id'         => $trainingtype,
        'level_id'        => $traininglevel,
        //'training_type'    => $trainingtype,
      );
     //print_r($params);exit;
      $result = $this->trainings_m->getList_trainings($params);
      //print_r($result);exit;

      echo json_encode($result);
    }
    else{
    $this->template
         ->append_js('module::script_training.js')
         ->append_js(array('jquery.dataTables.min.js', 'bootstrap-editable.min.js', 'dataTables.bootstrap.js','select2.js', 'bootbox.min.js', 'jquery.validate.min.js'))
         ->append_css(array('dataTables.bootstrap.css','bootstrap-editable.css', 'jquery.dataTables.css','select2.css')) 
         ->append_css('module::training.css')
         ->build('training_list_table');
  }
}

 public function training_form(){

   $row_id = $this->uri->segment(4);
   
   $result = $this->trainings_m->edit_training($row_id);
   
   //print_r($result);exit;
   $traininglevel = $this->trainings_m->dropdown_training_level();
   $trainingtype = $this->trainings_m->get_training_type();

   $type = $this->trainings_m->get_type_venue();
    //print_r($trainingtype);exit;
    $this->template
         ->append_js('datepicker.js')
         ->append_js('jquery.dataTables.min.js')
         ->append_js('moment.min.js')
         ->append_css(array('bootstrap-datetimepicker.min.css','nepali.datepicker.v2.2.min.css'))
         ->append_js(array('bootstrap-datetimepicker.min.js','nepali.datepicker.v2.2.min.js'))
         ->append_js('module::script_training.js')
         ->append_css('module::training.css')
         ->set('row_id',$row_id)
         ->set('result',$result)  
         ->set('training_level',$traininglevel)
         ->set('trainingtype',$trainingtype)
         ->set('type',$type)
         ->build('training_form');
  }

  public function save_training_form(){
    $params = array(
            'training_name'=>$this->input->post('training_name'),
            'start_date'=>$this->input->post('start_date'),
            'end_date'=>$this->input->post('end_date'),
            'level_id'=>$this->input->post('level_id'),
            'training_duration'=>$this->input->post('training_duration'),
            //'type_id'=>$this->input->post('type_id'),
            'type_id'=>$this->input->post('type_id'),
            'total_trainee'=>$this->input->post('total_trainee'),
            'description'=>$this->input->post('description'),
            'venue'=>$this->input->post('venue'),
            'month_breakdown'=>$this->input->post('month_breakdown'),
    );
  $result=$this->trainings_m->save_training_data($params);

  if($result){
       header('location:'.base_url()."trainings/training_list");
       echo json_encode(array('msg'=>'sucess', 'status'=>200));
     }else{
        echo json_encode(array('msg'=>'Failed', 'status'=>400));
     }

  }

  public function field_enums($table = 'training_type', $field = ''){
        $enums = array();
        if ($table == '' || $field == '') return $enums;
        preg_match_all("/'(.*?)'/", $this->hrdb->query("SHOW COLUMNS FROM {$table} LIKE '{$field}'")->row()->Type, $matches);
        foreach ($matches[1] as $key => $value) {
            $enums[$value] = $value; 
        }
        return $enums;
    }

    // public function trainingdays(){
    //   $start_date = strtotime($this->input->post('start_date'));
    //   $end_date = strtotime($this->input->post('end_date'));
    //   $datediff = $end_date - $start_date;
    //   $result['diff_days'] = floor($datediff / (60 * 60 * 24)) + 1;
    //   //print_r($result);exit;
    //   echo json_encode($result);
    // }

    public function _prep_delete_training_list(){
      
   $row_id=$this->input->post('row_id');
   //print_r($row_id);exit;
    $result = $this->hrdb->where('id',$row_id)
                            ->delete('trainings');   
    if($result){
      echo json_encode(array('status'=>200,'msg' => 'success'));                  
    }else{
      echo json_encode(array('status' =>300, 'msg' => 'failure'));
    }


  }

   public function exportToExcel(){
      $this->load->library('excel');    
        $this->excel_training_list();
    }

    public function excel_training_list(){
      $result = $this->trainings_m->export_training_data();
      
      
      $stylebold_alignCentre = array(
            'font'=>array('bold'=>true),
            'alignment'=>array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            );
      $stylebold_alignRight = array(
          'font'=>array('bold'=>true),
          'alignment'=>array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
          );
        $title='Trainings Details';
        $filename='trainingdetails.xls';
        $this->excel->setActiveSheetIndex(0);
        $trainingsheet=$this->excel->getActiveSheet();
        $trainingsheet->setTitle('Training List');
        $trainingsheet->getStyle('A1')->applyFromArray($stylebold_alignCentre);
        $trainingsheet->mergeCells('A1:L1');
        $trainingsheet->setCellValue('A1', $title);

        #heading

        $trainingsheet->setCellValue('A3', 'S.No');
        $trainingsheet->getStyle('A3')->getFont()->setBold(true);
        $trainingsheet->setCellValue('B3', 'Training Title');
        $trainingsheet->getColumnDimension('B')->setAutoSize(true);
        $trainingsheet->getStyle('B3')->getFont()->setBold(true);
        $trainingsheet->setCellValue('C3', 'Start Date');
        //$trainingsheet->getColumnDimension('C')->setAutoSize(true);
        $trainingsheet->getStyle('C3')->getFont()->setBold(true);
        $trainingsheet->setCellValue('D3', 'End Date');
        //$trainingsheet->getColumnDimension('D')->setAutoSize(true);
        $trainingsheet->getStyle('D3')->getFont()->setBold(true);
        $trainingsheet->setCellValue('E3', 'Duration');
        //$trainingsheet->getColumnDimension('E')->setAutoSize(true);
        $trainingsheet->getStyle('E3')->getFont()->setBold(true);
        $trainingsheet->setCellValue('F3', 'Members');
        //$trainingsheet->getColumnDimension('F')->setAutoSize(true);
        $trainingsheet->getStyle('F3')->getFont()->setBold(true);
        $trainingsheet->setCellValue('G3', 'Venue');
        //$trainingsheet->getColumnDimension('G')->setAutoSize(true);
        $trainingsheet->getStyle('G3')->getFont()->setBold(true);
        $trainingsheet->setCellValue('H3', 'Training Type');
        $trainingsheet->getColumnDimension('H')->setAutoSize(true);
        
        $trainingsheet->getStyle('H3')->getFont()->setBold(true);
        $trainingsheet->setCellValue('I3', 'Training Level');
        //$surveysheet->getColumnDimension('I')->setAutoSize(true);
        $trainingsheet->getStyle('I3')->getFont()->setBold(true);
        
        $trainingsheet->getStyle('G3')->getFont()->setBold(true);
        $trainingsheet->setCellValue('H3', 'Description');
        $row_count = 4;
        $sno=1;

        foreach ($result as $key=> $row) {
          if(is_null($row)|| $row==''){
            unset($result[$key]);
          }
         #echo '<pre>';print_r($row);exit;
            $trainingsheet->setCellValue('A' . $row_count, $sno);
            $trainingsheet->setCellValue('B' . $row_count, $row->training_name);
            $trainingsheet->setCellValue('C' . $row_count, $row->start_date);
            $trainingsheet->setCellValue('D' . $row_count, $row->end_date);
            $trainingsheet->setCellValue('E' . $row_count, $row->training_duration);
            $trainingsheet->setCellValue('F' . $row_count, $row->total_trainee);
            $trainingsheet->setCellValue('G' . $row_count, $row->venue);
            $trainingsheet->setCellValue('H' . $row_count, $row->type_id);
            $trainingsheet->setCellValue('I' . $row_count, $row->level_id);
            $trainingsheet->setCellValue('I' . $row_count, $row->description);

           
            $row_count++;
            $sno++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename .'"' );
        header('Cache-Control: max-age=0');
        ob_end_clean();
        ob_start();
        // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

        // Write the Excel file to filename
        $objWriter->save('php://output');
        exit();
        break;

    }


}?>