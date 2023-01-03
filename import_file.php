<?php

// Initialize the session
session_start();
 
 //Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
   header("location: index.php");


   exit;
}
if(isset($_POST["submit_file"]))
{
    require_once "config.php";
   
 $file = $_FILES["file"]["tmp_name"];
 $file_open = fopen($file,"r");
 while(($csv = fgetcsv($file_open, 1000, ",")) !== false)
 {
  $c1 = $csv[0];
  $c2 = $csv[1];
 
  $sql="INSERT INTO customer(customer_name,customer_email) VALUES ('$c1','$c2')";
  $result = mysqli_query($link, $sql);
  if($result){
    $arr="Excel File Imported Successfully";
    echo ("<script LANGUAGE='JavaScript'>
window.alert('$arr');

window. location. href='index';


</script>");

  }else{
    $arr="oops !! Error";
    echo ("<script LANGUAGE='JavaScript'>
window.alert('$arr');

window. location. href='index';


</script>");
  }
 }
}
?>