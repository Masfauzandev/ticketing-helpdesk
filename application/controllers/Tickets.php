<?php

class Tickets extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        parent::requireLogin();
        $this->setHeaderFooter('global/header.php', 'global/footer.php');
        $this->load->model('ticket/Ticket_model', 'Tickets');
        $this->load->model('user/User_model', 'Users');
        $this->load->model('ticket/Messages_model', 'Messages');
    }

    public function create_new()
    {
        $data['title'] = 'New Ticket';
        $this->load->model('user/User_model', 'Users');
        $data['users'] = $this->Users->getAllUsers();
        $data['subjects'] = SUBJECTS;
        $this->render('New Ticket', 'ticket/create_new', $data);
    }

    public function submit_new()
    {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->load->model('user/User_model', 'Users');

        $data = [
            'ticket_no' => '' . strtoupper(uniqid()),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'owner' => $this->Session->getLoggedDetails()['username'],
            'assign_to' => $this->input->post('assign_to'),
            'status' => 0,
            'created' => time(),
            'updated' => time()
        ];

        $this->Tickets->add($data);

        // ✅ Kirim email ke user yang di-assign
        $assign_id = $this->input->post('assign_to');
        $assign_user = $this->Users->getByID($assign_id);

        if ($assign_user && !empty($assign_user['email'])) {
            $this->load->library('email');

            $this->email->from('no-reply@yourdomain.com', 'Ticketing System');
            $this->email->to($assign_user['email']);
            $this->email->subject('Tiket Baru Ditugaskan');
            $this->email->message(
                "Halo {$assign_user['name']},\n\n" .
                "Anda telah ditugaskan tiket baru:\n\n" .
                "Judul: {$data['title']}\n" .
                "Deskripsi: {$data['description']}\n\n" .
                "Silakan login ke sistem untuk menindaklanjuti tiket ini."
            );

            if (!$this->email->send()) {
                log_message('error', 'Gagal kirim email ke ' . $assign_user['email']);
            }
        }

        // ✅ Redirect setelah submit
        redirect('Tickets/my_tickets');
    } else {
        show_404();
    }
    }

    public function list_all()
    {
        $data['title'] = 'All Tickets';
        $data['type']="all_tickets";
        $this->render('My Tickets', 'ticket/my_tickets', $data);
    }

    public function my_tickets()
    {
        $data['title'] = 'My Tickets';
        $data['type']="my_tickets";
        $this->render('My Tickets', 'ticket/my_tickets', $data);
    }

    public function assigned_to_me()
    {
        $data['title'] = 'Tickets assigned to me';
        $data['type'] = "assigned_to_me";
        $this->render('My Tickets', 'ticket/my_tickets', $data);
    }
    public function cc_to_me()
    {
        $data['title'] = 'Tickets followed by me';
        $data['type'] = "cc_to_me";
        $this->render('My Tickets', 'ticket/my_tickets', $data);
    }
    public function assigned_tickets()
    {
        $data['title'] = 'Assigned Tickets';
        $data['type'] = "assigned";
        $this->render('My Tickets', 'ticket/my_tickets', $data);
    }
    public function unassigned_tickets()
    {
        $data['title'] = 'Unassigned Tickets';
        $data['type'] = "unassigned";
        $this->render('My Tickets', 'ticket/my_tickets', $data);
    }

    public function closed_tickets()
    {
        $data['title'] = 'Closed Tickets';
        $data['type'] = "closed";
        $this->render('My Tickets', 'ticket/my_tickets', $data);
    }

    public function view_ticket()
    {
        
        $ticket = $this->uri->segment(3);
        $data['title'] = 'View Ticket';
        $usertype = $this->Session->getLoggedDetails()['type'];
        $data['privilege'] = ($usertype==USER_MANAGER || $usertype == USER_ADMIN)? true : false;
        if (!$ticket) {
            $this->render('View Ticket', 'unauthorised', $data);
        } else {
            $data['ticket_no'] = $ticket;
            $data['info'] = $this->Tickets->getBy(null,['ticket_no' => $ticket])[0];
            $data['messages'] = $this->Messages->getBy(null, ['ticket' => $ticket]);
            $this->render('View Ticket', 'ticket/view_ticket', $data);
        }
    }

}