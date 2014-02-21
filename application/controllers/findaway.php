<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Findaway extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function index() {
//        if (($this->session->userdata('user_name') == "")) {
//        }
        $this->load->view('header_view');
        $this->load->view('fromto');
        $this->load->view('footer_view');
    }
    
    public function paging($routeid,$from,$to,$start,$end) {
        $this->load->model('locref_model');
        $this->load->model('route_model');
        $total = 0;
        $paging = array();
        if ($routeid != -1) {
            $query = $this->suggestion_model->getSuggestionCount($routeid);
            if($query->num_rows() > 0){
                foreach($query->result() as $row){
                    $total = $row->TOTAL;
                }
                if($total > 0){
                    $ctr = $total / 5;
                    $i = 1;
                    $st = 0;
                    $en = 4;
                    while($i <= ($ctr + 1)){
                        if($st == $start and $en == $end){
                            $paging[] = array('VALUE' =>   $i);
                        }else{
                            $paging[] = array('VALUE' => "<span class='page' onclick=\"ajaxComments('findaway/route/','".$from."','".$to."',".$st.",".$en.");\"  style='cursor:pointer'><u>" . $i . "</u></span>");
                        }
                        $st += 4;
                        $en += 5;
                        $i++;
                    }
                }
            }
        }
        return $paging;
    }

    public function route() {
        $this->load->model('locref_model');
        $this->load->model('route_model');
        $this->load->model('suggestion_model');
        $this->load->model('user_model');

        $from = $this->locref_model->getId($this->input->post('from'));
        $to = $this->locref_model->getId($this->input->post('to'));
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $routeid = $this->route_model->getRouteId($from, $to);
        $paging = $this->paging($routeid,$this->input->post('from'),$this->input->post('to'),$start, $end);
         
        if ($routeid != -1) {
            $query = $this->suggestion_model->getSuggestions($routeid,$start,$end);
            if($query->num_rows() > 0){
                $data = array();
//                $commentfirstresult = FALSE;
                foreach($query->result() as $suggestion){
                    $query2 = $this->user_model->getUser($suggestion->USER_ID);
                    if($query2->num_rows() > 0){
                        foreach ($query2->result() as $user){
//                            $commentlist = array();
//                            if(!$commentfirstresult){
//                                $comments =  $this->comments_model->getComments($suggestion->ID);
//                                if($comments->num_rows() > 0){
//                                    foreach($comments->result() as $comment){
//                                        $commenter = "";
//                                        $commenter_q = $this->user_model->getUser($comment->USER_ID);
//                                        if($commenter_q->num_rows() > 0){
//                                            foreach ($commenter_q->result() as $commenter_r){
//                                                $commenter = $commenter_r->username;
//                                            }
//                                        }
//                                        $commentlist[] = array(
//                                            'USERNAME'      =>  ($commenter == "") ? "anonymous":$commenter,
//                                            'DATE_CREATED'  =>  $comment->DATE_CREATED,
//                                            'CONTENT'       =>  $comment->CONTENT
//                                        );
//                                    }
//                                }
//                                $data[] = array(
//                                            'ID'            =>  $suggestion->ID,
//                                            'USERNAME'      =>  $user->username,
//                                            'TITLE'         =>  $suggestion->TITLE,
//                                            'DATE_CREATED'  =>  $suggestion->DATE_CREATED,
//                                            'RATING'        =>  $suggestion->RATING_AVE,
//                                            'CONTENT'       =>  $suggestion->CONTENT,
//                                            'COMMENTS'      =>  json_encode($commentlist)
//                                        );
//                                $commentfirstresult = TRUE;
//                            }else{
                                $data[] = array(
                                            'ID'            =>  $suggestion->ID,
                                            'USERNAME'      =>  $user->username,
                                            'TITLE'         =>  $suggestion->TITLE,
                                            'DATE_CREATED'  =>  $suggestion->DATE_CREATED,
                                            'RATING'        =>  $suggestion->RATING_AVE,
                                            'CONTENT'       =>  $suggestion->CONTENT,
//                                            'COMMENTS'      =>  ""
                                        );
//                            }
                        }
                    }
                }
                $i = 1;
                foreach ($paging as $page){
                    $data['PAGING' . $i] = $page;
                    $i++;
                }
                $data['status'] = array('LOGGED_IN' => $this->session->userdata('logged_in')); 
                echo json_encode($data);
            }else{
                //if registered user, create own suggestion for specific route combination
                echo "<p>No Results Found." . anchor('#','Suggest?');
            } 
        } else {
            //suggest new route combination
            if($from == -1 OR $to == -1){
                if($from == -1){
                    echo "<p>Input in the FROM field is not yet in our database. Send as a suggestion? " . anchor('search/suggest_location','yes');
                }
                if($to == -1){
                    echo "<p>Input in the TO field is not yet in our database. Send as a suggestion? " . anchor('search/suggest_location','yes');
                }
            }else{
                echo "<p>Route combination not yet available. Send as a suggestion? " . anchor('search/newroute/?from=' . $from . '&to=' . $to, 'yes');
            }
        }
    }
    
    public function comments(){
        $this->load->model('comments_model');
        $this->load->model('user_model');
        $commentlist = array();
        $comments =  $this->comments_model->getComments($this->input->post('SUG_ID'));
        if($comments->num_rows() > 0){
            foreach($comments->result() as $comment){
                $commenter = "";
                $commenter_q = $this->user_model->getUser($comment->USER_ID);
                if($commenter_q->num_rows() > 0){
                    foreach ($commenter_q->result() as $commenter_r){
                        $commenter = $commenter_r->username;
                    }
                }
                $commentlist[] = array(
                    'USERNAME'      =>  ($commenter == "") ? "anonymous":$commenter,
                    'DATE_CREATED'  =>  $comment->DATE_CREATED,
                    'CONTENT'       =>  $comment->CONTENT
                );
            }
//            $commbox = "";
//            if($this->session->userdata('logged_in')){
//                $commbox= "<p>Yes you can post a comment.</p>";
//            }else{
////                $from = $this->session->userdata('from');
////                $to = $this->session->userdata('to');
////                $start = $this->session->userdata('start');
////                $end = $this->session->userdata('end');
////                $commbox= "<p>No you can't post a comment. <a href='user/?from=" + $from + "&to=" + $to + "&start=" + $start + "&end=" + $end + "'>Login</a> first</p>";
//                $commbox= "<p>No you can't post a comment. <a href='user/'>Login</a> first</p>";
//            }
//            $commentlist['status'] = array('LOGGED_IN' => $commbox); 
            $commentlist['status'] = array('LOGGED_IN' => $this->session->userdata('logged_in'));
            echo json_encode($commentlist);
        }else{
            $commentlist['status'] = array('LOGGED_IN' => $this->session->userdata('logged_in'));
            echo json_encode($commentlist);
        }
    }

}

?>
