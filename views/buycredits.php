<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php include('_header.php'); ?>
    <body>
        <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <fieldset>
                <legend>Buy Credits</legend>
                <label for="CC_NO">Credit Card Number:</label>
                <input type="text" id="CC_NO" name="CC_NO" value="<?php if (!empty($CC_NO)) echo $CC_NO; ?>" />
                <label for="CC_Type">Credit Card Type:</label>
                <select id="CC_Type" name="CC_Type"><br/>
                <option value="Visa" <?php if (!empty($CC_Type) && $CC_Type == 'Visa') echo 'selected = "selected"'; ?>>Visa</option>
                <option value="Master" <?php if (!empty($CC_Type) && $CC_Type == 'Master') echo 'selected = "selected"'; ?>>Master</option>
                </select><br /><br/>
                <label for="Name">Name on the Card:</label>
                <input type="text" id="Name" name="Name" value="<?php if (!empty($Name)) echo $Name; ?>" />
                <label for="ExpiryDate">Expiration Date:</label><br/>
                <input type="date" id="ExpiryDate" name="ExpiryDate" value="<?php if (!empty($ExpiryDate)) {echo $ExpiryDate;} else {echo 'mm/dd/yy';} ?>" /><br /><br />
                <label for="CSV">CSV:</label>
                <input type="text" id="CSV" name="CSV" value="<?php if (!empty($CSV)) echo $CSV; ?>" />
                <label for="Zip">Billing Zip:</label>
                <input type="text" id="Zip" name="Zip" value="<?php if (!empty($Zip)) echo $Zip; ?>" />
                <label for="Amount">Amount:</label>
                <input type="text" id="Amount" name="Amount" value="<?php if (!empty($Amount)) echo $Amount; ?>" />
            </fieldset>
            <input type="submit" value="Buy Credits" name="submit" />
        </form>
        <a href="index.php">Home</a>
    </body>
    <?php include('_footer.php'); ?>
</html>