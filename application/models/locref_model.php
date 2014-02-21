<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Locref_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function addNewLocation() {
        $id = $this->_getNextId();
        $varid = $this->_getNextIdVariantFor($id);
        $data = array(
        'ID'            =>  $id,  
        'ID_VARIANT'    =>  $varid,
        'NAME'          =>  $this->input->get('newloc'),
        'REMARKS'       =>  ""
        );
        $this->db->insert('LOCATION_REF',$data);
    }
    
    public function addNewLocationVariant($id){
        $varid = $this->_getNextIdVariantFor($id);
        $data = array(
        'ID'            =>  $id,  
        'ID_VARIANT'    =>  $varid,
        'NAME'          =>  $this->input->get('newloc'),
        'REMARKS'       =>  ""
        );
        $this->db->insert('LOCATION_REF',$data);
    }

    public function lookup($keyword){
        $queryString = "SELECT * FROM LOCATION_REF WHERE NAME LIKE '%" . $keyword . "%' OR NAME LIKE '" . $keyword . "%'";
        log_message('DEBUG',$queryString);
        return $query = $this->db->query($queryString);
    }
    
    public function getId($name){
        $querystring = "SELECT ID FROM LOCATION_REF WHERE NAME = '" . $name . "'";
        $query = $this->db->query($querystring);
        
        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                return $row->ID;
            }
        }
        return -1;
    }
    
    private function _getNextId() {  
        $this->db->select_max('ID','IDMAX');
        $query=$this->db->get('LOCATION_REF');
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row){
                return ($row->IDMAX + 1);
            }
        }else{
            return 1;
        }
    }
    
    private function _getNextIdVariantFor($id){
        $this->db->where('ID',$id);
        $this->db->select_max('ID_VARIANT','IDMAX');
        $query=$this->db->get('LOCATION_REF');
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
