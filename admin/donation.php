<?php 
ob_start();
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
include_once "../donation.php";
include_once "../delivery.php";
$del = new delivery();
$deli = $del->GetAll();
?>
<div class="span9">
	<div class="content">
		<?php 
			if(isset($_POST['btnUpdate'])){
				if($_POST['status']=='pending'|| $_POST['delivery']<1){
					echo("<div class='alert alert-warning'>Please confirm status and choose delivery man to complete this request.</div> ");
				}else{
					$ngu=new donations();
					$ngu->setnote($_POST['note']);
					$ngu->setstatus($_POST['status']);
					$ngu->setdeliveryID($_POST['delivery']);
					$msg=$ngu->Update();
					if($msg=="ok") echo("<div class='alert alert-success'>Guest has been Updated</div> ");
					else echo("<div class='alert alert-warning'>there is a problem please try again later</div> ");
				}
			}

			if(isset($_GET['id'])){
				$don=new donations();
				$don->setdonationID($_GET['id']);
				$donations=$don->getFId();
				$currdona=mysqli_fetch_assoc($donations);
			}else{
				header("location: donations.php");
			}
			?>
		<div class="module">
			<div class="module-head">
				<h3>Update Donation</h3>
			</div>
			<div class="module-body">
				<form class="form-horizontal row-fluid" method="POST" enctype="multipart/form-data">
					<div class="control-group">
						<label class="control-label">Description</label>
						<div class="controls">
							<textarea class="span8" rows="5" name="desc" disabled><?php echo $currdona['desc'];?></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Count</label>
						<div class="controls">
							<div class="input-prepend">
								<span class="add-on">#</span><input class="span8" type="number" name="count" <?php if($currdona['count']>0) echo "value='".$currdona['count']."'";?> disabled>       
							</div>
						</div>
					</div>					
					<div class="control-group">
						<label class="control-label">Note</label>
						<div class="controls">
							<textarea class="span8" rows="5" name="note"><?php echo $currdona['note'];?></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Status</label>
						<div class="controls">
							<select  name="status" class="span8">
								<option value="">....</option>
								<option value="pending" <?php if($currdona['status']=='pending') echo 'selected' ;?> >Pending</option>
								<option value="waiting" <?php if($currdona['status']=='waiting') echo 'selected' ;?> >Waiting</option>
								<option value="approved" <?php if($currdona['status']=='approved') echo 'selected' ;?> >Approved</option>
								<option value="arrived" <?php if($currdona['status']=='arrived') echo 'selected' ;?> >Arrived</option>
								<option value="completed" <?php if($currdona['status']=='completed') echo 'selected' ;?> >Completed</option>
								<option value="cancelled" <?php if($currdona['status']=='cancelled') echo 'selected' ;?> >Cancelled</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Data</label>
						<div class="controls">
							<input type="date" class="span8" name="date" disabled value="<?php echo date("Y-m-d",strtotime($currdona['date']));?>" >
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Delivery</label>
						<div class="controls">
							<select  name="delivery" class="span8">
								<option value="">....</option>
								<?php while($row=mysqli_fetch_assoc($deli)){
									?>
									<option value="<?php echo $row['deliveryID']; ?>" <?php if($row['deliveryID']== $currdona['deliveryID']) echo 'selected' ;?> ><?php echo $row['name'];?></option>
								<?php }?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type='submit' class='btn btn-success' name='btnUpdate'>Send</button>
						</div>
					</div>
				</form>
			</div>
		</div>	
	</div>
</div>

<?php include_once "footer.php";
?>