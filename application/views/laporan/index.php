<section class="forms">
    <div class="container-fluid">
        <div class="card custom-border-radius">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="h4"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <form method="GET" action="<?= BASE_URL ?>laporan/index" class="mb-4 pb-3 border-bottom">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="text-xs">Status</label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="">All</option>
                                <?php foreach(STATUS_MAP as $key => $val): ?>
                                    <option value="<?= $key ?>" <?= (isset($_GET['status']) && $_GET['status'] != '' && $_GET['status'] == $key) ? 'selected' : '' ?>><?= htmlspecialchars(strip_tags($val)) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="text-xs">Subject</label>
                            <select name="subject" class="form-control form-control-sm">
                                <option value="">All</option>
                                <?php foreach($subjects as $key => $val): ?>
                                    <option value="<?= htmlspecialchars($val) ?>" <?= (isset($_GET['subject']) && $_GET['subject'] != '' && $_GET['subject'] == $val) ? 'selected' : '' ?>><?= htmlspecialchars($val) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="text-xs">Category</label>
                            <select name="category" class="form-control form-control-sm">
                                <option value="">All</option>
                                <?php foreach($categories as $key => $val): ?>
                                    <option value="<?= $key ?>" <?= (isset($_GET['category']) && $_GET['category'] != '' && $_GET['category'] == $key) ? 'selected' : '' ?>><?= htmlspecialchars($val) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="text-xs">Severity</label>
                            <select name="severity" class="form-control form-control-sm">
                                <option value="">All</option>
                                <?php foreach($severities as $key => $val): ?>
                                    <option value="<?= $key ?>" <?= (isset($_GET['severity']) && $_GET['severity'] != '' && $_GET['severity'] == $key) ? 'selected' : '' ?>><?= htmlspecialchars($val) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="text-xs">Assigned To</label>
                            <select name="assign_to" class="form-control form-control-sm">
                                <option value="">All</option>
                                <?php foreach($users as $user): ?>
                                    <option value="<?= htmlspecialchars($user['username']) ?>" <?= (isset($_GET['assign_to']) && $_GET['assign_to'] == $user['username']) ? 'selected' : '' ?>><?= htmlspecialchars($user['username']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="text-xs">Created By</label>
                            <select name="owner" class="form-control form-control-sm">
                                <option value="">All</option>
                                <?php foreach($users as $user): ?>
                                    <option value="<?= htmlspecialchars($user['username']) ?>" <?= (isset($_GET['owner']) && $_GET['owner'] == $user['username']) ? 'selected' : '' ?>><?= htmlspecialchars($user['username']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm m-1"><i class="fa fa-filter"></i> Filter</button>
                            <a href="<?= BASE_URL ?>laporan/index" class="btn btn-secondary btn-sm m-1"><i class="fa fa-refresh"></i> Clear</a>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap" id="laporanTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Ticket No</th>
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Severity</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th>Created By</th>
                                <th>Assigned To</th>
                                <th>Created On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach ($tickets as $ticket): 
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($ticket['ticket_no']) ?></td>
                                <td><?= htmlspecialchars($ticket['subject']) ?></td>
                                <td><?= htmlspecialchars($ticket['title'] ? $ticket['title'] : '-') ?></td>
                                <td>
                                    <?php 
                                    if (isset($severities[$ticket['severity']])) {
                                        echo htmlspecialchars($severities[$ticket['severity']]);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    if (isset(STATUS_MAP[$ticket['status']])) {
                                        echo STATUS_MAP[$ticket['status']];
                                    } else {
                                        echo htmlspecialchars($ticket['status']);
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    if (isset($categories[$ticket['category']])) {
                                        echo htmlspecialchars($categories[$ticket['category']]);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($ticket['owner'] ? $ticket['owner'] : '-') ?></td>
                                <td><?= htmlspecialchars($ticket['assign_to'] ? $ticket['assign_to'] : '-') ?></td>
                                <td><?= date('Y-m-d H:i', $ticket['created']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Adjust DataTables elements for better alignment */
div.dt-buttons {
    margin-bottom: 10px;
}
#laporanTable th, #laporanTable td {
    white-space: nowrap;
}
</style>

<script>
$(document).ready(function() {
    $('#laporanTable').DataTable({
        scrollX: true,
        autoWidth: false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i> Export PDF',
                className: 'btn btn-danger btn-sm m-1'
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> Export Excel',
                className: 'btn btn-success btn-sm m-1'
            },
            {
                text: '<i class="fa fa-file-image-o"></i> Export Image',
                className: 'btn btn-info btn-sm m-1',
                action: function ( e, dt, node, config ) {
                    // Hide pagination & search temporarily for cleaner image, or just capture the visible table
                    html2canvas(document.querySelector("#laporanTable")).then(canvas => {
                        var link = document.createElement('a');
                        link.download = 'Laporan.png';
                        link.href = canvas.toDataURL("image/png");
                        link.click();
                    });
                }
            }
        ]
    });
});
</script>
