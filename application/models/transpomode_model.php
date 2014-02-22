<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    class Transpomode_model extends CI_Model{
        public function __construct() {
            parent::__construct();
        }
        
        public function addCommuteDetail(){
            $data = array(
                'NAME'      =>  $this->input->post('name'),
                'COLOR'     =>  $this->input->post('color')
                );
            $this->db->insert('COMMUTE_DET',$data);
        }
        
        public function getTranspoModes(){
            $stringquery = "SELECT * FROM TRANSPO_MODE";
            $transpo = array();
            $modes = $this->db->query($stringquery);
            if($modes->num_rows() > 0){
                $transpo = array();
                foreach ($modes->result() as $mode){
                    $transpo[] = array('ID' => $mode->ID,'NAME' => $mode->NAME,'COLOR' => $mode->COLOR);
                }
            }
            return $transpo;
        }
    }
?>
