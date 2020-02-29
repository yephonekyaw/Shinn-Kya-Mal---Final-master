<?php
function build_calendar($month, $year)
{
    $daysOfWeek = array('SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT');

    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

    $numberDays = date('t', $firstDayOfMonth);

    $dateComponents = getdate($firstDayOfMonth);

    $monthName = $dateComponents['month'];

    $dayOfWeek = $dateComponents['wday'];

    $datetoday = date('Y-m-d');

    $calendar = '<div class = "bg-white rounded shadow">';
    $calendar .= '  <main>';
    $calendar .= '    <div class = "toolbar row">';
    $calendar .= '      <div class = "toggle col-sm-4">';
    $calendar .= '        <button class = "btn btn-outline-dark btn-sm mr-2">Week</button>';
    $calendar .= '        <button class = "btn btn-outline-dark btn-sm">Month</button>';
    $calendar .= '      </div>';
    $calendar .= "      <div class = 'col text-right'>";
    $calendar .= "        <a class='btn btn-outline-dark btn-sm' href='?month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>< Previous Month</a> ";
    $calendar .= "        <a class='btn btn-outline-dark btn-sm' href='?month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a> ";
    $calendar .= "        <a class='btn btn-outline-dark btn-sm' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Next Month ></a>";
    $calendar .= "      </div>";
    $calendar .= '      <div class="search-input"></div>';
    $calendar .= '    </div>';
    $calendar .= '     <div class = "calendar">';
    $calendar .= '      <div class = "calendar__header">';

    foreach ($daysOfWeek as $day) {
        $calendar .= "<div>$day</div>";
    }
    $calendar .= '      </div>';
    $calendar .= '      <div class="calendar__week">';
    $currentDay = 1;

    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= '<div class="calendar__day day"></div>';
        }
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {

        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";

        $dayname = strtolower(date("l", strtotime($date)));
        $eventNum = 0;
        $today = $day == date('Y-m-d') ? "today" : "";

        if ($datetoday == $date) {
            $calendar .= "<div class='calendar__day day'>$currentDay</div>";
        } else {
            $calendar .= "<div class='calendar__day day'>$currentDay</div>";
        }

        $calendar .= "</td>";
        // Increment counters

        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        for ($l = 0; $l < $remainingDays; $l++) {
            $calendar .= "<div class='calendar__day day'></div>";
        }
    }
    echo $calendar;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- for dropdown search -->

    <script src="https://kit.fontawesome.com/8da23e008a.js"></script>
    <link rel="stylesheet" href="calendar/calendar.css">
    <script type="text/javascript" src="testScript.js"></script>

    <!-- for table Pagnition -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <!-- for datepicker -->
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <script>
        $('nav').affix({
            offset: {
                top: $('#services').offset().top
            }
        });
    </script>
</head>

<body>
    <!-- color of expense #FF5722 -->
    <!-- color of income #007BFF -->
    <!-- Vertical navbar -->
    <div class="vertical-nav bg-white" id="sidebar">
        <div class="py-4 px-3">
            <div class="media d-flex align-items-center"><img src="https://res.cloudinary.com/mhmd/image/upload/v1556074849/avatar-1_tcnd60.png" alt="..." width="65" class="mr-3 rounded-circle img-thumbnail shadow-sm">
                <div class="media-body">
                    <h4 class="m-0 text-dark">User Name</h4>
                    <p class="font-weight-light text-dark mb-0">Log Out</p>
                </div>
            </div>
        </div>

        <ul class="nav flex-column mb-0">
            <li class="nav-item py-2">
                <a href="home.html" class="nav-link text-dark text-uppercase">
                    <i class="fa fa-exchange mr-3 fa-fw" aria-hidden="true"></i>
                    Transactions
                </a>
            </li>
            <li class="nav-item py-2">
                <a href="report.html" class="nav-link text-dark text-uppercase">
                    <i class="fa fa-pie-chart mr-3 fa-fw" aria-hidden="true"></i>
                    Report
                </a>
            </li>
            <li class="nav-item active-ground py-2">
                <a href="Calendar.php" class="nav-link text-light text-uppercase">
                    <i class="fa fa-calendar mr-3 fa-fw" aria-hidden="true"></i>
                    Calendar
                </a>
            </li>
        </ul>
    </div>
    <!-- End vertical navbar -->


    <!-- Page content holder -->
    <div class="page-content p-0" id="content">
        <nav class="navbar">
            <button id="sidebarCollapse" type="button" class="btn btn-light shadow-sm px-4"><i class="fa fa-bars mr-0"></i></button>
            <!-- <h5 class="my-2 text-darkblue">Edit Transaction</h5> -->
            <ul class="nav justify-content-end">

                <li class="nav-link py-0">
                    <button type="button" class="btn bg-darkblue text-light addBtn " data-toggle="modal" data-target="#AddEvent">Add Event</button>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-darkblue" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <?php
                $dateComponents = getdate();
                if (isset($_GET['month']) && isset($_GET['year'])) {
                    $month = $_GET['month'];
                    $year = $_GET['year'];
                } else {
                    $month = $dateComponents['month'];
                    $year = $dateComponents['year'];
                }
                echo build_calendar($month, $year);
                ?>
            </div>
        </div>
    </div>




    <!-- Add Transaction Modal -->
    <div class="modal fade" id="AddEvent" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body justify-content-md-center">
                    <form action="" class="container-fluid" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">Description</label>
                                <input type="text" class="form-control" placeholder="Eg- Food">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCategory">Amount</label>
                                <input type="number" placeholder="0.00" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputDate">Start Date</label>
                                <input name="datetime" id="" class="datepicker form-control" data-provide="datapicker" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputDate">End Date</label>
                                <input name="datetime" id="" class="datepicker form-control" data-provide="datapicker" required>
                            </div>
                            <script>
                                $('.datepicker').datepicker({
                                    uiLibrary: 'bootstrap4'
                                });
                            </script>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="form-group col-md-6">
                            <label for="">Repeat</label>
                                <select name="" class="form-control" id="" required>
                                    <option value="Income">Everyday</option>
                                    <option value="Expense">Every Week</option>
                                    <option value="Expense">Every Month</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Type</label>
                                <select name="" class="form-control" id="" required>
                                    <option value="Income">Income</option>
                                    <option value="Expense">Expense</option>
                                    <option value="Expense">Refund</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button name="save" type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>