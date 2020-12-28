<?php 
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
include_once "../event.php";
include_once "../eventimg.php";
?>

<div class="span9">
					<div class="content">
						<?php
						if(isset($_POST['btnAdd'])){
							$gne=new eventimg();
							if(strlen($_FILES["filetoupload"]["tmp_name"]) > 0){
								$rand = rand(1111,9999);
								$target_dir="../images/event/eventsImages/";
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
							            $gne->seteventId($_GET['id']);
							            $msg=$gne->Add();
							            if($msg=="ok"){
											echo("<div class='alert alert-success'>Your Image has been Added</div> ");	
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
						if(isset($_POST['deleItem'])){
								$re=new eventimg();
								$re->seteveImgId($_POST['delval']);
								$old=$re->getById();
								$old_date=mysqli_fetch_assoc($old);
								$image=$old_date['img'];
								$msg=$re->Delete();
								if($msg=="ok"){
									$file='../images/event/eventsImages/'.$image;
									if(is_file($file)){
								        unlink($file);
					                }
									echo("<div class='alert alert-success' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>Event is Deleted.</div> ");	
								}else{
									echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There is a problem, please try again later.</div> ");
								}
							}
						if(isset($_GET['id'])){
							$re=new event();
							$re->seteventId($_GET['id']);
							$evn=$re->getById();
							$evnx=mysqli_fetch_assoc($evn);
							$name_event=$evnx['name'];
							$ev=new eventimg();
							$ev->seteventId($_GET['id']);
							$eve=$ev->getByEve();

						}else{
							header("location: events.php");
						}
						?>
						<div class="module">
							<div class="module-head">
								<h3><?php echo 'Images of '.$name_event.' event.'?></h3><br>
								<a class="btn btn-success" data-target="#newModal" data-toggle="modal" >Add</a>
								<a id="delete" class="btn btn-danger" data-target="#delmodal">Delete</a>
							</div>
							<div class="module-body table">
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Image</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										while($event=mysqli_fetch_assoc($eve)){ ?>
										<tr class="gradeA">
											<td><input type="checkbox" class="check" value="<?php echo $event['eveImgId']; ?>"></td>
											<td><img src="../images/event/eventsImages/<?php echo $event['img'];?>" style="width: 100px;height: 80px;"></td>
										</tr>
									<?php }?>
									</tbody>
								</table>
							</div>
						</div><!--/.module-->

					<br />
						
					</div><!--/.content-->
				</div><!--/.span9-->
<div id="delmodal" class="modal fade" role="dialog" style="width: 35%;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
	    <div class="modal-header" style="border-radius: 6px;background-color:#00e58b">
	    	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Deleting your choice</h4>
	    </div>
      	<div class="modal-body">
        	<p>Do you want to Delete this item from your list?</p>
      	</div>
      	<form action="#" method="post">
      		<div class="modal-footer">
      			<input type="hidden" id="delval" name="delval" value="">
      			<button type="submit" class="btn btn-primary" name="deleItem">Yes</button>
        		<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      		</div>
  		</form>
    </div>

  </div>
</div>
<div id="newModal" class="modal" role="dialog" style="display: none;">
  <div class="modal-dialog">

    <!-- Modal content-->
  <div class="modal-content">
	    <div class="modal-header" style="border-radius: 6px;background-color:#00e58b">
	        <h4 class="modal-title">Add Image</h4>
	    </div>
	    <form action="#" method="post" enctype="multipart/form-data">
	      	<div class="modal-body">
	      		<div class="row-fluid">
					<div class="control-group">
						<label class="control-label">Image</label>
						<div class="controls">
							<input type="file" class="span8" name="filetoupload" required="">
						</div>
					</div>
				</div>	
	      	</div>
      		<div class="modal-footer">
      			<button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
        		<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      		</div>
  		</form>
    </div>

  </div>
</div>
<?php include_once "footer.php"
?>
<script>
	$('input[type="checkbox"]').click(function(){
        var len = $('input[type="checkbox"]').filter(':checked').length;
        var id = $(this).val();
        if($(this).is(':checked')) { 
            if(len == 1){
                var checkedId = $('input[type="checkbox"]:checked').val();
                $('#delete').attr('data-toggle','modal');
                $('#delval').val(checkedId);
            }else{
                $('#delete').removeAttr('data-toggle');
                $('#delval').val('');
            }
        }else{
            if(len == 1){
                var checkedId = $('input[type="checkbox"]:checked').val();
                $('#delete').attr('data-toggle','modal');
                $('#delval').val(checkedId);
            }else{
                $('#delete').removeAttr('data-toggle');
                $('#delval').val('');
            }
        }
    });
	 $('#delete').click(function(){
        var len = $('input[type="checkbox"]').filter(':checked').length;
        if(len != 1){
            alert("You have to check only one element.");
        }
    });
</script>