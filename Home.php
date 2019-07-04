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
  $query = "SELECT * FROM ticket_STAFF WHERE t_STATUS = 'open' OR t_STATUS = 'in progress' OR t_STATUS = 'check'";
  $result = mysqli_query($conn, $query);
  $total = mysqli_num_rows($result);	
  //echo "<h2><a href=\"list.php?cat=staff.solved\">$total</a><h1>";
  
  $query2 = "SELECT * FROM ticket_STAFF WHERE t_STATUS = 'closed'";
  $result2 = mysqli_query($conn, $query2);
  $total2 = mysqli_num_rows($result2);
  
  $query3 = "SELECT * FROM ticket_CUSTOMER WHERE t_STATUS = 'open' OR t_STATUS = 'in progress' OR t_STATUS = 'follow'";
  $result3 = mysqli_query($conn, $query3);
  $total3 = mysqli_num_rows($result3);
  
   $query4 = "SELECT * FROM ticket_CUSTOMER WHERE t_STATUS = 'closed'";
  $result4 = mysqli_query($conn, $query4);
  $total4 = mysqli_num_rows($result4);
  
  
  
  
  mysqli_close($conn); //disconnect
?>

<!--<div class="row">-->
<div class="card-deck" style = "width: 60rem; height: 15rem; position: absolute;
  margin: auto;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;">
  <div class="card border-primary mb-3">
  <div class="card-header" style = "font-size: 1.2em; font-weight:bold;">Staff</div>
    <div class="card-body">
      <h5 class="card-title " style = "font-size: 1.2em; font-weight:bold;">Unsolved tickets</h5>
	  <p class="card-text"><?php echo "<div style = 'font-size:2em;font-weight:bold;'>".$total."</div>"; ?></p>
      <a href="\ticketlist.php?cat=staff.unsolved" class="btn btn-primary">view tickets</a>
	 <!-- <a href="\query1.php?cat=staff.unsolved" class="btn btn-primary">view tickets</a>-->
    </div>
  </div>
  <div class="card border-primary mb-3">
  <div class="card-header" style = "font-size: 1.2em; font-weight:bold;">Staff</div>
    <div class="card-body">
      <h5 class="card-title" style = "font-size: 1.2em; font-weight:bold;">Solved tickets</h5>
      <p class="card-text"><?php echo "<div style = 'font-size:2em;font-weight:bold;'>".$total2."</div>"; ?></p>
      <a href="\ticketlist.php?cat=staff.solved" class="btn btn-primary">view tickets</a>
	  <!--<a href="\query1.php?cat=staff.unsolved" class="btn btn-primary">view tickets</a>-->
    </div>
  </div>
 <div class="card border-primary mb-3">
 <div class="card-header" style = "font-size: 1.2em; font-weight:bold;">Customer</div>
    <div class="card-body">
      <h5 class="card-title" style = "font-size: 1.2em; font-weight:bold;">Unsolved tickets</h5>
      <p class="card-text"><?php echo "<div style = 'font-size:2em;font-weight:bold;'>".$total3."</div>"; ?></p>
	  <a href="\ticketlist.php?cat=customer.unsolved" class="btn btn-primary">view tickets</a>
	 <!-- <a href="\query1.php?cat=staff.unsolved" class="btn btn-primary">view tickets</a>-->
    </div>
  </div>
  <div class="card border-primary mb-3">
  <div class="card-header" style = "font-size: 1.2em; font-weight:bold;">Customer</div>
    <div class="card-body">
      <h5 class="card-title" style = "font-size: 1.2em; font-weight:bold;">Solved tickets</h5>
      <p class="card-text"><?php echo "<div style = 'font-size:2em;font-weight:bold;'>".$total4."</div>"; ?></p>
	 <a href="\ticketlist.php?cat=customer.solved" class="btn btn-primary">view tickets</a>
	  <!--<a href="\query1.php?cat=staff.unsolved" class="btn btn-primary">view tickets</a>-->
    </div>
  
  </div>
  
</div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>