<?php
function logout(){
    // Clear session variables
    session_start(); // Ensure the session is started
    $_SESSION = [];  // Clear session variables

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header('Location: ../login/login.php');
    exit();
}

function passwordhash($password){
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    return $password_hash;
}

function isAuthenticated() {
    return isset($_SESSION['user']);   
}

function opfill($val){
    //echo "<option value='" . htmlspecialchars($val) . "'>" . htmlspecialchars($name) . "</option>";
    $_SESSION['value']=isset($val)?$val:null;
    //echo "load";
  }
  
function optiongen($conn, $table, $val,$name) {
    // Properly construct the SQL query
    $query = "SELECT `$val`,`$name` FROM `$table`";
    $result = $conn->query($query);
    
    $val_o = isset($_SESSION['value']) ? $_SESSION['value'] : null;
      echo $val_o;
    //$name_o = isset($_SESSION['value']) ? $_SESSION['value'] : null;
  
    if ($result->num_rows > 0) {
        // Loop through each row
        while ($row = $result->fetch_row()) {
            // Properly fetch the column value
            $val = $row[0];
            $name = $row[1];
            echo "<option value='" . htmlspecialchars($val) . "'";
            if ($val == $val_o) {
              echo " selected";
            }
            echo ">" . htmlspecialchars($name) . "</option>";
          }
        unset($_SESSION['value']);
    } 
}

?>

