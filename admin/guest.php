<?php 
ob_start();
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
include_once "../guests.php";
$id=0;
?>
<div class="span9">
	<div class="content">
		<?php 
			if(isset($_POST['btnAdd'])){
				$ngu=new guests();
				$ngu->setname($_POST['name']);
				$ngu->setnickname($_POST['nickname']);
				$ngu->setgender($_POST['gender']);
				$ngu->setbrithDate($_POST['brithdate']);
				$ngu->setmobile($_POST['mobile']);
				$ngu->setnote($_POST['note']);
				$msg=$ngu->Add();
				if($msg=="ok") echo("<div class='alert alert-success'>Guest has been Added</div> ");
				else echo("<div class='alert alert-warning'>there is a problem please try again later</div> ");
			}
			if(isset($_POST['btnUpdate'])){
				$ngu=new guests();
				$ngu->setname($_POST['name']);
				$ngu->setnickname($_POST['nickname']);
				$ngu->setgender($_POST['gender']);
				$ngu->setbrithDate($_POST['brithdate']);
				$ngu->setmobile($_POST['mobile']);
				$ngu->setnote($_POST['note']);
				$ngu->setguestID($_GET['id']);
				$msg=$ngu->Update();
				if($msg=="ok") echo("<div class='alert alert-success'>Guest has been Updated</div> ");
				else echo("<div class='alert alert-warning'>there is a problem please try again later</div> ");
			}

		if(isset($_GET['id'])){
				$gu=new guests();
				$gu->setguestID($_GET['id']);
				$gue=$gu->getById();
				$currguest=mysqli_fetch_assoc($gue);
				$id=1;
			}
			?>
		<div class="module">
			<div class="module-head">
				<h3><?php if($id==1)echo'Update Guest'; else echo 'Add new guest';?></h3>
			</div>
			<div class="module-body">
				<form class="form-horizontal row-fluid" method="POST" enctype="multipart/form-data">
					<div class="control-group">
						<label class="control-label">Name</label>
						<div class="controls">
							<input type="text" class="span8" name="name" required="" <?php if($id==1)echo"value='".$currguest['name']."'" ?>>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Nickname</label>
						<div class="controls">
							<input type="text" class="span8" name="nickname" required="" <?php if($id==1)echo"value='".$currguest['nickname']."'" ?>>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Gender</label>
						<div class="controls">
							<select  name="gender" class="span8">
								<option value="">....</option>
								<option value="male" <?php if($id==1 && $currguest['gender']=='male') echo 'selected' ;?> >Male</option>
								<option value="female" <?php if($id==1 && $currguest['gender']=='female') echo 'selected' ;?> >Female</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Brithdate</label>
						<div class="controls">
							<input type="date" class="span8" name="brithdate" required="" <?php if($id==1)echo"value='".$currguest['brithDate']."'" ?>>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Mobile</label>
						<div class="controls">
							<input type="text" class="span8" name="mobile" required="" <?php if($id==1)echo"value='".$currguest['mobile']."'" ?>>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Note</label>
						<div class="controls">
							<textarea class="span8" rows="5" name="note"><?php if($id==1) echo $currguest['note'];?></textarea>
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