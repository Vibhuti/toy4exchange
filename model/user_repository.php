<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function get_users() {
    global $db;
    $query = 'SELECT ID, FirstName, Picture FROM profiles WHERE FirstName IS NOT NULL ORDER BY CreatedOn DESC LIMIT 5';
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_user($user_name, $password) {
    global $db;
    $query = 'SELECT ID, UserName FROM users
              WHERE UserName = :user_name AND Password = :password';
    try {
        $password = sha1($password);
        $statement = $db->prepare($query);
        $statement->bindValue(':user_name', $user_name);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_user_by_user_name($user_name) {
    global $db;
    $query = "SELECT * FROM profiles WHERE ID=(select ID from users where UserName= '$user_name')";
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_user_by_userid($user_id) {
    global $db;
    $query = "SELECT * FROM profiles WHERE ID = '$user_id'";
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}


function add_user($user_name, $password) {
    global $db;
    $query = "INSERT INTO users (user_name, password, join_date) "
            . "VALUES (:user_name, :password, NOW())";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_name', $user_name);
        $statement->bindValue(':password', sha1($password));
        //$statement->bindValue(':join_date', NOW());
        $statement->execute();
        $statement->closeCursor();

        // Get the last product ID that was automatically generated
        $user_id = $db->lastInsertId();
        return $user_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function update_user($first_name, $last_name, $gender, $birthdate, $city, $state, $new_picture) {
    global $db;
    if (!empty($new_picture)) {
        $query = "UPDATE profiles SET FirstName = '$first_name', LastName = '$last_name', Gender = '$gender', " .
                " DOB = '$birthdate', City = '$city', State = '$state', ProfilePic = '$new_picture' WHERE ID = '" . $_SESSION['user_id'] . "'";
    } else {
        $query = "UPDATE profiles SET FirstName = '$first_name', LastName = '$last_name', Gender = '$gender', " .
                " DOB = '$birthdate', City = '$city', State = '$state' WHERE ID = '" . $_SESSION['user_id'] . "'";
    }
    try {
        $db->exec($query);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_stockcount($stock_code, $user_id) {
    global $db;
    $query = "select numstocks from userstocks where stockid= '$stock_code' and uid='$user_id'";
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $stockcount = $statement->fetch();
        if ($stockcount[0] == '') {
            $stockcount[0] = 0;
        }
        $statement->closeCursor();
        return $stockcount[0];
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function buy_stock($stock_code, $stock_name, $user_id, $stock_price) {
    global $db;
    $stockcount = get_stockcount($stock_code, $user_id);
    $balance = get_balance($user_id);
    //echo "stockcount:$stockcount balance:$balance stockcode:$stock_code stockname:$stock_name stockprice: $stock_price userid: $user_id";
    if ($stockcount == 0 && $balance >= $stock_price) {
        $query = "insert into userstocks values($user_id,'$stock_code','$stock_name',$stock_price,1,now())";
        $db->exec($query);
        deduct_balance($user_id, $stock_price);
    } else if ($stockcount > 0 && $balance >= $stock_price) {
        $query = "update userstocks set numStocks='$stockcount'+1, lasttradedate=now() where uid='$user_id' and stockid='$stock_code'";
        $db->exec($query);
        deduct_balance($user_id, $stock_price);
    } else {
        echo "There is insufficient balance in your account. Please deposite sufficient money in to your account and try again.";
    }
}

function get_balance($user_id) {
    global $db;
    $query = "select balance from users where user_id='$user_id'";
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $balance = $statement->fetch();
        $statement->closeCursor();
        return $balance[0];
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function deduct_balance($user_id, $stock_price) {
    global $db;
    $balance = get_balance($user_id);
    $query = "update users set balance=('$balance'-'$stock_price') where user_id='$user_id'";
    $db->exec($query);
}

function deposit_balance($user_id, $amount) {
    global $db;
    $balance = get_balance($user_id);
    $query = "update users set balance=('$balance'+'$amount') where user_id='$user_id'";
    $db->exec($query);
}

function getuserstockinfo($user_id) {
    global $db;
    $query = "select stockid,stockname,stockprice,numstocks,lasttradedate from userstocks where uid='$user_id'";
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $stockinfo = $statement->fetchAll();
        $statement->closeCursor();
        return $stockinfo;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function updateuserstock($user_id, $stock_code) {
    global $db;
    $stockcount = get_stockcount($stock_code, $user_id);
    $query = "update userstocks set numStocks=$stockcount-1 where stockid='$stock_code' and uid=$user_id";
    $db->exec($query);
}

function sellstock($stock_code, $user_id, $stock_price) {
    global $db;
    $stockcount = get_stockcount($stock_code, $user_id);
    if ($stockcount > 0) {
        deposit_balance($user_id, $stock_price);
        updateuserstock($user_id, $stock_code);
    } else {
        echo "You do not have enough stocks to sell";
    }
}

function getstockprice($stock_code) {
    global $db;
    $query = "select stockprice from userstocks where stockid='$stock_code'";
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $stockprice = $statement->fetchAll();
        $statement->closeCursor();
        return $stockprice[0];
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}
?>

