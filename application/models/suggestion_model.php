<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    class Suggestion_model extends CI_Model{
        
        public function __construct() {
            parent::__construct();
        }
        
        public function addSuggestion($routeid,$newtitle){
            $id = $this->_getNextId();
            $data = array(
                'ID'            =>  $id,  
                'ROUTE_ID'      =>  $routeid,
                'USER_ID'       =>  $this->session->userdata('user_id'),
                'TITLE'         =>  $newtitle,
                'DATE_CREATED'  =>  mdate('%Y-%m-%d', time()),
                'DATE_EDITED'   =>  0000-00-00,
                'RATING_AVE'    =>  0.00,
                'RATING_COUNT'  =>  0,
                'CONTENT'       =>  ''
                );
            $this->db->insert('SUGGESTION',$data);
            log_message('ERROR','addSuggestion, new ID: "' . $id);
            return $id;
        }
        
        public function updateSuggestion($sug_id,$newtitle){
            $data = array(
               'TITLE' => $newtitle,
               'DATE_EDITED' => mdate('%Y-%m-%d', time())
            );

            $this->db->where('id', $sug_id);
            $this->db->update('SUGGESTION', $data);
        }
        
        public function updateRating($sug_id,$newratingave,$newratingcount){
            $data = array(
                'RATING_AVE' => $newratingave,
                'RATING_COUNT' => $newratingcount
            );

            $this->db->where('id', $sug_id);
            $this->db->update('SUGGESTION', $data);
        }
        
        public function getAllSuggestions($routeid){
            return $query = $this->db->query("SELECT * FROM SUGGESTION WHERE ROUTE_ID = " . $routeid . 
                    " ORDER BY RATING_AVE DESC, RATING_COUNT DESC, DATE_CREATED DESC");
        }
        
        public function getSuggestionCount($routeid){
            return $query = $this->db->query("SELECT COUNT(*) AS TOTAL FROM SUGGESTION WHERE ROUTE_ID = " . $routeid);
        }
        
        public function getRouteUser($routeid){
            $userid = $this->session->userdata('user_id');
            if($userid == ''){
                $userid = 0;//default/unregistered user
            }
            return $query = $this->db->query("SELECT * FROM SUGGESTION WHERE ROUTE_ID = " . $routeid . " AND USER_ID = " . $userid);
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
                    return ($row->USER_ID);
                }
            }else{
                return -1;
            }
        }
        
        public function getSuggestion($sug_id){
            $this->db->where('ID',$sug_id);
            $query = $this->db->get('SUGGESTION');
            if ($query->num_rows() > 0)
            {
                foreach ($query->result() as $row){
                    return $row;
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
