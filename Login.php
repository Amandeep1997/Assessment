<?php 
include "includes/header.php"; 
include "classes/ClassUser.php";
?>
<html>
<body>
	<div id="page" align="center">
    
    <?php include "includes/menu.php"?>
    <div id="content" style="width:800px" align="left">
				 
		<div class="col-sm-6"  style="font-size:14px;">
						   
            
            
            <?php
 
				$login_error = '';
				$login_confirm = '';
				 
				if(isset($_POST['Unregister']) && !empty($_POST['User_ID']) && !empty($_POST['Password']))
				{
							$user_id = $_POST['User_ID'];
							$password = $_POST['Password'];
							//Send a query to database to check the user_id and password
										
							
							$result = USER::Login($user_id, $password);
							 if(!$result){
								
								$login_error = '<img src="images/No.png" width="25px" />';
								$login_error .= '<strong>   Error : User ID and Password combination is incorrect !</strong><br/><br/><br/><br/>';
							}else{
								
								$login_confirm = '<img src="images/Yes.png" width="25px" />';
								$login_confirm .= "<strong>   Your Login is Successfull ! </strong><br/><br/><br/><br/>";
							}
						
					}
				?>
            
            <br/><br/>
            <font color=#CC0000><?php echo $login_error; ?></font> 
            <font color=#006600><?php echo $login_confirm; ?></font> 
            <br/><br/>
            <strong><font color=#CC0000>* required field.</font></strong>
            <br/>
			<form action="#" method="post">
				<div class="form-group">
				<br/>
				<strong>User ID :<font color=#CC0000> * </font></strong>
                <input type="text" name = "User_ID" class="form-control" required>
                
                <br/>
               
                <strong>Password :<font color=#CC0000> * </font></strong>
                <input type="password" name = "Password" class="form-control" required>
              
                <br/> 
                
                <input class = "btn btn-primary" type="submit" name="Unregister" value='Sign In'> 
                <a href="Register.php">New User ?</a><br/><br/>
				<a href="ResetPassword.php">Forgot your password ?</a>
                <br/>
                
                </div>
                </form>
					
				</div>	
        
        	
         
    </div>
</div>
		 	
	 
</body>
</html>