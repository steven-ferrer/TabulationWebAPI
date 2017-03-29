<?php
  class Vote_model extends CI_Model
  {

    function __construct()
    {
      parent::__construct();
      $this->load->database();
    }

    public function vote($judge_id, $candid_id, $categ_id, $vote)
    {
      $this->db->trans_start();

      $this->db->query(
        "INSERT INTO Vote
         VALUES('$judge_id', '$candid_id', '$categ_id', '$vote')"
      );

      $this->db->trans_complete();

      return $this->db->trans_status();
    }

    public function getResultPageant()
    {
      // Get all result of each category
      $winners = array();
      $creative = $this->getCategVote("1");
      $sports = $this->getCategVote("2");
      $swim = $this->getCategVote("3");
      $formal = $this->getCategVote("4");

      //format result
      $form_creative = array("creative"=>$this->getCategWinner($creative));
      $form_sports = array("sports"=>$this->getCategWinner($sports));
      $form_swim = array("swim"=>$this->getCategWinner($swim));
      $form_formal = array("formal"=>$this->getCategWinner($formal));
      $form_top = array("top"=>$this->getOverallWinner());

      array_push($winners, $form_creative);
      array_push($winners, $form_sports);
      array_push($winners, $form_swim);
      array_push($winners, $form_formal);
      array_push($winners, $form_top);
      return $winners;
    }

    public function getResultCheer()
    {
      $this->db->trans_start();
      $resultSet = $this->db->query(
        "SELECT Candidate.name, total_vote
         FROM (
           SELECT candid_id, SUM(vote) AS total_vote
           FROM Vote
           WHERE categ_id BETWEEN 5 AND 10
           GROUP BY candid_id
         ) AS T
         INNER JOIN Candidate ON candid_id=Candidate.ID
         ORDER BY total_vote DESC"
      );
      $this->db->trans_complete();
      return $resultSet->result_array();
    }

    private function getCategWinner($resultSet)
    {
      $win = array();
      $result_1 = $resultSet->row_array(0);
      $result_2 = $resultSet->row_array(1);
      $vote_1 = $result_1['total_vote'];
      $vote_2 = $result_2['total_vote'];
      if($vote_1 === $vote_2)
      {
        array_push($win, $result_1, $result_2);
      } else{
        array_push($win, $result_1);
      }
      return $win;
    }

    private function getCategVote($categ)
    {
      $this->db->trans_start();
      $res = $this->db->query(
        "SELECT Candidate.name AS candid_name,
         SUM(vote) AS total_vote
         FROM Vote
         INNER JOIN Candidate ON candid_id=Candidate.ID
         WHERE categ_id='$categ'
         GROUP BY candid_id, categ_id
         ORDER BY vote DESC"
      );

      $this->db->trans_complete();

      if($this->db->trans_status() === TRUE)
      {
        return $res;
      }

    }

    private function getOverallWinner()
    {
      $this->db->trans_start();
      $res = $this->db->query(
        "SELECT Candidate.name AS candid_name, SUM(vote) AS total_vote
        FROM Vote
        INNER JOIN Candidate ON candid_id=Candidate.ID
        GROUP BY candid_id
        ORDER BY total_vote DESC"
      );
      $this->db->trans_complete();

      return $res->result_array();
    }

  }
