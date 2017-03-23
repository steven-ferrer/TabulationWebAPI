<?php

  class Api extends CI_Controller
  {

    function __construct()
    {
      parent::__construct();
      $this->load->database();
    }

    public function index()
    {
      $this->load->view('error');
    }

    public function commit_vote($judge_id, $candid_id, $vote)
    {
      $this->db->trans_start();

      $this->db->query(
        "INSERT INTO Vote
         VALUES('$judge_id', '$candid_id', '$vote')"
      );

      $this->db->trans_complete();
      if($this->db->trans_status() === FALSE)
      {
        $this->load->view('error');
      } else {
        $this->load->view('ok');
      }
    }

  }
