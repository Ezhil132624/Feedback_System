<?php
class View_model extends CI_Model
{
    public function get_all_feedback()
    {
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('feedback_question');
        return $query->result();
    }

    public function get_all_questions()
    {
        // Assuming your questions table is 'feedback_questions'
        $query = $this->db->get('feedback_questions');
        return $query->result_array();
    }

    public function save_group_with_questions($group_name, $question_ids)
    {
        $this->db->trans_start();
        $this->db->insert('feedback_groups', [
            'name' => $group_name,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $group_id = $this->db->insert_id();

        if (!$group_id) {
            $this->db->trans_rollback();
            return false;
        }


        $insert_data = [];
        foreach ($question_ids as $qid) {
            $insert_data[] = [
                'group_id' => $group_id,
                'question_id' => $qid,
            ];
        }

        // Insert into mapping table 'group_questions'
        $this->db->insert_batch('group_questions', $insert_data);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_all_groups_with_questions()
    {
        // Select only id and name from feedback_groups

        $this->db->select('id, name, created_at');
        $this->db->from('feedback_groups');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_group_by_id($group_id)
    {
        return $this->db->get_where('feedback_groups', ['id' => $group_id])->row_array();
    }

    public function get_questions_by_group($group_id)
    {
        $this->db->select('fq.id, fq.name, fq.message');
        $this->db->from('group_questions gq');
        $this->db->join('feedback_question fq', 'fq.id = gq.question_id');
        $this->db->where('gq.group_id', $group_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    // public function save_feedback_response($data)
    // {
    //     return $this->db->insert('feedback_answers', [
    //         'group_id' => $data['group_id'],
    //         'question_id' => $data['question_id'],
    //         'email'=>$data['email'],
    //         'rating' => $data['rating'],
    //         'reply' => $data['reply']
    //     ]);
    // }
    public function save_feedback($data)
    {
        return $this->db->insert('feedback_answers',$data,[
            'group_id' => $data['group_id'],
            'question_id' => $data['question_id'],
            'email'=>$data['email'],
            'rating' => $data['rating'],
            'reply' => $data['reply']
        ]);
    }


    public function get_feedback_answers_with_details()
    {
        $this->db->select('fq.message, fa.id, fa.group_id, fa.question_id, fa.rating, fa.reply,fa.email, fa.created_at');
        $this->db->from('feedback_answers fa');
        $this->db->join('feedback_question fq', 'fq.id = fa.question_id'); // Proper join condition
        $this->db->order_by('fa.created_at', 'ASC'); // Corrected typo "AESC" to "ASC"
        $query = $this->db->get();
        return $query->result();
    }
}
