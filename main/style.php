<?php
    header("Content-type: text/css; charset: UTF-8");
    
    include("cons/config.php");
    session_start();
    if(!isset($_SESSION['user']))
    {
        header("location: ../main/signinPage.php?");
        exit();
    }
    else if(isset($_SESSION['user']))
    {
        $id = $_SESSION['id'];
        $month = $_GET['month'];
        $totalAmount = 0;

        // Calculation Each Income
        // Salary
        $sqlSalary = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='11' ";
        $resultSalary = mysqli_query($conn, $sqlSalary);
        $rowSalary = $resultSalary->fetch_assoc();
        $amountSalary = $rowSalary['income_cat_amount'];

        // Awards
        $sqlAwards = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='12' ";
        $resultAwards = mysqli_query($conn, $sqlAwards);
        $rowAwards = $resultAwards->fetch_assoc();
        $amountAwards = $rowAwards['income_cat_amount'];

        // Grants
        $sqlGrants = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='13' ";
        $resultGrants = mysqli_query($conn, $sqlGrants);
        $rowGrants = $resultGrants->fetch_assoc();
        $amountGrants = $rowGrants['income_cat_amount'];

        // Sale
        $sqlSale = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='14' ";
        $resultSale = mysqli_query($conn, $sqlSale);
        $rowSale = $resultSale->fetch_assoc();
        $amountSale = $rowSale['income_cat_amount'];

        // Rental
        $sqlRental = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='15' ";
        $resultRental = mysqli_query($conn, $sqlRental);
        $rowRental = $resultRental->fetch_assoc();
        $amountRental = $rowRental['income_cat_amount'];

        // Investments
        $sqlInvestments = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='16' ";
        $resultInvestments = mysqli_query($conn, $sqlInvestments);
        $rowInvestments = $resultInvestments->fetch_assoc();
        $amountInvestments = $rowInvestments['income_cat_amount'];

        // Lottery
        $sqlLottery = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='17' ";
        $resultLottery = mysqli_query($conn, $sqlLottery);
        $rowLottery = $resultLottery->fetch_assoc();
        $amountLottery = $rowLottery['income_cat_amount'];

        // Dividends
        $sqlDividends = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='18' ";
        $resultDividends = mysqli_query($conn, $sqlDividends);
        $rowDividends = $resultDividends->fetch_assoc();
        $amountDividends = $rowDividends['income_cat_amount'];

        // Pocket
        $sqlPocket = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='19' ";
        $resultPocket = mysqli_query($conn, $sqlPocket);
        $rowPocket = $resultPocket->fetch_assoc();
        $amountPocket = $rowPocket['income_cat_amount'];

        // Other
        $sqlOthers = "SELECT * FROM incomebycat WHERE income_user_cat_id='$id' AND MONTH(income_cat_date)='$month' AND income_cat_fk_id='20' ";
        $resultOthers = mysqli_query($conn, $sqlOthers);
        $rowOthers = $resultOthers->fetch_assoc();
        $amountOthers = $rowOthers['income_cat_amount'];

        // Calculating Total
        $totalInAmount = $amountSalary + $amountAwards + $amountGrants + $amountSale + $amountRental + $amountInvestments + $amountLottery + $amountDividends + $amountPocket + $amountOthers;

        // Calculating Percentages For income
        $perSal = $amountSalary/$totalInAmount;
        $perAw = $amountAwards/$totalInAmount;
        $perGra = $amountGrants/$totalInAmount;
        $perSale = $amountSale/$totalInAmount;
        $perRen = $amountRental/$totalInAmount;
        $perInv = $amountInvestments/$totalInAmount;
        $perLot = $amountLottery/$totalInAmount;
        $perDiv = $amountDividends/$totalInAmount;
        $perPock = $amountPocket/$totalInAmount;
        $perInOth = $amountOthers/$totalInAmount;
        
        // Calculating Each Expense
        // Food
        $sqlFood = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='37' ";
        $resultFood = mysqli_query($conn, $sqlFood);
        $rowFood = $resultFood->fetch_assoc();
        $amountFood = $rowFood['expense_cat_amount'];

        // Bills
        $sqlBills = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='38' ";
        $resultBills = mysqli_query($conn, $sqlBills);
        $rowBills = $resultBills->fetch_assoc();
        $amountBills = $rowBills['expense_cat_amount'];

        // Transportation
        $sqlTransportation = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='39' ";
        $resultTransportation = mysqli_query($conn, $sqlTransportation);
        $rowTransportation = $resultTransportation->fetch_assoc();
        $amountTransportation = $rowTransportation['expense_cat_amount'];

        // Entertainment
        $sqlEntertainment = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='40' ";
        $resultEntertainment = mysqli_query($conn, $sqlEntertainment);
        $rowEntertainment = $resultEntertainment->fetch_assoc();
        $amountEntertainment = $rowEntertainment['expense_cat_amount'];

        // Insurance
        $sqlInsurance = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='41' ";
        $resultInsurance = mysqli_query($conn, $sqlInsurance);
        $rowInsurance = $resultInsurance->fetch_assoc();
        $amountInsurance = $rowInsurance['expense_cat_amount'];

        // Clothing
        $sqlClothing = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='42' ";
        $resultClothing = mysqli_query($conn, $sqlClothing);
        $rowClothing = $resultClothing->fetch_assoc();
        $amountClothing = $rowClothing['expense_cat_amount'];

        // Tax
        $sqlTax = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='43' ";
        $resultTax = mysqli_query($conn, $sqlTax);
        $rowTax = $resultTax->fetch_assoc();
        $amountTax = $rowTax['expense_cat_amount'];

        // Shopping
        $sqlShopping = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='44' ";
        $resultShopping = mysqli_query($conn, $sqlShopping);
        $rowShopping = $resultShopping->fetch_assoc();
        $amountShopping = $rowShopping['expense_cat_amount'];

        // Telephone
        $sqlTelephone = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='45' ";
        $resultTelephone = mysqli_query($conn, $sqlTelephone);
        $rowTelephone = $resultTelephone->fetch_assoc();
        $amountTelephone = $rowTelephone['expense_cat_amount'];

        // Sports
        $sqlSports = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='46' ";
        $resultSports = mysqli_query($conn, $sqlSports);
        $rowSports = $resultSports->fetch_assoc();
        $amountSports = $rowSports['expense_cat_amount'];

        // Health
        $sqlHealth = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='47' ";
        $resultHealth = mysqli_query($conn, $sqlHealth);
        $rowHealth = $resultHealth->fetch_assoc();
        $amountHealth = $rowHealth['expense_cat_amount'];

        // Beauty
        $sqlBeauty = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='48' ";
        $resultBeauty = mysqli_query($conn, $sqlBeauty);
        $rowBeauty = $resultBeauty->fetch_assoc();
        $amountBeauty = $rowBeauty['expense_cat_amount'];

        // Baby
        $sqlBaby = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='49' ";
        $resultBaby = mysqli_query($conn, $sqlBaby);
        $rowBaby = $resultBaby->fetch_assoc();
        $amountBaby = $rowBaby['expense_cat_amount'];

        // Pet
        $sqlPet = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='50' ";
        $resultPet = mysqli_query($conn, $sqlPet);
        $rowPet = $resultPet->fetch_assoc();
        $amountPet = $rowPet['expense_cat_amount'];

        // Travel
        $sqlTravel = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='51' ";
        $resultTravel = mysqli_query($conn, $sqlTravel);
        $rowTravel = $resultTravel->fetch_assoc();
        $amountTravel = $rowTravel['expense_cat_amount'];

        // ExpOth
        $sqlExpOth = "SELECT * FROM expensebycat WHERE expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$month' AND expense_cat_fk_id='52' ";
        $resultExpOth = mysqli_query($conn, $sqlExpOth);
        $rowExpOth = $resultExpOth->fetch_assoc();
        $amountExpOth = $rowExpOth['expense_cat_amount'];

        // Calculating total 
        $totalExpAmount = $amountFood+$amountBills+$amountTransportation+$amountEntertainment+$amountInsurance+$amountClothing+$amountTax+$amountShopping+$amountTelephone+$amountSports+$amountHealth+$amountBeauty+$amountBaby+$amountPet+$amountTravel+$amountExpOth;
    
        // Caluculating percentages for expense
        $perFo = $amountFood/$totalExpAmount;
        $perBi = $amountBills/$totalExpAmount;
        $perTran = $amountTransportation/$totalExpAmount;
        $perEnt = $amountEntertainment/$totalExpAmount;
        $perIns = $amountInsurance/$totalExpAmount;
        $perClo = $amountClothing/$totalExpAmount;
        $perTax = $amountTax/$totalExpAmount;
        $perShop = $amountShopping/$totalExpAmount;
        $perTel = $amountTelephone/$totalExpAmount;
        $perSpo = $amountSports/$totalExpAmount;
        $perHal = $amountHealth/$totalExpAmount;
        $perBea = $amountBeauty/$totalExpAmount;
        $perBab = $amountBaby/$totalExpAmount;
        $perPe = $amountPet/$totalExpAmount;
        $perTvl = $amountTravel/$totalExpAmount;
        $perExpOth = $amountExpOth/$totalExpAmount;

        // Calculating For Monthly Overview Page
        $totalNetAmount = $totalInAmount - $totalExpAmount;
        $perTotalIn = $totalInAmount/($totalInAmount+$totalExpAmount);
        $perTotalExp = $totalExpAmount/($totalInAmount+$totalExpAmount);
        $perTotalNet = $totalNetAmount/($totalInAmount+$totalExpAmount);
    }
?>
*{
    margin: 0;
    padding: 0;
    font-family: DM Sans;
}


html {
    scroll-behavior: smooth;
  }

/* ------------ Navigation Bar ------------------- */

header{
    width: 100%;
    z-index: 10;
    top: 0;
}

#Top{
    background: url("Image/HeaderBG1980.jpg") center no-repeat;
    background-size: cover;
    height: 100vh;
}

.navbar-brand{
    font-weight: 600;
    font-size: 1.5rem !important;
    padding-left: 38px;
}

.navbar-brand .fas{
    font-size: 1.8rem;
    font-weight: 600 !important;
    padding: 10px 10px 10px 0;
}

.navbar-nav li{
    padding: 0px 10px;
}

.navbar ul li a{
    float: right;
    font-weight: 600 !important;
    font-size: 1rem;
    text-align: center;
    letter-spacing: 1.5px;
    color: #ffffff !important;
    /* color: #2C3E50 !important; */

}

.navbar ul li a:hover{
    color: #bde4f4 !important;
    transition: .5s;
}

header .container h1{
    color: #2C3E50 !important;
    text-transform: uppercase;
    font-weight: 500;
    font-size: 50px;
}

.container span{
    font-weight: 700;
}

header .container{
    display: table;
    padding: 220px 0 12px 0;
    /* margin-left: 120px; */
}

header .container p{
    font-size: 24px;
    padding: 28px 0 0 0;
}

header .container a{
    margin: 16px 0;
    font-size: 20px;
}

header .container a:hover{
    background: transparent;
    color: #2C3E50 !important;
    transition: .6s;
}

/* ------------ How ------------------- */
#How{
    padding: 50px 0px;
}

/* #How .container{
    height: 75vh;
} */

#How .container h1{
    font-size: 50px;
    font-weight: 600;
    padding: 0px 38px;
}

#How .container h2{
    font-size: 35px;
}

#How .container h2 a{
    margin: 10px 20px 10px 10px;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 20px;
}

#How .container h2 span{
    font-weight: 600;
    font-size: 34px;
}

#How .container h2 .or{
    font-size: 28px;
    padding-right: 10px;
}

.Instruction{
    padding: 0px 0;
}

.Instruction h2{
    padding: 12px 0 0;
    font-size: 28px;
}

.Instruction small{
    font-size: 18px;
    margin-left: 40px;
    text-align: left;
}

/* ------------ Our Main Features ------------------- */
#Features{
    padding: 50px 0;
    background: linear-gradient(45Deg, rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url("Image/features.jpg") center no-repeat;
    background-size: cover;
    background-attachment: fixed;
}

#Features h1{
    text-align: center;
    font-weight: 600;
    font-size: 42px;
    letter-spacing: 1.2px;
    color: #ECF0F1 !important;
}

#Features h1::after{
    content: '';
    width: 240px;
    height: 3.5px;
    margin: 10px auto 5px;
    display: block;
    background: #ECF0F1;
}

#Features h3{
    color: #ECF0F1 !important;
}

#Features .icon{
    font-size: 45px;
    margin: 20px auto;
    padding: 20px;
    height: 100px;
    color: #ECF0F1 !important;
    width: 100px;
    border: 1px solid #ECF0F1;
    border-radius: 50%;
}

#Features p{
    font-size: 14px;
    margin: 20px 0;
    color: #ECF0F1;
}

.feature{
    margin-top: 40px;
}
.feature .col-md-4{
    border-radius: 2.5%;
    padding: 40px auto;
}

.feature .col-md-4:hover{
    background: #2B8CFF;
    cursor: pointer;
    transition: 0.7s;
}

/* ------------ Sign Up & Sign In------------------- */

#SignUp{
    height: 100vh;
    width: 100%;
    background: url("Image/SignUp1980.jpg") center no-repeat;
    background-size: cover;
}

#SignIn{
    height: 100vh;
    width: 100%;
    background: url("Image/SignIn1980.jpg") center no-repeat;
    background-size: cover;    
}

.Sign .SignUp{
    margin: 70px 0 0;
}

.Sign h1{
    font-size: 45px;
    font-weight: 600;
    text-align: center;
    letter-spacing: .8px;
    color: #2C3E50 !important;
}

.Sign form{
    margin: 34px 0;
}

.Sign .container:first-of-type{
    height: 82vh;
}

.Sign .SignUp .form-group{
    padding: 0px 0;
    margin-bottom: 18px;
    position: relative;
}

.Sign .SignUp .form-group label{
    color: #333333 !important;
}

.Sign .SignUp .form-group small{
    color: #2C3E50 !important;
}

.forget a{
    color: #2C3E50 !important;
    font-size: 18px;
}

.forget a:hover{
    color: #2B8CFF !important;
    text-decoration: none;
}

.Sign .SignUp .form-group a small{
    float: right;
    padding: 8px 0;
}

.Sign .SignUp h6{
    color: #2C3E50 !important;
    text-align: center;
    font-size: 15px;
    padding-top: 8px;
}

.Sign .SignUp h6 a{
    color: #2B8CFF !important;
}

/* ------------ Main Page ------------------- */

/* #main nav{
    padding-left: 10px;
} */

#main .navbar-brand{
    padding: 0 0 0 0;
}

#main nav ul{
    padding-top: 5px;
    margin-left: 2%;
    display: inline-block;
}

#main nav ul li{
    color: #ffffff;
    font-size: 1.5rem;
    display: inline-block;
}

#main nav span i{
    font-size: 1.9rem;
    padding-right: 20px;
}

#main .navbar ul{
    padding-right: 12px;
}

#main .navbar ul li i{
    font-size: 30px;
}

#sub-Main #left-column{
    padding: 0 5px;
    background: #ffffff;
    
}

#sub-Main #right-column{
    overflow: auto;
    height: 91.5vh;
}

#sub-Main #left-column ul li{
    padding: 10px 0;
}

#sub-Main #left-column ul li a{
    color: #2C3E50 !important;
    padding: 0 0 0 15px;
}

#sub-Main #left-column ul li a:hover{
    color: #2B8CFF !important;
}

#sub-Main #left-column ul li a span{
    font-size: 1rem;
    line-height: 10px;
}

#sub-Main #left-column ul li i{
    font-size: 1.5rem;
    padding: 10px 12px 10px 0;
}

#sub-Main #middle-column{
    height: 91.5vh;
    overflow: auto;
}

#sub-Main #right-column ul li{
    display: inline-block;
    list-style: none;
}

#sub-Main .upperDetail{
    padding: 25px 0 0px;
    border-bottom: 2px solid #E74C3C
}

#sub-Main .upperDetail ul{
    margin: 25px auto 10px auto;
}

#sub-Main .upperDetail ul li:first-of-type{
    padding-left: 0px;
    padding-right: 0;
}

#sub-Main .upperDetail ul li:last-of-type{
    padding-right: 0;
    padding-left: 0;
}

#sub-Main .upperDetail ul li{
    padding: 0 3rem;
}

#sub-Main .upperDetail ul h4{
    font-size: 1.6rem;
    font-weight: 600;
    text-align: center;
}

#sub-Main .upperDetail ul button{
    color: #E74C3C;
    font-size: 1.2rem;
    text-align: center;
    padding: 0px 0px 8px 0;
}


#sub-Main #right-column .upperDetail ul li a i{
    color: #ec8f6a;
    font-size: 1.4rem;
}

#sub-Main #right-column .upperDetail ul li a:hover i{
    color: #ef4b4b;
}

#sub-Main .amount{
    padding: 50px 0;
}

#sub-Main .amount div{
    padding: 20px 0 0;
}

#sub-Main .amount ul li i{
    font-size: 2rem;
}

#sub-Main .amount ul li h4{
    font-size: 2rem;
    font-weight: 700;
    padding-left: 12px;
}

#sub-Main .amount i{
    font-size: 1rem;
}

#sub-Main .amount p{
    font-size: 16px;
    padding-left: 12px;
    line-height: 16px;
}

#sub-Main .lastDelete{
    padding: 80px 0 0;
}

#sub-Main .lastDelete a{
    color: #E74C3C !important;
    line-height: 20px !important;
    font-size: 1.25rem;
}

#sub-Main .lastDelete i{
    color: #E74C3C;
    font-size: 1.2rem;
    padding-right: 12px;
}


/* ------------ Dashboard ------------------- */
#sub-Main select{ 
    min-width:70px;
    max-width:140px;
    margin:5px;
    background:transparent;
    border:none;
    outline: none;
    text-align-last:center;
}

#sub-Main option{
    font-size: 1rem;
}

#sub-Main #middle-column .fas:hover{
    color: #414141;
}

/* --------------- Plus Button -----------------*/
#sub-Main .addBtn{
    position: absolute;
    transform-origin: 50% 50%;
    right: 8%;
    bottom: 30px;
    z-index: 99998;
    cursor: pointer;
}

#sub-Main .addBtn .fas{
    font-size: 5rem;
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.12), 0 12px 12px rgba(0, 0, 0, 0.24);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: none;
    color: rgba(231, 77, 60, 0.9);
}

#sub-Main .addBtn .fas:hover{
    color: rgba(231, 77, 60, 1);
}

#sub-Main .dashboard{
    padding-top: 10px;
    background: #E9EDEF;
    padding: 0 0;
}

.frame1 {
    margin-top: 12px;
    padding: 0 5vh;
    height: auto;
    /* box-shadow: 1px 2px 10px 0px rgba(0, 0, 0, 0.05); */
    overflow: hidden;
    color: #5E5E5E;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  .frame1 .row:first-of-type{
      padding: 12px 0 25px;
  }

  /* .frame1 .row .col-3:first-of-type{
      margin-right: 24px;
  }

  .frame1 .row .col-3:last-of-type{
      margin-left: 24px;
  } */

  .frame1 .row .col-3{
      margin: auto;
      padding: 0 0;
  }
  
  .plan {
    background: #fff;
    box-shadow: 2px 2px 4px 0 rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
  }

  .plan.basic:hover ~ .datas .users .fill1 {
    -webkit-transform: scaleX(0.6) translate3d(0, 0, 0);
            transform: scaleX(0.6) translate3d(0, 0, 0) !important;
  }

  .plan.basic:hover ~ .datas .gb .fill1
  {
    -webkit-transform: scaleX(0.3) translate3d(0, 0, 0);
           transform:  scaleX(0.3) translate3d(0, 0, 0) !important;
  }

  .plan.basic:hover ~ .datas .projects .fill1 {
    -webkit-transform: scaleX(0.1) translate3d(0, 0, 0);
            transform: scaleX(0.1) translate3d(0, 0, 0) !important;
  }

  .plan.pro:hover ~ .datas .users .fill1 {
    -webkit-transform: scaleX(0.3) translate3d(0, 0, 0);
            transform: scaleX(0.3) translate3d(0, 0, 0) !important;
  }
  .plan.pro:hover ~ .datas .gb .fill1  {
    -webkit-transform: scaleX(0.7) translate3d(0, 0, 0);
            transform: scaleX(0.7) translate3d(0, 0, 0) !important;
  }
  .plan.pro:hover ~ .datas .projects .fill1 {
    -webkit-transform: scaleX(0.5) translate3d(0, 0, 0);
            transform: scaleX(0.5) translate3d(0, 0, 0) !important;
  }

  .plan.premium:hover ~ .datas .users .fill1,
  .plan.premium:hover ~ .datas .gb .fill1,
  .plan.premium:hover ~ .datas .projects .fill1 {
    -webkit-transform: scaleX(0.6) translate3d(0, 0, 0);
            transform: scaleX(0.6) translate3d(0, 0, 0) !important;
  }

  .plan:hover {
    -webkit-transform: scale(1.1) translate3d(0, 0, 0);
            transform: scale(1.1) translate3d(0, 0, 0);
    box-shadow: 4px 4px 8px 0 rgba(0, 0, 0, 0.1);
  }

  .plan:hover .title {
    background: #2f89fc;
  }

  .plan:hover .price {
    color: #2B8CFF;
  }

  .plan .title{
    text-align: center;
    background: #1eafed;
    color: #fff;
    font-weight: 600;
    text-transform: uppercase;
    padding: 10px 0;
    font-size: 1rem !important;
    letter-spacing: 1.2px !important;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
  }

  .plan .price {
    text-align: center;
    font-size: 30px;
    line-height: 30px;
    font-weight: 700;
    padding: 16px 0 17px 0;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
  }

  .plan .price span {
    display: block;
    font-size: 12px;
    line-height: 12px;
    font-weight: 400;
  }

  .plan .line1 {
    height: 3px;
    background: #E4E4E4;
    margin: 0 auto 7px auto;
  }
  
  .datas {
    height: auto;
    width: 90%;
    background: #fff;
    box-shadow: 2px 2px 4px 0 rgba(0, 0, 0, 0.1);
  }

  .datas .data {
    margin: 20px 18px;
  }

  .datas .data .text {
    font-size: 15px;
    height: 10px;
  }

  .datas .data .text .left {
    float: left;
  }

  .datas .data .text .right {
    float: right;
  }

  .datas .data .line1 {
    z-index: 5;
    width: 100%;
    height: 10px;
    background: #E9EDEF;
    border-radius: 5px;
    overflow: hidden;
  }

  <?php
    if($totalNetAmount>=0)
    {
?>
    .datas .data .line1 .fill1 {
    z-index: 1;
    height: 10px;
    width: 100%;
    background: #007bff;
    -webkit-transform: scaleX(0);
            transform: scaleX(0);
    -webkit-transform-origin: 0 50%;
            transform-origin: 0 50%;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    border-radius: 3px;
  }
<?php
    }
    else
    {
?>
    .datas .data .line1 .fill1 {
    z-index: 1;
    height: 10px;
    width: 100%;
    background: #ff3333;
    -webkit-transform: scaleX(0);
            transform: scaleX(0);
    -webkit-transform-origin: 0 50%;
            transform-origin: 0 50%;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    border-radius: 3px;
  }
<?php        
    }
  ?>

  .datas .data .line1 .Salary{  
      transform: scaleX(<?php echo($perSal) ?>);
  }

  .datas .data .line1 .Awards{
      transform: scaleX(<?php echo($perAw) ?>);
  }

  .datas .data .line1 .Grants{
      transform: scaleX(<?php echo($perGra) ?>);
  }

  .datas .data .line1 .Sale{
      transform: scaleX(<?php echo($perSale) ?>);
  }

  .datas .data .line1 .Rental{
      transform: scaleX(<?php echo($perRen) ?>);
  }

  .datas .data .line1 .Investments{
      transform: scaleX(<?php echo($perInv) ?>);
  }

  .datas .data .line1 .Dividends{
      transform: scaleX(<?php echo($perDiv) ?>);
  }

  .datas .data .line1 .Lottery{
      transform: scaleX(<?php echo($perLot) ?>);
  }

  .datas .data .line1 .IncomeOther{
      transform: scaleX(<?php echo($perInOth) ?>);
  }

  .datas .data .line1 .PocketMoney{
      transform: scaleX(<?php echo($perPock) ?>);
  }

  .datas .data .line1 .ExpenseOther{
    transform: scaleX(<?php echo($perExpOth) ?>);
}

.datas .data .line1 .Travel{
    transform: scaleX(<?php echo($perTvl) ?>);
}

.datas .data .line1 .Pet{
    transform: scaleX(<?php echo($perPet) ?>);
}

.datas .data .line1 .Baby{
    transform: scaleX(<?php echo($perBab) ?>);
}

.datas .data .line1 .Beauty{
    transform: scaleX(<?php echo($perBea) ?>);
}

.datas .data .line1 .Health{
    transform: scaleX(<?php echo($perHal) ?>);
}

.datas .data .line1 .Sports{
    transform: scaleX(<?php echo($perSpo) ?>);
}

.datas .data .line1 .Shopping{
    transform: scaleX(<?php echo($perShop) ?>);
}

.datas .data .line1 .Telephone{
    transform: scaleX(<?php echo($perTel) ?>);
}

.datas .data .line1 .Tax{
    transform: scaleX(<?php echo($perTax) ?>);
}

.datas .data .line1 .Clothing{
    transform: scaleX(<?php echo($perClo) ?>);
}

.datas .data .line1 .Insurance{
    transform: scaleX(<?php echo($perIns) ?>);
}

.datas .data .line1 .Entertainment{
    transform: scaleX(<?php echo($perEnt) ?>);
}

.datas .data .line1 .Transportation{
    transform: scaleX(<?php echo($perTran) ?>);
}

.datas .data .line1 .Bills{
    transform: scaleX(<?php echo($perBi) ?>);
}

.datas .data .line1 .Food{
    transform: scaleX(<?php echo($perFo) ?>);
}

.datas .data .line1 .Income{
    transform: scaleX(<?php echo($perTotalIn) ?>);
}

.datas .data .line1 .Expense{
    transform: scaleX(<?php echo($perTotalExp) ?>);
}

.datas .data .line1 .Total{
    transform: scaleX(<?php echo($perTotalNet) ?>);
}

/* ------------ Dashboard Right Column ------------------- */
#sub-Main #right-column table{
    /* margin-top: 20px; */
    width: 100%;
}

#sub-Main #middle-column #clock{
    font-size: 1.4rem;
    text-align: center;
    margin-top: 8px;
}

#right-column table .income{
    background: #3490de; 
}

#right-column table .incomeCategory{
    color: #3490de !important;
}

#right-column table .expenseCategory{
    color: #ff2e63 !important;
}

#right-column table .expense{
    background: #ff2e63;
}

#right-column table #two td{
    color: #ffffff;
}

#sub-Main .money{
    text-align: right;
}

#sub-Main .money .fas{
    color: #ffffff;
    font-size: 1rem;
    padding: 0 10px 0 2px;
    transition: 0.3s ease-in-out;
}

#sub-Main .money .fas:hover{
    font-size: 1.4rem;
}

#sub-Main #right-column table th{
    text-align: center;
    padding: 25px 10px;
    font-size: 1rem;
    font-family: DM Sans;
    background-color:  #efefef;
    letter-spacing: .8px;
    transition: .2s;
}

#sub-Main #right-column table th:hover{
    /* box-shadow: 2px 2px 10px 0px rgba(0, 0, 0, 0.5); */
    color: #2B8CFF;
    cursor: pointer;
    
}

#sub-Main #right-column table td{
    padding: 10px 0 10px 20px;
    width: 50%;
}

#sub-Main #right-column .day{
    color:black;
}

.gray{
      color: gray;
}

#bycata{
    visibility: hidden;
}

#date .dateUnderline{
    border-bottom: 1px solid #33333352;
}

.donut{
    margin: 20px 0;
}

#bycata td .fas{
    padding-right: 5px;
    font-size: 1.4rem;
}

#bycata td{
    font-size: 1rem;
}
/* 
#borderchange1{
    border-bottom: 4px solid #444444;
} */

/* ------------ Pop Up Modal Page ------------------- */
.modal i{
    font-size: 1.5rem;
    color: #323232;
}

.modal-header h5{
    font-size: 1.2rem;
    margin-left: 1rem;
    font-weight: 600;
}


/* ------------ Profile Page ------------------- */
.AccountProfile{
    height: auto;
    padding-top: 3%;
}
.AccountProfile p{
    font-size: 1rem;
}

/* .AccountProfile .row{
     padding: 15px 0 10px; 
} */

.AccountProfile img{
    margin-bottom: 15px;
}

.AccountProfile h2{
    padding: 10px 0 20px;
    font-size: 2rem;
    font-weight: 600;
    letter-spacing: 1.2px;
}

.AccountProfile h6{
    font-size: 1.25rem;
    padding: 10px 0;
}

.AccountProfile .row a{
    color: #007bff !important;
}

/* ------------ footer ------------------- */
#Contact{
    padding: 60px 0;
}

#Contact h1{
    font-weight: 600;
    text-align: center;
    font-size: 42px;
}

#Contact .container h1::after{
    content: '';
    width: 180px;
    height: 4px;
    margin: 10px auto;
    background: #2C3E50 !important;
    display: block;
}

#Contact .container .row{
    margin-top: 30px;
}

#Contact .follow{
    background: #ECF0F1;
    padding: 10px;
    margin: 15px ;
}

#Contact .follow:hover{
    box-shadow: 0 0 15px 5px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    transition: 0.6s;
}

#Contact .contact-info .fas{
    margin: 10px;
    color: #2C3E50;
    font-weight: bold;
    font-size: 18px;
}

#Contact .contact-info .fab{
    margin: 8px 18px;
    color: #2C3E50;
    font-weight: bold;
    font-size: 28px;
}

::placeholder{
    color: #333333;
}
/* ------------ Our Team ------------------- */
#Team{
    padding: 75px 0;
    background: linear-gradient(45Deg, rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url("Image/Team.jpg") center no-repeat;
    background-size: cover;
    background-attachment: fixed;
}

#Team .row:first-of-type{
    padding-top: 25px;
}

#Team h1{
    text-align: center;
    font-weight: 600;
    font-size: 42px;
    letter-spacing: 1.5px;
    color: #ffffff;
}

#Team .profile-pic h2{
    font-weight: 600;
    padding: 10px 0 0;
    font-size: 20px;
    letter-spacing: 0.5px;
    color: #ffffff;
}

#Team h3{
    font-size: 15px;
    color: #ffffff !important;
    letter-spacing: 1.2px;
    margin-bottom: 24px;
}

#Team h1::after{
    content: '';
    background-color: #ffffff;
    width: 180px;
    height: 3.5px;
    display: block;
    margin: 10px auto 25px;
}

#Team .img-box img{
    border-radius: 50%;
}

/* ------------ FAQ ------------------- */
#FAQ{
    padding: 50px 0;
}

#FAQ h1{
    text-align: center;
    font-weight: 600;
    font-size: 42px;
    letter-spacing: 1.2px;
}

#FAQ h1::after{
    content: '';
    background-color: #2C3E50;
    width: 60px;
    height: 3.5px;
    display: block;
    margin: 10px auto 25px;
}

#FAQ .accordion{
    padding: 20px 0 0;
}


#FAQ .btn-link{
    color: #2B8CFF;
    font-size: 18px;
    font-weight: 600;
    text-decoration: none;
}

#FAQ .btn-link:hover{
    text-decoration: none;
}

#FAQ .card-body{
    text-align: left;
    padding: 10px 2rem;
}


/* #FAQ .card-header{
    width: 100%;
} */

/* ------------ Privacy Policy ------------------- */
#privacypolicy{
    padding: 25px 0;
}
#privacypolicy h1{
    font-weight: 700;
}

#privacypolicy h2{
    font-weight: 600;
}



/* ------------ Verification ------------------- */
#Verification{
    height: 100vh;
}

#Verification .verification{
    height: auto;
    margin-top: 50px;
    margin-bottom: 25px;
    width: 35%;
    background: #ECF0F1;
    border-radius: 12px;
    padding-top: 25px;
    padding-bottom: 25px;
}

#Verification .verification p{
    text-align: center;
    margin: 10px auto;
}

#Verification .verification form{
    width: 100%;
    padding: 25px 20% 0;
    margin-bottom: 25px;
}

#Verification .verification form button{
    float: right;
}

#Verification .container .row img{
    height: 200px;
    align-content: center;
    margin: 30px auto;
}

#Verification .container:last-of-type{
    margin: 0 auto
}

#Verification .container h6{
    text-align: center;
}

#Verification h2{
    margin: 0 auto;
    font-size: 32px;
    letter-spacing: 1.5px;
    font-weight: 600;
}

#Verification p{
    font-size: 17px;
}

/* ------------ Verification Complete ------------------- */
#Verification .verification .far{
    font-size: 80px;
    font-weight: 700;
    color: #2C3E50;
    margin: 35px auto;
}

/* ------------ Forget Password Page 2 ------------------- */
#Verification .verification .fas{
    font-size: 80px;
    font-weight: 700;
    color: #2C3E50;
    margin: 35px auto;
}


/* ------------ Modal ------------------- */


/* ------------ footer ------------------- */
footer{
    padding: 50px 0 14px;
    /* background: linear-gradient(65Deg, #000000, #434343); */
    /* background: #0275d8; */
}

footer h3, a{
    color: #ECF0F1 !important;
}

footer a:hover{
    text-decoration: none;
    color: #2C3E50 !important;
    transition: .5s;
}

footer h3{
    font-weight: 600;
}

footer ul li{
    list-style-type: none;
    margin: 12px 0;
}

footer a{
    font-size: 18px;
}

footer h3::after{
    content: '';
    background: #ECF0F1;
    display: block;
    margin-top: 6px;
    width: 105px;
    height: 3.2px;
}

.copyright h5{
    margin-top: 24px;
    color: #ECF0F1 !important;
    font-size: 18px;
}

.sign-footer h6{
    color: #2C3E50 !important;
    font-size: 18px;
}


/* ------------ loading ------------------- */
.preloader{
    position: fixed;
    z-index: 99;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #ffffff;
    display: flex;
    justify-content: center;
    align-items: center;
}

.preloader.hidden{
    animation: fadeOut 1s;
    animation-fill-mode: forwards;
}

@keyframes fadeOut{
    100%{
        opacity: 0;
        visibility: hidden;
    }
}
