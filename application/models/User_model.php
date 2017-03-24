<?php
  class User_model extends CI_Model
  {

    function __construct()
    {
      parent::__construct();
      $this->load->database();
    }

    public function user_exist($user)
    {

      $res = $this->db->query(
        "SELECT *
         FROM Judge
         WHERE name='$user'");
      return $res->num_rows() > 0 ? TRUE : FALSE;
    }

    public function user_pass_match($user, $pass)
    {
      $res = $this->db->query(
        "SELECT *
         FROM Judge
         WHERE name='$user'
         AND pwd='$pass'");
      return $res->num_rows() > 0 ? TRUE : FALSE;
    }

    public function get_user_info($id)
    {
      $res = $this->db->query(
        "SELECT *
         FROM Judge
         WHERE name='$id'");
      $row = $res->row_array();
      $judge = new stdClass();
      $judge->id = $row['ID'];
      $judge->name = $row['name'];

      return json_encode($judge);
    }
  }
