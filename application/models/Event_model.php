<?php
  class Event_model extends CI_Model
  {

    function __construct()
    {
      parent::__construct();
      $this->load->database();

    }

    public function get_events()
    {
      $this->db->trans_start();
      $res = $this->db->query(
        "SELECT id, name
         FROM Event"
      );
      $this->db->trans_complete();
      $events = array();
      foreach($res->result_array() as $row)
      {
        array_push($events, $row);
      }

      $data = array("data"=>$events);

      return json_encode($data);

    }

    public function get_categories($id)
    {
      $this->db->trans_start();
      $res = $this->db->query(
        "SELECT id, name
         FROM Category
         WHERE Event_ID='$id'"
      );
      $this->db->trans_complete();
      $events = array();
      foreach($res->result_array() as $row)
      {
        array_push($events, $row);
      }
      return json_encode($events);
    }

  }
