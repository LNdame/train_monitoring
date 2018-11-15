<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('ClientID', 'Name', 'Email')) {
            $allowed = array(
            );
            if (!in_array($this->router->fetch_method(), $allowed)) {
                redirect('/login');
            }
        }
    }

    public function home() {
        $this->form_validation->set_rules('e_date', 'End Date', 'trim|callback_compareDates');
        $this->form_validation->set_rules('e_time', 'End Date', 'trim|callback_compareTime');
        if ($this->form_validation->run() == false) {
            $this->home_();
        } else {
           $this->home_();
        }
    }

    public function home_() {
        $startDate = $this->input->post('s_date');
        $endDate = $this->input->post('e_date');
        $startTime = $this->input->post('s_time');
        $endTime = $this->input->post('e_time');
        $en_id = $this->input->post('engine');
        if($this->input->post('engine') == "all")
            {
             $engines ['eng_chart'] = $this->ClientModel->get_all($startDate, $endDate, $startTime, $endTime);
        }
        else{
        $engines ['eng_chart'] = $this->ClientModel->get_chart($startDate, $endDate, $startTime, $endTime, $en_id);
        }

        $engines ['eng_chart_all'] = $this->ClientModel->get_chart_all();

        $engines ['count'] = $this->ClientModel->count($startDate, $endDate, $startTime, $endTime, $en_id);
        $engines['engs'] = $this->ClientModel->get_engines();
        $engines['engs_'] = $this->ClientModel->get_engines2();
        $this->load->view('layout/header', $engines);
        $this->load->view('pages/client_graph', $engines);
        $this->load->view('layout/footer', $engines);
    }
    public function dashboard() {
        $this->load->view('layout/header');
        $this->load->view('pages/client_dashboard');
        $this->load->view('layout/footer');
    }
    public function table() {
        $this->form_validation->set_rules('e_date', 'End Date', 'trim|callback_compareDates');
        $this->form_validation->set_rules('e_time', 'End Date', 'trim|callback_compareTime');
        if ($this->form_validation->run() == false) {
            $this->table_();
        } else {
           $this->table_();
        }
    }
    public function table_() {
        $startDate = $this->input->post('s_date');
        $endDate = $this->input->post('e_date');
        $startTime = $this->input->post('s_time');
        $endTime = $this->input->post('e_time');
        $en_id = $this->input->post('engine');
        if($this->input->post('engine') == "all")
            {
             $engines ['eng_table'] = $this->ClientModel->get_all($startDate, $endDate, $startTime, $endTime);
        }
        else{
        $engines ['eng_table'] = $this->ClientModel->get_chart($startDate, $endDate, $startTime, $endTime, $en_id);
        }
        $engines['engs'] = $this->ClientModel->get_engines();
        $engines['engs_'] = $this->ClientModel->get_engines2();
        $this->load->view('layout/header', $engines);
        $this->load->view('pages/client_table', $engines);
        $this->load->view('layout/footer', $engines);
    }

    function compareDates() {
        $start = $this->input->post('s_date');
        $end = $this->input->post('e_date');
        if ($start > $end) {
            $this->form_validation->set_message('compareDates', 'Your start date must be earlier than your end date');
            return false;
        }
    }

    function compareTime() {
        $start = $this->input->post('s_time');
        $end = $this->input->post('e_time');
        if ($start > $end) {
            $this->form_validation->set_message('compareTime', 'Your start time must be earlier than your end time');
            return false;
        }
    }

}
