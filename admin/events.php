<?php 
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
include_once "../event.php";
?>

<div class="span9">
					<div class="content">
						<?php  
							if(isset($_POST['deleItem'])){
								$re=new event();
								$re->seteventId($_POST['delval']);
								$old=$re->getById();
								$old_data=mysqli_fetch_assoc($old);
								$image=$old_data['img'];
								$msg=$re->Delete();
								if($msg=="ok"){
									$file='../images/event/'.$image;
									if(is_file($file)){
								        unlink($file);
					                }
									echo("<div class='alert alert-success' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>Event is Deleted.</div> ");	
								}else{
									echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There is a problem, please try again later.</div> ");
								}
							}
							$ev=new event();
							$eve=$ev->getFull();
						?>
						<div class="module">
							<div class="module-head">
								<h3>Events</h3><br>
								<a id="new" href="event.php" class="btn btn-success">Add</a>
								<a id="edit" class="btn btn-success">Edit</a>
								<a id="delete" class="btn btn-danger" data-target="#delmodal">Delete</a>
								<a id="attend" class="btn btn-success">Attend</a>
								<a id="image" class="btn btn-info">Images</a>
							</div>
							<div class="module-body table">
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Description</th>
											<th>Date</th>
											<th>From</th>
											<th>To</th>
											<th>Image</th>
											<th>Max Number</th>
											<th>Type</th>
										</tr>
									</thead>
									<tbody>
										<?php while($event=mysqli_fetch_assoc($eve)){ ?>
										<tr class="gradeA">
											<td><input type="checkbox" class="check" value="<?php echo $event['eventId']; ?>"></td>
											<td><?php echo $event['eventName'] ?></td>
											<td><?php echo $event['eventDesc'] ?></td>
											<td><?php echo $event['date'] ?></td>
											<td><?php echo $event['from'] ?></td>
											<td><?php echo $event['to'] ?></td>
											<td><img src="../images/event/<?php echo $event['eventImg'] ?>"></td>
											<td><?php echo $event['maxNumber'] ?></td>
											<td><?php echo $event['eventcatName'] ?></td>
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

<?php include_once "footer.php"
?>
<script>
	$('input[type="checkbox"]').click(function(){
        var len = $('input[type="checkbox"]').filter(':checked').length;
        var id = $(this).val();
        if($(this).is(':checked')) { 
            if(len == 1){
                var checkedId = $('input[type="checkbox"]:checked').val();
                $('#edit').attr('href','event.php?id='+checkedId);
                $('#attend').attr('href','eventAttend.php?id='+checkedId);
                $('#image').attr('href','eventImage.php?id='+checkedId);
                $('#delete').attr('data-toggle','modal');
                $('#delval').val(checkedId);
            }else{
                $('#edit').removeAttr('href');
                $('#attend').removeAttr('href');
                $('#image').removeAttr('href');
                $('#delete').removeAttr('data-toggle');
                $('#delval').val('');
            }
        }else{
            if(len == 1){
                var checkedId = $('input[type="checkbox"]:checked').val();
                $('#edit').attr('href','event.php?id='+checkedId);
                $('#attend').attr('href','eventAttend.php?id='+checkedId);
                $('#image').attr('href','eventImage.php?id='+checkedId);
                $('#delete').attr('data-toggle','modal');
                $('#delval').val(checkedId);
            }else{
                $('#edit').removeAttr('href');
                $('#attend').removeAttr('href');
                $('#image').removeAttr('href');
                $('#delete').removeAttr('data-toggle');
                $('#delval').val('');
            }
        }
    });
	 $('#edit,#attend,#delete,#image').click(function(){
        var len = $('input[type="checkbox"]').filter(':checked').length;
        if(len != 1){
            alert("You have to check only one element.");
        }
    });
</script>