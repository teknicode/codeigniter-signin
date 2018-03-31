<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teknicode_signin {
    protected $CI;
    public function __construct($params=null)
    {
        //get codeigniter instnce
        $this->CI =& get_instance();

        //check session file path is set
        if( !$this->CI->config->item("sess_save_path") ){
            $this->CI->config->set_item("sess_save_path",sys_get_temp_dir());
        }

        //load session library
        $this->CI->load->library('session');

        //load database library
        $this->CI->load->database();
    }

    public function secure(){
        //check if user is logged in
        if( !isset($this->CI->session->user) ){
            //no user so redirect
            redirect( base_url("login") );
            exit;
        }
    }

    public function login(){
        if($p = $this->CI->input->post(null,true)) {

            $user = $this->CI->db->select("id,username")
                ->where("username", $p['username'])
                ->where("password", md5($p['password']))
                ->get("users");
            if ($user->num_rows() > 0) {
                //found user - assign to session, update last login and allow access
                $this->CI->session->user = $user->row();

                $this->CI->db->where("id",$this->CI->session->user->id);
                $this->CI->db->set("last_login",date("Y-m-d H:i:s",time()));
                $this->CI->db->update("users");

                redirect(base_url("dashboard"));
            } else {
                $this->CI->session->set_flashdata("login_failed_msg","Incorrect Login Credentials");
                redirect(base_url("login"));
            }
        }
    }

    public function logout(){
        if( !empty($this->CI->session->user) ) {
            $this->CI->session->set_flashdata("logout_msg","Logout Successful");
            $this->CI->session->unset_userdata('user');
        }
    }
}