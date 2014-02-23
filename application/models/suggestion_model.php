<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    class Suggestion_model extends CI_Model{
        
        public function __construct() {
            parent::__construct();
        }
        
        public function addSuggestion(){
            $id = $this->_getNextId();
            $data = array(
                'ID'            =>  $id,  
                'ROUTE_ID'      =>  $this->input->post('routeid'),
                'USER_ID'       =>  $this->session->userdata('user_id'),
                'TITLE'         =>  $this->input->post('title'),
                'DATE_CREATED'  =>  mdate('%Y-%m-%d', time()),
                'DATE_EDITED'   =>  null,
                'RATING_AVE'    =>  0.00,
                'RATING_COUNT'  =>  0,
                'CONTENT'       =>  $this->input->post('content')
                );
            $this->db->insert('SUGGESTION',$data);
        }
        
        public function getAllSuggestions($routeid){
            return $query = $this->db->query("SELECT * FROM SUGGESTION WHERE ROUTE_ID = " . $routeid . 
                    " ORDER BY RATING_AVE DESC, RATING_COUNT DESC, DATE_CREATED DESC");
        }
        
        public function getSuggestionCount($routeid){
            return $query = $this->db->query("SELECT COUNT(*) AS TOTAL FROM SUGGESTION WHERE ROUTE_ID = " . $routeid);
        }
        
        public function getSuggestions($routeid, $start,$end){
            $querystring = "SELECT * FROM SUGGESTION WHERE ROUTE_ID = " . $routeid . 
                    " ORDER BY RATING_AVE DESC, RATING_COUNT DESC, DATE_CREATED DESC LIMIT " . $start . "," . $end;
            log_message('ERROR','getSuggestions() -> ' . $querystring);
            return $query = $this->db->query($querystring);
        }
        
        public function getUserIdForSuggestion($sug_id){
            $this->db->where('ID',$sug_id);
            $query =  $this->db->get('SUGGESTION');
            if ($query->num_rows() > 0)
            {
                foreach ($query->result() as $row){
                    return ($row->ID);
                }
            }else{
                return -1;
            }
        }
        
        private function _getNextId() { 
            $this->db->select_max('ID','IDMAX');
            $query=$this->db->get('SUGGESTION');
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
