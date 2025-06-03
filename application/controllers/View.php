<?php

/**
 *  @property CI_View_model $View_model
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_db $db
 * @property CI_output $output
 */

class View extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('View_model');
    }

    public function home()
    {
        $this->load->view('templates/header');
        $this->load->view('home');
        $this->load->view('templates/footer');
    }

    public function question()
    {
        $this->load->view('templates/header');
        $this->load->view('feedback_view');
        $this->load->view('templates/footer');
    }

    public function get_feedback()
    {
        $data = $this->View_model->get_all_feedback();
        echo json_encode($data);
    }

    public function add_feedback()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $name = $input['name'] ?? '';
        $message = $input['message'] ?? '';

        if ($name && $message) {
            $this->db->insert('feedback_question', [
                'name' => $name,
                'message' => $message,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    //feedback_group function


    public function group()
    {
        $this->load->view('templates/header');
        $this->load->view('feedback_group');
        $this->load->view('templates/footer');
    }


    // Fetch all feedback questions
    public function get_group_feedback()
    {
        $questions = $this->View_model->get_all_questions();
        // Return JSON
        echo json_encode($questions);
    }

    // Save a new feedback group with selected question IDs
    public function save_group()
    {
        $input = json_decode(trim(file_get_contents('php://input')), true);

        $group_name = isset($input['group_name']) ? $input['group_name'] : '';
        $question_ids = isset($input['question_ids']) ? $input['question_ids'] : [];

        if (empty($group_name) || empty($question_ids)) {
            echo json_encode(['status' => false, 'message' => 'Group name and questions are required']);
            return;
        }

        // Save group and associate questions
        $saved = $this->View_model->save_group_with_questions($group_name, $question_ids);

        if ($saved) {
            echo json_encode(['status' => true, 'message' => 'Group saved successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to save group']);
        }
    }


    // Get saved groups with questions
    public function get_groups()
    {
        $groups = $this->View_model->get_all_groups_with_questions();
        echo json_encode($groups);
    }
    public function group_detail($group_id)
    {
        $this->load->model('View_model');

        $group = $this->View_model->get_group_by_id($group_id);
        $questions = $this->View_model->get_questions_by_group($group_id);

        if ($group) {
            $group['questions'] = $questions;
            $this->load->view('group_detail', ['group' => $group]);
        } else {
            show_404();
        }
    }

    
    public function save_group_feedback()
    {
        header('Content-Type: application/json'); // Important: Ensure JSON header

        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input) {
            echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
            return;
        }

        $group_id = $input['group_id'] ?? null;
        $email = $input['email'] ?? null;
        $feedback = $input['feedback'] ?? [];

        if (!$group_id || !$email || empty($feedback)) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            return;
        }

        $this->load->model('View_model');

        foreach ($feedback as $entry) {
            $this->View_model->save_feedback([
                'group_id' => $group_id,
                'question_id' => $entry['question_id'],
                'email' => $email,
                'rating' => $entry['rating'],
                'reply' => $entry['reply']
            ]);
        }

        echo json_encode(['success' => true]);
    }



    public function feedback_answer()
    {
        $this->load->view('templates/header');
        $this->load->view('feedback_answer');
        $this->load->view('templates/footer');
    }
    public function get_feedback_answers_json()
    {
        $this->load->model('View_model');
        $answers = $this->View_model->get_feedback_answers_with_details();
        echo json_encode($answers);
    }
}
