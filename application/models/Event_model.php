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
      $events = array();
      foreach($res->result as $row)
      {
        array_push($events, $row);
      }

      json_encode($events);
    }

  }
