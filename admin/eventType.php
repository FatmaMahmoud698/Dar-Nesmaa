<?php 
ob_start();
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
include_once "../eventCat.php";
$id=0;
?>
<div class="span9">
	<div class="content">
		<?php 
			if(isset($_POST['btnAdd'])){
				$gne=new eventCat();
				$gne->setname($_POST['name']);
				$gne->setdesc($_POST['desc']);
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
								echo("<div class='alert alert-success'>Your Type has been Added</div> ");	
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
				$gns = new eventCat();
				$gns->setcatId($_GET['id']);
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
		        $event = new eventCat();
		        $event->setname($_POST['name']);
				$event->setdesc($_POST['desc']);;
				$event->setimg($image);
				$event->setcatId($_GET['id']);
				$msg=$event->Update();
				if($msg=="ok"){
					echo("<div class='alert alert-success'>Your Event successfuly updated. </div> ");
				}else{
					echo $msg;
					// echo("<div class='alert alert-warning'>There is a problem please try again later.</div> ");
				}

			}

			if(isset($_GET['id'])){
				$eve=new eventCat();
				$eve->setcatId($_GET['id']);
				$even=$eve->getById();
				$event=mysqli_fetch_assoc($even);
				$id=1;
			}
			?>
		<div class="module">
			<div class="module-head">
				<h3><?php if($id==1)echo 'Update Type'; else echo 'Add New Type'; ?></h3>
			</div>
			<div class="module-body">
				<form class="form-horizontal row-fluid" method="POST" enctype="multipart/form-data">					
					<div class="control-group">
						<label class="control-label">Name</label>
						<div class="controls">
							<input type="text" class="span8" name="name" required="" <?php if($id==1)echo"value='".$event['name']."'" ?>>
						</div>
					</div>										
					<div class="control-group">
						<label class="control-label">Description</label>
						<div class="controls">
							<textarea class="span8" rows="3" name="desc" required=""><?php if($id==1)echo $event['desc']; ?></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Image</label>
						<div class="controls">
							<input type="file" name="filetoupload" class="span8" >
							<?php if($id==1){
							if(is_file('../images/event/'.$event['img'])){?>
							<img src="../images/event/<?php echo $event['img'];?>">
							<?php }} ?>
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