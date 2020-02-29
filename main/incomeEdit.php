<?php
    session_start();
    if(isset($_SESSION['user']))
    {
        $user_id = $_SESSION['id'];
        $id = $_GET['id'];
        include("cons/config.php");

        // Get Categories Name from expense table
        $sql = "SELECT * FROM income WHERE income_id='$id' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $catName = $row['income_categories'];
        $date = $row['income_dateTime'];
        $dateMonth = date('m',strtotime($date));

        // Get Id Form Categories Table
        $sqlCatId = "SELECT * FROM incomecat WHERE income_categories_name='$catName' ";
        $resultCatId = mysqli_query($conn, $sqlCatId);
        $rowCatId = mysqli_fetch_assoc($resultCatId);
        $catId = $rowCatId['income_categories_id'];

        // Minus From ExpenseByCat
        $sqlMin = "SELECT * FROM incomebycat WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' ";
        $resutlMin = mysqli_query($conn, $sqlMin);
        $rowMin = mysqli_fetch_assoc($resutlMin);
        $amountMin = 0;
        $amountMin = $rowMin['income_cat_amount'] - $row['income_amount'];

        if(isset($_POST['edit']))
        {
            // Update ExpenseByCat table
            mysqli_query($conn,"UPDATE incomebycat SET income_cat_amount='$amountMin' WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' ");
            
            // Delete the expense or income
            $sqlDel = "DELETE FROM income WHERE income_id='$id' ";
            mysqli_query($conn, $sqlDel);

            $amount = mysqli_real_escape_string($conn, $_POST['amount']);
            $categories = mysqli_real_escape_string($conn, $_POST['categories']);
            $datetime = mysqli_real_escape_string($conn, $_POST['datetime']);
            
            // Take categories id
            $sqlCat = "SELECT income_categories_id FROM incomecat WHERE income_categories_name='$categories' ";
            $resultCat = mysqli_query($conn, $sqlCat);
            $rowCat = $resultCat->fetch_assoc();
            $catId = $rowCat['income_categories_id'];

            // Insert into expense table
            $sqlExp = "INSERT INTO income (income_id, income_categories, income_user_fk_id, income_dateTime, income_amount) VALUES ('$id', '$categories', '$user_id', '$datetime', '$amount') ";
            mysqli_query($conn, $sqlExp);

            //Add to expensebycat table
            $addMonth = date('m', strtotime($datetime));
            $sqlByCat = "SELECT * FROM incomebycat WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$addMonth' ";
            $resultByCat = mysqli_query($conn, $sqlByCat);
            if($rowByCat=mysqli_fetch_assoc($resultByCat))
            {
                $updateAmount=0;
                $updateAmount = $rowByCat['income_cat_amount'] + $amount;
                mysqli_query($conn, "UPDATE incomebycat SET income_cat_amount='$updateAmount' WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$addMonth' ");
            }
            else if(!$rowByCat=mysqli_fetch_assoc($resultByCat))
            {
                mysqli_query($conn, "INSERT INTO incomebycat(income_cat_fk_id, income_user_cat_id, income_cat_amount, income_cat_date) VALUES('$catId', '$user_id', '$amount', '$datetime') ");
            }
            header("location: incomeMainPage.php?month=$addMonth");
        }
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
    <link rel="stylesheet" href="style.php?month=<?php echo($dateMonth) ?>" type="text/css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <script src="https://kit.fontawesome.com/8da23e008a.js"></script>
    <link href="https://fonts.googleapis.com/css?family=DM+Sans&display=swap" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="Image/Piggy.png">
    <title>Details</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", { packages: ["corechart"] });
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
            ['Categories', 'Amount'],

            <?php
                $sqlChart = "SELECT * FROM incomebycat WHERE income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' ";
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
                    left: "5%",
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
            </ul>
            <span><a href="profilePage.php"><i class="fas fa-user-circle"></i></a></span>
        </nav>
    </header>

    <?php
        $currnetMont = date('m', time());
    ?>

    <section id="sub-Main" class="h-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 shadow justify-content-md-center" id="left-column">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="monthlyMainPage.php?month=<?php echo($currnetMont) ?>">
                                <i class="fas fa-chart-line"></i>
                                <span>Monthly Overview</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="incomeMainPage.php?month=<?php echo($currnetMont) ?>">
                                <i class="fas fa-plus"></i>
                                <span>Incomes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="expenseMainPage.php?month=<?php echo($currnetMont) ?>">
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
                    <?php
                            // Calculation Each Income
                            
                            //Salary
                            $sqlSalary = "SELECT * FROM incomebycat WHERE  income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' AND income_cat_fk_id='11' ";
                            $resultSalary = mysqli_query($conn, $sqlSalary);
                            $rowSalary = $resultSalary->fetch_assoc();
                            $amountSalary = $rowSalary['income_cat_amount'];

                            //Awards
                            $sqlAwards = "SELECT * FROM incomebycat WHERE income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' AND income_cat_fk_id='12' ";
                            $resultAwards = mysqli_query($conn, $sqlAwards);
                            $rowAwards = $resultAwards->fetch_assoc();
                            $amountAwards = $rowAwards['income_cat_amount'];

                            //Grants
                            $sqlGrants = "SELECT * FROM incomebycat WHERE income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' AND income_cat_fk_id='13' ";
                            $resultGrants = mysqli_query($conn, $sqlGrants);
                            $rowGrants = $resultGrants->fetch_assoc();
                            $amountGrants = $rowGrants['income_cat_amount'];

                            //Sale
                            $sqlSale = "SELECT * FROM incomebycat WHERE income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' AND income_cat_fk_id='14' ";
                            $resultSale = mysqli_query($conn, $sqlSale);
                            $rowSale = $resultSale->fetch_assoc();
                            $amountSale = $rowSale['income_cat_amount'];

                            //Rental
                            $sqlRental = "SELECT * FROM incomebycat WHERE income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' AND income_cat_fk_id='15' ";
                            $resultRental = mysqli_query($conn, $sqlRental);
                            $rowRental = $resultRental->fetch_assoc();
                            $amountRental = $rowRental['income_cat_amount'];

                            //Investments
                            $sqlInvestments = "SELECT * FROM incomebycat WHERE income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' AND income_cat_fk_id='16' ";
                            $resultInvestments = mysqli_query($conn, $sqlInvestments);
                            $rowInvestments = $resultInvestments->fetch_assoc();
                            $amountInvestments = $rowInvestments['income_cat_amount'];

                            //Lottery
                            $sqlLottery = "SELECT * FROM incomebycat WHERE income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' AND income_cat_fk_id='17' ";
                            $resultLottery = mysqli_query($conn, $sqlLottery);
                            $rowLottery = $resultLottery->fetch_assoc();
                            $amountLottery = $rowLottery['income_cat_amount'];

                            //Dividends
                            $sqlDividends = "SELECT * FROM incomebycat WHERE income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' AND income_cat_fk_id='18' ";
                            $resultDividends = mysqli_query($conn, $sqlDividends);
                            $rowDividends = $resultDividends->fetch_assoc();
                            $amountDividends = $rowDividends['income_cat_amount'];

                            //Pocet
                            $sqlPocket = "SELECT * FROM incomebycat WHERE income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' AND income_cat_fk_id='19' ";
                            $resultPocket = mysqli_query($conn, $sqlPocket);
                            $rowPocket = $resultPocket->fetch_assoc();
                            $amountPocket = $rowPocket['income_cat_amount'];

                            //Other
                            $sqlOthers = "SELECT * FROM incomebycat WHERE income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' AND income_cat_fk_id='20' ";
                            $resultOthers = mysqli_query($conn, $sqlOthers);
                            $rowOthers = $resultOthers->fetch_assoc();
                            $amountOthers = $rowOthers['income_cat_amount'];
                        ?>
                <div class="col" id="middle-column">
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

                <?php
                    $resultEdit = mysqli_query($conn, "SELECT * FROM income WHERE income_id='$id' ");
                    $rowEdit = mysqli_fetch_assoc($resultEdit);
                    $dateDetail = strtotime($rowEdit['income_dateTime']);
                    $newDateFormat = date('d-M-Y', $dateDetail);
                    $returnMonth = date('m', $dateDetail);
                ?>

                <div class="col-3 shadow" id="right-column">
                    <div class="container-fluid">
                        <div class="row upperDetail">
                            <ul>
                                <li><a href="incomeMainPage.php?month=<?php echo($returnMonth) ?>"><i class="fas fa-chevron-left"></i></a></li>
                                <li>
                                    <h4>Detail</h4>
                                </li>
                                <li>
                                    <button type="button" class="btn btn-outline-*" data-toggle="modal" data-target="#editmodal">
                                        Edit
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="container-fluid amount">
                        <div class="row justify-content-md-center">
                            <ul>
                                <li>
                                    <i class="fas fa-money-bill"></i>
                                </li>
                                <li>
                                    <h4><?php echo($rowEdit['income_amount']) ?></h4>
                                </li>
                            </ul>
                        </div>

                        <div class="row justify-content-md-center">
                            <i class="fas fa-list-ul"></i>
                            <p><?php echo($rowEdit['income_categories']) ?></p>
                        </div>

                        <div class="row justify-content-md-center">
                            <i class="fas fa-calendar-alt"></i>
                            <p><?php echo($newDateFormat) ?></p>
                        </div>


                    </div>

                    <div class="row justify-content-md-center lastDelete">
                        <div class="row justify-content-md-center">
                            <i class="far fa-trash-alt"></i>
                            <a href="deleteIncomeData.php?id=<?php echo($id) ?>" class="text-dark">Delete</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Dar ka Income Modal -->

    <div class="modal fade" tabindex="-1" id="editmodal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Income</h5>
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
                                    <input name="amount" type="number" class="form-control" value=<?php echo($rowEdit['income_amount']) ?> requried>
                                </div>
                            </div>
                            <div class="form-group row justify-content-md-center">
                                <div class="col-1 pr-0 my-auto text-center">
                                        <i class="far fa-calendar-alt"></i>
                                </div>
    
                                <?php
                                    $date = $rowEdit['income_dateTime'];
                                ?>

                                <div class="col-8">
                                    <input name="datetime" type="date" class="form-control" value=<?php echo($date) ?> required>
                                </div>
                            </div>
    
                            <div class="form-group row justify-content-md-center">
                                <div class="col-1 pr-0 my-auto text-center">
                                        <i class="fas fa-list"></i>
                                </div>
                                <div class="col-8">
                                    <select class="form-control" name="categories" required>
                                    <?php
                                        $selected = $rowEdit['income_categories'];
                                        if($selected == "Salary")
                                        {
                                    ?>
                                        <option selected value="Salary">Salary</option>
                                        <option value="Awards">Awards</option>
                                        <option value="Grants">Grants</option>
                                        <option value="Sale">Sale</option>
                                        <option value="Rental">Rental</option>
                                        <option value="Investments">Investments</option>
                                        <option value="Lottery">Lottery</option>
                                        <option value="Dividends">Dividends</option>
                                        <option value="Pocket Money">Pocket Money</option>
                                        <option value="Others">Others</option>                                    
                                    <?php
                                        }
                                        else if($selected == "Awards")
                                        {
                                    ?>
                                        <option value="Salary">Salary</option>
                                        <option selected value="Awards">Awards</option>
                                        <option value="Grants">Grants</option>
                                        <option value="Sale">Sale</option>
                                        <option value="Rental">Rental</option>
                                        <option value="Investments">Investments</option>
                                        <option value="Lottery">Lottery</option>
                                        <option value="Dividends">Dividends</option>
                                        <option value="Pocket Money">Pocket Money</option>
                                        <option value="Others">Others</option>
                                    <?php
                                        }
                                        else if($selected == "Grants")
                                        {
                                    ?>
                                        <option value="Salary">Salary</option>
                                        <option value="Awards">Awards</option>
                                        <option selected value="Grants">Grants</option>
                                        <option value="Sale">Sale</option>
                                        <option value="Rental">Rental</option>
                                        <option value="Investments">Investments</option>
                                        <option value="Lottery">Lottery</option>
                                        <option value="Dividends">Dividends</option>
                                        <option value="Pocket Money">Pocket Money</option>
                                        <option value="Others">Others</option>
                                    <?php
                                        }
                                        else if($selected == "Sale")
                                        {
                                    ?>
                                        <option value="Salary">Salary</option>
                                        <option value="Awards">Awards</option>
                                        <option value="Grants">Grants</option>
                                        <option selected value="Sale">Sale</option>
                                        <option value="Rental">Rental</option>
                                        <option value="Investments">Investments</option>
                                        <option value="Lottery">Lottery</option>
                                        <option value="Dividends">Dividends</option>
                                        <option value="Pocket Money">Pocket Money</option>
                                        <option value="Others">Others</option>
                                    <?php
                                        }
                                        else if($selected =="Rental")
                                        {
                                    ?>
                                        <option value="Salary">Salary</option>
                                        <option value="Awards">Awards</option>
                                        <option value="Grants">Grants</option>
                                        <option value="Sale">Sale</option>
                                        <option selected value="Rental">Rental</option>
                                        <option value="Investments">Investments</option>
                                        <option value="Lottery">Lottery</option>
                                        <option value="Dividends">Dividends</option>
                                        <option value="Pocket Money">Pocket Money</option>
                                        <option value="Others">Others</option>
                                    <?php
                                        }
                                        else if($selected =="Investments")
                                        {
                                    ?>
                                        <option value="Salary">Salary</option>
                                        <option value="Awards">Awards</option>
                                        <option value="Grants">Grants</option>
                                        <option value="Sale">Sale</option>
                                        <option value="Rental">Rental</option>
                                        <option selected value="Investments">Investments</option>
                                        <option value="Lottery">Lottery</option>
                                        <option value="Dividends">Dividends</option>
                                        <option value="Pocket Money">Pocket Money</option>
                                        <option value="Others">Others</option>
                                    <?php
                                        }
                                        else if($selected =="Lottery")
                                        {
                                    ?>
                                        <option value="Salary">Salary</option>
                                        <option value="Awards">Awards</option>
                                        <option value="Grants">Grants</option>
                                        <option value="Sale">Sale</option>
                                        <option value="Rental">Rental</option>
                                        <option value="Investments">Investments</option>
                                        <option selected value="Lottery">Lottery</option>
                                        <option value="Dividends">Dividends</option>
                                        <option value="Pocket Money">Pocket Money</option>
                                        <option value="Others">Others</option>
                                    <?php
                                        }
                                        else if($selected =="Dividends")
                                        {
                                    ?>
                                        <option value="Salary">Salary</option>
                                        <option value="Awards">Awards</option>
                                        <option value="Grants">Grants</option>
                                        <option value="Sale">Sale</option>
                                        <option value="Rental">Rental</option>
                                        <option value="Investments">Investments</option>
                                        <option value="Lottery">Lottery</option>
                                        <option selected value="Dividends">Dividends</option>
                                        <option value="Pocket Money">Pocket Money</option>
                                        <option value="Others">Others</option>
                                    <?php
                                        }
                                        else if($selected =="Pocket Money")
                                        {
                                    ?>
                                        <option value="Salary">Salary</option>
                                        <option value="Awards">Awards</option>
                                        <option value="Grants">Grants</option>
                                        <option value="Sale">Sale</option>
                                        <option value="Rental">Rental</option>
                                        <option value="Investments">Investments</option>
                                        <option value="Lottery">Lottery</option>
                                        <option value="Dividends">Dividends</option>
                                        <option selected value="Pocket Money">Pocket Money</option>
                                        <option value="Others">Others</option>
                                    <?php
                                        }
                                        else if($selected =="Others")
                                        {
                                    ?>
                                        <option value="Salary">Salary</option>
                                        <option value="Awards">Awards</option>
                                        <option value="Grants">Grants</option>
                                        <option value="Sale">Sale</option>
                                        <option value="Rental">Rental</option>
                                        <option value="Investments">Investments</option>
                                        <option value="Lottery">Lottery</option>
                                        <option value="Dividends">Dividends</option>
                                        <option value="Pocket Money">Pocket Money</option>
                                        <option selected value="Others">Others</option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button name="edit" type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>