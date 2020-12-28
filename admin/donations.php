<?php 
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
include_once "../donation.php";
?>
<div class="span9">
	<div class="content">
		<?php 
			$don=new donations();
			if(isset($_GET['del'])){
				$don->setdeliveryID($_GET['del']);
				$donations=$don->getFDel();
			}else if(isset($_GET['cid'])){
				$don->setclientID($_GET['cid']);
				$donations=$don->getBycl();
			}else{
				$donations=$don->getFull();
			}
		?>
		<div class="module">
			<div class="module-head">
				<h3>Donations</h3><br>
				<a id="edit" class="btn btn-success">Edit</a>
			</div>
			<div class="module-body table">
				<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
					<thead>
						<tr>
							<th>#</th>
							<th>Description</th>
							<th>Count</th>
							<th>Note</th>
							<th>Status</th>
							<th>Data</th>
							<th>Client</th>
							<th>Guest</th>
							<th>Delivery</th>
						</tr>
					</thead>
					<tbody>
						<?php while($dona=mysqli_fetch_assoc($donations)){ ?>
						<tr class="gradeA">
							<td><input type="checkbox" class="check" value="<?php echo $dona['donationID']; ?>"></td>
							<td><?php echo $dona['desc'] ?></td>
							<td><?php echo $dona['count'] ?></td>
							<td><?php echo $dona['note'] ?></td>
							<td><?php echo $dona['status'] ?></td>
							<td><?php echo $dona['date'] ?></td>
							<td><?php echo $dona['clientName'] ?></td>
							<td><?php echo $dona['guestName'] ?></td>
							<td><?php echo $dona['deliveryName'] ?></td>
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
                $('#edit').attr('href','donation.php?id='+checkedId);
            }else{
                $('#edit').removeAttr('href');
            }
        }else{
            if(len == 1){
                var checkedId = $('input[type="checkbox"]:checked').val();
                $('#edit').attr('href','donation.php?id='+checkedId);
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