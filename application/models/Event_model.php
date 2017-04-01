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

    public function get_categs_candids($event_id)
    {
      $result_arr = array();

      array_push($result_arr, $this->get_categories($event_id));
      array_push($result_arr, $this->get_candidates($event_id));

      $categs_candids = array("categs_candids"=>$result_arr);
      return json_encode($categs_candids);
    }

    private function get_categories($event_id)
    {
      $this->db->trans_start();
      $res = $this->db->query(
        "SELECT id, name
         FROM Category
         WHERE Event_ID='$event_id'"
      );
      $this->db->trans_complete();
      $categs = array();
      foreach($res->result_array() as $row)
      {
        array_push($categs, $row);
      }

      $data = array("categs"=>$categs);

      return $data;
    }

    private function get_candidates($event_id)
    {
      $this->db->trans_start();
      $res = $this->db->query(
        "SELECT *
         FROM candidate
         WHERE event_ID='$event_id'"
      );
      $this->db->trans_complete();

      $candids = array();

      foreach($res->result_array() as $row)
      {
        array_push($candids, $row);
      }

      $data = array("candids"=>$candids);

      return $data;
    }

  }
