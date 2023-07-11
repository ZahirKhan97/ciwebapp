<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends CI_Model{

    // this method will insert a comment in db
    public function create($formArray)
    {
        $this->db->insert('comments',$formArray);

    }

    // this method will fetch all comments from db
    public function getComments($article_id, $status=null)
    {
        $this->db->where('article_id', $article_id);
        if ($status==true)
        {
            $this->db->where('status',1);
        }
        $this->db->order_by('created_at','DESC');
        $comments = $this->db->get('comments')->result_array();
        // echo  $this->db->last_query();
        return $comments;
    }

}


?>