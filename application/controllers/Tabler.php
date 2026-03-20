<?PHP

class Tabler extends MY_Tabler
{


    public function __construct()
    {
        parent::__construct();
        parent::requireLogin();
        $this->load->model('code/Session_model', 'Session');
    }


    public function list_my_tickets()
    {
        $this->load->model('ticket/Ticket_model', 'Tickets');
        $filter = array();
        $username = $this->Session->getLoggedDetails()['username'];
        // if (isset($_GET['username']) && $_GET['username'])
        // 	$filter['owner'] = $_GET['username'];

        if (!in_array((int) $this->Session->getLoggedDetails()['type'], array(USER_MANAGER, USER_ADMIN, USER_AGENT)))
            $filter['owner'] = $username;

        if (isset($_GET['type']) && $_GET['type']) {
            $type = $_GET['type'];
            if ($type == "my_tickets")
                $filter['owner'] = $username;
            else if ($type == "open")
                $filter['status'] = TICKET_STATUS_OPEN;
            else if ($type == "assigned_to_me")
                $filter['assign_to'] = $username;
            else if ($type == "cc_to_me")
                $filter['cc LIKE'] = '%' . $username . '%';
            else if ($type == "assigned")
                $filter['status'] = TICKET_STATUS_ASSIGNED;
            else if ($type == "unassigned")
                $filter['status'] = TICKET_STATUS_OPEN;
            else if ($type == "closed")
                $filter['status'] = TICKET_STATUS_CLOSED;
            else if ($type == "in_progress")
                $filter['status'] = TICKET_STATUS_IN_PROGRESS;
            else if ($type == "on_hold")
                $filter['status'] = TICKET_STATUS_ON_HOLD;
            else if ($type == "cancelled")
                $filter['status'] = TICKET_STATUS_CANCELLED;
        }



        $subjects = $this->Tickets->getAllSubjects();
        $subject_names = array_values($subjects);
        $subject_enum = empty($subject_names) ? array() : array_combine($subject_names, $subject_names);

        return $this->handler($this->Tickets, __FUNCTION__, array(), array(
            "assign_to" => [
                "title" => "Assigned To",
                "type" => "string"
            ],
            "status" => [
                "title" => "Status",
                "type" => "string",
                "enum" => array_column($this->Tickets->getAllStatus(), 'value', 'label')
            ],
            "subject" => [
                "title" => "Subject",
                "type" => "string",
                "enum" => $subject_enum
            ],
            "severity" => [
                "title" => "Severity",
                "type" => "string",
                "enum" => array_column($this->Tickets->getAllSeverities(), 'value', 'label')
            ],
            "category" => [
                "title" => "Category",
                "type" => "string",
                "enum" => array_flip($this->Tickets->getAllCategories())
            ]

        ), $filter, array(
        ));
    }

    public function list_users()
    {
        $this->load->model('user/User_model', 'Users');
        return $this->handler($this->Users, __FUNCTION__, array(), array(), array(), array(
        ));
    }

}
