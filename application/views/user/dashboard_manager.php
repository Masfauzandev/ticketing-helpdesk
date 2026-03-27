<!--Dashboard counts-->
<section class="dashboard-counts dashboard-header no-padding-bottom col-left-no-padding">
    <div class="container">
        <!--member stats-->
        <div class="row bg-white has-shadow custom-border-radius">
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-violet"><i class="fa fa-users"></i></div>
                    <div class="pl-3"><strong><span
                                class="number font-weight-bolder"><?= $stats['total_users'] ?></span></strong>
                        <br>
                        <span>Total Members</span>
                    </div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-blue"><i class="fa fa-user-secret"></i></div>
                    <div class="pl-3"><strong><span
                                class="number font-weight-bolder"><?= $stats['total_agents'] ?></span></strong>
                        <br>
                        <span>Total Agents</span>
                    </div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-green"><i class="fa fa-user-circle-o"></i></div>
                    <div class="pl-3"><strong><span
                                class="number font-weight-bolder"><?= $stats['total_manager'] ?></span></strong>
                        <br>
                        <span>Total Managers</span>
                    </div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-purple"><i class="fa fa-users"></i></div>
                    <div class="pl-3"><strong><span
                                class="number font-weight-bolder"><?= $stats['total_users_count'] ?></span></strong>
                        <br>
                        <span>Total Users</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--ticket stats-->
<section class="dashboard-header no-padding-bottom col-left-no-padding">
    <div class="container">
        <div class="row">
            <!-- Statistics -->
            <a href="<?= BASE_URL ?>tickets/list_all" class="col-md-3">
                <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                    <div class="icon bg-green"><i class="fa fa-tasks"></i></div>
                    <div class="text"><strong><?= $stats['total_tickets'] ?></strong><br>
                        <small>All Tickets</small>
                    </div>
                </div>
            </a>

            <a href="<?= BASE_URL ?>tickets/open_tickets" class="col-md-3">
                <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                    <div class="icon bg-orange"><i class="fa fa-ticket"></i></div>
                    <div class="text"><strong><?= $stats['open_tickets'] ?></strong><br>
                        <small>Open Tickets</small>
                    </div>
                </div>
            </a>

            <a href="<?= BASE_URL ?>tickets/in_progress_tickets" class="col-md-3">
                <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                    <div class="icon bg-primary"><i class="fa fa-spinner"></i></div>
                    <div class="text"><strong><?= $stats['in_progress_tickets'] ?></strong><br>
                        <small>In Progress</small>
                    </div>
                </div>
            </a>

            <a href="<?= BASE_URL ?>tickets/assigned_tickets" class="col-md-3">
                <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                    <div class="icon bg-info"><i class="fa fa-user"></i></div>
                    <div class="text"><strong><?= $stats['assigned_tickets'] ?></strong><br>
                        <small>Assigned Tickets</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="row mt-3">
            <a href="<?= BASE_URL ?>tickets/on_hold_tickets" class="col-md-3">
                <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                    <div class="icon bg-secondary"><i class="fa fa-pause"></i></div>
                    <div class="text"><strong><?= $stats['on_hold_tickets'] ?></strong><br>
                        <small>On Hold</small>
                    </div>
                </div>
            </a>

            <a href="<?= BASE_URL ?>tickets/closed_tickets" class="col-md-3">
                <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                    <div class="icon bg-red"><i class="fa fa-check"></i></div>
                    <div class="text"><strong><?= $stats['closed_tickets'] ?></strong><br>
                        <small>Closed Tickets</small>
                    </div>
                </div>
            </a>

            <a href="<?= BASE_URL ?>tickets/cancelled_tickets" class="col-md-3">
                <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                    <div class="icon bg-dark"><i class="fa fa-ban"></i></div>
                    <div class="text"><strong><?= $stats['cancelled_tickets'] ?></strong><br>
                        <small>Cancelled</small>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>


<!-- Severity graph & Ticket status -->
<section class="feeds">
    <div class="container col-left-no-padding">
        <div class="row">
            <div class="col-md-7 d-flex">
                <div class="bar-chart-example card custom-border-radius w-100">
                    <div class="card-header d-flex align-items-center  custom-border-radius">
                        <h2 class="h3">Ticket Status By Severity</h2>
                    </div>
                    <div class="card-body">
                        <canvas id="severity-bar-graph" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-flex">
                <div class="card custom-border-radius w-100">
                    <div class="card-header d-flex align-items-center  custom-border-radius">
                        <h2 class="h3">Tickets Status</h2>
                    </div>
                    <div class="work-amount">
                        <div class="card-body">
                            <div class="chart text-center">
                                <iframe class="chartjs-hidden-iframe" tabindex="-1"
                                    style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <div class="text">
                                    <strong><?= $stats['total_tickets'] ?></strong><br><span>Total Tickets</span>
                                </div>
                                <canvas id="pieChart" height="100"></canvas>
                            </div>
                            <div class="text-center">Open, Assigned and Closed Tickets Statistics</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- recent activity & Priority graph-->
<section class="feeds" style="margin-top: -44px;">
    <div class="container col-left-no-padding">
        <div class="row">
            <!-- Trending Articles-->
            <div class="col-lg-12">
                <div class="recent-updates card custom-border-radius w-100">
                    <div class="card-header d-flex align-items-center  custom-border-radius">
                        <h2 class="h3">Recent Tickets</h2>
                    </div>
                    <div class="card-header tab-card-header shadow-none">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link disabled-text  active show" id="one-tab" data-toggle="tab"
                                    href="#one" role="tab" aria-controls="One" aria-selected="true">Recent Tickets</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled-text" id="two-tab" data-toggle="tab" href="#two" role="tab"
                                    aria-controls="Two" aria-selected="false">Recent Open Tickets</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled-text" id="three-tab" data-toggle="tab" href="#three"
                                    role="tab" aria-controls="Three" aria-selected="false">Recent Assigned Tickets</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled-text" id="four-tab" data-toggle="tab" href="#four"
                                    role="tab" aria-controls="Four" aria-selected="false">Recent Closed Tickets</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                            <?php
                            if (is_array($recent['created']) && count($recent['created']) > 0) {
                                foreach ($recent['created'] as $recent_created) {
                                    echo '
                                <div class="item d-flex  justify-content-between">
                                    <div class="info d-flex">
                                    <div class="icon"><i class="fa fa-ticket text-green"></i></div>
                                    <div class="title">
                                    <a href="' . BASE_URL . 'tickets/view_ticket/' . $recent_created['ticket_no'] . '">
                                        <h5>' . $recent_created['ticket_no'] . '</h5>
                                    </a><br>
                                    <p>Subject: ' . $recent_created['subject'] . '</p>
                                    <p>Title: ' . $recent_created['title'] . '</p>
                                    <p>Description: ' . mb_substr(strip_tags($recent_created['message']), 0, 100) . (mb_strlen(strip_tags($recent_created['message'])) > 100 ? '...' : '') . '</p>
                                    </div>
                                    </div>
                                    <div class="date text-right"><span class="rel-time" data-value="' . $recent_created['created'] . '000"></span><br><span class="tik-status" data-value="' . $recent_created['status'] . '"></span></div>
                                </div>
                                ';
                                }
                            } else {
                                echo '
                                <div class="item d-flex align-items-center">
                                <div class="text">
                                    <a href="#">
                                    <h3 class="h5">OOPS</h3>
                                    </a>
                                    <small>No record found</small>
                                </div>
                                </div>
                                ';
                            }
                            ?>
                        </div>
                        <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
                            <?php
                            if (is_array($recent['open']) && count($recent['open']) > 0) {
                                foreach ($recent['open'] as $recent_open) {
                                    echo '
                                <div class="item d-flex  justify-content-between">
                                <div class="info d-flex">
                                    <div class="icon"><i class="fa fa-ticket text-red"></i></div>
                                    <div class="title">
                                    <a href="' . BASE_URL . 'tickets/view_ticket/' . $recent_open['ticket_no'] . '">
                                        <h5>' . $recent_open['ticket_no'] . '</h5>
                                    </a><br>
                                    <p>Subject: ' . $recent_open['subject'] . '</p>
                                    <p>Title: ' . $recent_open['title'] . '</p>
                                    <p>Description: ' . mb_substr(strip_tags($recent_open['message']), 0, 100) . (mb_strlen(strip_tags($recent_open['message'])) > 100 ? '...' : '') . '</p>
                                    </div>
                                    </div>
                                    <div class="date text-right"><span class="rel-time" data-value="' . $recent_open['created'] . '000"></span><br><span class="tik-status" data-value="' . $recent_open['status'] . '"></span></div>
                                </div>
                                ';
                                }
                            } else {
                                echo '
                                <div class="item d-flex align-items-center">
                                <div class="text">
                                    <a href="#">
                                    <h3 class="h5">OOPS</h3>
                                    </a>
                                    <small>No record found</small>
                                </div>
                                </div>
                                ';
                            }
                            ?>

                        </div>
                        <div class="tab-pane fade p-3" id="three" role="tabpanel" aria-labelledby="three-tab">
                            <?php
                            if (is_array($recent['assigned']) && count($recent['assigned']) > 0) {
                                foreach ($recent['assigned'] as $recent_assigned) {
                                    echo '
                                <div class="item d-flex  justify-content-between">
                                <div class="info d-flex">
                                    <div class="icon"><i class="fa fa-ticket text-info"></i></div>
                                    <div class="text">
                                    <a href="' . BASE_URL . 'tickets/view_ticket/' . $recent_assigned['ticket_no'] . '">
                                        <h5>' . $recent_assigned['ticket_no'] . '</h5>
                                    </a><br>
                                    <p>Subject: ' . $recent_assigned['subject'] . '</p>
                                    <p>Title: ' . $recent_assigned['title'] . '</p>
                                    <p>Description: ' . mb_substr(strip_tags($recent_assigned['message']), 0, 100) . (mb_strlen(strip_tags($recent_assigned['message'])) > 100 ? '...' : '') . '</p>
                                    </div>
                                    </div>
                                    <div class="date text-right"><span class="rel-time" data-value="' . $recent_assigned['created'] . '000"></span><br><span class="tik-status" data-value="' . $recent_assigned['status'] . '"></span></div>
                                </div>
                                ';
                                }
                            } else {
                                echo '
                                <div class="item d-flex align-items-center">
                                <div class="text">
                                    <a href="#">
                                    <h3 class="h5">OOPS</h3>
                                    </a>
                                    <small>No record found</small>
                                </div>
                                </div>
                                ';
                            }
                            ?>
                        </div>
                        <div class="tab-pane fade p-3" id="four" role="tabpanel" aria-labelledby="four-tab">
                            <?php
                            if (is_array($recent['closed']) && count($recent['closed']) > 0) {
                                foreach ($recent['closed'] as $recent_closed) {
                                    echo '
                                <div class="item d-flex  justify-content-between">
                                <div class="info d-flex">
                                    <div class="icon"><i class="fa fa-ticket text-red"></i></div>
                                    <div class="title">
                                    <a href="' . BASE_URL . 'tickets/view_ticket/' . $recent_closed['ticket_no'] . '">
                                        <h5>' . $recent_closed['ticket_no'] . '</h5>
                                    </a><br>
                                    <p>Subject: ' . $recent_closed['subject'] . '</p>
                                    <p>Title: ' . $recent_closed['title'] . '</p>
                                    <p>Description: ' . mb_substr(strip_tags($recent_closed['message']), 0, 100) . (mb_strlen(strip_tags($recent_closed['message'])) > 100 ? '...' : '') . '</p>
                                    </div>
                                    </div>
                                    <div class="date text-right"><span class="rel-time" data-value="' . $recent_closed['created'] . '000"></span><br><span class="tik-status" data-value="' . $recent_closed['status'] . '"></span></div>
                                </div>
                                ';
                                }
                            } else {
                                echo '
                                <div class="item d-flex align-items-center">
                                <div class="text">
                                    <a href="#">
                                    <h3 class="h5">OOPS</h3>
                                    </a>
                                    <small>No record found</small>
                                </div>
                                </div>
                                ';
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>

    // ------------------------------------------------------- //
    // Charts Gradients
    // ------------------------------------------------------ //
    var ctx1 = $("canvas").get(0).getContext("2d");
    var gradient1 = ctx1.createLinearGradient(150, 0, 150, 300);
    gradient1.addColorStop(0, 'rgba(255,6,0,0.94)');
    gradient1.addColorStop(1, 'rgba(255,118,118,0.94)');

    var gradient2 = ctx1.createLinearGradient(146.000, 0.000, 154.000, 300.000);
    gradient2.addColorStop(0, 'rgba(255,113,0,0.85)');
    gradient2.addColorStop(1, 'rgba(255,144,84,0.85)');

    var gradient3 = ctx1.createLinearGradient(146.000, 0.000, 154.000, 300.000);
    gradient3.addColorStop(0, 'rgba(104, 179, 112, 0.85)');
    gradient3.addColorStop(1, 'rgba(165,236,69,0.85)');


    // ------------------------------------------------------- //
    // Severity Bar graph
    // ------------------------------------------------------ //
    var BARCHARTEXMPLE = $('#severity-bar-graph');
    var barChartExample = new Chart(BARCHARTEXMPLE, {
        type: 'bar',
        options: {
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        color: '#eee'
                    }
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        color: '#eee'
                    }
                }]
            },
        },
        data: {
            labels: ["Open", "Assigned", "Closed"],
            datasets: [
                <?php 
                $gradients = ['gradient1', 'gradient2', 'gradient3'];
                $i = 0;
                foreach ($stats['count_by_severity'] as $sev_key => $sev_data) {
                    $label = ucfirst($sev_key);
                    $grad = $gradients[$i % count($gradients)];
                    $jsonData = json_encode($sev_data);
                    if ($i > 0) echo ',';
                    echo "
                {
                    label: \"Severity {$label}\",
                    backgroundColor: [{$grad}, {$grad}, {$grad}],
                    hoverBackgroundColor: [{$grad}, {$grad}, {$grad}],
                    borderColor: [{$grad}, {$grad}, {$grad}],
                    borderWidth: 1,
                    data: {$jsonData},
                }";
                    $i++;
                }
                ?>
            ]
        }
    });


    // ------------------------------------------------------- //
    // Tickets status
    // ------------------------------------------------------ //
    var PIECHART = $('#pieChart');
    var myPieChart = new Chart(PIECHART, {
        type: 'doughnut',
        options: {
            cutoutPercentage: 80,
            legend: {
                display: false
            }
        },
        data: {
            labels: [
                "Open",
                "In Progress",
                "Assigned",
                "On Hold",
                "Closed"
            ],
            datasets: [
                {
                    data: [
                        <?= $stats['open_tickets'] ?>,
                        <?= $stats['in_progress_tickets'] ?>,
                        <?= $stats['assigned_tickets'] ?>,
                        <?= $stats['on_hold_tickets'] ?>,
                        <?= $stats['closed_tickets'] ?>
                    ],
                    borderWidth: [0, 0, 0, 0, 0],
                    backgroundColor: [
                        '#ffc36d',      // Open - Orange
                        "#007bff",      // In Progress - Blue
                        "#17a2b8",      // Assigned - Info
                        "#6c757d",      // On Hold - Grey
                        "#ff7676"       // Closed - Red
                    ],
                    hoverBackgroundColor: [
                        '#e2ab62',      // Open hover
                        "#0056b3",      // In Progress hover
                        "#15788d",      // Assigned hover
                        "#545b62",      // On Hold hover
                        "#cc5d5d"       // Closed hover
                    ]
                }]
        }
    });


</script>