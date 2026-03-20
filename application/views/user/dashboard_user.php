<!-- Comment Section-->

<div class="container" style="padding:0; margin-top: -4em;">

    <!--Dashboard counts-->
    <section class="dashboard-header no-padding-bottom col-left-no-padding" style="margin-top: 4em;">
        <div class="container">
            <div class="row">
                <!-- Statistics -->
                <div class="col-md-3">
                    <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                        <div class="icon bg-green"><i class="fa fa-tasks"></i></div>
                        <div class="text"><strong><?= $stats['total_tickets'] ?></strong><br>
                            <small>All Tickets</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                        <div class="icon bg-orange"><i class="fa fa-ticket"></i></div>
                        <div class="text"><strong><?= $stats['open_tickets'] ?></strong><br>
                            <small>Open Tickets</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                        <div class="icon bg-primary"><i class="fa fa-spinner"></i></div>
                        <div class="text"><strong><?= $stats['in_progress_tickets'] ?></strong><br>
                            <small>In Progress</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                        <div class="icon bg-info"><i class="fa fa-user"></i></div>
                        <div class="text"><strong><?= $stats['assigned_tickets'] ?></strong><br>
                            <small>Assigned Tickets</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                        <div class="icon bg-secondary"><i class="fa fa-pause"></i></div>
                        <div class="text"><strong><?= $stats['on_hold_tickets'] ?></strong><br>
                            <small>On Hold</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                        <div class="icon bg-red"><i class="fa fa-check"></i></div>
                        <div class="text"><strong><?= $stats['closed_tickets'] ?></strong><br>
                            <small>Closed Tickets</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="statistic d-flex align-items-center bg-white has-shadow custom-border-radius">
                        <div class="icon bg-dark"><i class="fa fa-ban"></i></div>
                        <div class="text"><strong><?= $stats['cancelled_tickets'] ?></strong><br>
                            <small>Cancelled</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- recent activity -->
    <section class="feeds">
        <div class="container-fluid col-left-no-padding">
            <div class="row">
                <div class="col-lg-6 d-flex">
                    <div class="card custom-border-radius w-100">
                        <div class="card-header d-flex align-items-center  custom-border-radius">
                            <h2 class="h3">Tickets status</h2>
                        </div>
                        <div class="work-amount">
                            <div class="card-body">
                                <div class="chart text-center">
                                    <iframe class="chartjs-hidden-iframe" tabindex="-1"
                                        style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                    <div class="text"><strong><?= $stats['total_tickets'] ?></strong><br><span>Total
                                            Tickets</span>
                                    </div>
                                    <canvas id="pieChart"
                                        style="display: block; width: height: 100%; height: 100%"></canvas>
                                </div>
                                <div class="text-center">Open, Assigned and Closed Tickets stats.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Trending Articles-->
                <div class="col-lg-6 d-flex">
                    <div class="recent-updates card custom-border-radius  w-100">
                        <div class="card-header d-flex align-items-center  custom-border-radius">
                            <h2 class="h3">Recent Tickets</h2>
                        </div>
                        <div class="card-header tab-card-header shadow-none">
                            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link disabled-text  active show" id="one-tab" data-toggle="tab"
                                        href="#one" role="tab" aria-controls="One" aria-selected="true">Recently Created
                                        By Me</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled-text" id="three-tab" data-toggle="tab" href="#three"
                                        role="tab" aria-controls="Three" aria-selected="false">Recent Closed Tickets</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active p-3" id="one" role="tabpanel"
                                aria-labelledby="one-tab">
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
                            <div class="tab-pane fade p-3" id="three" role="tabpanel" aria-labelledby="three-tab">
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