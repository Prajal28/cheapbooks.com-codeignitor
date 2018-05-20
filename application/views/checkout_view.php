<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>CheapBooks.com</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>/assets/css/sticky-footer-navbar.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

    <nav class="navbar navbar-default navbar-fixed-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="#">Web Data Management : Project 4</a>
	        </div>
	        <div id="navbar" class="collapse navbar-collapse">
	            <form class="navbar-form navbar-right" action ="<?php echo base_url(); ?>Search" method ="POST">
	  				<input class="btn btn-danger" type="submit" name="logout" value="Logout"/>
	  			</form> 		
	        </div>
	      </div>
	    </nav>



    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1>Ready for Checkout</h1>
      </div>
      <!-- Every other code comes here -->
      <?php
		if(!isset($_SESSION['user_session'])){
		header("Location: customer");
		exit();
		}

		try{
		if(!isset($_POST['Buy'])){		
		if(count($_SESSION['basket'])>0){
			echo "<table class='table table-bordered'>	
			<tr><th>ISBN</th><th>Book Title</th><th>Price</th><th>No. of Books</th></tr>";
			$sum = 0;
			foreach($_SESSION['basket'] as $key=>$value){
				$row = $_SESSION['searchResults'][$key];
				echo "<tr><td>".$row['ISBN']."</td><td>".$row['book_name']."</td><td>".$row['price']."</td><td>".$value."</td>";
				$rowPrice = $row['price']*$value;
				$sum+=$rowPrice;
				echo "</td></tr>";	
			}
			echo "</table><h4>Total Amount: $".$sum."</h4>";
		}else{
			echo "<br/>";
			echo "<h4>Oops !! Basket is Empty. Press on Buy and Search for a new book.</h4><br>";
		}		
		}else{
			$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$basketId = uniqid();
			$username = $_SESSION['user_session'];
			$statement= $dbh->prepare("insert into shoppingbasket(basketId, username) values ('{$basketId}','{$username}')");
			$statement->execute();
			foreach($_SESSION['basket'] as $key=>$value){
				$quantity = $_SESSION['basket'][$key];
				$row = $_SESSION['searchResults'][$key];
				$warehousecode = $row['warehousecode'];
				$statement= $dbh->prepare("insert into contains(ISBN,basketId,number) values('{$key}','{$basketId}','{$value}')");
				$statement->execute();
				$statement= $dbh->prepare("insert into shippingorder(ISBN, warehousecode, username, number)values ('{$key}','{$warehousecode}','{$username}','{$value}')");
				$statement->execute();
				$newCount = $row['number'] - $quantity;
				$statement= $dbh->prepare("update stocks set number ='{$newCount}' where ISBN = '{$key}'");
				$statement->execute();
			}
			$_SESSION['basket']=array();
			echo "<h4>Book Purchased Successfully.</h4><br><button class='btn btn-primary' type='button' onclick='location.href=&quot;".base_url()."Search&quot;;'>Look For Another Book</button>";
			exit();
		}
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}

		?>

      <form action="<?php echo base_url(); ?>checkout" method="post">
        <div class="form-group">
        	<input class="btn btn-success" type ="submit" name="Buy" value ="Buy" />
        </div>
      </form>      
		<!-- Every other code stops here -->
      
    </div>

    <footer class="footer">
      <div class="container">
        <h4 class="text-muted" style="text-align: center;">Name - Prajal Mishra ; ID - 1001434611 ; This is my forth project for CSE 5335 - Web Data Mangement.</h4>
      </div>
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
