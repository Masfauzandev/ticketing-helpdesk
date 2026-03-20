<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ticket/Ticket_model', 'ticket');
        $this->load->model('core/Session_model', 'Session');
        $this->load->model('user/User_model', 'User');
        
        if (!$this->Session->isLoggedin()) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $filters = array();
        if ($this->input->get('status') !== null && $this->input->get('status') !== '') {
            $filters['status'] = $this->input->get('status');
        }
        if ($this->input->get('category') !== null && $this->input->get('category') !== '') {
            $filters['category'] = $this->input->get('category');
        }
        if ($this->input->get('severity') !== null && $this->input->get('severity') !== '') {
            $filters['severity'] = $this->input->get('severity');
        }
        if ($this->input->get('assign_to') !== null && $this->input->get('assign_to') !== '') {
            $filters['assign_to'] = $this->input->get('assign_to');
        }
        if ($this->input->get('owner') !== null && $this->input->get('owner') !== '') {
            $filters['owner'] = $this->input->get('owner');
        }
        if ($this->input->get('subject') !== null && $this->input->get('subject') !== '') {
            $filters['subject'] = $this->input->get('subject');
        }
        
        $data['tickets'] = $this->ticket->get($filters);
        
        $data['categories'] = $this->ticket->getAllCategories();
        $data['subjects'] = $this->ticket->getAllSubjects();
        
        $data['severities'] = array();
        $sevs = $this->ticket->getAllSeverities();
        foreach($sevs as $s) {
            $data['severities'][$s['value']] = $s['label'];
        }
        
        $data['users'] = $this->User->getAll("username, name");
        
        $data['title'] = 'Laporan';
        $this->load->view('global/header', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('global/footer', $data);
    }
}
