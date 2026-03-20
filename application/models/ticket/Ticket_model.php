<?PHP

require __DIR__ . "/constants.php";



class Ticket_model extends BaseMySQL_model
{

    public function __construct()
    {
        parent::__construct(TABLE_TICKETS);
        $this->load->model("core/Session_model", "Session");
        $this->load->model("user/User_model", "User");
        $this->load->model("notification/Email_model", "Email");
    }

    public function test()
    {
        $threadId = 2;
        $from = "test_user";
        $to = "test_admin";
        //status 1 = open, 0 = closed
        $data = array(
            "threadid" => $threadId,
            "from" => $from,
            "to" => $to,
            "subject" => "start subject thread",
            "body" => 'hello,  test body',
            "seen_status" => 0,
        );
        $tId = $this->create($data);

        $data2 = array(
            "threadid" => $threadId,
            "from" => $to,
            "to" => $from,
            "subject" => "start subject thread",
            "body" => 'hello,  test body',
            "seen_status" => 0,
        );
        $tId2 = $this->create($data2);

        $data3 = array(
            "threadid" => $threadId,
            "from" => $from,
            "to" => $to,
            "subject" => "start subject thread",
            "body" => 'hello,  test body',
            "seen_status" => 0,
        );
        $tId3 = $this->create($data3);

        if ($tId) {
            echo "Ticket create() ---> successfull";
        } else {
            echo "Ticket create() ---> ERROR!";
        }

        $updateData = array(
            "seen_status" => 1
        );
        $updateRes = $this->update($tId, $updateData);
        if ($updateRes) {
            echo "Ticket update() ---> Successfull";
        } else {
            echo "Ticket update() ---> Error";
        }

        $ticket = $this->get(array('id' => $tId));
        if (count($ticket) > 0) {
            echo "Ticket --> get() --> Successfull!";
        } else {
            echo "Ticket --> get() --> ERROR!";
        }

        if ($ticket[0]['seen_status'] == $updateData['seen_status']) {
            echo "Ticket --> update() --> Successfull!";
        } else {
            echo "Ticket --> update() --> ERROR";
        }


        $this->deleteById($tId);

    }

    public function getByThread($tId)
    {
        $query = array('threadid' => $tId);
        return parent::getBy("*", $query);
    }

    public function getTicketNoFromID($id)
    {
        if (!$id)
            return "-";
        return CLIENT_TICKET_PREFIX . $this->pad($id, CLIENT_TICKET_ID_LENGTH);
    }
    public function pad($num, $size)
    {
        $s = (string) (1000000 + (int) $num);
        return substr($s, strlen($s) - $size);
    }

    public function create($data)
    {
        $info = getValuesOfKeys($data, array(
            'owner',
            'purpose',
            'subject',
            'title',
            'message',
            'assign_to',
            'assign_on',
            'severity',
            'priority',
            'category',
            'cc',
            'data'
        ));

        // Simpan dulu data mentah (buat attachment ref), lalu tambahkan created_by, lalu encode ke DB
        $rawData = isset($info['data']) ? $info['data'] : null;          // bisa array / null

        // simpan siapa yang membuat tiket (supaya notifikasi selalu terkirim ke pembuat tiket)
        $loggedCreate = $this->Session->getLoggedDetails();
        $creatorUsername = isset($loggedCreate['username']) ? $loggedCreate['username'] : '';
        $creatorEmail = isset($loggedCreate['email']) ? $loggedCreate['email'] : '';

        if (!is_array($rawData))
            $rawData = array();
        if ($creatorUsername !== '' && empty($rawData['created_by'])) {
            $rawData['created_by'] = $creatorUsername;
        }
        if ($creatorEmail !== '' && empty($rawData['created_by_email'])) {
            $rawData['created_by_email'] = $creatorEmail;
        }

        $info['data'] = json_encode($rawData);

        // Default owner kalau kosong
        if (empty($info['owner'])) {
            $logged = $this->Session->getLoggedDetails();
            $info['owner'] = isset($logged['username']) ? $logged['username'] : '';
        }

        // Handle category array - convert to JSON string if it's an array
        if (isset($info['category']) && is_array($info['category'])) {
            // Remove null values and convert to JSON
            $info['category'] = json_encode(array_filter($info['category'], function ($val) {
                return $val !== 'null' && $val !== null;
            }));
        }

        // Validasi minimal
        if (!empty($info['subject']) && !empty($info['message'])) {

            $info = array_merge($info, array(
                'ticket_no' => NULL,
                'created' => time(),
                'status' => TICKET_STATUS_OPEN
            ));

            $res = parent::add($info);

            if ($res) {
                $ticket_no = $this->getTicketNoFromID($res);
                parent::setByID($res, array('ticket_no' => $ticket_no));

                // ✅ add attachment reference (SAFE)
                // rawData biasanya bentuknya: ['attachments' => [ ... ]]
                if (is_array($rawData) && !empty($rawData['attachments']) && is_array($rawData['attachments'])) {
                    $this->addAttachmentRef($rawData['attachments'], $ticket_no);
                }

                // ✅ send update email (SAFE + CC rapi)
                if (defined('EMAIL_NOTIFICATIONS_ENABLED') && EMAIL_NOTIFICATIONS_ENABLED === true) {

                    $usernames = array();

                    if (!empty($info['owner'])) {
                        $usernames[] = $info['owner'];
                    }

                    // pastikan pembuat tiket juga dapat notifikasi
                    $logged = $this->Session->getLoggedDetails();
                    if (!empty($logged['username'])) {
                        $usernames[] = $logged['username'];
                    }
                    if (!empty($logged['email'])) {
                        $usernames[] = $logged['email'];
                    }

                    $ccRaw = isset($info['cc']) ? $info['cc'] : '';
                    if (!empty($ccRaw)) {
                        $ccList = array_filter(array_map('trim', explode(';', (string) $ccRaw)));
                        $usernames = array_merge($usernames, $ccList);
                    }

                    // hilangkan duplikat + nilai kosong
                    $usernames = array_values(array_unique(array_filter($usernames)));

                    if (!empty($usernames)) {
                        $this->sendUpdateEmail(
                            $usernames,
                            '[#' . $ticket_no . '] ' . $info['subject'],
                            $info['message']
                        );
                    }
                }

                return $ticket_no;
            }

        } else {
            $res = -1;
        }

        return $res;
    }


    public function addAttachmentRef($attachments, $ref)
    {
        if ($attachments && !empty($attachments)) {
            $attach_ref = array();
            foreach ($attachments as $attachment) {
                array_push($attach_ref, array('ref' => $ref, 'name' => $attachment['file_name'], 'path' => $attachment['path'], 'uploaded_by' => $this->Session->getLoggedDetails()['username']));
            }

            return $this->db->insert_batch('attachments', $attach_ref);
        }
    }

    public function updateTicket($data, $meta)
    {
        if (empty($data['id']))
            return -1;

        // Handle category array - convert to JSON string if it's an array
        if (isset($data['category']) && is_array($data['category'])) {
            $data['category'] = json_encode($data['category']);
        }

        $data['updated'] = time();
        $res = parent::setByID($data['id'], $data);

        $info = parent::getBy(array('owner', 'cc', 'ticket_no', 'subject'), array('id' => $data['id']));

        // ✅ send update Email (FULL)
        if (
            $res &&
            defined('EMAIL_NOTIFICATIONS_ENABLED') && EMAIL_NOTIFICATIONS_ENABLED === true &&
            !empty($info) && isset($info[0])
        ) {
            $t = $info[0];

            $usernames = array();

            if (!empty($t['owner']))
                $usernames[] = $t['owner'];

            // tambahkan pembuat tiket (dari kolom data JSON)
            $tData = array();
            if (!empty($t['data'])) {
                $decoded = json_decode($t['data'], true);
                if (is_array($decoded))
                    $tData = $decoded;
            }
            if (!empty($tData['created_by']))
                $usernames[] = $tData['created_by'];
            if (!empty($tData['created_by_email']))
                $usernames[] = $tData['created_by_email'];

            $ccRaw = isset($t['cc']) ? $t['cc'] : '';
            if (!empty($ccRaw)) {
                $ccList = array_filter(array_map('trim', explode(';', (string) $ccRaw)));
                $usernames = array_merge($usernames, $ccList);
            }

            $usernames = array_values(array_unique(array_filter($usernames)));

            if (!empty($usernames)) {
                $plain = isset($meta['plain_txt_message']) ? $meta['plain_txt_message'] : 'Ticket updated.';

                $this->sendUpdateEmail(
                    $usernames,
                    '[#' . $t['ticket_no'] . '] ' . (isset($t['subject']) ? $t['subject'] : ''),
                    'Update:<br>' . $plain
                );
            }
        }

        return $res;
    }


    public function getAllCategories()
    {
        // Fetch from DB
        $results = $this->db->where('is_active', 1)->order_by('id', 'ASC')->get('mst_category')->result();
        $categories = array();
        foreach ($results as $row) {
            // Use ID as index if possible, but the original was 0-indexed array.
            // Since we inserted with IDs 0..7, we can just push to array or use ID as key.
            // Ideally we return simple array of strings ['Bug', 'Feature...']
            $categories[$row->id] = $row->name;
        }
        return $categories;
    }

    public function getAllSubjects()
    {
        $results = $this->db->where('is_active', 1)->order_by('id', 'ASC')->get('mst_subject')->result();
        $subjects = array();
        foreach ($results as $row) {
            $subjects[$row->id] = $row->name;
        }
        return $subjects;
    }

    public function getAllPriorities()
    {
        return TICKET_PRIORITIES; // Still constant as requested
    }

    public function getAllSeverities()
    {
        // Fetch from DB: [{severity_val: 0, severity_name: 'Low'}, ...]
        $results = $this->db->where('is_active', 1)->order_by('severity_val', 'ASC')->get('mst_severity')->result_array();

        $severities = array();
        foreach ($results as $row) {
            $severities[] = array(
                'value' => (int) $row['severity_val'],
                'label' => $row['severity_name']
            );
        }
        return $severities;
    }
    public function getAllStatus()
    {
        return TICKET_STATUS;
    }

    public function get($data)
    {
        return parent::getBy("*", $data);
    }

    public function getAllTickets()
    {
        return parent::getAll("*");
    }

    public function deleteById($tId)
    {
        $query = array('id' => $tId);
        return parent::deleteBy($query);
    }

    public function add_thread($data, $sendEmail = TRUE)
    {
        $res = $this->db->insert(TABLE_MESSAGES, $data);

        // Ambil data ticket untuk subject + owner + cc
        $info = parent::getBy(array('owner', 'cc', 'ticket_no', 'subject'), array('ticket_no' => $data['ticket']));

        // ✅ send update Email (FULL)
        if (
            $res &&
            $sendEmail === TRUE &&
            defined('EMAIL_NOTIFICATIONS_ENABLED') && EMAIL_NOTIFICATIONS_ENABLED === true &&
            !empty($info) && isset($info[0])
        ) {
            $t = $info[0];

            $usernames = array();

            // penerima utama: owner ticket
            if (!empty($t['owner']))
                $usernames[] = $t['owner'];

            // tambahkan pembuat tiket (dari kolom data JSON)
            $tData = array();
            if (!empty($t['data'])) {
                $decoded = json_decode($t['data'], true);
                if (is_array($decoded))
                    $tData = $decoded;
            }
            if (!empty($tData['created_by']))
                $usernames[] = $tData['created_by'];
            if (!empty($tData['created_by_email']))
                $usernames[] = $tData['created_by_email'];

            // penerima: yg reply (supaya dia juga dapat thread, opsional)
            if (!empty($data['owner']))
                $usernames[] = $data['owner'];

            // penerima: cc ticket
            $ccRaw = isset($t['cc']) ? $t['cc'] : '';
            if (!empty($ccRaw)) {
                $ccList = array_filter(array_map('trim', explode(';', (string) $ccRaw)));
                $usernames = array_merge($usernames, $ccList);
            }

            // bersihkan list
            $usernames = array_values(array_unique(array_filter($usernames)));

            if (!empty($usernames)) {
                $fromUser = !empty($data['owner']) ? $data['owner'] : 'system';
                $msgBody = 'From @' . $fromUser . ':<br>' . (isset($data['message']) ? $data['message'] : '');

                $this->sendUpdateEmail(
                    $usernames,
                    '[#' . $t['ticket_no'] . '] ' . (isset($t['subject']) ? $t['subject'] : ''),
                    $msgBody
                );
            }
        }

        return $res;
    }


    /**
     * Process mails from IMAP endpoint, process the content and accordingly create reply messages or new tickets
     */
    public function processIMAPEmail($data)
    {

        $subject = $data['subject'];

        $owner = $this->User->getBy(array('username'), array('email' => $data['from'][0]['address']));
        if (empty($owner))
            $owner = $data['from'][0]['address']; // user's email address     
        else
            $owner = $owner[0]['username'];
        if (substr($subject, 0, 2) === '[#' || substr($subject, 0, 6) === 'Re: [#' || substr($subject, 0, 6) === 'RE: [#') //is a reply to existing mail thread 
        {
            print_r('Replying to thread based on ticket number in to subject line');
            $message_thread = array('created' => time());
            preg_match_all("/\[([^\]]*)\]/", $subject, $matches);
            $message_thread['ticket'] = substr($matches[1][0], 1, strlen($matches[1][0]));
            $message_thread['message'] = $this->Email->getCurrentEmailContent($data['text']);

            $message_thread['owner'] = $owner;
            $message_thread['type'] = 1; //message type

            $message_thread['to'] = array();
            if (!empty($data['cc'])) {
                foreach ($data['cc'] as $cc) {
                    array_push($message_thread['to'], $cc['address']);
                }
            }

            $message_thread['to'] = implode(';', $message_thread['to']);
            // $message_thread['data']['attachment'] = TODO attachments download and attach with this message

            print_r($message_thread);
            return $this->add_thread($message_thread);
        } else {
            $to_addresses = array();
            if (!empty($data['to'])) { // create new ticket if mail came to specific helpdesk email
                foreach ($data['to'] as $to) {
                    array_push($to_addresses, $to['address']);
                }
                if (in_array(CLIENT_HELPDESK_EMAIL, $to_addresses)) {
                    print_r('Creating a new ticket via' . CLIENT_HELPDESK_EMAIL);
                    $ticket = array(
                        'created' => time(),
                        'subject' => $data['subject'],
                        'message' => $this->Email->getCurrentEmailContent($data['text']),
                        'owner' => $owner
                    );

                    $ticket['cc'] = array();
                    if (!empty($data['cc'])) {
                        foreach ($data['cc'] as $cc) {
                            array_push($ticket['cc'], $cc['address']);
                        }
                    }
                    $ticket['cc'] = implode(';', $ticket['cc']);
                    // $ticket['data']['attachment'] = TODO attachments download and attach with this message
                    print_r($ticket);
                    return $this->create($ticket);
                } else {
                    foreach ($to_addresses as $to) {
                        $username = explode('@', $to)[0];
                        // check if username is ticket id ?
                        $ticket = parent::getBy(array('ticket_no'), array('ticket_no' => $username));
                        if (!empty($ticket)) {
                            // This is redundant, need to arrange this code.
                            print_r('Replying to thread based on ticket number in to field');
                            $message_thread = array('created' => time());
                            $message_thread['ticket'] = $ticket[0]['ticket_no'];
                            $message_thread['message'] = $this->Email->getCurrentEmailContent($data['text']);

                            $message_thread['owner'] = $owner;
                            $message_thread['type'] = 1; //message type

                            $message_thread['to'] = array();
                            if (!empty($data['cc'])) {
                                foreach ($data['cc'] as $cc) {
                                    array_push($message_thread['to'], $cc['address']);
                                }
                            }

                            $message_thread['to'] = implode(';', $message_thread['to']);
                            // $message_thread['data']['attachment'] = TODO attachments download and attach with this message

                            print_r($message_thread);
                            return $this->add_thread($message_thread);
                        }

                    }
                }
            }

        }



    }

    //TODO: should this be in User_model? but this is Ticket specific only
    public function getEmailFromUsername($username)
    {
        if (!$this->checkIfEmail($username))
            return $username . '@' . CLIENT_DOMAIN;
        else
            return $username;
    }

    public function getUsernameFromEmail($email)
    {
        if (!$this->checkIfEmail($email)) {
            $split = explode('@', $email);
            $domain = $split[1];
            if ($domain == CLIENT_DOMAIN)
                return $split[0];
        }
        return $email;
    }

    public function sendUpdateEmail($users, $subject, $message)
    {
        // normalize users: array atau string "a;b;c"
        if (!is_array($users)) {
            $users = preg_split('/[;,]+/', (string) $users, -1, PREG_SPLIT_NO_EMPTY);
        }

        // build recipient list
        $to_emails = array();
        foreach ((array) $users as $user) {
            $user = trim((string) $user);
            if ($user === '')
                continue;

            $email = $this->getEmailFromUsername($user);
            $email = trim((string) $email);

            if ($email !== '' && $this->checkIfEmail($email)) {
                // unique case-insensitive
                $to_emails[strtolower($email)] = $email;
            }
        }

        $to_emails = array_values($to_emails);
        if (empty($to_emails))
            return false;

        // kalau message bukan HTML, rapikan jadi HTML aman
        $msg = (string) $message;
        if ($msg !== strip_tags($msg)) {
            // sudah ada HTML
            $html = $msg;
        } else {
            $html = nl2br(htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'));
        }

        $footer = defined('CLIENT_MAIL_FOOTER') ? CLIENT_MAIL_FOOTER : '';
        return $this->Email->send($to_emails, CLIENT_FROM_EMAIL, $subject, $html . $footer, CLIENT_REPLYTO_EMAIL);
    }


    // checks if string is email.
    function checkIfEmail($str)
    {
        if (filter_var($str, FILTER_VALIDATE_EMAIL))
            return TRUE;
        else
            return FALSE;
    }

    public function makeDatatableQuery($table, $context, $db, $arguments = null)
    {

        return array(
            'columns' => array(
                'id' => TABLE_TICKETS . ".id",
                'ticket_no' => TABLE_TICKETS . ".ticket_no",
                'owner' => TABLE_TICKETS . '.owner',
                'severity' => TABLE_TICKETS . '.severity',
                'priority' => TABLE_TICKETS . '.priority',
                'category' => TABLE_TICKETS . '.category',
                'created' => TABLE_TICKETS . '.created',
                'purpose' => TABLE_TICKETS . '.purpose',
                'subject' => TABLE_TICKETS . '.subject',
                'title' => TABLE_TICKETS . '.title',
                'message' => TABLE_TICKETS . '.message',
                'status' => TABLE_TICKETS . '.status',
                'assign_to' => TABLE_TICKETS . '.assign_to',
                'assign_on' => TABLE_TICKETS . '.assign_on',
                'progress' => TABLE_TICKETS . '.progress',
                'updated' => TABLE_TICKETS . '.updated'
            ),
        );
    }

}
