<?php
    session_start();
    include("cons/config.php");
    if(isset($_SESSION['user']))
    {
        $id=$_SESSION['id'];
        $email=$_SESSION['email'];
        $month = $_GET['month'];
        $monthToStyle = $month;
        $currentMonth = $month;
        if(isset($_POST['goToMonth']))
        {
           $monthly = $_POST['month'];
           $dashMonth = date('m', strtotime($monthly));
           $monthToStyle = $dashMonth; 
           $currentMonth = $dashMonth; 
           header("location:monthlyMainPage.php?month=$dashMonth"); 
        }
        if($currentMonth == "01")
        {
            $calMonth = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        }
        else if($currentMonth == "02")
        {
            $calMonth = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28");
        }
        else if($currentMonth == "03")
        {
            $calMonth = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        }
        else if($currentMonth == "04")
        {
            $calMonth = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30");
        }
        else if($currentMonth == "05")
        {
            $calMonth = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        }
        else if($currentMonth == "06")
        {
            $calMonth = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30");
        }
        else if($currentMonth == "07")
        {
            $calMonth = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        }
        else if($currentMonth == "08")
        {
            $calMonth = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        }
        else if($currentMonth == "09")
        {
            $calMonth = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30");
        }
        else if($currentMonth == "10")
        {
            $calMonth = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        }
        else if($currentMonth == "11")
        {
            $calMonth = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30");
        }
        else if($currentMonth == "12")
        {
            $calMonth = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        }
            $arrlength = count($calMonth);

    }
    else if(!isset($_SESSION['user']))
    {
        header("location: signinPage.php?");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.php?month=<?php echo($monthToStyle) ?>" type="text/css">
    <script src="scriptMain.js" type="text/javascript"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- for google chart -->
    <script src="https://kit.fontawesome.com/8da23e008a.js"></script>
    <link href="https://fonts.googleapis.com/css?family=DM+Sans&display=swap" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="Image/Piggy.png">
    <title>Dashboard</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", { packages: ["corechart"] });
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
            ['Categories', 'Amount'],
            <?php
                $totalExp = 0;
                $totalIn = 0;
                $totalNet = 0;
                // Calculation Expense
                $sqlTotalExp = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' ";
                $resultTotalExp = mysqli_query($conn, $sqlTotalExp);
                while($rowTotalExp = $resultTotalExp->fetch_assoc())
                {
                    $totalExp = $totalExp + $rowTotalExp['expense_cat_amount'];
                }
                    
                // Calculation Income
                $sqlTotalIn = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' ";
                $resultTotalIn = mysqli_query($conn, $sqlTotalIn);
                while($rowTotalIn = $resultTotalIn->fetch_assoc())
                {
                    $totalIn = $totalIn + $rowTotalIn['income_cat_amount'];
                }

                $totalInCat = "Income";
                $totalExpCat = "Expense";
                $totalNetCat = "Net";
                $totalNet = $totalIn - $totalExp;
                echo "['".$totalInCat."',".$totalIn."],";
                echo "['".$totalExpCat."',".$totalExp."],";
            ?>
            
            ]);

            var options = {
                legend: { position: 'right', alignment: 'center' },
                tooltip: { fontSize: 15 },
                backgroundColor: 'transparent',
                height: 400,
                width: '100%',
                pieSliceText: 'none',
                pieHole: 0.78,
                colors: ['#00b8a9', '#3490de', '#444444', '#ff8a5c', '#ffdd67', '#f6416c', '#e23e57', '#ff5722'],
                chartArea: {
                    left: "20%",
                    top: "5%",
                    height: "90%",
                    width: "100%"
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>
    <script>
        window.addEventListener("load", function () {
            const preloader = document.querySelector(".preloader");
            preloader.classList.add("hidden");
        });
    </script>
</head>

<body>
    <div class="preloader" id="Loader">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    <header id="main">
        <nav class="navbar navbar-light bg-primary">
            <a class="navbar-brand" href="#"><i class="fas fa-piggy-bank"></i>Shinn Kya Mal</a>
            <ul class="navbar-nav mr-auto my-auto">
                <li class="nav-item">
                    Dashboard
                </li>
                <li class="nav-item">
                    <?php
                       if($month == "01")
                       {
                           echo("January");
                       }
                       else if($month == "02")
                       {
                            echo("February");
                       }
                       else if($month == "03")
                       {
                            echo("March");
                       }
                       else if($month == "04")
                       {
                            echo("April");
                       }
                       else if($month == "05")
                       {
                            echo("May");
                       }
                       else if($month == "06")
                       {
                            echo("June");
                       }
                       else if($month == "07")
                       {
                            echo("July");
                       }
                       else if($month == "08")
                       {
                            echo("August");
                       }
                       else if($month == "09")
                       {
                            echo("September");
                       }
                       else if($month == "10")
                       {
                            echo("October");
                       }
                       else if($month == "11")
                       {
                            echo("November");
                       }
                       else if($month == "12")
                       {
                            echo("December");
                       }
                    ?>
                </li>
            </ul>
            <span><a href="profilePage.php?"><i class="fas fa-user-circle"></i></a></span>
        </nav>
    </header>

    <!-- Calculating current month -->
    <?php
        $current = date('m', time());
    ?>

    <section id="sub-Main">
        <div class="container-fluid">
            <div class="row">

                <div class="col-2 shadow justify-content-md-center" id="left-column">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="monthlyMainPage.php?month=<?php echo($current) ?>">
                                <i class="fas fa-chart-line"></i>
                                <span>Monthly Overview</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="incomeMainPage.php?month=<?php echo($current) ?>">
                                <i class="fas fa-plus"></i>
                                <span>Incomes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="expenseMainPage.php?month=<?php echo($current) ?>">
                                <i class="fas fa-minus"></i>
                                <span>Expense</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout_inc.php?">
                                <i class="fas fa-sign-out-alt"></i>
                                <span> Log Out</span>
                            </a>
                        </li>
                    </ul>
                </div>


                <div class="col-7 dashboard " id="middle-column">

                    <form action="" method="POST">
                        <div id="clock">
                            <select id="months" name="month">
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
                            <button type="submit" style="border:none;outline:none;background:transparent;" name="goToMonth"><i class="fas fa-angle-right gray"></i></button>
                        </div>
                    </form>

                        <?php
                            $totalExp = 0;
                            $totalIn = 0;
                            $totalNet = 0;
                            // Calculation Expense
                            $sqlTotalExp = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' ";
                            $resultTotalExp = mysqli_query($conn, $sqlTotalExp);
                            while($rowTotalExp = $resultTotalExp->fetch_assoc())
                            {
                                $totalExp = $totalExp + $rowTotalExp['expense_cat_amount'];
                            }
                    
                            // Calculation Income
                            $sqlTotalIn = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' ";
                            $resultTotalIn = mysqli_query($conn, $sqlTotalIn);
                            while($rowTotalIn = $resultTotalIn->fetch_assoc())
                            {
                                $totalIn = $totalIn + $rowTotalIn['income_cat_amount'];
                            }

                            $totalNet = $totalIn - $totalExp;
                        ?>

                    <div class="frame1">

                        <div class="row justify-content-md-center">
                            <div class="plan basic col-3" onclick="void(0);">
                                <div class="title">Incomes</div>
                                <div class="price"><?php echo($totalIn) ?></div>
                                <div class="lines">
                                    <div class="line1" style="width: 69px;"></div>
                                    <div class="line1" style="width: 59px;"></div>
                                    <div class="line1" style="width: 66px;"></div>
                                    <div class="line1" style="width: 46px;"></div>
                                </div>
                            </div>

                            <div class="plan pro col-3" onclick="void(0);">
                                <div class="title">Expense</div>
                                <div class="price"><?php echo($totalExp) ?></div>
                                <div class="lines">
                                    <div class="line1" style="width: 69px;"></div>
                                    <div class="line1" style="width: 59px;"></div>
                                    <div class="line1" style="width: 66px;"></div>
                                    <div class="line1" style="width: 46px;"></div>
                                </div>
                            </div>

                            <div class="plan premium col-3" onclick="void(0);">
                                <div class="title">Net</div>
                                <div class="price"><?php echo($totalNet) ?></div>
                                <div class="lines">
                                    <div class="line1" style="width: 69px;"></div>
                                    <div class="line1" style="width: 59px;"></div>
                                    <div class="line1" style="width: 66px;"></div>
                                    <div class="line1" style="width: 46px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-md-center">

                            <div class="datas">
                                <div class="data users">
                                    <div class="text">
                                        <span class="left">Income</span>
                                        <span class="right"><?php echo($totalIn) ?></span>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 Income"></div>
                                    </div>
                                </div>

                                <div class="data gb">
                                    <div class="text">
                                        <span class="left">Expense</span>
                                        <span class="right"><?php echo($totalExp) ?></span>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 Expense"></div>
                                    </div>
                                </div>

                                <div class="data projects">
                                    <div class="text">
                                        <span class="left">Net</span>
                                        <span class="right"><?php echo($totalNet) ?></span>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 Total"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row donut justify-content-md-center">
                            <div class="container-fluid">
                                <div id="donutchart"></div>
                            </div>

                        </div>

                        <div class="row justify-content-md-center py-3">
                            <h6><i class="fas fa-copyright"></i> 2019 UIT. All Rights Reserved. </h6>
                        </div>
                    </div>


                </div>

                <div class="col-3 shadow" id="right-column">

                    <table>

                        <tr>
                            <th id="borderchange1" onclick="bydate()">By DATE</th>
                            <th id="borderchange2" onclick="bycata()">By CATAGORY</th>
                        </tr>

                        <tr class="blank_row">
                            <td colspan="1"></td>
                        </tr>


                        <tbody id="date">
                        
                        <?php
                            for($day=0; $day<$arrlength; $day++)
                            {
                                $contDay = $calMonth[$day];
                                $preDate = "";
                                // Get expense data
                                $sqlAllExp = "SELECT * FROM expense WHERE expense_user_fk_id='$id' AND MONTH(expense_dateTime)='$currentMonth' AND DAY(expense_dateTime)='$contDay' ";
                                $resultAllExp = mysqli_query($conn, $sqlAllExp);
                                while($rowAllExp = $resultAllExp->fetch_assoc())
                                {
                                    if($preDate!=$rowAllExp['expense_dateTime'])
                                    {
                                        $preDate = $rowAllExp['expense_dateTime'];
                                        $preDate_format = strtotime($preDate);
                                        $newDateFormat = date('D, F d', $preDate_format);
                        ?>
                                <tr class="dateUnderline">
                                    <td class="day"><?php echo($newDateFormat) ?></td>
                                    <td class="gray text-right">MMK</td>
                                </tr>
                                <tr id="two" class="expense">
                                    <td>
                                        <?php echo($rowAllExp['expense_categories']) ?>
                                    </td>
                                    <td class="money">
                                        <?php echo($rowAllExp['expense_amount']) ?>
                                        <a href="expenseEdit.php?id=<?php echo($rowAllExp['expense_id']) ?>">
                                            <i class="fas fa-angle-right gray"></i></i>
                                        </a>
                                    </td>
                                </tr> 
                        <?php
                                    }
                                    else if($preDate == $rowAllExp['expense_dateTime'])
                                    {
                        ?>
                                <tr id="two" class="expense">
                                    <td>
                                        <?php echo($rowAllExp['expense_categories']) ?>
                                    </td>
                                    <td class="money">
                                        <?php echo($rowAllExp['expense_amount']) ?>
                                        <a href="expenseEdit.php?id=<?php echo($rowAllExp['expense_id']) ?>">
                                            <i class="fas fa-angle-right gray"></i></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php                
                                    }
                                }

                                // Get data from income
                                $sqlAllIn = "SELECT * FROM income WHERE income_user_fk_id='$id' AND MONTH(income_dateTime)='$currentMonth' AND DAY(income_dateTime)='$contDay' ";
                                $resultAllIn = mysqli_query($conn, $sqlAllIn);
                                while($rowAllIn = mysqli_fetch_assoc($resultAllIn))
                                {
                                    if($preDate == "")
                                    {
                                        $preDate = $rowAllIn['income_dateTime'];
                                        $preDate_format = strtotime($preDate);
                                        $newDateFormat = date('D, F d', $preDate_format);
                        ?>  
                                <tr class="dateUnderline">
                                    <td class="day"><?php echo($newDateFormat) ?></td>
                                    <td class="gray text-right">MMK</td>
                                </tr>
                                <tr id="two" class="income">
                                    <td>
                                        <?php echo($rowAllIn['income_categories']) ?>
                                    </td>
                                    <td class="money">
                                        <?php echo($rowAllIn['income_amount']) ?>
                                        <a href="incomeEdit.php?id=<?php echo($rowAllIn['income_id']) ?>">
                                            <i class="fas fa-angle-right gray"></i></i>
                                        </a>
                                    </td>
                                </tr>            
                        <?php
                                    }
                                    else
                                    {
                        ?>
                            <tr id="two" class="income">
                                <td>
                                    <?php echo($rowAllIn['income_categories']) ?>
                                </td>
                                <td class="money">
                                    <?php echo($rowAllIn['income_amount']) ?>
                                    <a href="incomeEdit.php?id=<?php echo($rowAllIn['income_id']) ?>">
                                        <i class="fas fa-angle-right gray"></i></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                                    }            
                                }
                            }
                        ?>
                        
                        </tbody>
                        <tbody id="bycata">
                        <?php
                            $sqlByCatTable = "SELECT expensebycat.*, expensecat.categories_name FROM expensebycat LEFT JOIN expensecat ON expense_cat_fk_id=categories_id WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month'  ";
                            $resultByCatTable = mysqli_query($conn, $sqlByCatTable);
                            while($rowByCatTable = mysqli_fetch_assoc($resultByCatTable))
                            {
                                if($rowByCatTable['expense_cat_amount'] != 0)
                                {
                        ?>
                             <tr class="expenseCategory">
                                <td>
                                    <i class='fas fa-tag'></i> <?php echo($rowByCatTable['categories_name']) ?>

                                </td>
                                <td class="money">MMK<?php echo($rowByCatTable['expense_cat_amount']) ?></td>

                            </tr>
                        <?php
                                }
                            }
                        ?>

                        <?php
                            $sqlByCatTable = "SELECT incomebycat.*, incomecat.income_categories_name FROM incomebycat LEFT JOIN incomecat ON income_cat_fk_id=income_categories_id WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month'  ";
                            $resultByCatTable = mysqli_query($conn, $sqlByCatTable);
                            while($rowByCatTable = mysqli_fetch_assoc($resultByCatTable))
                            {
                                if($rowByCatTable['income_cat_amount'] != 0)
                                {
                        ?>
                             <tr class="incomeCategory">
                                <td>
                                    <i class='fas fa-tag'></i> <?php echo($rowByCatTable['income_categories_name']) ?>

                                </td>
                                <td class="money">MMK<?php echo($rowByCatTable['income_cat_amount']) ?></td>

                            </tr>
                        <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

</body>

</html>