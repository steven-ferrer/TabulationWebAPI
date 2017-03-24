<?php

  class Api extends CI_Controller
  {
    // Api constructor
    function __construct()
    {
      parent::__construct();
    }

    //For Testing only - TODO: Remove
    public function index()
    {
      $this->load->view('error');
    }

    //Vote ssaving to db
    public function commit_vote($judge_id, $candid_id, $vote)
    {
      $this->load->model('Vote_model');
      $res = $this->vote_model->vote($judge_id, $candid_id, $vote);

      if($res)
      {
        $this->load->view('ok');
      } else {
        $this->load->view('error');
      }

    }

    public function login()
    {
      $user = $this->input->post('judge_id');
      $pass = $this->input->post('pass');

      if()
    }

  }
