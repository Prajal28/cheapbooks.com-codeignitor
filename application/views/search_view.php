
<div class="container">
	     	<div class="page-header">
	        	<h1>Search Your Book Here</h1>
	      	</div>
	    
	        <div class="jumbotron">
				<form action ="<?php echo base_url(); ?>Search" method ="POST">
					
					<div class="form-group">
	         			<label>Search :</label>
	            		<input name="searchText" type="text">
	        		</div><br>

					<input type="submit" style="margin-right: 5px;" class="btn btn-primary" value="Search By Author" name="Search">

					<input type="submit" class="btn btn-primary" value="Search By Title" name="Search">
				</form>
			</div>

		<?php

		try{
			if(isset($_POST['Search'])){
			$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$sql="";
		    if($_POST['Search'] == 'Search By Author'){
			$searchauthor = $_POST['searchText'];
			$sql = "SELECT book.title as book_name, writtenby.ISBN , stocks.number, book.price, stocks.warehousecode from writtenby INNER JOIN author on author.ssn = writtenby.ssn INNER JOIN book on book.ISBN = writtenby.ISBN INNER join stocks on stocks.ISBN = book.ISBN WHERE author.name like '%{$searchauthor}%'";
			}
			else if($_POST['Search'] == 'Search By Title'){
			$searchbytitle = $_POST['searchText'];
			$sql = "SELECT book.title as book_name, writtenby.ISBN , stocks.number, book.price, stocks.warehousecode from writtenby INNER JOIN author on author.ssn = writtenby.ssn INNER JOIN book on book.ISBN = writtenby.ISBN INNER join stocks on stocks.ISBN = book.ISBN WHERE book.title like '%{$searchbytitle}%'";
			}
			
		    $dbh->beginTransaction();
			$statement = $dbh->prepare($sql);
			$statement->execute();
			$dbh->commit();
			$searchResults = array();
				if($statement->rowcount()){
				echo "<table class='table table-bordered' >";	
				echo "<tr><th>ISBN</th><th>Book Title</th><th>Price</th><th>No. of Available Books </th><th></th></tr>";
				while($row=$statement ->fetch()){
					if($row['number']>0){
						$searchResults[$row['ISBN']] = $row;
						echo "<tr><td>".$row['ISBN']."</td><td>".$row['book_name']."</td><td>".$row['price']."</td><td>".$row['number']."</td><td>
						<button class='btn btn-success' type='button' onClick='addToCart(&quot;{$row['ISBN']}&quot;,&quot;{$row['book_name']}&quot;)'>Add to cart</button>;</td></tr>";				
					}
				}
				echo "</table><br/>";				
			}
			$_SESSION['searchResults'] = $searchResults;
		}
		}
		catch(PDOException $e){
			echo $e->getMessage();
						}

		?>	

	  <button type="button" class="btn btn-info" name="shoppingbasket" onclick="location.href='<?php echo base_url(); ?>checkout';" /> Shopping Basket</button><br>	  	  
	  <h4><div id="count">Counter - 0</div></h4><br>	  	  
	  </div>
