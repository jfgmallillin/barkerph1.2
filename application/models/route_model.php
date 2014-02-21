<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    class Route_model extends CI_Model{
        
        public function __construct() {
            parent::__construct();
        }
        
        public function addNewRoute($fromid,$toid) {
            $id = $this->_getNextId();
            $data = array(
                'ID'            =>  $id,  
                'ROUTE_FROM'    =>  $fromid,
                'ROUTE_TO'      =>  $toid,
                'HIT_COUNT'     =>  0,
                'DATE_CREATED'  =>  mdate('%Y-%m-%d', time())
                );
            $this->db->insert('routes',$data);
        }
        
        public function getRouteId($from,$to){
            $query=$this->db->query("SELECT * FROM ROUTES WHERE ROUTE_FROM = " . $from . " AND ROUTE_TO = " . $to);
            if($query->num_rows()>0){
                foreach($query->result() as $row){
                    return $row->ID;
                }
            }
            return -1;
        }
        
        private function _getNextId() { 
            $this->db->select_max('ID','IDMAX');
            $query=$this->db->get('ROUTES');
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
