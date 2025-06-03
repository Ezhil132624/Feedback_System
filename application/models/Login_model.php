<?php
class Login_model extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    public function login($name, $password){
        // You should hash and verify password in a real app
        $this->db->where('name', $name);
        $this->db->where('password', $password); 
        $query = $this->db->get('users');
        return $query->row();
    }
}