<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    class Comments_model extends CI_Model {
        
        public function __construct() {
            parent::__construct();
        }
        
        public function addComment(){
//            $id = $this->_getNextId();
            $this->load->helper('text');
            $sug_id = $this->input->post('sug_id');
            $msg = $this->input->post('msg');
            $msg = word_limiter($msg, strlen($msg) - 1);
            $data = array(
                'SUG_ID'        =>  $sug_id,
                'USER_ID'       =>  $this->session->userdata('user_id'),
                'DATE_CREATED'  =>  mdate('%Y-%m-%d', time()),
                'TIME_CREATED'  =>  mdate('%h:%i:%a', time()),
                'CONTENT'       =>  $msg
                );
            $this->db->insert('comments',$data);
        }
        
        public function getComments($suggestionid){
            $querystring = "SELECT * FROM COMMENTS WHERE SUG_ID = " . $suggestionid . " ORDER BY DATE_CREATED";
            return $query = $this->db->query($querystring);
        }
        
//        private function _getNextId() { 
//            $this->db->select_max('ID','IDMAX');
//            $query=$this->db->get('COMMENTS');
//            if ($query->num_rows() > 0)
//            {
//                foreach ($query->result() as $row){
//                    return ($row->IDMAX + 1);
//                }
//            }else{
//                return 1;
//            }
//        }
    }
?>
