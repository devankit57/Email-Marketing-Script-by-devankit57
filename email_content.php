
<!DOCTYPE html>
<html>
	<head>
		<title>Email Portal</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	</head>
	<body>

		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Email Portal</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link " aria-current="page" href="home">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="add_excel">Add Excel </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="data">Email Data</a>
              </li>
			  <li class="nav-item">
                <a class="nav-link active" href="email_content">Email Content</a>
              </li>
              <li class="nav-item dropdown">
        
              
              </li>
              <li class="nav-item">
                <a class="nav-link disabled"></a>
              </li>
            </ul>
            
            <a href="logout">
              <button class="btn btn-outline-success" >Logout</button></a>
            
          </div>
        </div>
      </nav>
      <?php

// Initialize the session
session_start();
 
 //Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
   header("location: index.php");


   exit;
}
require_once'config.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $subject=$_POST['subject'];
    $content=$_POST['content'];
$sql="UPDATE content
SET 
    subject = '$subject',
    content = '$content'
WHERE
    id = 1 ";

$check = mysqli_query($link,$sql);



    
      if ($check){?>
        <div class="alert alert-success" role="alert">
  The Email content has been successfully added !!
</div>
    <?php
    }else{ ?>
      <div class="alert alert-danger" role="alert">
  Some Error Occured !!
</div>
        <?php
    }
  }
      

?>
<div class="m-4">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="row mb-3">
            <label for="inputEmail" class="col-sm-2 col-form-label">Email Subject</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="subject" placeholder="Subject" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputPassword" class="col-sm-2 col-form-label">Email Content</label>
            <div class="col-sm-10">
            <textarea  name="content" rows="14" cols="120" required>

</textarea>
            </div>
        </div>
     
        <div class="row">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </div>
        </div>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>





