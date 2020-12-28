<?php 
ob_start();
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
if(isset($_POST['need_id'])){
	include '../needCat.php';
	$cne=new needscategory();
	$cne->setneedId($_POST['need_id']);
	$cnee=$cne->getByNeedId();
	while($cneed=mysqli_fetch_assoc($cnee)){
		echo("<option value='".$cneed['needIdCat']."' required>".$cneed['name']."</option>");
	}

	exit();
}
include_once "header.php";
include_once "../needs.php";
include_once "../guests.php";
include '../guestNeed.php';
include '../needCat.php';
$id=0;
?>
<div class="span9">
	<div class="content">
<?php if(isset($_POST['btnAdd'])){
		$gne=new guestNeeds();
		$gne->setname($_POST['stuff']);
		$gne->setneedCat($_POST['catneeds']);
		$gne->setcount($_POST['count']);
		$gne->setdesc($_POST['desc']);
		$gne->setguestID($_POST['guest']);
		$gne->setpriority($_POST['priority']);
		if(strlen($_FILES["filetoupload"]["tmp_name"]) > 0){
			$rand = rand(1111,9999);
			$target_dir="../images/needs/";
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
						echo("<div class='alert alert-success'>Your need has been Added</div> ");	
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
		}

	}
	if(isset($_POST['btnUpdate'])){
		$gns = new guestNeeds();
		$gns->setgneedId($_GET['id']);
		$gnes = $gns->getById();
		$gnees = mysqli_fetch_assoc($gnes);
		$image = $gnees['img'];
		if(strlen($_FILES["filetoupload"]["tmp_name"]) > 0){
            $rand = rand(1111,9999);
            $target_dir="../images/needs/";
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
            		$file='../images/needs/'.$image;
            		if(is_file($file)){
		                unlink('../images/needs/'.$image);
		                // echo "old image deleted.";
            		}
		            $uploadOk == 1;
		            } else {
		                // echo "Sorry, there was an error uploading your file.";
		                $uploadOk == 0 ;
		            }
            	$image=$currentimage;
            }
        }
        $ugne = new guestNeeds();
        $ugne->setname($_POST['stuff']);
		$ugne->setneedCat($_POST['catneeds']);
		$ugne->setcount($_POST['count']);
		$ugne->setdesc($_POST['desc']);
		$ugne->setguestID($_POST['guest']);
		$ugne->setpriority($_POST['priority']);
		$ugne->setimg($image);
		$msg=$ugne->Update();
		if($msg=="ok"){
			echo("<div class='alert alert-success'>Your Need successfuly updated. </div> ");
		}else{
			// echo $msg;
			echo("<div class='alert alert-warning'>There is a problem please try again later.</div> ");
		}

	}
if(isset($_GET['id'])){
	$xne=new guestNeeds();
	$xne->setgneedId($_GET['id']);
	$xnee=$xne->getById();
	$currNeed=mysqli_fetch_assoc($xnee);
	$id=1;
	$xcat=new needscategory();
	$xcat->setneedIdCat($currNeed['needCat']);
	$xcate=$xcat->getById();
	$currCat=mysqli_fetch_assoc($xcate);
	$currCatId=$currCat['needId'];

}
$ne=new needs();
$nee=$ne->GetAll();
$gu=new guests();
$gue=$gu->GetAll();

	?>
		<div class="module">
			<div class="module-head">
				<h3><?php if($id==1)echo'Update Need'; else echo 'Add new Need';?></h3>
			</div>
			<div class="module-body">
				<form class="form-horizontal row-fluid" method="POST" enctype="multipart/form-data">
					<div class="control-group">
						<label class="control-label">Guest</label>
						<div class="controls">
							<select  name="guest" class="span8" required="">
								<option value="">....</option>
								<?php while($guest=mysqli_fetch_assoc($gue)){?>
								<option value="<?php echo $guest['guestID']; ?>" <?php if($id==1 && $currNeed['guestID']==$guest['guestID']) echo 'selected' ;?>><?php echo $guest['name']; ?></option>
							<?php }?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Stuff name</label>
						<div class="controls">
							<input type="text" class="span8" name="stuff" required="" <?php if($id==1)echo"value='".$currNeed['name']."'" ?>>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Category</label>
						<div class="controls">
							<select  name="needs" id="needs" class="span8">
								<option value="">....</option>
								<?php while($need=mysqli_fetch_assoc($nee)){?>
								<option value="<?php echo $need['needId']; ?>" <?php if($id==1 && $currCatId==$need['needId']) echo 'selected' ;?> ><?php echo $need['name']; ?></option>
							<?php }?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Type</label>
						<div class="controls">
							<select name="catneeds" id="catneeds" class="span8">
								<option value="">....</option>
								<?php if($id==1){ 
									$xcne=new needscategory();
									$xcne->setneedId($currCatId);
									$xcnee=$xcne->getByNeedId();
									while($xcneed=mysqli_fetch_assoc($xcnee)){
										echo("<option value='".$xcneed['needIdCat']."' ");
										if($xcneed['needIdCat']==$currNeed['needCat'])echo ' selected ';
										echo(" required >".$xcneed['name']."</option>");
									}

									?>

								<?php }?>	
							</select>
						</div>
					</div>					
					<div class="control-group">
						<label class="control-label">Priority</label>
						<div class="controls" >
							<select  name="priority" class="span8">
								<option value="">....</option>
								<option value="weak" <?php if($id==1 && $currNeed['priority']=='weak') echo ' selected '?>>Weak</option>
								<option value="normal" <?php if($id==1 && $currNeed['priority']=='normal') echo ' selected '?>>Normal</option>
								<option value="strong" <?php if($id==1 && $currNeed['priority']=='strong') echo ' selected '?>>Strong</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="basicinput">Count</label>
						<div class="controls">
							<div class="input-prepend">
								<span class="add-on">#</span><input class="span8" type="number" name="count" <?php if($id==1) echo "value='".$currNeed['count']."'";?>>       
							</div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Image</label>
						<div class="controls">
							<input type="file" name="filetoupload" class="span8">
							<?php if($id==1){
							if(is_file('../images/needs/'.$currNeed['img'])){?>
							<img src="../images/needs/<?php echo $currNeed['img'];?>">
							<?php }} ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Description</label>
						<div class="controls">
							<textarea class="span8" rows="5" name="desc"><?php if($id==1) echo $currNeed['desc'];?></textarea>
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
<script>
	$('#needs').change(function(){
        var ne = $('#needs').val();
        $.ajax({
            type: "POST",
            url: "need.php",
            data: {need_id: ne},
            cache: false,
            success: function (result) {
                if(result==0){
                    $("#catneeds").empty();
                    $("#catneeds").append("<option value=''>....</option>"); 
                }else{
                    $("#catneeds").empty();
                    $("#catneeds").append("<option value=''>....</option>");
                    $("#catneeds").append(result);   
                }
            }
        });
    });
</script>