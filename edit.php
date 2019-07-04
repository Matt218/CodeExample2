<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	
	<style> input[type="text"]{width:211px;}</style>
  </head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style = "height:7em;">
  <a class="navbar-brand" href="Home.php" style = "font-size: 2em;">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><!-- make others active if its pressed -->
        <a class="nav-link" href="ticketlist.php?cat=staff.unsolved">Staff unsolved <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="ticketlist.php?cat=staff.solved">Staff solved</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="ticketlist.php?cat=customer.unsolved">Customer unsolved</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="ticketlist.php?cat=customer.solved">Customer solved</a>
      </li>
     
    </ul>
      <form action = "searchquery.php" method = "post" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" style = "width:20em;"type="search" placeholder="Search by ID" aria-label="Search" name = "search" pattern = "[0-9]{1,}" title = "Enter an ID number!"required></input>
      <button class="btn btn-primary my-2 my-sm-0"  type="submit" name = "btn">Search</button>
    </form>
  </div>
</nav>



<?php 
	$host = '127.0.0.1';
$user = 's4905084';
$pwd = 'y9M7FHkWe9FgufYfdUaswMKdXWeo7ukv';
$db = $user;
$conn = mysqli_connect($host, $user, $pwd, $db);

if(isset($_GET['id']))
{
	
	if($_GET['ticket'] == 'staff'){
	if(isset($_POST['update']))
	{
		if(!empty($_POST['status']))
		{
			//make status a drop down
			
			$tID = $_POST['id'];
			$status =  strtoupper($_POST['status']);
			$query = "UPDATE ticket_STAFF SET t_STATUS = '".$status."' WHERE t_ID = ".$tID."";
			$result = mysqli_query($conn,$query);
			
		
		}
		if(!empty($_POST['priority']))
		{
			if(hasLetters($_POST['priority']))
			{
				echo "<div class='alert alert-danger' role='alert'>
					Priority input contains letters!</div>";
					
				
			}else if(hasSpecial($_POST['priority']))
			{
				echo "<div class='alert alert-danger' role='alert'>
					Priority input contains special characters!</div>";
				
			}else if (noHigher($_POST['priority'])){
				$tID = $_POST['id'];
				$priority = $_POST['priority'];
				$query = "UPDATE ticket_STAFF SET t_PRIORITY = '".$priority."' WHERE t_ID = ".$tID."";
				$result = mysqli_query($conn,$query);
				echo "<div class='alert alert-primary' role='alert'>";
				echo "Update successful!</div>";
			}
			else {
				
				echo "<div class='alert alert-danger' role='alert'>
					Priority input not valid!</div>";
			}
		}else if(isset($_POST['priority']) && empty($_POST['priority']))
		{
			$tID = $_POST['id'];
			$priority = 0;
			$query = "UPDATE ticket_STAFF SET t_PRIORITY = '".$priority."' WHERE t_ID = ".$tID."";
			$result = mysqli_query($conn,$query);
				echo "<div class='alert alert-primary' role='alert'>";
				echo "Update successful!</div>";
		}
		
		
	
	
	}
	else if(isset($_POST['delete']))
	{
		$tID = $_GET['id'];// id here being retrieved from url, connected with href in updateticket.php
		$query = "DELETE FROM ticket_STAFF WHERE t_ID = ".$tID."";
		$result = mysqli_query($conn,$query);
		if($_GET['prev'] == 'staff.solved'){
		header("Location: ticketlist.php?cat=staff.solved");}
		else if($_GET['prev'] == 'staff.unsolved'){
		header("Location: ticketlist.php?cat=staff.unsolved");}
		else if($_GET['prev'] == 'staff.open'){
		header("Location: TicketOpenProgress.php?status=staff.open");}
		else if($_GET['prev'] == 'staff.progress'){
		header("Location: TicketOpenProgress.php?status=staff.progress");}
		else if($_GET['prev'] == 'home'){
		header("Location: Home.php");}

		
	}
	
	
$tID = $_GET['id'];
//$user = $_GET['user'];
//if($user == 'staff'){}
//else if($user == 'customer'){}
$query = "SELECT * FROM ticket_STAFF WHERE t_ID = ".$tID."";
$result = mysqli_query($conn, $query);

echo "<br>";
while($row = mysqli_fetch_assoc($result))
	{	
	 echo "<form action=\"\" method=\"post\">
        <input type=\"text\" name=\"id\" value=\"".$row['t_ID']."\" readonly><br>
		<input type=\"text\" name=\"title\" value=\"".$row['t_TITLE']."\" readonly><br>
		<input type=\"text\" name=\"summary\" value=\"".$row['t_SUMMARY']."\" readonly><br>
		<input type=\"text\" name=\"user\" value=\"".$row['t_USER']."\" readonly><br>
		<input type=\"text\" name=\"uid\" value=\"".$row['t_UID']."\" readonly><br>
		<input type=\"text\" name=\"usrgroup\" value=\"".$row['t_USRGROUP']."\" readonly><br>
		<input type=\"text\" name=\"category\" value=\"".$row['t_CAT']."\" readonly><br>
		<input type=\"text\" name=\"timestamp\" value=\"".$row['t_TIMESTAMP']."\" readonly><br>
		<input type=\"text\" name=\"priority\" value=\"".$row['t_PRIORITY']."\" required><br>
		<select style = 'width: 211px;' name =\"status\"><option value ='OPEN' "; if ($row['t_STATUS'] == 'OPEN') echo 'selected';echo ">OPEN</option>
		<option value = 'CLOSED' "; if ($row['t_STATUS'] == 'CLOSED') echo 'selected';echo ">CLOSED</option>
		<option value = 'IN PROGRESS' "; if ($row['t_STATUS'] == 'IN PROGRESS') echo 'selected'; echo ">IN PROGRESS</option>
		<option value = 'CHECK' "; if ($row['t_STATUS'] == 'CHECK') echo 'selected';echo " >CHECK</option></select><br><br>
		<input type=\"submit\" name=\"update\" value=\"Update\">
		<input type=\"submit\" name=\"delete\" value=\"Delete\">
      </form>";
	// get rid of redundant option for dropdown?
	}
} else if($_GET['ticket'] == 'customer'){
	if(isset($_POST['update']))
	{
		if(!empty($_POST['status']))
		{
			//make status a drop down
			
			$tID = $_POST['id'];
			$status =  strtoupper($_POST['status']);
			$query = "UPDATE ticket_CUSTOMER SET t_STATUS = '".$status."' WHERE t_ID = ".$tID."";
			$result = mysqli_query($conn,$query);
			
			
		
		}
		if(!empty($_POST['priority']))
		{
			if(hasLetters($_POST['priority']))
			{
				echo "<div class='alert alert-danger' role='alert'>
					Priority input contains letters!</div>";
				
			}else if(hasSpecial($_POST['priority']))
			{
				echo "<div class='alert alert-danger' role='alert'>
					Priority input contains special characters!</div>";
				
			}else if (noHigher($_POST['priority'])){
				$tID = $_POST['id'];
				$priority = $_POST['priority'];
				$query = "UPDATE ticket_CUSTOMER SET t_PRIORITY = '".$priority."' WHERE t_ID = ".$tID."";
				$result = mysqli_query($conn,$query);
				echo "<div class='alert alert-primary' role='alert'>";
				echo "Update successful!</div>";
				
			}
			else {
				
				echo "<div class='alert alert-danger' role='alert'>
					Priority input not valid!</div>";
			}
		}else if(isset($_POST['priority']) && empty($_POST['priority']))
		{
			$tID = $_POST['id'];
			$priority = 0;
			$query = "UPDATE ticket_CUSTOMER SET t_PRIORITY = '".$priority."' WHERE t_ID = ".$tID."";
			$result = mysqli_query($conn,$query);
			echo "<div class='alert alert-primary' role='alert'>";
				echo "Update successful!</div>";
		}
		
		
	
	
	}
	else if(isset($_POST['delete']))
	{
		$tID = $_GET['id'];// id here being retrieved from url, connected with href in updateticket.php
		$query = "DELETE FROM ticket_CUSTOMER WHERE t_ID = ".$tID."";
		$result = mysqli_query($conn,$query);
		if($_GET['prev'] == 'customer.solved'){
		header("Location: ticketlist.php?cat=customer.solved");}
		else if($_GET['prev'] == 'customer.unsolved'){
		header("Location: ticketlist.php?cat=customer.unsolved");}
		else if($_GET['prev'] == 'home'){
			header("Location: Home.php");}
		else if($_GET['prev'] == 'customer.open'){
		header("Location: TicketOpenProgress.php?status=customer.open");}
		else if($_GET['prev'] == 'customer.progress'){
		header("Location: TicketOpenProgress.php?status=customer.progress");}
		
		
	}
	
	
$tID = $_GET['id'];
//$user = $_GET['user'];
//if($user == 'staff'){}
//else if($user == 'customer'){}
$query = "SELECT * FROM ticket_CUSTOMER WHERE t_ID = ".$tID."";
$result = mysqli_query($conn, $query);

echo "<br>";
while($row = mysqli_fetch_assoc($result))
	{
	  echo "<form action=\"\" method=\"post\">
        <input type=\"text\" name=\"id\" value=\"".$row['t_ID']."\" readonly><br>
		<input type=\"text\" name=\"title\" value=\"".$row['t_TITLE']."\" readonly><br>
		<input type=\"text\" name=\"summary\" value=\"".$row['t_SUMMARY']."\" readonly><br>
		<input type=\"text\" name=\"user\" value=\"".$row['t_USER']."\" readonly><br>
		<input type=\"text\" name=\"uid\" value=\"".$row['t_UID']."\" readonly><br>
		<input type=\"text\" name=\"usrgroup\" value=\"".$row['t_USRGROUP']."\" readonly><br>
		<input type=\"text\" name=\"category\" value=\"".$row['t_CAT']."\" readonly><br>
		<input type=\"text\" name=\"timestamp\" value=\"".$row['t_TIMESTAMP']."\" readonly><br>
		<input type=\"text\" name=\"priority\" value=\"".$row['t_PRIORITY']."\" required><br>
		<select style = 'width: 211px;' name =\"status\"><option value ='OPEN' "; if ($row['t_STATUS'] == 'OPEN') echo 'selected';echo ">OPEN</option>
		<option value = 'CLOSED' "; if ($row['t_STATUS'] == 'CLOSED') echo 'selected';echo ">CLOSED</option>
		<option value = 'IN PROGRESS' "; if ($row['t_STATUS'] == 'IN PROGRESS') echo 'selected'; echo ">IN PROGRESS</option>
		<option value = 'FOLLOW' "; if ($row['t_STATUS'] == 'FOLLOW') echo 'selected';echo " >FOLLOW</option></select><br><br>
		<input type=\"submit\" name=\"update\" value=\"Update\">
		<input type=\"submit\" name=\"delete\" value=\"Delete\">
      </form>";
	// get rid of redundant option for dropdown?
	}
}
}
else
{
	echo "<p>Access blocked. Access through ticket list.</p>";
	
}

function hasLetters($string)
{
	//echo $string;
	return preg_match('/[a-zA-Z]/', $string);
	
}

function noHigher($string)
{
	$min = 0;
	$max = 3;
	if($string < $min || $string > $max)
	{
		return false;
	}
	else{
		return true;
	}
	
}
function hasSpecial($string)
{
	return preg_match('/[^a-zA-Z\d]/', $string);
}
	

mysqli_close($conn);

?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>