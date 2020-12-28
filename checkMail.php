<?php 
session_start();	
include_once "headerBefore.php";
// ob_start();  
	
?>

<div class="login">
	
		<div class="main-agileits">
				<div class="form-w3agile">
					<h3>Forget Password</h3>
					<form action="checkbefore.php" method="post">
						<div class="key">
							<i class="fa fa-envelope" aria-hidden="true"></i>
							<input  type="text" name="txtmail" required="" placeholder="Email" style="color: #000;">
							<div class="clearfix"></div>
						</div>
						<input type="submit" value="Send Email" name="btncheck">
						<?php
						// if(isset($_POST['btncheck'])){
						// 	include_once "client.php";
						// 	$cl=new client();
						// 	$cl->setemail($_POST['txtmail']);
						// 	$rs= $cl->getByEmail();
						// 	if($row=mysqli_fetch_assoc($rs)){
                             
      //                           $no=rand(1111,9999);
      //                           $link="http://localhost/NTI2021Shopping/UpdatePassword.php?id=".$row["ClientID"];
      //                           //Send Email
                                
      //                       	require_once "src/PHPMailer.php";
      //                       	require_once "src/Exception.php";
      //                       	require_once "src/SMTP.php";
      //                       	require_once "vendor/autoload.php";
                                
      //                           $mail = new  PHPMailer\PHPMailer\PHPMailer();
        
      //                           $mail->IsSMTP();
      //                           //$mail->SMTPDebug = 1;
      //                           $mail->SMTPAuth = true;
      //                           $mail->SMTPSecure = 'ssl';
      //                           $mail->Host = "smtp.gmail.com";
      //                           $mail->Port = 465; // or 587
      //                           $mail->IsHTML(true);
    								
      //                           $mail->Username = "darnesmaa@gmail.com";
      //                           $mail->Password = "Fatma123@123";
    
      //                           $mail->setFrom('darnesmaa@gmail.com', 'Nti 2020 Shopping');
                              
                                

      //                           $mail->addAddress($_POST["txtmail"], "NTI 2020 Shopping");
      //                           $mail->Subject = 'Forget Password';
                         
      //                           $mail->Body ="Dear : ".($row["name"])."\n Your Verfication Code is ".$no."\n Please Clike here To Update Password ".$link;
                                
      //                           if(!$mail->send()) {
      //                             //  echo "Opps! For some technical reasons we couldn't able to sent you an email. We will shortly get back to you with download details.";	
      //                               echo "Mailer Error: " . $mail->ErrorInfo;
      //                           }
      //                           else{
      //                               $_SESSION["code"]=$no;
      //                               echo("<div class='alert alert-success'> Check Your Email </div>");		 
      //                           } 
						// 	}else{
						// 		echo("<br/><div class='alert alert-danger'>Invalid Email, Try Again</div> ");
						// 	}
						// }
						
						?>
					</form>
				</div>
				<div class="forg">
					<a href="login.php" class="forg-left">Login Again</a>
				<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<!-- newsletter -->
	</div>
<?php include_once "footer.php";?>