<?php 
ob_start();
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
include_once "../requestdelivery.php";
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
					$ngu=new requestdelivery();
					$ngu->setdate($_POST['date']);
					$ngu->setnote($_POST['note']);
					$ngu->setstatus($_POST['status']);
					$ngu->setdeliveryID($_POST['delivery']);
					$msg=$ngu->Update();
					if($msg=="ok") echo("<div class='alert alert-success'>Request has been Updated</div> ");
					else echo("<div class='alert alert-warning'>there is a problem please try again later</div> ");
				}
			}

			if(isset($_GET['id'])){
				$req=new requestdelivery();
				$req->setrequestID($_GET['id']);
				$requ=$req->getByidre();
				$request=mysqli_fetch_assoc($requ);
			}else{
				header("location: requests.php");
			}
			?>
		<div class="module">
			<div class="module-head">
				<h3>Update Request</h3>
			</div>
			<div class="module-body">
				<form class="form-horizontal row-fluid" method="POST" enctype="multipart/form-data">
					<div class="control-group">
						<label class="control-label">Status</label>
						<div class="controls">
							<select  name="status" class="span8">
								<option value="">....</option>
								<option value="pending" <?php if($request['status']=='pending') echo 'selected' ;?> >Pending</option>
								<option value="waiting" <?php if($request['status']=='waiting') echo 'selected' ;?> >Waiting</option>
								<option value="approved" <?php if($request['status']=='approved') echo 'selected' ;?> >Approved</option>
								<option value="completed" <?php if($request['status']=='completed') echo 'selected' ;?> >Completed</option>
								<option value="cancelled" <?php if($request['status']=='cancelled') echo 'selected' ;?> >Cancelled</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Delivery</label>
						<div class="controls">
							<select  name="delivery" class="span8">
								<option value="">....</option>
								<?php while($row=mysqli_fetch_assoc($deli)){
									?>
									<option value="<?php echo $row['deliveryID']; ?>" <?php if($row['deliveryID']== $request['deliveryID']) echo 'selected' ;?> ><?php echo $row['name'];?></option>
								<?php }?>
							</select>
						</div>
					</div>					
					<div class="control-group">
						<label class="control-label">Note</label>
						<div class="controls">
							<textarea class="span8" rows="3" name="note"><?php echo $request['note'];?></textarea>
						</div>
					</div>					
					<div class="control-group">
						<label class="control-label">Data</label>
						<div class="controls">
							<input type="date" class="span8" name="date" <?php if($request['date']){echo "value='".date("Y-m-d",strtotime($request['date']))."'";}?> >
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