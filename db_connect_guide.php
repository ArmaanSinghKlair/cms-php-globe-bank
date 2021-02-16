<?php

// This guide demonstrates the five fundamental steps
// of database interaction using PHP.

// Credentials
$dbhost = '';
$dbuser = '';
$dbpass = '';
$dbname = '';

// 1. Create a database connection
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(mysqli_connect_errno()){
    $msg = "Database connection failed: ";
    $msg .= mysqli_connect_error();
    $msg .=" (".mysqli_connect_errno().")";
    exit($msg);
}

// 2. Perform database query
$query = "SELECT * FROM subjects";
$result_set = mysqli_query($connection, $query);

if(!result_set){
    exit("Database query failed");
}
// 3. Use returned data (if any)
while($result = mysqli_fetch_assoc($result_set)){
    echo $result["menu_name"]."<br />";
}
// 4. Release returned data
mysqli_free_result($result_set);
// 5. Close database connection
mysqli_close($connection);

?>
