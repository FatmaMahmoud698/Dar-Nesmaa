<?php 
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
include_once "../requestdelivery.php";
?>
<div class="span9">
	<div class="content">
		<?php 
			$req=new requestdelivery();
			if(isset($_GET['del'])){
				$req->setdeliveryID($_GET['del']);
				$reque=$req->getByDel();
			}else if(isset($_GET['cid'])){
				$req->setclientID($_GET['cid']);
				$reque=$req->getBycl();
			}else{
				$reque=$req->GetFull();
			}
		?>
		<div class="module">
			<div class="module-head">
				<h3>Requests</h3><br>
				<a id="edit" class="btn btn-success">Edit</a>
			</div>
			<div class="module-body table">
				<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
					<thead>
						<tr>
							<th>#</th>
							<th>Stuff</th>
							<th>Guest</th>
							<th>Client</th>
							<th>Status</th>
							<th>Delivery</th>
							<th>Note</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<?php while($request=mysqli_fetch_assoc($reque)){ ?>
						<tr class="gradeA">
							<td><input type="checkbox" class="check" value="<?php echo $request['requestID']; ?>"></td>
							<td><?php echo $request['guestneedName'] ?></td>
							<td><?php echo $request['guestName'] ?></td>
							<td><?php echo $request['name'] ?></td>
							<td><?php echo $request['status'] ?></td>
							<td><?php echo $request['deliveryName'] ?></td>
							<td><?php echo $request['note'] ?></td>
							<td><?php echo $request['date'] ?></td>
						</tr>
					<?php }?>
					</tbody>
				</table>
			</div>
		</div><!--/.module-->

	<br />
		
	</div><!--/.content-->
</div><!--/.span9-->
<?php include_once "footer.php"
?>
<script>
	$('input[type="checkbox"]').click(function(){
        var len = $('input[type="checkbox"]').filter(':checked').length;
        var id = $(this).val();
        if($(this).is(':checked')) { 
            if(len == 1){
                var checkedId = $('input[type="checkbox"]:checked').val();
                $('#edit').attr('href','request.php?id='+checkedId);
            }else{
                $('#edit').removeAttr('href');
            }
        }else{
            if(len == 1){
                var checkedId = $('input[type="checkbox"]:checked').val();
                $('#edit').attr('href','request.php?id='+checkedId);
            }else{
                $('#edit').removeAttr('href');
            }
        }
    });
	 $('#edit').click(function(){
        var len = $('input[type="checkbox"]').filter(':checked').length;
        if(len != 1){
            alert("You have to check only one element.");
        }
    });
</script>