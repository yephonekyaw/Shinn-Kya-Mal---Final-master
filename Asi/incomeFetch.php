<?php

    session_start();
    include("../main/cons/config.php");
    if(isset($_SESSION['user']) == true)
    {
        if (isset($_POST['editId'])) {
            $userId = $_SESSION['id'];
            $transId = mysqli_real_escape_string($conn, $_POST['editId']);
        
            $sql = "SELECT * FROM income WHERE income_id='$transId' AND  income_user_fk_id='$userId' ";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
        
            $current_cat = $row['income_categories'];
            $date = $row['income_dateTime'];
            $month = date('m', strtotime($date));
        }
    }
    else 
    {
        header("location:../main/signinPage.php?");
        exit();
    }

?>
<form action="transactionEdit.php" class="container-fluid" method="POST">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="">Type</label>
            <select name="trans_type" class="form-control" id="trans_type" required>
                <option value="Income" selected>Income</option>
                <option value="Expense">Expense</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="">Cateogry</label>
            <select name="trans_cat" class="form-control" id="trans_cat" required>
                <option value="<?php echo($current_cat) ?>" selected><?php echo($current_cat); ?></option>
                <?php
                // Show Categories
                $sqlUserCat = "SELECT * FROM incomecat WHERE extra_cat_on_user_id IN(0, '$userId') AND income_categories_name NOT IN('$current_cat')";
                $resultUserCat = mysqli_query($conn, $sqlUserCat);
                while ($rowUserCat = mysqli_fetch_assoc($resultUserCat)) {
                ?>
                    <option value="<?php echo ($rowUserCat['income_categories_name']) ?>"><?php echo ($rowUserCat['income_categories_name']) ?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="">Date</label>
            <input name="datetime" value="<?php echo($row['income_dateTime']); ?>" type="date" id="datetime" class="form-control" data-provide="datapicker" required>
        </div>
        <div class="form-group col-md-6">
            <label for="">Amount</label>
            <input name="trans_amount" id="trans_amount" type="number" class="form-control" value="<?php echo($row['income_amount']); ?>" required>
        </div>
    </div>
    <div class="form-row justify-content-center">
        <div class="form-group col-md-6">
            <label for="">Tag</label>
            <input type="text" name="trans_tag" id="trans_tag" value="<?php echo($row['income_tag']); ?>" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label for="">Description</label>
            <textarea name="trans_des" class="form-control" id="trans_des" cols="50" rows="3"><?php echo($row['income_description']); ?></textarea>
        </div>
        <input type="hidden" name="editId" value="<?php echo($row['income_id']); ?>" id="editId">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="edit" id="edit" value="Edit" class="btn btn-primary">
    </div>
</form>