<?php
session_start();
include("../main/cons/config.php");
include("buildCalendar.php");
if (isset($_SESSION['user'])) {
    $id = $_SESSION['id'];
    $email = $_SESSION['email'];
    $month = $_GET['month'];
    // $monthToStyle = $month;
    $currentMonth = $month;
    $currentYear = "";

    // Insert Into database
    if (isset($_POST['save'])) {

        $trans_type = mysqli_real_escape_string($conn, $_POST['trans_type']);
        $trans_cat = mysqli_real_escape_string($conn, $_POST['trans_cat']);
        $trans_date = mysqli_real_escape_string($conn, $_POST['datetime']);
        $trans_date = date('Y-m-d', strtotime($trans_date));
        $trans_amount = mysqli_real_escape_string($conn, $_POST['trans_amount']);
        $trans_tag = mysqli_real_escape_string($conn, $_POST['trans_tag']);
        $trans_des = mysqli_real_escape_string($conn, $_POST['trans_des']);

        if ($trans_type == "Expense") {

            // Take categories Id
            $sqlCat = "SELECT categories_id FROM expensecat WHERE categories_name='$trans_cat' AND extra_cat_on_user_id IN(0,'$id') ";
            $resultCat = mysqli_query($conn, $sqlCat);
            $rowCat = $resultCat->fetch_assoc();
            $catId = $rowCat['categories_id'];

            // Insert into expense
            $sqlInData = "INSERT INTO expense(expense_id, expense_categories, expense_user_fk_id, expense_dateTime, expense_amount, expense_description, expense_tag) VALUES(null, '$trans_cat', '$id', '$trans_date', '$trans_amount', '$trans_des', '$trans_tag')";
            mysqli_query($conn, $sqlInData);


            //Add to expensebycat table
            $addMonth = date('m', strtotime($trans_date));
            $sqlByCat = "SELECT * FROM expensebycat WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$addMonth' ";
            $resultByCat = mysqli_query($conn, $sqlByCat);
            if ($row = mysqli_fetch_assoc($resultByCat)) {
                $updateAmount = 0;
                $updateAmount = $trans_amount + $row['expense_cat_amount'];
                mysqli_query($conn, "UPDATE expensebycat SET expense_cat_amount='$updateAmount' WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$addMonth' ");
            } else if (!$row = mysqli_fetch_assoc($resultByCat)) {
                mysqli_query($conn, "INSERT INTO expensebycat(expense_cat_fk_id, expense_user_cat_id, expense_cat_amount, expense_cat_date) VALUES('$catId', '$id', '$trans_amount', '$trans_date') ");
            }

            header("location:dashboard.php?month=$addMonth");
        } else if ($trans_type == "Income") {

            // Take categories id
            $sqlCat = "SELECT income_categories_id FROM incomecat WHERE income_categories_name='$trans_cat' AND extra_cat_on_user_id IN(0,'$id') ";
            $resultCat = mysqli_query($conn, $sqlCat);
            $rowCat = $resultCat->fetch_assoc();
            $catId = $rowCat['income_categories_id'];

            // Insert into income table
            $sqlIn = "INSERT INTO income (income_id, income_categories, income_user_fk_id, income_dateTime, income_amount, income_description, income_tag) VALUES (null, '$trans_cat', '$id', '$trans_date', '$trans_amount', '$trans_des', '$trans_tag') ";
            mysqli_query($conn, $sqlIn);


            //Add to incomebycat table
            $addMonth = date('m', strtotime($trans_date));
            $sqlByCat = "SELECT * FROM incomebycat WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$id' AND MONTH(income_cat_date)='$addMonth' ";
            $resultByCat = mysqli_query($conn, $sqlByCat);
            if ($row = mysqli_fetch_assoc($resultByCat)) {
                $updateAmount = 0;
                $updateAmount = $trans_amount + $row['income_cat_amount'];
                mysqli_query($conn, "UPDATE incomebycat SET income_cat_amount='$updateAmount' WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$id' AND MONTH(income_cat_date)='$addMonth' ");
            } else if (!$row = mysqli_fetch_assoc($resultByCat)) {
                mysqli_query($conn, "INSERT INTO incomebycat(income_cat_fk_id, income_user_cat_id, income_cat_amount, income_cat_date) VALUES('$catId', '$id', '$trans_amount', '$trans_date') ");
            }
            header("location:dashboard.php?month=$addMonth");
        }
        $currentYear = date('Y', strtotime($trans_date));
        $currentYear = $currentYear % 4;
    }


    if ($currentMonth == "01") {
        $calMonth = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
    } else if ($currentMonth == "02") {
        if ($currentYear == 0) {
            $calMonth = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29");
        } else {
            $calMonth = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28");
        }
    } else if ($currentMonth == "03") {
        $calMonth = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
    } else if ($currentMonth == "04") {
        $calMonth = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30");
    } else if ($currentMonth == "05") {
        $calMonth = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
    } else if ($currentMonth == "06") {
        $calMonth = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30");
    } else if ($currentMonth == "07") {
        $calMonth = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
    } else if ($currentMonth == "08") {
        $calMonth = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
    } else if ($currentMonth == "09") {
        $calMonth = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30");
    } else if ($currentMonth == "10") {
        $calMonth = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
    } else if ($currentMonth == "11") {
        $calMonth = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30");
    } else if ($currentMonth == "12") {
        $calMonth = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
    }
    $arrlength = count($calMonth);
} else if (!isset($_SESSION['user'])) {
    header("location: ../main/signinPage.php?");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- for ajax -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- for dropdown search -->
    <script src="https://kit.fontawesome.com/8da23e008a.js"></script>
    <link rel="stylesheet" href="main.css">
    <script type="text/javascript" src="testScript.js"></script>

    <!-- for table Pagnition -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


    <script>
        $('nav').affix({
            offset: {
                top: $('#services').offset().top
            }
        });

        function test() {
            $('#insert_form')[0].reset();
            $('#AddTransaction').modal('show');
        }

        function addBud() {
            $('#insert_budget')[0].reset();
            $('#AddBudget').modal('show');    
        }

        function OpenEditTransaction() {
            $('#EditTransaction').modal('show');
        }

        // Data Picker Initialization
        $('.datepicker').pickadate();
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
                    <p class="font-weight-light text-dark mb-0"> <a href="../main/logout_inc.php">Log Out</a></p>
                </div>
            </div>
        </div>

        <ul class="nav flex-column mb-0">
            <li class="nav-item active-ground py-2">
                <a href="home.html" class="nav-link text-light text-uppercase">
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
            <li class="nav-item py-2">
                <a href="#" class="nav-link text-dark text-uppercase">
                    <i class="fa fa-calendar mr-3 fa-fw" aria-hidden="true"></i>
                    Calendar
                </a>
            </li>
            <!-- <li class="nav-item py-2">
                <a href="#" class="nav-link text-light font-italic">
                    <i class="fa fa-picture-o mr-3 text-primary fa-fw"></i>
                    Gallery
                </a>
            </li> -->
        </ul>
    </div>
    <!-- End vertical navbar -->


    <!-- Page content holder -->
    <div class="page-content p-0" id="content">
        <nav class="navbar">
            <button id="sidebarCollapse" type="button" class="btn btn-light shadow-sm px-4"><i class="fa fa-bars mr-0"></i></button>
            <ul class="nav justify-content-end">
                <li class="nav-link py-0">
                    <button type="button" class="btn bg-darkblue text-light addBtn" data-toggle="" onclick="test();" data-target="">Add Transaction</button>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-darkblue" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                    </a>

                </li>
            </ul>
        </nav>
        <!-- Toggle button -->


        <!-- Demo content -->
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 shadow bg-white rounded">
                <div class="row py-3 justify-content-center mx-auto">
                    <div class="col py-1 text-center">
                        <h6>Last Month</h6>
                    </div>
                    <div class="col py-1 text-center border-bottom border-2 border-info">
                        <h6 class="text-info">
                            <?php
                            if ($month == "01") {
                                echo ("January");
                            } else if ($month == "02") {
                                echo ("February");
                            } else if ($month == "03") {
                                echo ("March");
                            } else if ($month == "04") {
                                echo ("April");
                            } else if ($month == "05") {
                                echo ("May");
                            } else if ($month == "06") {
                                echo ("June");
                            } else if ($month == "07") {
                                echo ("July");
                            } else if ($month == "08") {
                                echo ("August");
                            } else if ($month == "09") {
                                echo ("September");
                            } else if ($month == "10") {
                                echo ("October");
                            } else if ($month == "11") {
                                echo ("November");
                            } else if ($month == "12") {
                                echo ("December");
                            }
                            ?>
                        </h6>
                    </div>
                    <div class="col py-1 text-center">
                        <h6>Future</h6>
                    </div>
                </div>
                <?php
                $totalExp = 0;
                $totalIn = 0;
                $totalNet = 0;
                // Calculation Expense
                $sqlTotalExp = "SELECT * FROM expense WHERE expense_user_fk_id='$id' AND MONTH(expense_dateTime)='$month' ";
                $resultTotalExp = mysqli_query($conn, $sqlTotalExp);
                while ($rowTotalExp = $resultTotalExp->fetch_assoc()) {
                    $totalExp = $totalExp + $rowTotalExp['expense_amount'];
                }

                // Calculation Income
                $sqlTotalIn = "SELECT * FROM income WHERE income_user_fk_id='$id' AND MONTH(income_dateTime)='$month' ";
                $resultTotalIn = mysqli_query($conn, $sqlTotalIn);
                while ($rowTotalIn = $resultTotalIn->fetch_assoc()) {
                    $totalIn = $totalIn + $rowTotalIn['income_amount'];
                }

                $totalNet = $totalIn - $totalExp;
                ?>

                <div class="row py-1 px-2">
                    <div class="col">
                        <h6>Income</h6>
                    </div>
                    <div class="col text-right text-primary">
                        <h6>+$<?php echo ($totalIn) ?></h6>
                    </div>
                </div>
                <div class="row py-1 px-2">
                    <div class="col">
                        <h6>Expense</h6>
                    </div>
                    <div class="col text-right text-danger">
                        <h6>-$<?php echo ($totalExp) ?></h6>
                    </div>
                </div>
                <div class="row px-2">
                    <div class="col">

                    </div>
                    <div class="col">

                    </div>
                    <div class="col pr-0 mr-3 border-top border-2 text-right">
                        <?php
                        if ($totalIn > $totalExp) {
                        ?>
                            <h6 class="pt-2 text-primary">+$<?php echo ($totalNet); ?></h6>
                        <?php
                        } else if ($totalIn < $totalExp) {
                        ?>
                            <h6 class='pt-2 text-danger'>-$<?php echo (abs($totalNet)); ?></h6>
                        <?php
                        } else if ($totalIn == $totalExp) {
                        ?>
                            <h6 class="pt-2 text-primary">+$<?php echo ($totalNet); ?></h6>
                        <?php
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="row ml-5 my-3 d-flex justify-content-center">
            <div class="col-md-5 shadow bg-white rounded">
                <div class="row py-3 px-2">
                    <div class="col">
                        <h5 class="my-2">BUDGETS</h5>
                    </div>
                    <div class="col text-right">
                        <button type="button" class="btn text-primary" data-toggle="" data-target="" onclick="addBud();">Add</button>
                    </div>
                </div>
                <div class="row justify-content-center mx-2">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-left">Category</th>
                                <th scope="col" class="text-right">Avaiable</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sqlBud = "SELECT * FROM expense_budget WHERE exp_user_fk_id='$id' AND exp_bud_month='$currentMonth' ";
                                $resultBud = mysqli_query($conn, $sqlBud);
                                $totalBudAmount = 0;
                                while($rowBud = mysqli_fetch_assoc($resultBud))
                                {
                                    $unused_amount = $rowBud['exp_bud_amount'] - $rowBud['exp_bud_used_amount'];
                                    $totalBudAmount = $totalBudAmount + $unused_amount;
                            ?>
                                    <tr>
                                        <th scope="row" class="font-weight-light"><?php echo($rowBud['exp_bud_cat']) ?></th>
                            <?php
                                    if ($unused_amount >= 0)
                                    {
                            ?>
                                        <td class="text-right text-success">+ <?php echo($unused_amount); ?></td>
                            <?php
                                    }
                                    else 
                                    {
                            ?>  
                                        <td class="text-right text-danger">- <?php echo(abs($unused_amount)); ?></td>
                            <?php
                                    }
                            ?>
                                    </tr>    
                            <?php
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr class="">
                                <td class="font-weight-normal">TOTAL</td>
                                <td class="text-right text-success">
                                    <?php
                                        if($totalBudAmount >= 0)
                                        {
                                    ?>
                                        <td class="text-right text-success">+ <?php echo($totalBudAmount); ?></td>
                                    <?php
                                        }
                                        else 
                                        {
                                    ?>
                                        <td class="text-right text-danger">- <?php echo(abs($totalBudAmount)); ?></td>
                                    <?php
                                        }
                                    ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col">
                <div class="container">
                    <!-- Calendar -->
                    <!-- <div class="calendar shadow bg-white p-5">
                        <div class="d-flex align-items-center"><i class="fa fa-calendar fa-2x mr-3"></i>
                            <h4 class="month font-weight-bold mb-0 text-uppercase">December 2019</h4>
                        </div>
                        <p class="font-italic text-muted mb-5">No events for this day.</p>
                        <ol class="day-names list-unstyled">
                            <li class="font-weight-bold text-uppercase">Sun</li>
                            <li class="font-weight-bold text-uppercase">Mon</li>
                            <li class="font-weight-bold text-uppercase">Tue</li>
                            <li class="font-weight-bold text-uppercase">Wed</li>
                            <li class="font-weight-bold text-uppercase">Thu</li>
                            <li class="font-weight-bold text-uppercase">Fri</li>
                            <li class="font-weight-bold text-uppercase">Sat</li>
                        </ol>

                        <ol class="days list-unstyled">
                            <li>
                                <div class="date">1</div>
                                <div class="event bg-success">Event with Long Name</div>
                            </li>
                            <li>
                                <div class="date">2</div>
                            </li>
                            <li>
                                <div class="date">3</div>
                            </li>
                            <li>
                                <div class="date">4</div>
                            </li>
                            <li>
                                <div class="date">5</div>
                            </li>
                            <li>
                                <div class="date">6</div>
                            </li>
                            <li>
                                <div class="date">7</div>
                            </li>
                            <li>
                                <div class="date">8</div>
                            </li>
                            <li>
                                <div class="date">9</div>
                            </li>
                            <li>
                                <div class="date">10</div>
                            </li>
                            <li>
                                <div class="date">11</div>
                            </li>
                            <li>
                                <div class="date">12</div>
                            </li>
                            <li>
                                <div class="date">13</div>
                                <div class="event all-day begin span-2 bg-warning">Event Name</div>
                            </li>
                            <li>
                                <div class="date">14</div>
                            </li>
                            <li>
                                <div class="date">15</div>
                                <div class="event all-day end bg-success">Event Name</div>
                            </li>
                            <li>
                                <div class="date">16</div>
                            </li>
                            <li>
                                <div class="date">17</div>
                            </li>
                            <li>
                                <div class="date">18</div>
                            </li>
                            <li>
                                <div class="date">19</div>
                            </li>
                            <li>
                                <div class="date">20</div>
                            </li>
                            <li>
                                <div class="date">21</div>
                                <div class="event bg-primary">Event Name</div>
                                <div class="event bg-success">Event Name</div>
                            </li>
                            <li>
                                <div class="date">22</div>
                                <div class="event bg-info">Event with Longer Name</div>
                            </li>
                            <li>
                                <div class="date">23</div>
                            </li>
                            <li>
                                <div class="date">24</div>
                            </li>
                            <li>
                                <div class="date">25</div>
                            </li>
                            <li>
                                <div class="date">26</div>
                            </li>
                            <li>
                                <div class="date">27</div>
                            </li>
                            <li>
                                <div class="date">28</div>
                            </li>
                            <li>
                                <div class="date">29</div>
                            </li>
                            <li>
                                <div class="date">30</div>
                            </li>
                            <li>
                                <div class="date">31</div>
                            </li>
                            <li class="outside">
                                <div class="date">1</div>
                            </li>
                            <li class="outside">
                                <div class="date">2</div>
                            </li>
                            <li class="outside">
                                <div class="date">3</div>
                            </li>
                            <li class="outside">
                                <div class="date">4</div>
                            </li>
                        </ol>
                    </div> -->
                    <?php
                    $dateComponents = getdate();
                    $calendarYear = $dateComponents['year'];
                    $calendarMonth = $currentMonth;
                    build_calendar($calendarMonth, $calendarYear);
                    ?>
                </div>
            </div>
        </div>

        <div class="row my-4 d-flex justify-content-center">
            <div class="col-md-11 bg-white rounded py-2">
                <div class="row mx-2 pt-2">
                    <h4>Transactions</h4>
                    <div class="col text-right">
                        <i class="fas fa-download"></i>
                    </div>
                    <span class="">

                    </span>

                </div>

                <div class="container">
                    <div class="table-responsive-lg">
                        <table class="table table-hover table-bordered TransactionTable" id="TransactionTable" style="width: 100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Tag</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Amount</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($day = 0; $day < $arrlength; $day++) {
                                    $contDay = $calMonth[$day];
                                    $preDate = "";

                                    // Get expense data
                                    $sqlAllExp = "SELECT * FROM expense WHERE expense_user_fk_id='$id' AND MONTH(expense_dateTime)='$currentMonth' AND DAY(expense_dateTime)='$contDay'";
                                    $resultAllExp = mysqli_query($conn, $sqlAllExp);
                                    while ($rowAllExp = $resultAllExp->fetch_assoc()) {
                                        if ($preDate != $rowAllExp['expense_dateTime']) {
                                            $preDate = $rowAllExp['expense_dateTime'];
                                            $dataDate_format = strtotime($preDate);
                                            $newDateFormat = date('D, F d', $dataDate_format);
                                ?>
                                            <tr>
                                                <td scope="row"><?php echo ($newDateFormat); ?></td>
                                                <td><?php echo ($rowAllExp['expense_categories']); ?></td>
                                                <td><?php echo ($rowAllExp['expense_tag']) ?></td>
                                                <td><?php echo ($rowAllExp['expense_description']) ?></td>
                                                <td class="text-danger">-$ <?php echo ($rowAllExp['expense_amount']) ?></td>
                                                <td>
                                                    <input type="button" name="edit" value="Edit" id="e<?php echo ($rowAllExp['expense_id']); ?>" class="btn btn-info btn-xs edit_data" />
                                                    <a href="deleteExpense.php?id=<?php echo($rowAllExp['expense_id']) ?>" data-toggle="" data-target=""><i class="far fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        <?php
                                        } else if ($preDate == $rowAllExp['expense_dateTime']) {
                                        ?>
                                            <tr>
                                                <td scope="row"><?php echo ($newDateFormat); ?></td>
                                                <td><?php echo ($rowAllExp['expense_categories']); ?></td>
                                                <td><?php echo ($rowAllExp['expense_tag']) ?></td>
                                                <td><?php echo ($rowAllExp['expense_description']) ?></td>
                                                <td class="text-danger">-$ <?php echo ($rowAllExp['expense_amount']) ?></td>
                                                <td>
                                                    <input type="button" name="edit" value="Edit" id="e<?php echo ($rowAllExp['expense_id']); ?>" class="btn btn-info btn-xs edit_data" />
                                                    <a href="deleteExpense.php?id=<?php echo($rowAllExp['expense_id']) ?>" data-toggle="" data-target=""><i class="far fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }

                                    // Get income data
                                    $sqlAllIn = "SELECT * FROM income WHERE income_user_fk_id='$id' AND MONTH(income_dateTime)='$currentMonth' AND DAY(income_dateTime)='$contDay'";
                                    $resultAllIn = mysqli_query($conn, $sqlAllIn);
                                    while ($rowAllIn = mysqli_fetch_assoc($resultAllIn)) {
                                        if ($preDate == "") {
                                            $preDate = $rowAllIn['income_dateTime'];
                                            $dataDate_format = strtotime($preDate);
                                            $newDateFormat = date('D, F d', $dataDate_format);
                                        ?>
                                            <tr>
                                                <td scope="row"><?php echo ($newDateFormat) ?></td>
                                                <td><?php echo ($rowAllIn['income_categories']) ?></td>
                                                <td><?php echo ($rowAllIn['income_tag']) ?></td>
                                                <td><?php echo ($rowAllIn['income_description']) ?></td>
                                                <td class="text-primary">+$ <?php echo ($rowAllIn['income_amount']) ?></td>
                                                <td>
                                                    <input type="button" name="edit" value="Edit" id="i<?php echo ($rowAllIn['income_id']); ?>" class="btn btn-info btn-xs edit_data" />
                                                    <a href="deleteIncome.php?id=<?php echo($rowAllIn['income_id']) ?>" data-toggle="" data-target=""><i class="far fa-trash-alt"></i></a>    
                                                </td>
                                            </tr>
                                        <?php
                                        } else {
                                        ?>
                                            <tr>
                                                <td scope="row"><?php echo ($newDateFormat) ?></td>
                                                <td><?php echo ($rowAllIn['income_categories']) ?></td>
                                                <td><?php echo ($rowAllIn['income_tag']) ?></td>
                                                <td><?php echo ($rowAllIn['income_description']) ?></td>
                                                <td class="text-primary">+$ <?php echo ($rowAllIn['income_amount']) ?></td>
                                                <td>
                                                    <input type="button" name="edit" value="Edit" id="i<?php echo ($rowAllIn['income_id']); ?>" class="btn btn-info btn-xs edit_data" />
                                                    <a href="deleteIncome.php?id=<?php echo($rowAllIn['income_id']) ?>" data-toggle="" data-target=""><i class="far fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <script>
                    // For Table Pagnition
                    $('.TransactionTable').DataTable();
                </script>
            </div>
        </div>

        <!-- End demo content -->
    </div>

    <!-- Add Transaction Modal -->
    <div class="modal fade" id="AddTransaction" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Transaction</h5>
                    <button type="button" id="addTransaction" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body justify-content-md-center" id="modal-body">
                    <form action="" id="insert_form" class="container-fluid" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">Type</label>
                                <select name="trans_type" class="form-control" id="trans_type" required>
                                    <option value="Income">Income</option>
                                    <option value="Expense">Expense</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Cateogry</label>
                                <select name="trans_cat" class="form-control" id="trans_cat" required>
                                    <?php
                                    // Show Expense Categories
                                    $sqlUserCat = "SELECT * FROM expensecat WHERE extra_cat_on_user_id IN(0,'$id')";
                                    $resultUserCat = mysqli_query($conn, $sqlUserCat);
                                    while ($rowUserCat = mysqli_fetch_assoc($resultUserCat)) {
                                    ?>
                                        <option value="<?php echo ($rowUserCat['categories_name']) ?>"><?php echo ($rowUserCat['categories_name']) ?></option>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    $sqlUserInCat = "SELECT * FROM incomecat WHERE extra_cat_on_user_id IN(0,'$id')";
                                    $resultUserInCat = mysqli_query($conn, $sqlUserInCat);
                                    while ($rowUserInCat = mysqli_fetch_assoc($resultUserInCat)) {
                                    ?>
                                        <option value="<?php echo ($rowUserInCat['income_categories_name']) ?>"><?php echo ($rowUserInCat['income_categories_name']) ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">Date</label>
                                <input name="datetime" type="date" id="datetime" class="form-control" data-provide="datapicker" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Amount</label>
                                <input name="trans_amount" id="trans_amount" type="number" class="form-control" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="form-group col-md-6">
                                <label for="">Tag</label>
                                <input type="text" name="trans_tag" id="trans_tag" placeholder="#Something" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Description</label>
                                <textarea name="trans_des" class="form-control" id="trans_des" cols="50" rows="3" placeholder="Add more details"></textarea>
                            </div>
                            <input type="hidden" name="editId" id="editId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" name="save" id="save" value="Save" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Transaction -->
    <div class="modal fade" id="DeleteTransaction" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Your transaction is successfully deleted!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Budget -->
    <div class="modal fade" id="AddBudget" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Expense Budget</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="addBudget.php" id="insert_budget" method="POST" class="container-fluid">
                        <div class="form-row">
                            <label for="">Cateogry</label>
                            <select name="bud_cat" class="form-control" id="bud_cat" required>
                                <?php
                                // Show Categories
                                $sqlUserCat = "SELECT * FROM expensecat WHERE extra_cat_on_user_id=0";
                                $resultUserCat = mysqli_query($conn, $sqlUserCat);
                                while ($rowUserCat = mysqli_fetch_assoc($resultUserCat)) {
                                ?>
                                    <option value="<?php echo ($rowUserCat['categories_name']) ?>"><?php echo ($rowUserCat['categories_name']) ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-row">
                            <label for="">For</label>
                            <select name="bud_month" class="form-control" id="bud_month" required>
                                <option value="January">January</option>
                                <option value="February 1">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <label for="">Amount</label>
                            <input name="bud_amount" id="bud_amount" type="number" class="form-control" placeholder="0.00" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <input type="submit" name="bud_add" id="bud_add" value="Save" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {

        $('.edit_data').click(function() {
            var editIdANDtype = $(this).attr('id');
            var editType = editIdANDtype.substr(0, 1);
            var editId = editIdANDtype.substr(1);
            var expense = "e";
            var income = "i";

            if (editType === expense) {
                $.ajax({
                    url: 'expenseFetch.php',
                    method: 'POST',
                    data: {
                        editId: editId
                    },
                    success: function(data) {
                        $('#modal-body').html(data);
                        $('#AddTransaction').modal('show');
                    }
                });
            } else if (editType === income) {
                $.ajax({
                    url: 'incomeFetch.php',
                    method: 'POST',
                    data: {
                        editId: editId
                    },
                    success: function(data) {
                        $('#modal-body').html(data);
                        $('#AddTransaction').modal('show');
                    }
                });
            }
        });

        $('.delete_data').click(function(){
            var deleteIdAndType = $(this).attr('id');
            var deleteType = deleteIdAndType.substr(0, 1);
            var deleteId = deleteIdAndType.substr(1);
            var expense = "e";
            var income = "i";

            if(confirm("Are You Sure?"))
            {
                if(deleteType === expense)
                {
                    $.ajax({
                        url: 'expenseDelete.php',
                        method: 'POST',
                        date: {
                            deleteId: deleteId
                        },
                        success: function(data) {
                            $('#DeleteTransaction').modal('show');
                        }
                    });
                }
                else if(deleteType === income)
                {
                    $.ajax({
                        url: 'incomeDelete.php',
                        method: 'POST',
                        date: {
                            deleteId: deleteId
                        },
                        success: function(data) {
                            $('#DeleteTransaction').modal('show');
                        }
                    });
                }
            }
        });
    });
</script>

</html>