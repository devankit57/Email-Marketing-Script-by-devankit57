<?php


// Initialize the session
session_start();
 
 //Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
   header("location: index.php");


   exit;
}

$link = new PDO("mysql:host=localhost;dbname=email", "root", "");
$query = "SELECT * FROM customer ORDER BY customer_id";
$statement = $link->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

?>
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
                <a class="nav-link active" aria-current="page" href="home">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="add_excel">Add Excel </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="data">Email Data</a>
              </li>
			  <li class="nav-item">
                <a class="nav-link" href="email_content">Email Content</a>
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
		<div class="container">
			<h3 align="center">All Available Emails</h3>
			<br />
			<p>
         <input type="button" onclick='selectAll()' value="Select All"/>
         <input type="button" onclick='UnSelectAll()' value="Unselect All"/>
		 <button type="button" name="bulk_email" class="btn btn-info email_button" id="bulk_email" data-action="bulk">Send Bulk</button>
      </p>
	  
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
				
					<tr>
						<th>Customer Name</th>
						<th>Email</th>
						<th>Select</th>
						<th>Action</th>
					</tr>
				<?php
				$count = 0;
				foreach($result as $row)
				{
					$count = $count + 1;
					echo '
					<tr>
						<td>'.$row["customer_name"].'</td>
						<td>'.$row["customer_email"].'</td>
						<td>
							<input type="checkbox" name="single_select" class="single_select" data-email="'.$row["customer_email"].'" data-name="'.$row["customer_name"].'" />
						</td>
						<td>
						<button type="button" name="email_button" class="btn btn-info btn-xs email_button" id="'.$count.'" data-email="'.$row["customer_email"].'" data-name="'.$row["customer_name"].'" data-action="single">Send Single</button>
						</td>
					</tr>
					';
				}
				?>
					
				</table>
			</div>
		</div>
	</body>
</html>

<script>
$(document).ready(function(){
	$('.email_button').click(function(){
		$(this).attr('disabled', 'disabled');
		var id  = $(this).attr("id");
		var action = $(this).data("action");
		var email_data = [];
		if(action == 'single')
		{
			email_data.push({
				email: $(this).data("email"),
				name: $(this).data("name")
			});
		}
		else
		{
			$('.single_select').each(function(){
				if($(this).prop("checked") == true)
				{
					email_data.push({
						email: $(this).data("email"),
						name: $(this).data('name')
					});
				} 
			});
		}

		$.ajax({
			url:"send_mail.php",
			method:"POST",
			data:{email_data:email_data},
			beforeSend:function(){
				$('#'+id).html('Sending...');
				$('#'+id).addClass('btn-danger');
			},
			success:function(data){
				if(data == 'ok')
				{
					$('#'+id).text('Success');
					$('#'+id).removeClass('btn-danger');
					$('#'+id).removeClass('btn-info');
					$('#'+id).addClass('btn-success');
				}
				else
				{
					$('#'+id).text(data);
				}
				$('#'+id).attr('disabled', false);
			}
		})

	});
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script type="text/javascript">
         function selectAll(){
         	var items=document.getElementsByName('single_select');
         	for(var i=0; i<items.length; i++){
         		if(items[i].type=='checkbox')
         			items[i].checked=true;
         	}
         }
         
         function UnSelectAll(){
         	var items=document.getElementsByName('single_select');
         	for(var i=0; i<items.length; i++){
         		if(items[i].type=='checkbox')
         			items[i].checked=false;
         	}
         }
	</script>



