<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    class Routeview_model extends CI_Model{
        public function __construct() {
            parent::__construct();
        }
        
        public function getCommuteDetailView(){
            $sug_id = $this->input->post('sug_id');
//            $this->db->order_by('COMMUTE_SEQ','ASC');
//            $this->db->where('SUG_ID',$sug_id);
//            $details=$this->db->get('ROUTE_VIEW');
            $querystring = "SELECT * FROM ROUTE_VIEW WHERE SUG_ID=" . $sug_id . " ORDER BY COMMUTE_SEQ ASC";
            log_message('ERROR',"QUERY: " . $querystring);
            $details = $this->db->query($querystring);
            $data = array();
            if($details->num_rows() > 0){
                foreach($details->result() as $detail){
                    $data[] = array(
                        'SUG_ID'            =>  $detail->SUG_ID,  
                        'COMMUTE_SEQ'       =>  $detail->COMMUTE_SEQ,
                        'TRANSPOMODE_ID'    =>  $detail->TRANSPOMODE_ID,
                        'TRANSPOMODE_DESC'  =>  $detail->TRANSPOMODE_DESC,
                        'TRAVEL_DESC'       =>  $detail->TRAVEL_DESC,
                        'FARE'              =>  $detail->FARE,
                        'ETA'               =>  $detail->ETA,
                        'TRANSPOMODE_NAME'  =>  $detail->NAME,
                        'TRANSPOMODE_COLOR' =>  $detail->COLOR
                    );
                }
            }
            return $data;
        }
    }
?>
