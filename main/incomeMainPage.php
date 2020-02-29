<?php
    include("cons/config.php");
    session_start();
    if(!isset($_SESSION['user']))
    {
        header("location: signinPage.php?");
        exit();
    }
    else if(isset($_SESSION['user']))
    {
        $id=$_SESSION['id'];
        $email=$_SESSION['email'];
        $month = $_GET['month'];
        $monthToStyle = $month;

        // Get from the database
        $sql = "SELECT income.* FROM income LEFT JOIN userinfo ON user_id=income_user_fk_id WHERE income_user_fk_id='$id' AND MONTH(income_dateTime)='$month' ORDER BY income_dateTime ";
        $result = mysqli_query($conn, $sql);
        $preDate = "";
        $total = 0;

        // Inset into the database
        if(isset($_POST['save']))
        {
            $amount = mysqli_real_escape_string($conn, $_POST['amount']);
            $categories = mysqli_real_escape_string($conn, $_POST['categories']);
            $datetime = mysqli_real_escape_string($conn, $_POST['datetime']);
            // Take categories id
            $sqlCat = "SELECT income_categories_id FROM incomecat WHERE income_categories_name='$categories' ";
            $resultCat = mysqli_query($conn, $sqlCat);
            $rowCat = $resultCat->fetch_assoc();
            $catId = $rowCat['income_categories_id'];

            // Insert into income table
            $sqlIn = "INSERT INTO income (income_id, income_categories, income_user_fk_id, income_dateTime, income_amount) VALUES (null, '$categories', '$id', '$datetime', '$amount') ";
            mysqli_query($conn, $sqlIn);

            //Add to incomebycat table
            $addMonth = date('m', strtotime($datetime));
            $sqlByCat = "SELECT * FROM incomebycat WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$id' AND MONTH(income_cat_date)='$addMonth' ";
            $resultByCat = mysqli_query($conn, $sqlByCat);
            if($row=mysqli_fetch_assoc($resultByCat))
            {
                $updateAmount=0;
                $updateAmount = $amount + $row['income_cat_amount'];
                mysqli_query($conn, "UPDATE incomebycat SET income_cat_amount='$updateAmount' WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$id' AND MONTH(income_cat_date)='$addMonth' ");
            }
            else if(!$row=mysqli_fetch_assoc($resultByCat))
            {
                mysqli_query($conn,"INSERT INTO incomebycat(income_cat_fk_id, income_user_cat_id, income_cat_amount, income_cat_date) VALUES('$catId', '$id', '$amount', '$datetime') ");
            }
            $monthToStyle = $addMonth;
            header("location: incomeMainPage.php?month=$addMonth");
        }
        if(isset($_POST['goToMonth']))
        {
            $month = date('m',strtotime($_POST['month']));
            header("location: incomeMainPage.php?month=$month");
        }
        
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
    <title>Dashboard - Income</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", { packages: ["corechart"] });
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
            ['Categories', 'Amount'],

            <?php
                $sqlChart = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' ";
                $resultChart = mysqli_query($conn, $sqlChart);
                while($rowChart = $resultChart->fetch_assoc())
                {
                    $ChartCatId = $rowChart['income_cat_fk_id'];
                    $sqlChartCat = "SELECT income_categories_name FROM incomecat WHERE income_categories_id='$ChartCatId' ";
                    $resultChartCat = mysqli_query($conn, $sqlChartCat);
                    $rowChartCat = $resultChartCat->fetch_assoc();
                    echo "['".$rowChartCat['income_categories_name']."',".$rowChart['income_cat_amount']."],";
                }
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
                    Income Dashboard
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
        $currentMont = date('m', time());
    ?>

    <section id="sub-Main">
        <div class="container-fluid">
            <div class="row">

                <div class="col-2 shadow justify-content-md-center" id="left-column">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="monthlyMainPage.php?month=<?php echo($currentMont) ?> ">
                                <i class="fas fa-chart-line"></i>
                                <span>Monthly Overview</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="incomeMainPage.php?month=<?php echo($currentMont) ?> ">
                                <i class="fas fa-plus"></i>
                                <span>Incomes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="expenseMainPage.php?month=<?php echo($currentMont) ?> ">
                                <i class="fas fa-minus"></i>
                                <span>Expense</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout_inc.php">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Log Out</span>
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
                            <button type="submit" style="border:none;outline:none;background:transparent;" name="goToMonth"><i class="fas fa-angle-right"></i></button>
                        </div>
                    </form>

                    <?php
                            // Calculation Each Income
                            
                            //Salary
                            $sqlSalary = "SELECT * FROM incomebycat WHERE  income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='11' ";
                            $resultSalary = mysqli_query($conn, $sqlSalary);
                            $rowSalary = $resultSalary->fetch_assoc();
                            $amountSalary = $rowSalary['income_cat_amount'];

                            //Awards
                            $sqlAwards = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='12' ";
                            $resultAwards = mysqli_query($conn, $sqlAwards);
                            $rowAwards = $resultAwards->fetch_assoc();
                            $amountAwards = $rowAwards['income_cat_amount'];

                            //Grants
                            $sqlGrants = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='13' ";
                            $resultGrants = mysqli_query($conn, $sqlGrants);
                            $rowGrants = $resultGrants->fetch_assoc();
                            $amountGrants = $rowGrants['income_cat_amount'];

                            //Sale
                            $sqlSale = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='14' ";
                            $resultSale = mysqli_query($conn, $sqlSale);
                            $rowSale = $resultSale->fetch_assoc();
                            $amountSale = $rowSale['income_cat_amount'];

                            //Rental
                            $sqlRental = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='15' ";
                            $resultRental = mysqli_query($conn, $sqlRental);
                            $rowRental = $resultRental->fetch_assoc();
                            $amountRental = $rowRental['income_cat_amount'];

                            //Investments
                            $sqlInvestments = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='16' ";
                            $resultInvestments = mysqli_query($conn, $sqlInvestments);
                            $rowInvestments = $resultInvestments->fetch_assoc();
                            $amountInvestments = $rowInvestments['income_cat_amount'];

                            //Lottery
                            $sqlLottery = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='17' ";
                            $resultLottery = mysqli_query($conn, $sqlLottery);
                            $rowLottery = $resultLottery->fetch_assoc();
                            $amountLottery = $rowLottery['income_cat_amount'];

                            //Dividends
                            $sqlDividends = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='18' ";
                            $resultDividends = mysqli_query($conn, $sqlDividends);
                            $rowDividends = $resultDividends->fetch_assoc();
                            $amountDividends = $rowDividends['income_cat_amount'];

                            //Pocet
                            $sqlPocket = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='19' ";
                            $resultPocket = mysqli_query($conn, $sqlPocket);
                            $rowPocket = $resultPocket->fetch_assoc();
                            $amountPocket = $rowPocket['income_cat_amount'];

                            //Other
                            $sqlOthers = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='20' ";
                            $resultOthers = mysqli_query($conn, $sqlOthers);
                            $rowOthers = $resultOthers->fetch_assoc();
                            $amountOthers = $rowOthers['income_cat_amount'];
                    ?>

                    <div class="frame1">

                        <div class="row donut justify-content-md-center">
                            <div class="container-fluid">
                                <div id="donutchart"></div>
                            </div>
                        </div>

                        <div class="row justify-content-md-center">

                            <div class="datas">
                                <div class="data users">
                                    <div class="text">
                                        <span class="left">Salary</span>
                                        <?php
                                            if($amountSalary != 0)
                                            {
                                        ?>
                                            <span class="right"><?php echo($amountSalary) ?></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 Salary">

                                        </div>
                                    </div>
                                </div>

                                <div class="data gb">
                                    <div class="text">
                                        <span class="left">Awards</span>
                                        <?php
                                            if($amountAwards != 0)
                                            {
                                        ?>
                                            <span class="right"><?php echo($amountAwards) ?></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 Awards"></div>
                                    </div>
                                </div>

                                <div class="data projects">
                                    <div class="text">
                                        <span class="left">Grants</span>
                                        <?php
                                            if($amountGrants != 0)
                                            {
                                        ?>
                                            <span class="right"><?php echo($amountGrants) ?></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 Grants"></div>
                                    </div>
                                </div>

                                <div class="data projects">
                                    <div class="text">
                                        <span class="left">Sale</span>
                                        <?php
                                            if($amountSale != 0)
                                            {
                                        ?>
                                            <span class="right"><?php echo($amountSale) ?></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 Sale"></div>
                                    </div>
                                </div>

                                <div class="data projects">
                                    <div class="text">
                                        <span class="left">Rental</span>
                                        <?php
                                            if($amountRental != 0)
                                            {
                                        ?>
                                            <span class="right"><?php echo($amountRental) ?></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 Rental"></div>
                                    </div>
                                </div>

                                <div class="data projects">
                                    <div class="text">
                                        <span class="left">Investments</span>
                                        <?php
                                            if($amountInvestments != 0)
                                            {
                                        ?>
                                            <span class="right"><?php echo($amountInvestments) ?></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 Investments"></div>
                                    </div>
                                </div>

                                <div class="data projects">
                                    <div class="text">
                                        <span class="left">Lottery</span>
                                        <?php
                                            if($amountLottery != 0)
                                            {
                                        ?>
                                            <span class="right"><?php echo($amountLottery) ?></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 Lottery"></div>
                                    </div>
                                </div>

                                <div class="data projects">
                                    <div class="text">
                                        <span class="left">Dividends</span>
                                        <?php
                                            if($amountDividends != 0)
                                            {
                                        ?>
                                            <span class="right"><?php echo($amountDividends) ?></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 Dividends"></div>
                                    </div>
                                </div>

                                <div class="data projects">
                                    <div class="text">
                                        <span class="left">Pocket Money</span>
                                        <?php
                                            if($amountPocket != 0)
                                            {
                                        ?>
                                            <span class="right"><?php echo($amountPocket) ?></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 PocketMoney"></div>
                                    </div>
                                </div>

                                <div class="data projects">
                                    <div class="text">
                                        <span class="left">Others</span>
                                        <?php
                                            if($amountOthers != 0)
                                            {
                                        ?>
                                            <span class="right"><?php echo($amountOthers) ?></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 IncomeOther"></div>
                                    </div>
                                </div>
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
                            while($rowTable = mysqli_fetch_assoc($result))
                            {
                                if($preDate != $rowTable['income_dateTime'])
                                {
                                    $preDate = $rowTable['income_dateTime'];
                                    $preDate_format = strtotime($preDate);
                                    $new_date_format = date('D, F d', $preDate_format);
                                    $editMonth = date('m', $preDate_format);
                                    $sqlTotal = "SELECT income.* FROM income LEFT JOIN userinfo ON user_id=income_user_fk_id WHERE income_user_fk_id='$id' AND income_dateTime='$preDate' ";
                                    $resultTotal = mysqli_query($conn, $sqlTotal);
                                    while($rowTotal = mysqli_fetch_assoc($resultTotal))
                                    {
                                        $total = $total + $rowTotal['income_amount'];
                                    }
                        ?>
                            <tr class="dateUnderline">
                                <td class="day"><?php echo($new_date_format) ?></td>
                                <td class="gray text-right">MMK<?php echo($total); $total=0; ?></td>
                            </tr>

                            <tr id="two" class="income">
                                <td>
                                    <?php echo($rowTable['income_categories']) ?>
                                </td>
                                <td class="money">
                                    <?php echo($rowTable['income_amount']) ?>
                                    <a href="incomeEdit.php?id=<?php echo($rowTable['income_id'])?>&month=<?php echo($editMonth) ?>">
                                        <i class="fas fa-angle-right gray"></i></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                                }
                                else if($preDate == $rowTable['income_dateTime'])
                                {
                        ?>
                            <tr id="two" class="income">
                                <td><?php echo($rowTable['income_categories']) ?></td>
                                <td class="money"><?php echo($rowTable['income_amount']) ?>
                                    <a href="incomeEdit.php?id=<?php echo($rowTable['income_id'])?>&month=<?php echo($editMonth) ?>">
                                        <i class="fas fa-angle-right gray"></i></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                                }
                            }
                        ?>

                        </tbody>
                        <tbody id="bycata">

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

            <div class="addBtn">
                        <a href="" class="btn btn-outline-*" data-toggle="modal" data-target="#incomemodal">
                        <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
        </div>
    </section>

    <div class="modal fade" tabindex="-1" id="incomemodal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Income</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body justify-content-md-center">
                    <form action="" class="container-fluid" method="POST">
                        <div class="form-group row justify-content-md-center">
                            <div class="col-1 pr-0 my-auto text-center">
                                <i class="fas fa-dollar-sign"></i>
                            </div>

                            <div class="col-8">
                                <input name="amount" type="number" class="form-control" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="form-group row justify-content-md-center">
                            <div class="col-1 pr-0 my-auto text-center">
                                <i class="far fa-calendar-alt"></i>
                            </div>

                            <div class="col-8">
                                <input name="datetime" type="date" class="form-control" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="form-group row justify-content-md-center">
                            <div class="col-1 pr-0 my-auto text-center">
                                <i class="fas fa-list"></i>
                            </div>
                            <div class="col-8">
                                <select class="form-control" name="categories" id="" required>
                                    <option value="Salary">Salary</option>
                                    <option value="Awards">Awards</option>
                                    <option value="Grants">Grants</option>
                                    <option value="Sale">Sale</option>
                                    <option value="Rental">Rental</option>
                                    <option value="Investments">Investments</option>
                                    <option value="Lottery">Lottery</option>
                                    <option value="Dividends">Dividends</option>
                                    <option value="Pocket Money">Pocket Money</option>
                                    <option value="Others">Others</option>
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