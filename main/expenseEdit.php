<?php
    session_start();
    if(isset($_SESSION['user']))
    {
        $user_id = $_SESSION['id'];
        $id = $_GET['id'];
        include("cons/config.php");

        // Get Categories Name from expense table
        $sql = "SELECT * FROM expense WHERE expense_id='$id' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $catName = $row['expense_categories'];
        $date = $row['expense_dateTime'];
        $dateMonth = date('m',strtotime($date));

        // Get Id Form Categories Table
        $sqlCatId = "SELECT * FROM expensecat WHERE categories_name='$catName' ";
        $resultCatId = mysqli_query($conn, $sqlCatId);
        $rowCatId = mysqli_fetch_assoc($resultCatId);
        $catId = $rowCatId['categories_id'];

        // Minus From ExpenseByCat
        $sqlMin = "SELECT * FROM expensebycat WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' ";
        $resutlMin = mysqli_query($conn, $sqlMin);
        $rowMin = mysqli_fetch_assoc($resutlMin);
        $amountMin = 0;
        $amountMin = $rowMin['expense_cat_amount'] - $row['expense_amount'];

        if(isset($_POST['edit']))
        {
            // Update ExpenseByCat table
            mysqli_query($conn,"UPDATE expensebycat SET expense_cat_amount='$amountMin' WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' ");
            
            // Delete the expense or income
            $sqlDel = "DELETE FROM expense WHERE expense_id='$id' ";
            mysqli_query($conn, $sqlDel);

            $amount = mysqli_real_escape_string($conn, $_POST['amount']);
            $categories = mysqli_real_escape_string($conn, $_POST['categories']);
            $datetime = mysqli_real_escape_string($conn, $_POST['datetime']);
            
            // Take categories id
            $sqlCat = "SELECT categories_id FROM expensecat WHERE categories_name='$categories' ";
            $resultCat = mysqli_query($conn, $sqlCat);
            $rowCat = $resultCat->fetch_assoc();
            $catId = $rowCat['categories_id'];

            // Insert into expense table
            $sqlExp = "INSERT INTO expense (expense_id, expense_categories, expense_user_fk_id, expense_dateTime, expense_amount) VALUES ('$id', '$categories', '$user_id', '$datetime', '$amount') ";
            mysqli_query($conn, $sqlExp);

            //Add to expensebycat table
            $addMonth = date('m', strtotime($datetime));
            $sqlByCat = "SELECT * FROM expensebycat WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$addMonth' ";
            $resultByCat = mysqli_query($conn, $sqlByCat);
            if($rowByCat=mysqli_fetch_assoc($resultByCat))
            {
                $updateAmount=0;
                $updateAmount = $rowByCat['expense_cat_amount'] + $amount;
                mysqli_query($conn, "UPDATE expensebycat SET expense_cat_amount='$updateAmount' WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$addMonth' ");
            }
            else if(!$rowByCat=mysqli_fetch_assoc($resultByCat))
            {
                mysqli_query($conn, "INSERT INTO expensebycat(expense_cat_fk_id, expense_user_cat_id, expense_cat_amount, expense_cat_date) VALUES('$catId', '$user_id', '$amount', '$datetime') ");
            }
            header("location: expenseMainPage.php?month=$addMonth");
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
                $sqlChart = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' ";
                $resultChart = mysqli_query($conn, $sqlChart);
                while($rowChart = $resultChart->fetch_assoc())
                {
                    $ChartCatId = $rowChart['expense_cat_fk_id'];
                    $sqlChartCat = "SELECT categories_name FROM expensecat WHERE categories_id='$ChartCatId' ";
                    $resultChartCat = mysqli_query($conn, $sqlChartCat);
                    $rowChartCat = $resultChartCat->fetch_assoc();
                    echo "['".$rowChartCat['categories_name']."',".$rowChart['expense_cat_amount']."],";
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
        $currentMont = date('m', time());
    ?>

    <section id="sub-Main" class="h-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 shadow justify-content-md-center" id="left-column">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="monthlyMainPage.php?month=<?php echo($currentMont) ?>">
                                <i class="fas fa-chart-line"></i>
                                <span>Monthly Overview</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="incomeMainPage.php?month=<?php echo($currentMont) ?>">
                                <i class="fas fa-plus"></i>
                                <span>Incomes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="expenseMainPage.php?month=<?php echo($currentMont) ?>">
                                <i class="fas fa-minus"></i>
                                <span>Expense</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout_inc.php">
                                <i class="fas fa-sign-out-alt"></i>
                                <span> Log Out</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <?php
                        // Calculating Each Expense
                        // Food
                        $sqlFood = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='37' ";
                        $resultFood = mysqli_query($conn, $sqlFood);
                        $rowFood = $resultFood->fetch_assoc();
                        $amountFood = $rowFood['expense_cat_amount'];

                        // Bills
                        $sqlBills = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='38' ";
                        $resultBills = mysqli_query($conn, $sqlBills);
                        $rowBills = $resultBills->fetch_assoc();
                        $amountBills = $rowBills['expense_cat_amount'];

                        // Transportation
                        $sqlTransportation = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='39' ";
                        $resultTransportation = mysqli_query($conn, $sqlTransportation);
                        $rowTransportation = $resultTransportation->fetch_assoc();
                        $amountTransportation = $rowTransportation['expense_cat_amount'];

                        // Entertainment
                        $sqlEntertainment = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='40' ";
                        $resultEntertainment = mysqli_query($conn, $sqlEntertainment);
                        $rowEntertainment = $resultEntertainment->fetch_assoc();
                        $amountEntertainment = $rowEntertainment['expense_cat_amount'];

                        // Insurance
                        $sqlInsurance = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='41' ";
                        $resultInsurance = mysqli_query($conn, $sqlInsurance);
                        $rowInsurance = $resultInsurance->fetch_assoc();
                        $amountInsurance = $rowInsurance['expense_cat_amount'];

                        // Clothing
                        $sqlClothing = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='42' ";
                        $resultClothing = mysqli_query($conn, $sqlClothing);
                        $rowClothing = $resultClothing->fetch_assoc();
                        $amountClothing = $rowClothing['expense_cat_amount'];

                        // Tax
                        $sqlTax = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='43' ";
                        $resultTax = mysqli_query($conn, $sqlTax);
                        $rowTax = $resultTax->fetch_assoc();
                        $amountTax = $rowTax['expense_cat_amount'];

                        // Shopping
                        $sqlShopping = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='44' ";
                        $resultShopping = mysqli_query($conn, $sqlShopping);
                        $rowShopping = $resultShopping->fetch_assoc();
                        $amountShopping = $rowShopping['expense_cat_amount'];

                        // Telephone
                        $sqlTelephone = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='45' ";
                        $resultTelephone = mysqli_query($conn, $sqlTelephone);
                        $rowTelephone = $resultTelephone->fetch_assoc();
                        $amountTelephone = $rowTelephone['expense_cat_amount'];

                        // Sports
                        $sqlSports = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='46' ";
                        $resultSports = mysqli_query($conn, $sqlSports);
                        $rowSports = $resultSports->fetch_assoc();
                        $amountSports = $rowSports['expense_cat_amount'];

                        // Health
                        $sqlHealth = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='47' ";
                        $resultHealth = mysqli_query($conn, $sqlHealth);
                        $rowHealth = $resultHealth->fetch_assoc();
                        $amountHealth = $rowHealth['expense_cat_amount'];

                        // Beauty
                        $sqlBeauty = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='48' ";
                        $resultBeauty = mysqli_query($conn, $sqlBeauty);
                        $rowBeauty = $resultBeauty->fetch_assoc();
                        $amountBeauty = $rowBeauty['expense_cat_amount'];

                        // Baby
                        $sqlBaby = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='49' ";
                        $resultBaby = mysqli_query($conn, $sqlBaby);
                        $rowBaby = $resultBaby->fetch_assoc();
                        $amountBaby = $rowBaby['expense_cat_amount'];

                        // Pet
                        $sqlPet = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='50' ";
                        $resultPet = mysqli_query($conn, $sqlPet);
                        $rowPet = $resultPet->fetch_assoc();
                        $amountPet = $rowPet['expense_cat_amount'];

                        // Travel
                        $sqlTravel = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='51' ";
                        $resultTravel = mysqli_query($conn, $sqlTravel);
                        $rowTravel = $resultTravel->fetch_assoc();
                        $amountTravel = $rowTravel['expense_cat_amount'];

                        // ExpOth
                        $sqlExpOth = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' AND expense_cat_fk_id='52' ";
                        $resultExpOth = mysqli_query($conn, $sqlExpOth);
                        $rowExpOth = $resultExpOth->fetch_assoc();
                        $amountExpOth = $rowExpOth['expense_cat_amount'];
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
                                    <span class="left">Food</span>
                                    <?php
                                        if($amountFood != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountFood) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 Food">

                                    </div>
                                </div>
                            </div>

                            <div class="data gb">
                                <div class="text">
                                    <span class="left">Bills</span>
                                    <?php
                                        if($amountBills != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountBills) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 Bills"></div>
                                </div>
                            </div>

                            <div class="data projects">
                                <div class="text">
                                    <span class="left">Transportation</span>
                                    <?php
                                        if($amountTransportation != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountTransportation) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 Transportation"></div>
                                </div>
                            </div>

                            <div class="data projects">
                                <div class="text">
                                    <span class="left">Entertainment</span>
                                    <?php
                                        if($amountEntertainment != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountEntertainment) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 Entertainment"></div>
                                </div>
                            </div>

                            <div class="data projects">
                                <div class="text">
                                    <span class="left">Insurance</span>
                                    <?php
                                        if($amountInsurance != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountInsurance) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 Insurance"></div>
                                </div>
                            </div>

                            <div class="data projects">
                                <div class="text">
                                    <span class="left">Clothing</span>
                                    <?php
                                        if($amountClothing != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountClothing) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 Clothing"></div>
                                </div>
                            </div>

                            <div class="data projects">
                                <div class="text">
                                    <span class="left">Tax</span>
                                    <?php
                                        if($amountTax != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountTax) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 Tax"></div>
                                </div>
                            </div>

                            <div class="data projects">
                                <div class="text">
                                    <span class="left">Shopping</span>
                                    <?php
                                        if($amountShopping != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountShopping) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 Shopping"></div>
                                </div>
                            </div>

                            <div class="data projects">
                                <div class="text">
                                    <span class="left">Telephone</span>
                                    <?php
                                        if($amountTelephone != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountTelephone) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 Telephone"></div>
                                </div>
                            </div>

                            <div class="data projects">
                                <div class="text">
                                    <span class="left">Sports</span>
                                    <?php
                                        if($amountSports != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountSports) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 Sports"></div>
                                </div>
                            </div>

                            <div class="data projects">
                                <div class="text">
                                    <span class="left">Health</span>
                                    <?php
                                        if($amountHealth != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountHealth) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 Health"></div>
                                </div>
                            </div>

                            <div class="data projects">
                                <div class="text">
                                    <span class="left">Beauty</span>
                                    <?php
                                        if($amountBeauty != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountBeauty) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 Beauty"></div>
                                </div>
                            </div>

                            <div class="data projects">
                                <div class="text">
                                    <span class="left">Baby</span>
                                    <?php
                                        if($amountBaby != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountBaby) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 Baby"></div>
                                </div>
                            </div>

                            <div class="data projects">
                                    <div class="text">
                                        <span class="left">Pet</span>
                                        <?php
                                        if($amountPet != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountPet) ?></span>
                                    <?php
                                        }
                                    ?>
                                    </div>
                                    <div class="line1">
                                        <div class="fill1 Pet"></div>
                                    </div>
                                </div>

                                <div class="data projects">
                                        <div class="text">
                                            <span class="left">Travel</span>
                                            <?php
                                        if($amountTravel != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountTravel) ?></span>
                                    <?php
                                        }
                                    ?>
                                        </div>
                                        <div class="line1">
                                            <div class="fill1 Travel"></div>
                                        </div>
                                    </div>

                            <div class="data projects">
                                <div class="text">
                                    <span class="left">Others</span>
                                    <?php
                                        if($amountExpOth != 0)
                                        {
                                    ?>
                                        <span class="right"><?php echo($amountExpOth) ?></span>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="line1">
                                    <div class="fill1 ExpenseOther"></div>
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
                    $resultEdit = mysqli_query($conn, "SELECT * FROM expense WHERE expense_id='$id' ");
                    $rowEdit = mysqli_fetch_assoc($resultEdit);
                    $dateDetail = strtotime($rowEdit['expense_dateTime']);
                    $newDateFormat = date('d-M-Y', $dateDetail);
                    $returnMonth = date('m', $dateDetail);
                ?>

                <div class="col-3 shadow" id="right-column">
                    <div class="container-fluid">
                        <div class="row upperDetail">
                            <ul>
                                <li><a href="expenseMainPage.php?month=<?php echo($returnMonth) ?>"><i class="fas fa-chevron-left"></i></a></li>
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
                                    <h4><?php echo($rowEdit['expense_amount']) ?></h4>
                                </li>
                            </ul>
                        </div>

                        <div class="row justify-content-md-center">
                            <i class="fas fa-list-ul"></i>
                            <p><?php echo($rowEdit['expense_categories']) ?></p>
                        </div>

                        <div class="row justify-content-md-center">
                            <i class="fas fa-calendar-alt"></i>
                            <p><?php echo($newDateFormat) ?></p>
                        </div>


                    </div>

                    <div class="row justify-content-md-center lastDelete">
                        <div class="row justify-content-md-center">
                            <i class="far fa-trash-alt"></i>
                            <a href="deleteExpenseData.php?id=<?php echo($id) ?>" class="text-dark">Delete</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
        <!-- Dar ka Expense Modal -->

        <div class="modal fade" tabindex="-1" id="editmodal" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Expense</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body justify-content-md-center">
                            <!-- <img src="Image/money-bag.png" class="w-50 h-50" alt=""> -->
                            <form action="" class="container-fluid" method="POST">
                                <div class="form-group row justify-content-md-center">
                                    <div class="col-1 pr-0 my-auto text-center">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
        
                                    <div class="col-8">
                                        <input name="amount" type="number" class="form-control" value=<?php echo($rowEdit['expense_amount'])?> required>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-md-center">
                                    <div class="col-1 pr-0 my-auto text-center">
                                            <i class="far fa-calendar-alt"></i>
                                    </div>
        
                                <?php
                                    $date = $rowEdit['expense_dateTime'];
                                ?>

                                    <div class="col-8">
                                        <input name="datetime" type="date" class="form-control" value=<?php echo($date) ?> required >
                                    </div>
                                </div>
        
                                <div class="form-group row justify-content-md-center">
                                    <div class="col-1 pr-0 my-auto text-center">
                                            <i class="fas fa-list"></i>
                                    </div>
                                    <div class="col-8">
                                        <select class="form-control" name="categories">
                                        <?php
                                            $selected = $rowEdit['expense_categories'];
                                            if($selected == "Food")
                                            {
                                        ?>
                                            <option selected value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>
                                        <?php
                                            }
                                            else if($selected == "Bills")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option selected value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Transportation")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option selected value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Entertainment")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option selected value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Insurance")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option selected value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Clothing")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option selected value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Tax")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option selected value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Shopping")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option selected value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Telephone")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option selected value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Sports")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option selected value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Health")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option selected value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Beauty")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option selected value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Baby")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option selected value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Pet")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option selected value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Travel")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option selected value="Travel">Travel</option>
                                            <option value="Others">Others</option>

                                        <?php
                                            }
                                            else if($selected == "Others")
                                            {
                                        ?>
                                            <option value="Food">Food</option>
                                            <option value="Bills">Bills</option>
                                            <option value="Transportation">Transportation</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Shopping">Shopping</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Health">Health</option>
                                            <option value="Beauty">Beauty</option>
                                            <option value="Baby">Baby</option>
                                            <option value="Pet">Pet</option>
                                            <option value="Travel">Travel</option>
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