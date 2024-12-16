<!-- 
    Author: Kamoliddin Sultanov 
    File purpose: log out the system

-->
<?php 

// session_start();
// if(session_destroy()){
// 	header("location: index.php");
// }


session_start();
session_unset(); 
session_destroy(); 
header("Location: index.php"); 
exit;

?>