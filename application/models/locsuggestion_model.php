<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    class Locsuggestion_model extends CI_Model{
        
        public function __construct() {
            parent::__construct();
        }
        
        public function addLocsuggestion(){
            $data = array(
                'USER_ID'       =>  $this->session->userdata('user_id'),
                'LOC_NAME'      =>  $this->input->post('val'),
                'TAG'           =>  0
                );
            $this->db->insert('LOC_SUGGESTION',$data);
        }
    }
?>
