<?php
  class Vote_model extends CI_Model
  {

    function __construct()
    {
      parent::__construct();
      $this->load->database();
    }

    public function vote($judge_id, $candid_id, $vote)
    {
      $this->db->trans_start();

      $this->db->query(
        "INSERT INTO Vote
         VALUES('$judge_id', '$candid_id', '$vote')"
      );

      $this->db->trans_complete();

      return $this->db->trans_status();
    }

  }
