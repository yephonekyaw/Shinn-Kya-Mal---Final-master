<?php
session_start();
include("../main/cons/config.php");
if ($_SESSION['user'] == true) {
    $id = $_SESSION['id'];
    $email = $_SESSION['email'];

    if (isset($_POST['edit'])) {

        $trans_id = mysqli_real_escape_string($conn, $_POST['editId']);
        $trans_type = mysqli_real_escape_string($conn, $_POST['trans_type']);
        $trans_cat = mysqli_real_escape_string($conn, $_POST['trans_cat']);
        $trans_date = mysqli_real_escape_string($conn, $_POST['datetime']);
        $trans_amount = mysqli_real_escape_string($conn, $_POST['trans_amount']);
        $trans_tag = mysqli_real_escape_string($conn, $_POST['trans_tag']);
        $trans_des = mysqli_real_escape_string($conn, $_POST['trans_des']);

        if ($trans_type == 'Expense') {

            // Get Categories Name from expense table
            $sql = "SELECT * FROM expense WHERE expense_id='$trans_id' ";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $catName = $row['expense_categories'];
            $date = $row['expense_dateTime'];
            $dateMonth = date('m', strtotime($date));

            // Get Id From Categories Table
            $sqlCatId = "SELECT * FROM expensecat WHERE categories_name='$catName' AND extra_cat_on_user_id IN(0,'$id') ";
            $resultCatId = mysqli_query($conn, $sqlCatId);
            $rowCatId = mysqli_fetch_assoc($resultCatId);
            $catId = $rowCatId['categories_id'];

            // Minus From ExpenseByCat
            $sqlMin = "SELECT * FROM expensebycat WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$dateMonth' ";
            $resutlMin = mysqli_query($conn, $sqlMin);
            $rowMin = mysqli_fetch_assoc($resutlMin);
            $amountMin = 0;
            $amountMin = $rowMin['expense_cat_amount'] - $row['expense_amount'];

            // Update ExpenseByCat table
            mysqli_query($conn,"UPDATE expensebycat SET expense_cat_amount='$amountMin' WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$dateMonth' ");
            
            // Delete the expense or income
            $sqlDel = "DELETE FROM expense WHERE expense_id='$trans_id' ";
            mysqli_query($conn, $sqlDel);

            // Take categories id
            $sqlCat = "SELECT categories_id FROM expensecat WHERE categories_name='$trans_cat' AND extra_cat_on_user_id IN(0,'$id') ";
            $resultCat = mysqli_query($conn, $sqlCat);
            $rowCat = $resultCat->fetch_assoc();
            $catId = $rowCat['categories_id'];

            // Insert into expense table
            $sqlExp = "INSERT INTO expense(expense_id, expense_categories, expense_user_fk_id, expense_dateTime, expense_amount, expense_description, expense_tag) VALUES('$trans_id', '$trans_cat', '$id', '$trans_date', '$trans_amount', '$trans_des', '$trans_tag')";
            mysqli_query($conn, $sqlExp);

            //Add to expensebycat table
            $addMonth = date('m', strtotime($trans_date));
            $sqlByCat = "SELECT * FROM expensebycat WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$addMonth' ";
            $resultByCat = mysqli_query($conn, $sqlByCat);
            if($rowByCat=mysqli_fetch_assoc($resultByCat))
            {
                $updateAmount=0;
                $updateAmount = $rowByCat['expense_cat_amount'] + $trans_amount;
                mysqli_query($conn, "UPDATE expensebycat SET expense_cat_amount='$updateAmount' WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$addMonth' ");
            }
            else if(!$rowByCat=mysqli_fetch_assoc($resultByCat))
            {
                mysqli_query($conn, "INSERT INTO expensebycat(expense_cat_fk_id, expense_user_cat_id, expense_cat_amount, expense_cat_date) VALUES('$catId', '$id', '$trasn_amount', '$trans_date') ");
            }
            header("location: dashboard.php?month=$addMonth");
            exit();

        } else if ($trans_type == 'Income') {

            // Get Categories Name from income table
            $sql = "SELECT * FROM income WHERE income_id='$trans_id' ";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $catName = $row['income_categories'];
            $date = $row['income_dateTime'];
            $dateMonth = date('m', strtotime($date));

            // Get Id Form Categories Table
            $sqlCatId = "SELECT * FROM incomecat WHERE income_categories_name='$catName' AND extra_cat_on_user_id IN(0,'$id') ";
            $resultCatId = mysqli_query($conn, $sqlCatId);
            $rowCatId = mysqli_fetch_assoc($resultCatId);
            $catId = $rowCatId['income_categories_id'];

            // Minus From IncomeByCat
            $sqlMin = "SELECT * FROM incomebycat WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$id' AND MONTH(income_cat_date)='$dateMonth' ";
            $resutlMin = mysqli_query($conn, $sqlMin);
            $rowMin = mysqli_fetch_assoc($resutlMin);
            $amountMin = 0;
            $amountMin = $rowMin['income_cat_amount'] - $row['income_amount'];

            // Update ExpenseByCat table
            mysqli_query($conn,"UPDATE incomebycat SET income_cat_amount='$amountMin' WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$id' AND MONTH(income_cat_date)='$dateMonth' ");

            // Delete the expense or income
            $sqlDel = "DELETE FROM income WHERE income_id='$trans_id' ";
            mysqli_query($conn, $sqlDel);

            // Take categories id
            $sqlCat = "SELECT income_categories_id FROM incomecat WHERE income_categories_name='$trans_cat' ";
            $resultCat = mysqli_query($conn, $sqlCat);
            $rowCat = $resultCat->fetch_assoc();
            $catId = $rowCat['income_categories_id'];

            // Insert into expense table
            $sqlExp = "INSERT INTO income (income_id, income_categories, income_user_fk_id, income_dateTime, income_amount, income_description, income_tag) VALUES ('$trans_id', '$trans_cat', '$id', '$trans_date', '$trans_amount', '$trans_des', '$trans_tag') ";
            mysqli_query($conn, $sqlExp);

            
            //Add to incomebycat table
            $addMonth = date('m', strtotime($trans_date));
            $sqlByCat = "SELECT * FROM incomebycat WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$id' AND MONTH(income_cat_date)='$addMonth' ";
            $resultByCat = mysqli_query($conn, $sqlByCat);
            if($rowByCat=mysqli_fetch_assoc($resultByCat))
            {
                $updateAmount=0;
                $updateAmount = $rowByCat['income_cat_amount'] + $trans_amount;
                mysqli_query($conn, "UPDATE incomebycat SET income_cat_amount='$updateAmount' WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$id' AND MONTH(income_cat_date)='$addMonth' ");
            }
            else if(!$rowByCat=mysqli_fetch_assoc($resultByCat))
            {
                mysqli_query($conn, "INSERT INTO incomebycat(income_cat_fk_id, income_user_cat_id, income_cat_amount, income_cat_date) VALUES('$catId', '$id', '$trans_amount', '$trans_date') ");
            }
            header("location: dashboard.php?month=$addMonth");
            exit();
        }
    }
}
else 
{
    header("../main/signinPage.php");
    exit();
}
