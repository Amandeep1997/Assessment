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
		$password_conf_error = "";
		$email_error ="";
		$register_confirm="";
		
	if(isset($_POST['Register']) && !empty($_POST['Email'])
	&& !empty($_POST['Password'])&&!empty($_POST['Confirm_Password']))
    {
        $email = $_POST['Email'];
        $password = $_POST['Password'];
        $confirm_password = $_POST['Confirm_Password'];
		
        //Check if the password and its confirmation are the same
        if($password != $confirm_password){
            $password_conf_error = '<img src="images/No.png" width="25px" />';
            $password_conf_error.= '  Error : Password inputs do not match !<br/><br/>';
        }
        //Send a query to database to check if the email exists 
		if(USER::Email_Exists($email)){
			
            $email_error = '<img src="images/No.png" width="25px" />';
            $email_error .= '  Error : Email Address already exist !<br/><br/>';
        }
		
		//Send a query to database to create new user
		if(! USER::Email_Exists($email) && ($password ==  $confirm_password)){
			$first_name = $_POST['First_Name'];
			$last_name  = $_POST['Last_Name'];
			$job_title  = $_POST['Job_Title']; 
			$email = $_POST['Email'];
            $address_1 = $_POST['Address_1'];
			$address_2 = $_POST['Address_2'];
			$city = $_POST['City'];
			$postal_code = $_POST['Postal_Code'];
            $province = $_POST['Province'];
			$country = $_POST['Country'];
			$phone = $_POST['Phone'];
			$password = USER::Encrypt( $_POST['Password'] );
			$date_of_birth = $_POST['Date_Of_Birth'];
			//Send a query to database to insert the data of the new user 
			
			$salt = USER::CreateSalt($password);
			
            $newUser = new USER($first_name , $last_name, $job_title, $email, 
                         $address_1, $address_2,$city, $postal_code, 
                         $province, $country, $phone, $password, $salt, 
                         $date_of_birth);
			
			$new_user_id = $newUser->Create();
			
			$register_confirm  = '   <img src="images/Yes.png" width="25px" />';
            $register_confirm .= "   Your account is successfully created ! <br>";
			$register_confirm .= "   Please, login on Sign-In page.<br>";
			$register_confirm .= "   Your User ID is $new_user_id<br><br><br><br>";
			
        }
		
    }	
			
			?>
			<br/><br/>
			<font color=#CC0000><?php echo $password_conf_error; ?></font> 			
			<font color=#CC0000><?php echo $email_error; ?></font> 
            <font color=#006600><?php echo $register_confirm; ?></font> 
            <br/><br/>			
            <strong><font color=#CC0000>* required field.</font></strong>
            <br/>
			<form action="#" method="post">
				<div class="form-group">
				
				<strong>First Name :<font color=#CC0000> * </font></strong>
                <input type="text" name = "First_Name" class="form-control" required>
                <br/>
                
				<strong>Last Name :<font color=#CC0000> * </font></strong>
                <input type="text" name = "Last_Name" class="form-control" required>
                <br/>
               
                 <strong>Email :<font color=#CC0000> * </font></strong>
                <input type="email" name = "Email" class="form-control" required>
                <br/>
                
                 <strong>Password:<font color=#CC0000> * </font></strong>
                <input type="password" name = "Password" class="form-control" required>
                <br/>
                
                <strong>Confirm Password :<font color=#CC0000> * </font></strong>
                <input type="password" name = "Confirm_Password" class="form-control" required>
                <br/>
                
                <strong>Job Title :<font color=#CC0000> * </font></strong>
                <input type="text" name = "Job_Title" class="form-control" required>
                <br/>
                
                <strong>Address_1 :<font color=#CC0000> * </font></strong>
                <input type="text" name = "Address_1" class="form-control" required>
                <br/> 
                
                <strong>Address_2 :<font color=#CC0000> (optional) </font></strong>
                <input type="text" name = "Address_2" class="form-control">
                <br/>
                
                <strong>City :<font color=#CC0000> * </font></strong>
                <input type="text" name = "City" class="form-control" required>
                <br/>
                
                <strong>Postal Code :<font color=#CC0000> * </font></strong>
                <input type="text" name = "Postal_Code" class="form-control" required>
                <br/>
                
                <strong>province :<font color=#CC0000> * </font></strong>
                <input type="text" name = "Province" class="form-control" required>
                <br/>
                
                <strong>Country :<font color=#CC0000> * </font></strong>
                <input type="text" name = "Country" class="form-control" required>
                <br/>
                
                <strong>Phone :<font color=#CC0000> * </font></strong>
                <input type="number" name = "Phone" class="form-control" required>
                <br/>
                
                <strong>Date Of Birth :<font color=#CC0000> * </font></strong>
                <input type="date" name = "Date_Of_Birth" class="form-control" required>
                <br/>
                
                <input class = "btn btn-primary" type="submit" name="Register" value='Register'> 
                <br/>
                
                </div>
                </form>
					
				</div>	
        
        	
         
    </div>
</div>
		 	
	 
</body>
</html>