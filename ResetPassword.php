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
 
				$password_error = '';
				$reset_confirm = '';
				 
				if(isset($_POST['Reset']) && !empty($_POST['User_ID'])&& !empty($_POST['Password']) 
				   && !empty($_POST['New_Password'])&& !empty($_POST['Confirm_Password']))
				{
					//Check if the password and its confirmation are the same
					if($_POST['New_Password'] != $_POST['Confirm_Password']){
						$password_error = '<img src="images/No.png" width="25px" />';
						$password_error.= '  Error : Password inputs do not match !<br/><br/>';
					}
                    else{
                    $user_id = $_POST['User_ID'];
                    $old_password = $_POST['Password'];
                    $new_password = $_POST['New_Password'];

                    //Send a query to database to check the email and password
                    $found = USER::Login($user_id, $old_password);

                     if($found){
                        echo "found";
                        $updated = USER::Update_Password($user_id,$new_password);

                        if($updated){
                            $reset_confirm  = '   <img src="images/Yes.png" width="25px" />';
                            $reset_confirm .= "   Your password is successfully updated ! <br>";
                            $reset_confirm .= "   Please, login on Sign-In page.<br>";
                            }
							}
						}
					}
				?>
            
            <br/><br/>
            <font color=#CC0000><?php echo $password_error; ?></font> 
            <font color=#006600><?php echo $reset_confirm; ?></font>
            <br/><br/>
		   
            <strong><font color=#CC0000>* required field.</font></strong>
            <br/>
			<form action="#" method="post">
				<div class="form-group">
				<br/>
				<strong>User ID :<font color=#CC0000> * </font></strong>
                <input type="text" name = "User_ID" class="form-control" required>
                
                <br/>
                <strong>Old Password :<font color=#CC0000> * </font></strong>
                <input type="password" name = "Password" class="form-control" required>
              
                <br/>
                <strong>New Password :<font color=#CC0000> * </font></strong>
                <input type="password" name = "New_Password" class="form-control" required>
              
                <br/> 
                <strong>Confirm New Password :<font color=#CC0000> * </font></strong>
                <input type="password" name = "Confirm_Password" class="form-control" required>
              
                <br/> 
                <input class = "btn btn-primary" type="submit" name="Reset" value='Reset Password'> 
                <br/>
                
                </div>
                </form>
					
				</div>	
        
        	
         
    </div>
</div>
		 	
	 
</body>
</html>