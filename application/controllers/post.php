<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    class Post extends CI_Controller{
        
        public function __construct() {
            parent::__construct();
        }
        
        public function comment(){
            $this->load->model('comments_model');
            $this->load->model('user_model');
            $sug_id = $this->input->post('sug_id');
            $msg = $this->input->post('msg');
            $commenter = $this->user_model->getUser($this->session->userdata('user_id'));
            if($commenter->num_rows() > 0){
                foreach ($commenter->result() as $user){
                    log_message('ERROR',$sug_id . ' ' . $msg . ' "' . $user->username . '"');
                    $this->comments_model->addComment();
                    $commentlist = array();
                    $commentlist[] = array(
                        'USERNAME'      =>  ($user->id == 0) ? "annonymous":$user->username,
                        'DATE_CREATED'  =>  mdate('%Y-%m-%d', time()),
                        'CONTENT'       =>  $msg
                    );
                }
            }
            echo json_encode($commentlist);
        }
    }
?>
