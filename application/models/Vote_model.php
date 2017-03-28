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

    public function getResult($event)
    {
      // Get all result of each category
      $winners = array();
      $creative = $this->getCategVote("1");
      $sports = $this->getCategVote("2");
      $swim = $this->getCategVote("3");
      $formal = $this->getCategVote("4");
      array_push($winners, $this->getCategWinner($creative));
      array_push($winners, $this->getCategWinner($sports));
      array_push($winners, $this->getCategWinner($swim));
      array_push($winners, $this->getCategWinner($formal));
      return $winners;
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
        "SELECT candid_id, categ_id, SUM(vote) AS total_vote
        FROM Vote
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

  }
