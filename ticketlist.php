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
	<?php if($_GET['cat'] == 'staff.unsolved')
      echo "<li class='nav-item active' ><!-- make others active if its pressed -->
        <a class='nav-link'  href='ticketlist.php?cat=staff.unsolved'>Staff unsolved <span class='sr-only'>'(current)'</span></a>
      </li>";
	  else echo "<li class='nav-item' ><!-- make others active if its pressed -->
        <a class='nav-link'  href='ticketlist.php?cat=staff.unsolved'>Staff unsolved <span class='sr-only'>'(current)'</span></a>
      </li>";
	  ?>
	  <?php if($_GET['cat'] == 'staff.solved')
		echo "<li class='nav-item active'>
        <a class='nav-link' href='ticketlist.php?cat=staff.solved'>Staff solved</a>
      </li>";
	  else echo  "<li class='nav-itemS'>
        <a class='nav-link' href='ticketlist.php?cat=staff.solved'>Staff solved</a>
      </li>";
	  ?>
	  <?php if($_GET['cat'] == 'customer.unsolved')
	  echo "<li class='nav-item active'>
        <a class='nav-link' href='ticketlist.php?cat=customer.unsolved'>Customer unsolved</a>
      </li>";
	  else echo "<li class='nav-item'>
        <a class='nav-link' href='ticketlist.php?cat=customer.unsolved'>Customer unsolved</a>
      </li>";
	  ?>
	  <?php if($_GET['cat'] == 'customer.solved')
	  echo "<li class='nav-item active'>
        <a class='nav-link' href='ticketlist.php?cat=customer.solved'>Customer solved</a>
      </li>";
	  else echo "<li class='nav-item'>
        <a class='nav-link' href='ticketlist.php?cat=customer.solved'>Customer solved</a>
      </li>";
	  ?>
    </ul>
      <form action = "searchquery.php" method = "post" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" style = "width:20em;"type="search" placeholder="Search by ID" aria-label="Search" name = "search" pattern = "[0-9]{1,}" title = "Enter an ID number!"required></input>
      <button class="btn btn-primary my-2 my-sm-0"  type="submit" name = "btn">Search</button>
    </form>
  </div>
</nav>





<form action="#" method="get">
<select id = 'sorting' name = 'order' onchange = 'this.form.submit()' <?php if(!isset($_GET['cat'])) echo 'hidden';?> >
<option value = 'ASC' <?php if ($_GET['order'] == 'ASC') echo 'selected';?> >priority:low-high</option>
<option value ='DESC' <?php if($_GET['order'] == 'DESC') echo 'selected';?> >priority:high-low </option></select>
<input type = 'hidden' name = 'cat' value = <?php echo $_GET['cat'];?>></input>
</form>



<?php 
$host = '127.0.0.1';
$user = 's4905084';
$pwd = 'y9M7FHkWe9FgufYfdUaswMKdXWeo7ukv';
$db = $user;
$conn = mysqli_connect($host, $user, $pwd, $db);


if(isset($_GET['cat']) || isset($_GET['order'])){// isset 'order' needed or if statement inside enough?// split get cat and get order into separate ifs
	$order = $_GET['order'];//needed here or put inside if '$_GET == staff.solved' statement?
	$category = $_GET['cat'];
	
if ($_GET['cat'] == 'staff.solved' ){
	
$query = "SELECT * from ticket_STAFF WHERE t_STATUS = 'closed' ORDER BY t_PRIORITY ASC, t_STATUS ";
$result = mysqli_query($conn,$query);
//pagination
$totalrows = mysqli_num_rows($result); // step 1: find total records in db
$maxpage = 5;// step 2: decide yourself, maximum no. of records displayed per page
$totalpages = ceil($totalrows/$maxpage);// step 3:calculates total no. of pages needed
$pagenum = 1;//set default of pagination



echo "<table class='table table-hover' style = 'margin: 0 auto;'>";
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

if(isset($_GET['page'])){
	if(isset($_GET['order'])){
	$order = $_GET['order'];
	}
$currentpage = $_GET['page'];// step 4:get the current page the user is on via clicking on page number
$offset = ($currentpage - 1) * $maxpage;// step 5:calculate the offset for each page. to be used in query2	
$query2 = "SELECT * from ticket_STAFF WHERE t_STATUS = 'closed' ORDER BY t_PRIORITY ". $order .", t_STATUS  LIMIT  ". $offset.",".$maxpage." ;";// step 6: add the 'LIMIT OFFSET, MAXPAGE' in query

$result2 = mysqli_query($conn, $query2) OR die("<p> could not run query");


while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
	echo"<tr><td><a href=\"edit.php?id=".$row['t_ID']."&ticket=staff&prev=staff.solved\">".$row['t_ID']."</td>"; // add user = staff&... add user= customer&... in href
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
else // if the user doesn't click/specify a page to go to
{
	if(isset($_GET['order'])){
	$order = $_GET['order'];
	}
$currentpage = $_GET['page'];
$start = 0;// offset, starts at index 0 to get first few records
$query2 = "SELECT * from ticket_STAFF WHERE t_STATUS = 'closed' ORDER BY t_PRIORITY ". $order .", t_STATUS LIMIT  ". $start.",".$maxpage." ;";

$result2 = mysqli_query($conn, $query2) OR die("<p> could not run query");



while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
	echo"<tr><td><a href=\"edit.php?id=".$row['t_ID']."&ticket=staff&prev=staff.solved\">".$row['t_ID']."</td>";
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

echo "</tbody></table>";
//pagination
if(isset($_GET['page'])){
$pagenum = $_GET['page'];
}
	
  echo "<ul class='pagination justify-content-center'>";
  if($pagenum == 1 || !isset($_GET['page'])){
	   echo " <li class='page-item disabled'><a class='page-link' href='?cat=".$category."&order=".$order."&page='>Previous</a></li>";
  }else if (isset($_GET['page'])){
  echo " <li class='page-item'><a class='page-link' href='?cat=".$category."&order=".$order."&page=".($pagenum-1)."'>Previous</a></li>";}
for($i = 1; $i <= $totalpages; $i++)
{	
		if($i == $_GET['page'] || $i == $pagenum){
	echo "<li class = 'page-item active'><a class = 'page-link' href = '?cat=".$category."&order=".$order."&page=".$i."'>".$i."</a></li>";// displays page numbers and links to each page
		}else{
			echo "<li class = 'page-item'><a class = 'page-link' href = '?cat=".$category."&order=".$order."&page=".$i."'>".$i."</a></li>";
		}
}
echo "</p>";
if($pagenum == $totalpages || $pagenum == -1){
	echo "<li class='page-item disabled'><a class='page-link' href='?cat=".$category."&order=".$order."&page='>Next</a></li>";
}else{
echo "<li class='page-item'><a class='page-link' href='?cat=".$category."&order=".$order."&page=".($pagenum+1)."'>Next</a></li>";}
echo "</ul></div>";


}else if($_GET['cat'] == 'staff.unsolved')
	{
		
$query = "SELECT * from ticket_STAFF WHERE t_STATUS = 'open' OR t_STATUS = 'in progress' OR t_STATUS = 'CHECK' ORDER BY t_PRIORITY ASC, t_STATUS ";
$result = mysqli_query($conn,$query);
//pagination
$totalrows = mysqli_num_rows($result); // step 1: find total records in db
$maxpage = 5;// step 2: decide yourself, maximum no. of records displayed per page
$totalpages = ceil($totalrows/$maxpage);// step 3:calculates total no. of pages needed
$pagenum = 1;//set default of pagination


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


if(isset($_GET['page'])){
	if(isset($_GET['order'])){
	$order = $_GET['order'];
	}
$currentpage = $_GET['page'];// step 4:get the current page the user is on via clicking on page number
$offset = ($currentpage - 1) * $maxpage;// step 5:calculate the offset for each page. to be used in query2	
$query2 = "SELECT * from ticket_STAFF WHERE t_STATUS = 'open' OR t_STATUS = 'in progress' OR t_STATUS = 'CHECK' ORDER BY t_PRIORITY ". $order .", t_STATUS LIMIT  ". $offset.",".$maxpage." ;";// step 6: add the 'LIMIT OFFSET, MAXPAGE' in query

$result2 = mysqli_query($conn, $query2) OR die("<p> could not run query");


while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
	echo"<tr><td><a href=\"edit.php?id=".$row['t_ID']."&ticket=staff&prev=staff.unsolved\">".$row['t_ID']."</td>"; // add user = staff&... add user= customer&... in href
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
else // if the user doesn't click/specify a page to go to
{
	if(isset($_GET['order'])){
	$order = $_GET['order'];
	}
$currentpage = $_GET['page'];
$start = 0;// offset, starts at index 0 to get first few records
$query2 = "SELECT * from ticket_STAFF WHERE t_STATUS = 'open' OR t_STATUS = 'in progress' OR t_STATUS = 'CHECK' ORDER BY t_PRIORITY ". $order .", t_STATUS LIMIT  ". $start.",".$maxpage." ;";

$result2 = mysqli_query($conn, $query2) OR die("<p> could not run query");


while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
	echo"<tr><td><a href=\"edit.php?id=".$row['t_ID']."&ticket=staff&prev=staff.unsolved\">".$row['t_ID']."</td>";
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
echo "</tbody></table>";
//pagination
if(isset($_GET['page'])){
$pagenum = $_GET['page'];
}
	
  echo "<ul class='pagination justify-content-center'>";
  if($pagenum == 1 || !isset($_GET['page'])){
	   echo " <li class='page-item disabled'><a class='page-link' href='?cat=".$category."&order=".$order."&page='>Previous</a></li>";
  }else if (isset($_GET['page'])){
  echo " <li class='page-item'><a class='page-link' href='?cat=".$category."&order=".$order."&page=".($pagenum-1)."'>Previous</a></li>";}
  
for($i = 1; $i <= $totalpages; $i++)
{	
		if($i == $_GET['page'] || $i == $pagenum){
	echo "<li class = 'page-item active'><a class = 'page-link' href = '?cat=".$category."&order=".$order."&page=".$i."'>".$i."</a></li>";// displays page numbers and links to each page
		}else{
			echo "<li class = 'page-item'><a class = 'page-link' href = '?cat=".$category."&order=".$order."&page=".$i."'>".$i."</a></li>";
		}
}
echo "</p>";
if($pagenum == $totalpages || $pagenum == -1){
	echo "<li class='page-item disabled'><a class='page-link' href='?cat=".$category."&order=".$order."&page='>Next</a></li>";
}else{
echo "<li class='page-item'><a class='page-link' href='?cat=".$category."&order=".$order."&page=".($pagenum+1)."'>Next</a></li>";}
echo "</ul></div>";

  $queryOpen = "SELECT * FROM ticket_STAFF WHERE t_STATUS = 'open'";
  $resultOpen = mysqli_query($conn, $queryOpen);
  $totalOpen = mysqli_num_rows($resultOpen);	
  //echo "<h2><a href=\"list.php?cat=staff.solved\">$total</a><h1>";
  
  $queryProgress = "SELECT * FROM ticket_STAFF WHERE t_STATUS = 'in progress'";
  $resultProgress = mysqli_query($conn, $queryProgress);
  $totalProgress = mysqli_num_rows($resultProgress);

echo "<div class='card-deck' style = 'width: 30rem; height: 15rem; position: relative; margin: auto; top: 100px; right: 0; bottom: 0; left: 0;'>";
  echo "<div class='card border-primary mb-3'>";
  echo "<div class='card-header' style = 'font-size: 1.2em; font-weight:bold;'>Open</div>";
   echo "<div class='card-body'>";
    echo  "<h5 class='card-title' style = 'font-size: 1.2em; font-weight:bold;'>Open tickets</h5>";
	  echo "<p class='card-text'>"; echo "<div style = 'font-size:2em;font-weight:bold;'>".$totalOpen."</div></p>";
     echo "<a href='TicketOpenProgress.php?status=staff.open' class='btn btn-primary'>view tickets</a>";
    echo "</div>";
  echo "</div>";
  echo "<div class='card border-primary mb-3'>";
  echo "<div class='card-header' style = 'font-size: 1.2em; font-weight:bold;'>In Progress</div>";
    echo "<div class='card-body'>";
     echo "<h5 class='card-title' style = 'font-size: 1.2em; font-weight:bold;'>In Progress tickets</h5>";
      echo "<p class='card-text'>"; echo "<div style = 'font-size:2em;font-weight:bold;'>".$totalProgress."</div></p>";
      echo "<a href='TicketOpenProgress.php?status=staff.progress' class='btn btn-primary'>view tickets</a>";
    echo "</div>";
  echo "</div>";

 echo "</div>";
 
	
}else if ($_GET['cat'] == 'customer.unsolved')
	{
	
$query = "SELECT * from ticket_CUSTOMER WHERE t_STATUS = 'open' OR t_STATUS = 'in progress' OR t_STATUS = 'FOLLOW' ORDER BY t_PRIORITY ASC, t_STATUS";
$result = mysqli_query($conn,$query);
//pagination
$totalrows = mysqli_num_rows($result); // step 1: find total records in db
$maxpage = 5;// step 2: decide yourself, maximum no. of records displayed per page
$totalpages = ceil($totalrows/$maxpage);// step 3:calculates total no. of pages needed
$pagenum = 1;//set default of pagination


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

if(isset($_GET['page'])){
	if(isset($_GET['order'])){
	$order = $_GET['order'];
	}
$currentpage = $_GET['page'];// step 4:get the current page the user is on via clicking on page number
$offset = ($currentpage - 1) * $maxpage;// step 5:calculate the offset for each page. to be used in query2	
$query2 = "SELECT * from ticket_CUSTOMER WHERE t_STATUS = 'open' OR t_STATUS = 'in progress' OR t_STATUS = 'FOLLOW' ORDER BY t_PRIORITY ". $order .", t_STATUS LIMIT  ". $offset.",".$maxpage." ;";// step 6: add the 'LIMIT OFFSET, MAXPAGE' in query

$result2 = mysqli_query($conn, $query2) OR die("<p> could not run query");


while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
	echo"<tr><td><a href=\"edit.php?id=".$row['t_ID']."&ticket=customer&prev=customer.unsolved\">".$row['t_ID']."</td>"; // add user = staff&... add user= customer&... in href
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
else // if the user doesn't click/specify a page to go to
{
	if(isset($_GET['order'])){
	$order = $_GET['order'];
	}
$currentpage = $_GET['page'];
$start = 0;// offset, starts at index 0 to get first few records
$query2 = "SELECT * from ticket_CUSTOMER WHERE t_STATUS = 'open' OR t_STATUS = 'in progress' OR t_STATUS = 'FOLLOW' ORDER BY t_PRIORITY ". $order .", t_STATUS LIMIT  ". $start.",".$maxpage." ;";

$result2 = mysqli_query($conn, $query2) OR die("<p> could not run query");


while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
	echo"<tr><td><a href=\"edit.php?id=".$row['t_ID']."&ticket=customer&prev=customer.unsolved\">".$row['t_ID']."</td>";
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
echo "</tbody></table>";
//pagination
if(isset($_GET['page'])){
$pagenum = $_GET['page'];
}
	
  echo "<ul class='pagination justify-content-center'>";
  if($pagenum == 1 || !isset($_GET['page'])){
	   echo " <li class='page-item disabled'><a class='page-link' href='?cat=".$category."&order=".$order."&page='>Previous</a></li>";
  }else if (isset($_GET['page'])){
  echo " <li class='page-item'><a class='page-link' href='?cat=".$category."&order=".$order."&page=".($pagenum-1)."'>Previous</a></li>";}
for($i = 1; $i <= $totalpages; $i++)
{	
		if($i == $_GET['page'] || $i == $pagenum){
	echo "<li class = 'page-item active'><a class = 'page-link' href = '?cat=".$category."&order=".$order."&page=".$i."'>".$i."</a></li>";// displays page numbers and links to each page
		}else{
			echo "<li class = 'page-item'><a class = 'page-link' href = '?cat=".$category."&order=".$order."&page=".$i."'>".$i."</a></li>";
		}
}
echo "</p>";
if($pagenum == $totalpages || $pagenum == -1){
	echo "<li class='page-item disabled'><a class='page-link' href='?cat=".$category."&order=".$order."&page='>Next</a></li>";
}else{
echo "<li class='page-item'><a class='page-link' href='?cat=".$category."&order=".$order."&page=".($pagenum+1)."'>Next</a></li>";}
echo "</ul></div>";

  $queryOpen = "SELECT * FROM ticket_CUSTOMER WHERE t_STATUS = 'open'";
  $resultOpen = mysqli_query($conn, $queryOpen);
  $totalOpen = mysqli_num_rows($resultOpen);	
  //echo "<h2><a href=\"list.php?cat=staff.solved\">$total</a><h1>";
  
  $queryProgress = "SELECT * FROM ticket_CUSTOMER WHERE t_STATUS = 'in progress'";
  $resultProgress = mysqli_query($conn, $queryProgress);
  $totalProgress = mysqli_num_rows($resultProgress);

echo "<div class='card-deck' style = 'width: 30rem; height: 15rem; position: relative; margin: auto; top: 100px; right: 0; bottom: 0; left: 0;'>";
  echo "<div class='card border-primary mb-3'>";
  echo "<div class='card-header' style = 'font-size: 1.2em; font-weight:bold;'>Open</div>";
   echo "<div class='card-body'>";
    echo  "<h5 class='card-title' style = 'font-size: 1.2em; font-weight:bold;'>Open tickets</h5>";
	  echo "<p class='card-text'>"; echo "<div style = 'font-size:2em;font-weight:bold;'>".$totalOpen."</div></p>";
     echo "<a href='TicketOpenProgress.php?status=customer.open' class='btn btn-primary'>view tickets</a>";
    echo "</div>";
  echo "</div>";
  echo "<div class='card border-primary mb-3'>";
  echo "<div class='card-header' style = 'font-size: 1.2em; font-weight:bold;'>In Progress</div>";
    echo "<div class='card-body'>";
     echo "<h5 class='card-title' style = 'font-size: 1.2em; font-weight:bold;'>In Progress tickets</h5>";
      echo "<p class='card-text'>"; echo "<div style = 'font-size:2em;font-weight:bold;'>".$totalProgress."</div></p>";
      echo "<a href='TicketOpenProgress.php?status=customer.progress' class='btn btn-primary'>view tickets</a>";
    echo "</div>";
  echo "</div>";

 echo "</div>";
		
}else if($_GET['cat'] == 'customer.solved')
	{
			
$query = "SELECT * from ticket_CUSTOMER WHERE t_STATUS = 'closed' ORDER BY t_PRIORITY ASC, t_STATUS";
$result = mysqli_query($conn,$query);
//pagination
$totalrows = mysqli_num_rows($result); // step 1: find total records in db
$maxpage = 5;// step 2: decide yourself, maximum no. of records displayed per page
$totalpages = ceil($totalrows/$maxpage);// step 3:calculates total no. of pages needed
$pagenum = 1;//set default of pagination

	
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
	
if(isset($_GET['page'])){
	if(isset($_GET['order'])){
	$order = $_GET['order'];
	}
$currentpage = $_GET['page'];// step 4:get the current page the user is on via clicking on page number
$offset = ($currentpage - 1) * $maxpage;// step 5:calculate the offset for each page. to be used in query2	
$query2 = "SELECT * from ticket_CUSTOMER WHERE t_STATUS = 'closed' ORDER BY t_PRIORITY ". $order .", t_STATUS LIMIT  ". $offset.",".$maxpage." ;";// step 6: add the 'LIMIT OFFSET, MAXPAGE' in query

$result2 = mysqli_query($conn, $query2) OR die("<p> could not run query");


while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
	echo"<tr><td><a href=\"edit.php?id=".$row['t_ID']."&ticket=customer&prev=customer.solved\">".$row['t_ID']."</td>"; // add user = staff&... add user= customer&... in href
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
else // if the user doesn't click/specify a page to go to
{
	if(isset($_GET['order'])){
	$order = $_GET['order'];
	}
$currentpage = $_GET['page'];
$start = 0;// offset, starts at index 0 to get first few records
$query2 = "SELECT * from ticket_CUSTOMER WHERE t_STATUS = 'closed' ORDER BY t_PRIORITY ". $order .", t_STATUS LIMIT  ". $start.",".$maxpage." ;";

$result2 = mysqli_query($conn, $query2) OR die("<p> could not run query");


while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
	echo"<tr><td><a href=\"edit.php?id=".$row['t_ID']."&ticket=customer&prev=customer.solved\">".$row['t_ID']."</td>";
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
echo "</tbody></table>";
//pagination
if(isset($_GET['page'])){
$pagenum = $_GET['page'];
}
	
  echo "<ul class='pagination justify-content-center'>";
  if($pagenum == 1 || !isset($_GET['page'])){
	   echo " <li class='page-item disabled'><a class='page-link' href='?cat=".$category."&order=".$order."&page='>Previous</a></li>";
  }else if (isset($_GET['page'])){
  echo " <li class='page-item'><a class='page-link' href='?cat=".$category."&order=".$order."&page=".($pagenum-1)."'>Previous</a></li>";}
for($i = 1; $i <= $totalpages; $i++)
{	
		if($i == $_GET['page'] || $i == $pagenum){
	echo "<li class = 'page-item active'><a class = 'page-link' href = '?cat=".$category."&order=".$order."&page=".$i."'>".$i."</a></li>";// displays page numbers and links to each page
		}else{
			echo "<li class = 'page-item'><a class = 'page-link' href = '?cat=".$category."&order=".$order."&page=".$i."'>".$i."</a></li>";
		}
}
echo "</p>";
if($pagenum == $totalpages || $pagenum == -1){
	echo "<li class='page-item disabled'><a class='page-link' href='?cat=".$category."&order=".$order."&page='>Next</a></li>";
}else{
echo "<li class='page-item'><a class='page-link' href='?cat=".$category."&order=".$order."&page=".($pagenum+1)."'>Next</a></li>";}
echo "</ul></div>";

	} 
	
	
}
else{

	echo "<p> Direct access not allowed</p>";
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

