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

    }

    //Vote ssaving to db
    public function commit_vote($judge_id, $candid_id, $categ_id, $vote)
    {
      $this->load->model('vote_model');
      $res = $this->vote_model->vote($judge_id, $candid_id, $categ_id, $vote);

      if($res)
      {
        $this->load->view('ok');
      } else {
        $this->load->view('error');
      }

    }

    public function login()
    {
      $this->load->model('user_model');
      $user = 'qwe'; //$this->input->post('judge_id');
      $pass = 'qwe'; //$this->input->post('pass');

      if($this->user_model->user_exist($user))
      {
        if($this->user_model->user_pass_match($user,$pass))
        {
          $data['json'] = $this->user_model->get_user_info('qwe');
          $this->load->view('output_json', $data);
        } else {
          $this->load->view('error');
        }
      } else {
        $this->load->view('error');
      }

    }

    public function fetch($categ_id = NULL)
    {
      $this->load->model('event_model');
      if($categ_id === NULL)
      {
        $events = $this->event_model->get_events();

        $data['json'] = $events;

      } else {
        $categs = $this->event_model->get_categories($categ_id);
        $data['json'] = $categs;
      }

      $this->load->view('output_json', $data);
    }

    public function getResults($eventID)
    {
      $this->load->model('vote_model');
      if($eventID == "2") // Pageant event
      {
        $res = $this->vote_model->getResultPageant();
        $json=json_encode($res);
        $data['json'] = $json;
        $this->load->view('output_json', $data);
      }
      else if($eventID == "1") // cheer leading
      {
        $res = $this->vote_model->getResultCheer();
        $json=json_encode($res);
        $data['json'] = $json;
        $this->load->view('output_json', $data);
      }
    }

  }
