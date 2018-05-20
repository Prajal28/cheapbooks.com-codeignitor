<!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1>New User Registration</h1>
      </div>
      <!-- Every other code comes here -->
<?php
      if(isset($_POST['register']))
      {
        try {
        $dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $user_name = trim($_POST['user_name']);
        $new_pass = trim($_POST['new_pass']);
        $address = trim($_POST['address']);
        $email = trim($_POST['email']);
        $contact_number = trim($_POST['contact_number']);
        
      if($user_name==""){
        $error[] = "Please provide a UserName";
        echo "<h4 style='color: red;'>Please provide a UserName</h4>";
        }
        else if($new_pass==""){
         $error[] = "Please provide a password";
         echo "<h4 style='color: red;'>Please provide a password</h4>";
         }
        else if($email==""){
          $error[]= "Please provide an E-Mail ID";
          echo "<h4 style='color: red;'>Please provde an E-Mail ID</h4>";
        }
         else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error[]= "Please provide a valid E-Mail address";
    echo "<h4 style='color: red;'>Please provide a valid E-Mail address</h4>";  
}
        else
         {
      $stmt = $dbh->prepare("insert into customers (username,password,address,phone,email) values(:user_name,:new_pass,:address,:contact_number,:email)");
      $hashpassword= md5($new_pass);
      $stmt->bindparam(":user_name", $user_name);
      $stmt->bindparam(":new_pass", $hashpassword);
      $stmt->bindparam(":address", $address);
      $stmt->bindparam(":contact_number", $contact_number);
      $stmt->bindparam(":email", $email);
      $stmt->execute();
      header("Location: customer");      
      exit();   
        }
        }
      catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
      }
?>
      <div class="jumbotron">

      <form action="<?php echo base_url(); ?>register" method="post">
        <div class="form-group">
            <label>UserName :</label>
            <input id="user_name" name="user_name" type="text">
        </div>
        <div class="form-group">
            <label>Password :</label>
            <input id="new_pass" name="new_pass" type="password">
        </div>
        <div class="form-group">
            <label>Address :</label>
            <input id="address" name="address" type="text">
        </div>
        <div class="form-group">
            <label>Email: </label>
            <input id="email" name="email" type="email">
        </div>
        <div class="form-group">
            <label>Contact Number:</label>
            <input id="contact_number" name="contact_number" type="text">
        </div>
        <button class="btn btn-primary" type="submit" name="register">Register</button>
        
                 
      </form>      




      <!-- Every other code stops here -->
      </div>
    </div>
