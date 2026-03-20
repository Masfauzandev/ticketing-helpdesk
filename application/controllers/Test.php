<?php
class Test extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/Ticket_model', 'Tickets');
    }
    public function get_all() {
        $options = [
            'draw' => '1',
            'start' => '0',
            'length' => '10',
            'columns' => [
                ['data' => 'id'],
                ['data' => 'ticket_no'],
                ['data' => 'ticket_no'],
                ['data' => 'subject'],
                ['data' => 'title'],
                ['data' => 'severity'],
                ['data' => 'status'],
                ['data' => 'category'],
                ['data' => 'owner'],
                ['data' => 'assign_to'],
                ['data' => 'created'],
            ],
            'order' => [
                ['column' => '10', 'dir' => 'desc']
            ],
            'filters' => []
        ];
        $dt = $this->Tickets->getDataTable($options);
        $context = ['action' => 'list_my_tickets', 'type' => 1, 'uid' => 'admin', 'username' => 'admin'];
        $data = $dt->getDataTableData($context, $options);
        header('Content-Type: application/json');
        file_put_contents('test.log', json_encode($data, JSON_INVALID_UTF8_IGNORE));
    }
}
