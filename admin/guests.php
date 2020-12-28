<?php 
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
include_once "../guests.php";
?>

<div class="span9">
					<div class="content">
						<?php  
							if(isset($_POST['deleItem'])){
								$re=new guests();
								$re->setguestID($_POST['delval']);
								$msg=$re->Delete();
								if($msg=="ok"){
									echo("<div class='alert alert-success' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>Guest is Deleted.</div> ");	
								}else{
									echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There is a problem, please try again later.</div> ");
								}
							}
							$gue=new guests();
							$guests=$gue->GetAll();
						?>
						<div class="module">
							<div class="module-head">
								<h3>Guests</h3><br>
								<a id="new" href="guest.php" class="btn btn-success">Add</a>
								<a id="edit" class="btn btn-success">Edit</a>
								<a id="delete" class="btn btn-danger" data-target="#delmodal">Delete</a>
								<a id="needs" class="btn btn-success">Needs</a>
							</div>
							<div class="module-body table">
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Nickname</th>
											<th>Gender</th>
											<th>Brithdate</th>
											<th>mobile</th>
											<th>note</th>
										</tr>
									</thead>
									<tbody>
										<?php while($guest=mysqli_fetch_assoc($guests)){ ?>
										<tr class="gradeA">
											<td><input type="checkbox" class="check" value="<?php echo $guest['guestID']; ?>"></td>
											<td><?php echo $guest['name'] ?></td>
											<td><?php echo $guest['nickname'] ?></td>
											<td><?php echo $guest['gender'] ?></td>
											<td><?php echo $guest['brithDate'] ?></td>
											<td><?php echo $guest['mobile'] ?></td>
											<td><?php echo $guest['note'] ?></td>
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
                $('#edit').attr('href','guest.php?id='+checkedId);
                $('#needs').attr('href','needs.php?guest='+checkedId);
                $('#delete').attr('data-toggle','modal');
                $('#delval').val(checkedId);
            }else{
                $('#edit').removeAttr('href');
                $('#needs').removeAttr('href');
                $('#delete').removeAttr('data-toggle');
                $('#delval').val('');
            }
        }else{
            if(len == 1){
                var checkedId = $('input[type="checkbox"]:checked').val();
                $('#edit').attr('href','guest.php?id='+checkedId);
                $('#needs').attr('href','needs.php?guest='+checkedId);
                $('#delete').attr('data-toggle','modal');
                $('#delval').val(checkedId);
            }else{
                $('#edit').removeAttr('href');
                $('#needs').removeAttr('href');
                $('#delete').removeAttr('data-toggle');
                $('#delval').val('');
            }
        }
    });
	 $('#edit,#needs,#delete').click(function(){
        var len = $('input[type="checkbox"]').filter(':checked').length;
        if(len != 1){
            alert("You have to check only one element.");
        }
    });
</script>