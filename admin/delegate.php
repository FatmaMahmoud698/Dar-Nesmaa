<?php 
ob_start();
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
include_once "../delivery.php";
$id=0;
?>
<div class="span9">
	<div class="content">
		<?php 
			if(isset($_POST['btnAdd'])){
				$ngu=new delivery();
				$ngu->setname($_POST['name']);
				$ngu->setemail($_POST['email']);
				$ngu->setpass($_POST['password']);
				$ngu->setmobile($_POST['mobile']);
				$ngu->setnote($_POST['note']);
				$ngu->setaddress($_POST['address']);
				$msg=$ngu->Add();
				if($msg=="ok") echo("<div class='alert alert-success'>Delagate has been Added</div> ");
				else echo("<div class='alert alert-warning'>there is a problem please try again later</div> ");
			}
			if(isset($_POST['btnUpdate'])){
				$ngu=new delivery();
				$ngu->setname($_POST['name']);
				$ngu->setemail($_POST['email']);
				$ngu->setpass($_POST['password']);
				$ngu->setmobile($_POST['mobile']);
				$ngu->setnote($_POST['note']);
				$ngu->setaddress($_POST['address']);
				$ngu->setdelid($_GET['id']);
				$msg=$ngu->Update();
				if($msg=="ok") echo("<div class='alert alert-success'>Delagate has been Updated</div> ");
				else echo("<div class='alert alert-warning'>there is a problem please try again later</div> ");
			}

		if(isset($_GET['id'])){
				$gu=new delivery();
				$gu->setdelid($_GET['id']);
				$gue=$gu->getById();
				$currdel=mysqli_fetch_assoc($gue);
				$id=1;
			}
			?>
		<div class="module">
			<div class="module-head">
				<h3><?php if($id==1)echo'Update delegate'; else echo 'Add new delagate';?></h3>
			</div>
			<div class="module-body">
				<form class="form-horizontal row-fluid" method="POST" enctype="multipart/form-data">
					<div class="control-group">
						<label class="control-label">Name</label>
						<div class="controls">
							<input type="text" class="span8" name="name" required="" <?php if($id==1)echo"value='".$currdel['name']."'" ?>>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Email</label>
						<div class="controls">
							<input type="text" class="span8" name="email" required="" <?php if($id==1)echo"value='".$currdel['email']."'" ?>>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Password</label>
						<div class="controls">
							<input type="text" class="span8" name="password" required="" <?php if($id==1)echo"value='".$currdel['password']."'" ?>>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Mobile</label>
						<div class="controls">
							<input type="text" class="span8" name="mobile" required="" <?php if($id==1)echo"value='".$currdel['mobile']."'" ?>>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Address</label>
						<div class="controls">
							<textarea class="span8" rows="3" name="address"><?php if($id==1) echo $currdel['address'];?></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Note</label>
						<div class="controls">
							<textarea class="span8" rows="5" name="note"><?php if($id==1) echo $currdel['note'];?></textarea>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<?php if($id==1)
							echo("<button type='submit' class='btn btn-success' name='btnUpdate'>Update</button>");
							else
								echo("<button type='submit' class='btn btn-success' name='btnAdd'>Add</button>");?>
						</div>
					</div>
				</form>
			</div>
		</div>	
	</div>
</div>

<?php include_once "footer.php"
?>