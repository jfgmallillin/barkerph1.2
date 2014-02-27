<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    class Commutedet_model extends CI_Model{
        public function __construct() {
            parent::__construct();
        }
        
        public function addCommuteDetail($mode_id,$mode_desc,$t_desc,$fare,$eta){
            $sug_id = $this->input->post('sug_id');
            $nextSeq = $this->_getNextSequence($sug_id);
            $data = array(
                'SUG_ID'            =>  $sug_id,  
                'COMMUTE_SEQ'       =>  $nextSeq,
                'TRANSPOMODE_ID'    =>  $mode_id,
                'TRANSPOMODE_DESC'  =>  $mode_desc,
                'TRAVEL_DESC'       =>  $t_desc,
                'FARE'              =>  $fare,
                'ETA'               =>  $eta
                );
            $this->db->insert('COMMUTE_DET',$data);
        }
        
        public function getCommuteDetail(){
            $sug_id = $this->input->post('sug_id');
            $this->db->order_by('COMMUTE_SEQ','ASC');
            $this->db->where('SUG_ID',$sug_id);
            $details=$this->db->get('COMMUTE_DET');
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
                        'ETA'               =>  $detail->ETA
                    );
                }
            }
            return $data;
        }
        
        public function deleteCommuteDetail(){
            $sug_id = $this->input->post('sug_id');
            $this->db->delete('COMMUTE_DET', array('SUG_ID'=>$sug_id));
        }
        
        private function _getNextSequence($sug_id){
            $this->db->where('SUG_ID',$sug_id);
            $this->db->select_max('COMMUTE_SEQ','IDMAX');
            $query=$this->db->get('COMMUTE_DET');
            if ($query->num_rows() > 0)
            {
                foreach ($query->result() as $row){
                    return ($row->IDMAX + 1);
                }
            }else{
                return 1;
            }
        }
    }
?>
