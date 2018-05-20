


    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1>Welcome to CheapBooks.com</h1>
      </div>
      <!-- Every other code comes here -->
      <div class="jumbotron">
      
      <form action="<?php echo base_url(); ?>customer/login_validation" method="post">
        <div class="form-group">
            <label>UserName :</label>
            <input id="name" name="username" type="text">
        </div>
        <div class="form-group">
            <label>Password :</label>
            <input id="password" name="password" type="password">
        </div>
        
        <button class="btn btn-primary" type="submit" name="login">Login</button>
        
        <div class="form-group">
            <br>
            <label> Not an existing User ? Register here </label>
            <button type="button" class="btn btn-info" name="register" onclick ="location.href='<?php echo base_url(); ?>register';" /> Register</button>
        </div>         
      </form>      




      <!-- Every other code stops here -->
      </div>
    </div>

 