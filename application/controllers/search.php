<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function test(){
        $this->load->view('welcome_view');
    }
    
    public function index() {
        $keyword = $this->input->get('term');
        $data['response'] = 'false'; //Set default response
        $this->load->model('locref_model');
        $query = $this->locref_model->lookup($keyword); //Search DB
        if ($query->num_rows() > 0) { 
            $data = array();
            foreach ($query->result() as $row) {
                $data[] = array('label' => $row->NAME, 'value' => $row->NAME, 'id' => $row->ID . '_' . $row->ID_VARIANT); //Add a row to array
            }
        }else{
            $data = array();
//            $data[] = array('label' => 'No Results Found', 'value' => 'No Results Found', 'id' => 'No Results Found'); //Add a row to array
        } 
        echo json_encode($data);
    }
    
    public function newroute(){
        $this->load->model('route_model');
        $fromid=$this->input->get('from');
        $toid=$this->input->get('to');
        $this->route_model->addNewRoute($fromid,$toid);
    }
    
    public function suggest_location(){
        $this->load->model('locsuggestion_model');
        $this->locsuggestion_model->addLocsuggestion();
    }

}

?>
