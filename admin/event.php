<?php 
ob_start();
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
include_once "../eventCat.php";
include_once "../event.php";
$evCa = new eventCat();
$evCate = $evCa->GetAll();
$id=0;
?>
<div class="span9">
	<div class="content">
		<?php 
			if(isset($_POST['btnAdd'])){
				$gne=new event();
				$gne->setname($_POST['name']);
				$gne->setdesc($_POST['desc']);
				$gne->setdate($_POST['date']);
				$gne->setfrom($_POST['from']);
				$gne->setto($_POST['to']);
				$gne->setmaxNumber($_POST['maxNumber']);
				$gne->seteventCat($_POST['type']);
				if(strlen($_FILES["filetoupload"]["tmp_name"]) > 0){
					$rand = rand(1111,9999);
					$target_dir="../images/event/";
					$target_file = $target_dir .$rand. basename($_FILES["filetoupload"]["name"]);
					$currentimage = $rand . basename($_FILES["filetoupload"]["name"]);
					$uploadOk = 1;
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					$check = getimagesize($_FILES["filetoupload"]["tmp_name"]);
					if($check !== false) {
						$uploadOk = 1;
					}else{
						echo "File is not an image.";
					    $uploadOk = 0;	
					}
					if (file_exists($target_file)) {
		                $uploadOk = 0;				                    
		            }
		            if ($_FILES["filetoupload"]["size"] > 500000) {
		                echo "Sorry, your file is too large.";
		                $uploadOk = 0;
		            }
		            if ($uploadOk == 0) {
		                echo "Sorry, your file was not uploaded.";
		            // if everything is ok, try to upload file
		            }else {
		            	if (move_uploaded_file($_FILES["filetoupload"]["tmp_name"], $target_file)) {
				            $gne->setimg($currentimage);
				            $msg=$gne->Add();
				            if($msg=="ok"){
								echo("<div class='alert alert-success'>Your event has been Added</div> ");	
							}else{
								if(is_file($target_file)){
					                unlink($target_file);
		                		}
								// echo("<div class='alert alert-warning'>there is a problem please try again later</div> ");
								echo $msg;
							}
			            }else{
			                echo "Sorry, there was an error uploading your file.";
			                $uploadOk == 0 ;
			            }
		            }					
				}else{
					echo("<div class='alert alert-danger'>There is no image.</div> ");
				}

			}
			if(isset($_POST['btnUpdate'])){
				$gns = new event();
				$gns->seteventId($_GET['id']);
				$gnes = $gns->getById();
				$gnees = mysqli_fetch_assoc($gnes);
				$image = $gnees['img'];
				if(strlen($_FILES["filetoupload"]["tmp_name"]) > 0){
		            $rand = rand(1111,9999);
		            $target_dir="../images/event/";
		            $target_file = $target_dir .$rand. basename($_FILES["filetoupload"]["name"]);
		            $currentimage = $rand . basename($_FILES["filetoupload"]["name"]);
		            $uploadOk = 1;
		            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));               
		            $check = getimagesize($_FILES["filetoupload"]["tmp_name"]);
		            if($check !== false) {
		               // echo "File is an image - " . $check["mime"] . ".";
		                $uploadOk = 1;
		            } else {
		                echo "File is not an image.";
		                $uploadOk = 0;
		            }
		            if (file_exists($target_file)) {
		                $uploadOk = 0;				                    
		            }
		            if ($_FILES["filetoupload"]["size"] > 500000) {
		                // echo "Sorry, your file is too large.";
		                $uploadOk = 0;
		            }
		            if ($uploadOk == 0) {
		                // echo "Sorry, your file was not uploaded.";
		            // if everything is ok, try to upload file
		            } else {
		            	if (move_uploaded_file($_FILES["filetoupload"]["tmp_name"], $target_file)) {
		            		$file='../images/event/'.$image;
		            		if(file_exists($file)){
				                unlink($file);
		            		}
				            $uploadOk == 1;
				            } else {
				                // echo "Sorry, there was an error uploading your file.";
				                $uploadOk == 0 ;
				            }
		            	$image=$currentimage;
		            }
		        }
		        $event = new event();
		        $event->setname($_POST['name']);
				$event->setdesc($_POST['desc']);
				$event->setdate($_POST['date']);
				$event->setfrom($_POST['from']);
				$event->setto($_POST['to']);
				$event->setmaxNumber($_POST['maxNumber']);
				$event->seteventCat($_POST['type']);
				$event->setimg($image);
				$event->seteventId($_GET['id']);
				$msg=$event->Update();
				if($msg=="ok"){
					echo("<div class='alert alert-success'>Your Event successfuly updated. </div> ");
				}else{
					echo $msg;
					// echo("<div class='alert alert-warning'>There is a problem please try again later.</div> ");
				}

			}

			if(isset($_GET['id'])){
				$eve=new event();
				$eve->seteventId($_GET['id']);
				$even=$eve->getByIdC();
				$event=mysqli_fetch_assoc($even);
				$id=1;
			}
			?>
		<div class="module">
			<div class="module-head">
				<h3><?php if($id==1)echo 'Update Event'; else echo 'Add New Event'; ?></h3>
			</div>
			<div class="module-body">
				<form class="form-horizontal row-fluid" method="POST" enctype="multipart/form-data">					
					<div class="control-group">
						<label class="control-label">Name</label>
						<div class="controls">
							<input type="text" class="span8" name="name" required="" <?php if($id==1)echo"value='".$event['eventName']."'" ?>>
						</div>
					</div>										
					<div class="control-group">
						<label class="control-label">Description</label>
						<div class="controls">
							<textarea class="span8" rows="3" name="desc" required=""><?php if($id==1)echo $event['eventDesc']; ?></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Date</label>
						<div class="controls">
							<input type="date" class="span8" name="date" required="" <?php if($id==1)echo"value='".$event['date']."'" ?>>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">From</label>
						<div class="controls">
							<input type="time" class="span8" name="from" required="" <?php if($id==1)echo"value='".$event['from']."'" ?>>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">To</label>
						<div class="controls">
							<input type="time" class="span8" name="to" required="" <?php if($id==1)echo"value='".$event['to']."'" ?>>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="basicinput">Max Number</label>
						<div class="controls">
							<div class="input-prepend">
								<span class="add-on">#</span><input class="span8" type="number" name="maxNumber" required="" <?php if($id==1) echo "value='".$event['maxNumber']."'";?>>       
							</div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Image</label>
						<div class="controls">
							<input type="file" name="filetoupload" class="span8" >
							<?php if($id==1){
							if(is_file('../images/event/'.$event['eventImg'])){?>
							<img src="../images/event/<?php echo $event['eventImg'];?>">
							<?php }} ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Type</label>
						<div class="controls">
							<select  name="type" class="span8" required="">
								<option value="">....</option>
								<?php while($type=mysqli_fetch_assoc($evCate)){?>
								<option value="<?php echo $type['catId'] ?>" <?php if( $id==1){if($event['catId']== $type['catId']) echo 'selected' ;}?> ><?php echo $type['name'] ;?></option>	
							<?php } ?>
							</select>
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

<?php include_once "footer.php";
?>