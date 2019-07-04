<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	
	
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



if(isset($_POST["btn"]))
{
	if(!empty($_POST["search"]))
	{
		$usr = $_POST["search"];
		$query = "SELECT * from ticket_STAFF WHERE t_ID = '".$usr."%' UNION ALL SELECT * from ticket_CUSTOMER WHERE t_ID = '".$usr."%' ORDER BY t_STATUS";
		$result = mysqli_query($conn, $query); 
		$count = mysqli_num_rows($result);
		
					echo "<br>";
echo "<table class='table table-hover'>";
  echo "<thead class='thead-dark'>";
    echo "<tr>";
        echo "<th scope='col'>ID</th>";
     echo  "<th scope='col'>Title</th>";
     echo "<th scope='col'>Summary</th>";
	 echo "<th scope='col'>User</th>";
     echo  "<th scope='col'>UID</th>";
     echo "<th scope='col'>User Group</th>";
	 echo "<th scope='col'>Category</th>";
     echo  "<th scope='col'>Timestamp</th>";
     echo "<th scope='col'>Priority</th>";
	 echo "<th scope='col'>Status</th>";
   echo  "</tr>";
	echo "</thead>";
	echo "<tbody>";
	
		if($count > 0){
		
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

		//echo "<p>".$row["t_ID"]." ".$row["t_TITLE"]." ".$row["t_USER"]."</p>";
		
			
			if($row['t_USRGROUP'] == 'STAFF')
			{
				echo "<tr><td><a href=\"edit.php?id=".$row['t_ID']."&ticket=staff&prev=home\">".$row['t_ID']."</td>";// put prev=home and add if statement on edit delete
				echo"<td>".$row['t_TITLE']."</td>";
				echo"<td>".$row['t_SUMMARY']."</td>";
				echo"<td>".$row['t_USER']."</td>";
				echo"<td>".$row['t_UID']."</td>";
				echo"<td>".$row['t_USRGROUP']."</td>";
				echo"<td>".$row['t_CAT']."</td>";
				echo"<td>".$row['t_TIMESTAMP']."</td>";
				echo"<td>".$row['t_PRIORITY']."</td>";
				echo"<td>".$row['t_STATUS']."</a></td></tr>";
		
			}else if($row['t_USRGROUP'] == 'CUSTOMER')
			{
				echo "<tr><td><a href=\"edit.php?id=".$row['t_ID']."&ticket=customer&prev=home\">".$row['t_ID']."</td>";
				echo"<td>".$row['t_TITLE']."</td>";
				echo"<td>".$row['t_SUMMARY']."</td>";
				echo"<td>".$row['t_USER']."</td>";
				echo"<td>".$row['t_UID']."</td>";
				echo"<td>".$row['t_USRGROUP']."</td>";
				echo"<td>".$row['t_CAT']."</td>";
				echo"<td>".$row['t_TIMESTAMP']."</td>";
				echo"<td>".$row['t_PRIORITY']."</td>";
				echo"<td>".$row['t_STATUS']."</a></td></tr>";
			}
	
		}
		
		}else{
			echo "<p>ID not found</p>";// not showing
			
		}
			
	}
	
	
}else {
	
	echo "<p>no ID entered</p>";
}
echo "</tbody></table>";


mysqli_close($conn);
?>
 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
