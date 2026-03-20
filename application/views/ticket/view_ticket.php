<script>

</script>
<div class="container fluid-content ">
    <div class="row ">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <!-- Pre-process data -->
                    <?PHP
                    $decoded = json_decode($info['data'], true);

                    // Check if ticket is locked (Closed or Cancelled for more than 1 day)
                    $is_locked = false;
                    $closed_at = isset($info['closed_at']) ? $info['closed_at'] : null;
                    if (($info['status'] == 100 || $info['status'] == 120) && $closed_at) {
                        $one_day_ago = time() - (24 * 60 * 60);
                        if ($closed_at < $one_day_ago) {
                            $is_locked = true;
                        }
                    }

                    $resolve = isset($info['resolve']) ? $info['resolve'] : '';
                    $reason = isset($info['reason']) ? $info['reason'] : '';
                    ?>

                    <!-- Header Design V2 -->
                    <!-- Load Custom CSS for Ticket View -->
                    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/ticket_view.css?v=<?= time() ?>">

                    <?PHP
                    // Determine status color
                    $status_color = '#00c292'; // Default Green (Open)
                    if ($info['status'] == 100) { // Closed
                        $status_color = '#fc4b6c'; // Red
                    } elseif ($info['status'] == 75) { // On Hold
                        $status_color = '#6c757d'; // Grey
                    } elseif ($info['status'] == 50) { // Assigned
                        $status_color = '#1e88e5'; // Blue
                    } elseif ($info['status'] == 25) { // In Progress
                        $status_color = '#007bff'; // Primary Blue
                    } elseif ($info['status'] == 120) { // Cancelled
                        $status_color = '#343a40'; // Dark
                    }
                    ?>
                    <div class="ticket-header-wrapper">
                        <div class="d-inline-block text-center ticket-status-badge"
                            style="background-color: <?= $status_color ?>;">
                            <span class="text-uppercase"
                                data-value="<?= $info['status'] ?>"><?= array_search($info['status'], array_column(TICKET_STATUS, 'value', 'label')) ?: 'STATUS' ?></span>
                        </div>
                    </div>

                    <div class="card custom-border-radius m-0 ticket-card">
                        <div class="px-4 py-4">
                            <!-- Ticket No & Subject -->
                            <div class="mb-2">
                                <span class="badge ticket-number-badge"><?= $info['ticket_no'] ?></span>
                            </div>

                            <h2 class="mt-2 mb-2 ticket-subject">
                                <?= $info['title'] ?>
                            </h2>
                            <div class="mb-4">
                                <span class="badge badge-info" style="font-size: 14px; font-weight: normal;"><i class="fa fa-tag"></i> <?= $info['subject'] ?></span>
                            </div>

                            <!-- Description -->
                            <div class="mt-3">
                                <strong class="ticket-label">Description :</strong>
                                <p class="mt-2 ticket-description-text">
                                    <?= $info['message'] ?>
                                </p>
                            </div>

                            <!-- Resolve Section (shown only if ticket is closed and resolve exists) -->
                            <?php if ($info['status'] == 100 && !empty($resolve)): ?>
                                <div class="mt-4 p-3"
                                    style="background-color: #f8f9fa; border-left: 4px solid #28a745; border-radius: 4px;">
                                    <strong class="ticket-label" style="color: #28a745;"><i class="fa fa-check-circle"></i>
                                        Resolution :</strong>
                                    <p class="mt-2 mb-0">
                                        <?= nl2br(htmlspecialchars($resolve)) ?>
                                    </p>
                                    <?php
                                    // Display resolve attachments if they exist
                                    $resolve_attachments = isset($decoded['resolve_attachments']) && is_array($decoded['resolve_attachments']) ? $decoded['resolve_attachments'] : array();
                                    if (!empty($resolve_attachments)):
                                        ?>
                                        <div class="mt-3">
                                            <strong class="small">Attachments:</strong>
                                            <div class="d-flex flex-wrap mt-2">
                                                <?php foreach ($resolve_attachments as $attachment): ?>
                                                    <div class="d-flex align-items-center mr-3 mb-2">
                                                        <i class="fa fa-paperclip mr-1" style="color: #28a745;"></i>
                                                        <a href="<?= base_url() . $attachment['path'] ?>" target="_blank"
                                                            class="small">
                                                            <?= $attachment['file_name'] ?>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Reason Section (shown only if ticket is On Hold or Cancelled and reason exists) -->
                            <?php if (($info['status'] == 75 || $info['status'] == 120) && !empty($reason)): ?>
                                <div class="mt-4 p-3"
                                    style="background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
                                    <strong class="ticket-label" style="color: #856404;"><i class="fa fa-info-circle"></i>
                                        Reason :</strong>
                                    <p class="mt-2 mb-0">
                                        <?= nl2br(htmlspecialchars($reason)) ?>
                                    </p>
                                    <?php
                                    // Display reason attachments if they exist
                                    $reason_attachments = isset($decoded['reason_attachments']) && is_array($decoded['reason_attachments']) ? $decoded['reason_attachments'] : array();
                                    if (!empty($reason_attachments)):
                                        ?>
                                        <div class="mt-3">
                                            <strong class="small">Attachments:</strong>
                                            <div class="d-flex flex-wrap mt-2">
                                                <?php foreach ($reason_attachments as $attachment): ?>
                                                    <div class="d-flex align-items-center mr-3 mb-2">
                                                        <i class="fa fa-paperclip mr-1" style="color: #856404;"></i>
                                                        <a href="<?= base_url() . $attachment['path'] ?>" target="_blank"
                                                            class="small">
                                                            <?= $attachment['file_name'] ?>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Attachments Footer -->
                        <?PHP
                        $attachments = (isset($decoded['attachments']) && is_array($decoded['attachments'])) ? $decoded['attachments'] : array();
                        ?>
                        <div class="px-4 py-3 ticket-attachment-footer">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong class="ticket-attachment-label m-0">Attachment :</strong>
                                <?php if (!$is_locked): ?>
                                    <button class="btn btn-sm btn-outline-primary" id="btnAddHeaderAttachment"
                                        type="button">
                                        <i class="fa fa-plus"></i> Add
                                    </button>
                                    <input type="file" id="headerAttachmentInput" style="display: none;">
                                <?php else: ?>
                                    <span class="badge badge-warning">Ticket Locked</span>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex flex-wrap" id="headerAttachmentList">
                                <?php if (empty($attachments)): ?>
                                    <span class="text-muted small" id="no-attachments-msg">No attachments.</span>
                                <?php endif; ?>

                                <?php foreach ($attachments as $tik_attachment): ?>
                                    <div class="d-flex align-items-center mr-4 mb-2 p-2 ticket-attachment-card">
                                        <?php
                                        $ext = pathinfo($tik_attachment['file_name'], PATHINFO_EXTENSION);
                                        $icon = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']) ? 'fa-file-image-o' : 'fa-file-text-o';
                                        ?>
                                        <i class="fa <?= $icon ?> mr-2 ticket-attachment-icon"></i>
                                        <a href="<?= base_url() . $tik_attachment['path'] ?>" target="_blank"
                                            class="ticket-attachment-link">
                                            <?= $tik_attachment['file_name'] ?>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    var ticketDataRaw = <?= json_encode($decoded) ?>;
                    if (!ticketDataRaw) ticketDataRaw = {};
                    if (!ticketDataRaw.attachments) ticketDataRaw.attachments = [];
                </script>
                <div class="col-md-12">
                    <div class="comments-container">
                        <ul id="comments-list" class="comments-list">
                            <?PHP foreach ($messages as $message) {
                                $attachments = '';
                                $decoded = json_decode($message['data'], true);

                                if ($decoded && !empty($decoded['attachments'])) {
                                    foreach ($decoded['attachments'] as $attachment) {
                                        $attachments = $attachments . '<p><span class="attachment" data-filename="' . $attachment['file_name'] . '" data-filepath="' . base_url() . $attachment['path'] . '"></p>';
                                    }
                                }
                                if ($message['type'] == 1)
                                    echo '<li>
                                <div class="comment-main-level">
                                    <div class="d-flex align-items-start">
                                        <!-- Avatar -->
                                        <div class="comment-avatar" data-username="' . $message['owner'] . '"></div>
                                        <!-- Comment & Attachments -->

                                        <div class="comment-box">
                                            <div class="comment-head">
                                                <h6 class="comment-name"><a href="#" class="user-name" data-username="' . $message['owner'] . '"></a></h6>
                                                <span class="rel-time" data-value="' . $message['created'] . '000"></span>
                                            </div>
                                            <div class="comment-content">
                                                ' . $message['message'] . $attachments
                                        . '
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </li>';
                                else
                                    echo ' <li>
                            <!-- Activity-tag -->
                           <div class="activity-tag">
                                <div class="d-flex align-items-center">
                                    <!-- Avatar -->
                                       <i class="activity-icon" data-type="' . $message['type'] . '"></i>
                                    <div class="activity-text">
                                        <h6 class="comment-name"><a href="#">@' . $message['owner'] . '</a> ' . $message['message'] . ' 
                                            <span class="rel-time" data-value="' . $message['created'] . '000"></span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </li>';
                            } ?>
                        </ul>
                    </div>
                </div>
                <?php if (!$is_locked): ?>
                <div class="col-md-12 mt-3">
                    <div class="card custom-border-radius">
                        <div class="card-body">
                            <h5 class="mb-3">Add Comment</h5>
                            <div id="comment" style="min-height: 120px;"></div>
                            <div class="mt-2">
                                <ul id="attached_files" class="list-unstyled"></ul>
                            </div>
                            <div class="mt-3 d-flex justify-content-between">
                                <label class="btn btn-sm btn-outline-secondary">
                                    <i class="fa fa-paperclip"></i> Attach File
                                    <input type="file" style="display:none;">
                                </label>
                                <button class="btn btn-sm btn-primary" id="reply" data-ticket-no="<?= $info['ticket_no'] ?>">
                                    <i class="fa fa-send"></i> Reply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>


        <div class="col-md-4 no-padding-left ticket-details-right">
            <div class="card custom-border-radius sticky-this">
                <div class="card-header d-flex align-items-center custom-border-radius">
                    <h3 class="h4"><i class="fa fa-ticket"></i>Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table-responsiveW">
                            <table class="table">
                                <tr>
                                    <th class="border-0">Ticket Number</th>
                                    <td class="border-0"><?= $info['ticket_no'] ?></td>
                                    <td class="border-0"></td>
                                </tr>
                                <tr>
                                    <th>Created on</th>
                                    <td><span class="rel-time" data-value="<?= $info['created'] . '000' ?>"></span></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Created By</th>
                                    <td>
                                        <?php
                                        $owner = isset($info['owner']) ? $info['owner'] : '';
                                        if (!empty($owner)) {
                                            $owner_user = $this->db->get_where('users', array('username' => $owner))->row_array();
                                            echo $owner_user ? $owner_user['name'] : $owner;
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Ticket Status</th>
                                    <td><span class="tik-status" data-value="<?= $info['status'] ?>"></span></td>
                                    <td><a href="Javascript:void(0);" class="edit-ticket-dropdown">Edit</a>
                                        <div class="col-sm-12 select select-ticket-dropdown hide"
                                            style="position: absolute;right:0; margin-top: -25px;">
                                            <select name="status" id="status_dd" data-id="<?= $info['id'] ?>"
                                                data-type="4" class="form-control" style="width: 100%">
                                                <option></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ticket Severity</th>
                                    <td><span class="tik-severity" data-value="<?= $info['severity'] ?>"></span></td>
                                    <?php if (!$is_locked): ?>
                                        <td><a href="Javascript:void(0);" class="edit-ticket-dropdown">Edit</a>
                                            <div class="col-sm-12 select select-ticket-dropdown hide"
                                                style="position: absolute;right:0; margin-top: -25px;">
                                                <select name="severity" id="severity_dd" data-id="<?= $info['id'] ?>"
                                                    data-type="5" class="form-control selection" style="width: 100%">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </td>
                                    <?php else: ?>
                                        <td><span class="text-muted">Locked</span></td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <th>Ticket Category</th>
                                    <td>
                                        <?php
                                        $category = isset($info['category']) ? $info['category'] : '';
                                        if (!empty($category)) {
                                            // Check if it's JSON array (new format)
                                            $categories = json_decode($category, true);
                                            if (is_array($categories)) {
                                                // Multiple categories
                                                foreach ($categories as $cat_id) {
                                                    echo '<span class="tik-category" data-value="' . $cat_id . '"></span> ';
                                                }
                                            } else {
                                                // Single category (old format)
                                                echo '<span class="tik-category" data-value="' . $category . '"></span>';
                                            }
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td><a href="Javascript:void(0);" class="edit-ticket-dropdown">Edit</a>
                                        <div class="col-sm-12 select select-ticket-dropdown hide"
                                            style="position: absolute;right:0; margin-top: -25px;">
                                            <select name="category" id="category_dd" data-id="<?= $info['id'] ?>"
                                                data-type="7" class="form-control" style="width: 100%">
                                                <option></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>


                                <tr>
                                    <th>Assigned to</th>
                                    <td>
                                        <?php
                                        $assign_to = isset($info['assign_to']) ? $info['assign_to'] : '';
                                        if (!empty($assign_to)) {
                                            $assigned_user = $this->db->get_where('users', array('username' => $assign_to))->row_array();
                                            echo $assigned_user ? $assigned_user['name'] : $assign_to;
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    if ($privilege) { ?>
                                        <td><a href="Javascript:void(0);" class="edit-ticket-dropdown">Edit</a>
                                            <div class="col-sm-12 select select-ticket-dropdown hide"
                                                style="position: absolute;right:0; margin-top: -25px;">
                                                <select name="assign_to" id="assign_to_dd" data-id="<?= $info['id'] ?>"
                                                    data-type="8" class="form-control" style="width: 100%">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </td>
                                    <?php } ?>
                                </tr>

                                <tr>
                                    <th>Assigned on</th>
                                    <td><span class="rel-time" data-value="<?= $info['assign_on'] ?>"></span></td>
                                </tr>
                                <tr>
                                    <th>CC</th>
                                    <td><?php
                                    if (!empty($info['cc'])) {
                                        $ccs = explode(';', $info['cc']);
                                        foreach ($ccs as $cc) {
                                            $cc = trim($cc);
                                            if (!empty($cc)) {
                                                // Try to get user name
                                                $cc_user = $this->db->get_where('users', array('username' => $cc))->row_array();
                                                if ($cc_user) {
                                                    echo '<span class="badge badge-secondary mr-1 mb-1">' . $cc_user['name'] . '</span>';
                                                } else {
                                                    echo '<span class="badge badge-secondary mr-1 mb-1">' . $cc . '</span>';
                                                }
                                            }
                                        }
                                    } else
                                        echo '-';

                                    ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Last Updated on</th>
                                    <td><span class="rel-time" data-value="<?= $info['updated'] . '000' ?>"></span></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Include Modals -->
<?php include('modals/resolve_modal.php'); ?>
<?php include('modals/reason_modal.php'); ?>

<script>
    var IS_TICKET_LOCKED = <?= $is_locked ? 'true' : 'false' ?>;
    $(document).ready(function () {
        var attached_files = [];

        //call a function to handle file upload on select file
        $('input[type=file]').on('change', function (e) {
            var res = fileUpload(e, BASE_URL + 'API/Ticket/upload_attachment', function (res) {
                console.log(res);
                if (res) {
                    attached_files.push(res);
                    var attached_link = getAttachmentLabel(res.file_name, res.path);
                    $('#attached_files').append('<li>' + attached_link + '<span class="remove-this" data-index="' + attached_files.length + '"><i class="fa fa-close"></i></span></li>')
                    removeAttachment();
                }
            });
        });

        var toolbarOptions = [
            [{ 'font': [] }],
            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote', 'code-block'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'script': 'sub' }, { 'script': 'super' }],      // superscript/subscript
            [{ 'indent': '-1' }, { 'indent': '+1' }],          // outdent/indent
            [{ 'direction': 'rtl' }],                         // text direction
        ];

        var cquill = null;
        if (document.getElementById('comment')) {
            cquill = new Quill('#comment', {
                modules: {
                    toolbar: toolbarOptions
                },
                theme: 'snow'
            });
        }

        $("#reply").on('click', function (e) {
            e.preventDefault();
            var ticket_no = $(this).attr('data-ticket-no');
            var message = cquill ? cquill.root.innerHTML : '';
            if (!message || message === '<p><br></p>') {
                showNotification('error', 'Please enter a comment.');
                return;
            }
            var data = { "attachments": attached_files }
            attached_files = [];
            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/Ticket/addThreadMessage',
                dataType: 'text',
                data: { 'ticket_no': ticket_no, 'message': message, 'data': data, 'type': 1 },

                beforeSend: function () {
                    $('#au_result').html('<img src="' + BASE_URL + 'assets/img/loader.gif" class="pull-right" style="width: 30px;">');
                },

                success: function (response) {
                    if (JSON.parse(response)['data']['result']) {
                        showNotification('success', 'Comment added successfully')
                        window.location.reload();
                    } else
                        showNotification('error', 'Some error occured')
                }
            });
        });

        // --- Resolve Modal Attachment Handling ---
        var resolveAttachments = [];

        $('#btnAddResolveAttachment').click(function () {
            $('#resolveAttachmentInput').click();
        });

        $('#resolveAttachmentInput').on('change', function (e) {
            fileUpload(e, BASE_URL + 'API/Ticket/upload_attachment', function (res) {
                if (res) {
                    resolveAttachments.push(res);
                    var listItem = '<li class="mb-1" data-index="' + (resolveAttachments.length - 1) + '">' +
                        '<i class="fa fa-paperclip mr-1"></i>' +
                        '<span>' + res.file_name + '</span> ' +
                        '<a href="javascript:void(0);" class="text-danger remove-resolve-attachment ml-2" data-index="' + (resolveAttachments.length - 1) + '">' +
                        '<i class="fa fa-times"></i></a>' +
                        '</li>';
                    $('#resolveAttachmentList').append(listItem);
                    // Reset input
                    $('#resolveAttachmentInput').val('');
                }
            });
        });

        $(document).on('click', '.remove-resolve-attachment', function () {
            var index = $(this).data('index');
            resolveAttachments.splice(index, 1);
            $(this).closest('li').remove();
            // Re-index remaining items
            $('#resolveAttachmentList li').each(function (i) {
                $(this).attr('data-index', i);
                $(this).find('.remove-resolve-attachment').attr('data-index', i);
            });
        });

        // --- Reason Modal Attachment Handling ---
        var reasonAttachments = [];

        $('#btnAddReasonAttachment').click(function () {
            $('#reasonAttachmentInput').click();
        });

        $('#reasonAttachmentInput').on('change', function (e) {
            fileUpload(e, BASE_URL + 'API/Ticket/upload_attachment', function (res) {
                if (res) {
                    reasonAttachments.push(res);
                    var listItem = '<li class="mb-1" data-index="' + (reasonAttachments.length - 1) + '">' +
                        '<i class="fa fa-paperclip mr-1"></i>' +
                        '<span>' + res.file_name + '</span> ' +
                        '<a href="javascript:void(0);" class="text-danger remove-reason-attachment ml-2" data-index="' + (reasonAttachments.length - 1) + '">' +
                        '<i class="fa fa-times"></i></a>' +
                        '</li>';
                    $('#reasonAttachmentList').append(listItem);
                    // Reset input
                    $('#reasonAttachmentInput').val('');
                }
            });
        });

        $(document).on('click', '.remove-reason-attachment', function () {
            var index = $(this).data('index');
            reasonAttachments.splice(index, 1);
            $(this).closest('li').remove();
            // Re-index remaining items
            $('#reasonAttachmentList li').each(function (i) {
                $(this).attr('data-index', i);
                $(this).find('.remove-reason-attachment').attr('data-index', i);
            });
        });

        // Clear attachments when modals are closed
        $('#resolveModal').on('hidden.bs.modal', function () {
            resolveAttachments = [];
            $('#resolveAttachmentList').empty();
            $('#resolveText').val('');
        });

        $('#reasonModal').on('hidden.bs.modal', function () {
            reasonAttachments = [];
            $('#reasonAttachmentList').empty();
            $('#reasonText').val('');
        });

        // ... previous code ...
        renderDropdowns();

        // --- Header Attachment Logic ---
        $('#btnAddHeaderAttachment').click(function () {
            $('#headerAttachmentInput').click();
        });

        $('#headerAttachmentInput').on('change', function (e) {
            // Upload file first
            fileUpload(e, BASE_URL + 'API/Ticket/upload_attachment', function (res) {
                if (res) {
                    console.log("Uploaded:", res);

                    // Add to current ticket data
                    ticketDataRaw.attachments.push(res);

                    // Construct update payload
                    // We need to send 'data' as a JSON string to update ticket column
                    var updatedJsonData = JSON.stringify(ticketDataRaw);

                    var data = {
                        'update_data': {
                            'id': "<?= $info['id'] ?>",
                            'data': updatedJsonData
                        },
                        'meta': {
                            'ticket_no': "<?= $info['ticket_no'] ?>",
                            'message': 'Added attachment: ' + res.file_name,
                            'type': 4, // Status change type or similar (4 is usually update)
                            'plain_txt_message': 'Added attachment: ' + res.file_name
                        }
                    };

                    // Call updateTicket API
                    $.ajax({
                        type: 'POST',
                        url: BASE_URL + 'API/Ticket/updateTicket',
                        dataType: 'text', // Expecting text/json response
                        data: data,
                        beforeSend: function () {
                            showNotification('info', 'Saving attachment to ticket...');
                        },
                        success: function (response) {
                            try {
                                var r = JSON.parse(response);
                                // The API returns {result: true/1} usually, wrapped in data maybe? 
                                // Actually API/Ticket/updateTicket sends {result: update_result} directly.
                                if (r.result) {
                                    showNotification('success', 'Attachment added successfully!', {}, function () {
                                        window.location.reload();
                                    });
                                } else {
                                    showNotification('error', 'Failed to update ticket data.');
                                }
                            } catch (ev) {
                                console.error(ev);
                                showNotification('error', 'Error parsing server response');
                            }
                        },
                        error: function () {
                            showNotification('error', 'Server Error');
                        }
                    });
                }
            });
        });
        // -------------------------------

        $('.edit-ticket-dropdown').click(function (e) {
            e.preventDefault();
            var $this = $(this);
            var $dropdown = $this.siblings('.select-ticket-dropdown');
            $dropdown.toggleClass('hide');
            
            if (!$dropdown.hasClass('hide')) {
                var id_select = $dropdown.children('select').attr('id');
                var $select = $("#" + id_select);
                
                // Wait for Select2 to be initialized (loaded via AJAX)
                var tryOpen = function(attempts) {
                    if ($select.data('select2')) {
                        $select.select2('open');
                    } else if (attempts > 0) {
                        setTimeout(function() { tryOpen(attempts - 1); }, 200);
                    }
                };
                tryOpen(15); // retry up to 15 times (3 seconds)
            }
            
            $this.prop('disabled', true);
            setTimeout(function () {
                $this.prop('disabled', false);
            }, 2000);
        });

        // Use Select2 close event instead of focusout (focusout fires immediately
        // when Select2 opens because its dropdown is appended to body)
        $('select.form-control').on('select2:close', function () {
            $(this).closest('.select-ticket-dropdown').addClass('hide');
        });

        $('select.form-control').on('change', function () {
            var intfields = ['severity', 'priority', 'status']; // Removed 'category' to handle it separately
            var field = $(this).attr('name');
            var value = $(this).val(); // Use .val() to capture array for multi-select

            if (intfields.includes(field)) {
                // Ensure single value is parsed as int
                if (!Array.isArray(value)) {
                    value = parseInt(value);
                }
            } else if (field === 'category') {
                // Category is special, can be array or single. 
                // If it's a numeric array (from IDs), we keep it as is.
                // If it's single value, parseInt or keep string? 
                // DB stores JSON string of strings usually ["1","2"] or single "1".
                // Let's keep it as is (strings/array of strings).
            }

            var ticket_id = $(this).attr('data-id');

            // Format value for display in attribute (handle array/JSON)
            var displayVal = (typeof value === 'object') ? JSON.stringify(value) : value;
            // Use single quotes for data-value to support JSON double quotes
            var message = "Changed " + field + " to <span class='tik-" + field + "' data-value='" + displayVal + "'></span>";
            var plain_txt_message = "Changed " + field + " to " + displayVal + ".";

            var type = parseInt($(this).attr('data-type'));

            // Check if ticket is locked
            if (IS_TICKET_LOCKED) {
                showNotification('error', 'This ticket is locked and cannot be edited.');
                $(this).val('').trigger('change');
                return false;
            }

            // Check if changing to Closed status - require resolve
            if (field === 'status' && value === 100) {
                // Show resolve modal
                $('#resolveModal').modal('show');
                $('#submitResolve').off('click').on('click', function () {
                    var resolve = $('#resolveText').val().trim();
                    if (!resolve) {
                        showNotification('error', 'Please provide resolution details.');
                        return;
                    }
                    // Proceed with status change including resolve and attachments
                    updateTicketWithResolve(ticket_id, value, message, plain_txt_message, type, resolve, resolveAttachments);
                    $('#resolveModal').modal('hide');
                    $('#resolveText').val('');
                    resolveAttachments = [];
                    $('#resolveAttachmentList').empty();
                });
                return false;
            }

            // Check if changing to On Hold or Cancelled - require reason
            if (field === 'status' && (value === 75 || value === 120)) {
                // Show reason modal
                var statusLabel = value === 75 ? 'On Hold' : 'Cancelled';
                $('#targetStatusLabel').text(statusLabel);
                $('#reasonModal').modal('show');
                $('#submitReason').off('click').on('click', function () {
                    var reason = $('#reasonText').val().trim();
                    if (!reason) {
                        showNotification('error', 'Please provide a reason for this status change.');
                        return;
                    }
                    // Proceed with status change including reason and attachments
                    updateTicketWithReason(ticket_id, value, message, plain_txt_message, type, reason, reasonAttachments);
                    $('#reasonModal').modal('hide');
                    $('#reasonText').val('');
                    reasonAttachments = [];
                    $('#reasonAttachmentList').empty();
                });
                return false;
            }

            // Normal update for other fields
            var data = {
                'update_data': { 'id': ticket_id },
                'meta': {
                    'ticket_no': "<?= $info['ticket_no'] ?>",
                    'message': message,
                    'type': type,
                    'plain_txt_message': plain_txt_message
                }
            };
            data['update_data'][field] = value;

            if (field === "assign_to") {
                message = data['meta']['message'] = 'Changed assignee to <span class="user-label" data-username="' + value + '"></span>';
                plain_txt_message = data['meta']['plain_txt_message'] = 'Changed assignee to ' + value + '.';
                data['update_data']['assign_on'] = Date.now();
                data['update_data']['status'] = 50; //hardcoded assigned status;
            }

            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/Ticket/updateTicket',
                dataType: 'text',
                data: data,

                beforeSend: function () {
                    $('#au_result').html('<img src="' + BASE_URL + 'assets/img/loader.gif" class="pull-right" style="width: 30px;">');
                },

                success: function (response) {
                    if (JSON.parse(response)['data']['result']) {
                        showNotification('success', message, {}, function () {
                            window.location.reload();
                        })
                    } else
                        showNotification('error', 'Some error occured.');

                }
            });
        });

        // Function to update ticket with resolve
        function updateTicketWithResolve(ticket_id, status, message, plain_txt_message, type, resolve, attachments) {
            // Update ticket data with resolve attachments
            if (attachments && attachments.length > 0) {
                ticketDataRaw.resolve_attachments = attachments;
            }

            var updatedJsonData = JSON.stringify(ticketDataRaw);

            var data = {
                'update_data': {
                    'id': ticket_id,
                    'status': status,
                    'resolve': resolve,
                    'closed_at': Math.floor(Date.now() / 1000),
                    'data': updatedJsonData
                },
                'meta': {
                    'ticket_no': "<?= $info['ticket_no'] ?>",
                    'message': message,
                    'type': type,
                    'plain_txt_message': plain_txt_message
                }
            };

            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/Ticket/updateTicket',
                dataType: 'text',
                data: data,
                beforeSend: function () {
                    $('#au_result').html('<img src="' + BASE_URL + 'assets/img/loader.gif" class="pull-right" style="width: 30px;">');
                },
                success: function (response) {
                    if (JSON.parse(response)['data']['result']) {
                        showNotification('success', 'Ticket closed successfully', {}, function () {
                            window.location.reload();
                        })
                    } else
                        showNotification('error', 'Some error occured.');
                }
            });
        }

        // Function to update ticket with reason
        function updateTicketWithReason(ticket_id, status, message, plain_txt_message, type, reason, attachments) {
            // Update ticket data with reason attachments
            if (attachments && attachments.length > 0) {
                ticketDataRaw.reason_attachments = attachments;
            }

            var updatedJsonData = JSON.stringify(ticketDataRaw);

            var data = {
                'update_data': {
                    'id': ticket_id,
                    'status': status,
                    'reason': reason,
                    'data': updatedJsonData
                },
                'meta': {
                    'ticket_no': "<?= $info['ticket_no'] ?>",
                    'message': message,
                    'type': type,
                    'plain_txt_message': plain_txt_message
                }
            };

            // Add closed_at if status is Cancelled
            if (status === 120) {
                data['update_data']['closed_at'] = Math.floor(Date.now() / 1000);
            }

            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/Ticket/updateTicket',
                dataType: 'text',
                data: data,
                beforeSend: function () {
                    $('#au_result').html('<img src="' + BASE_URL + 'assets/img/loader.gif" class="pull-right" style="width: 30px;">');
                },
                success: function (response) {
                    if (JSON.parse(response)['data']['result']) {
                        showNotification('success', 'Status changed successfully', {}, function () {
                            window.location.reload();
                        })
                    } else
                        showNotification('error', 'Some error occured.');
                }
            });
        }
    });

    function removeAttachment() {
        $('.remove-this').on('click', function () {
            var index = parseInt($(this).attr('data-index'));
            let attached_files = $("#attached_files");
            attached_files.splice(index, 1);
            console.log(attached_files);
            $(this).parent().remove();
        });
    }
</script>