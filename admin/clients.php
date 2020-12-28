<?php
session_start(); 
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
include_once "../client.php";
$cl=new client();
$cli=$cl->GetAll();

?>

<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>Clients</h3><br>
								<a id="donation" class="btn btn-success">Donations</a>
								<a id="request" class="btn btn-success">Requests</a>
							</div>
							<div class="module-body table">
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Username</th>
											<th>Email</th>
											<th>Gender</th>
											<th>Phone</th>
											<th>Address</th>
										</tr>
									</thead>
									<tbody>
										<?php while($client=mysqli_fetch_assoc($cli)){ ?>
										<tr class="gradeA">
											<td><input type="checkbox" class="check" value="<?php echo $client['ClientID']; ?>"></td>
											<td><?php echo $client['name'] ?></td>
											<td><?php echo $client['username'] ?></td>
											<td><?php echo $client['email'] ?></td>
											<td><?php echo $client['gender'] ?></td>
											<td><?php echo $client['phone'] ?></td>
											<td><?php echo $client['address'] ?></td>
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
                $('#donation').attr('href','donations.php?cid='+checkedId);
                $('#request').attr('href','requests.php?cid='+checkedId);
            }else{
                $('#donation').removeAttr('href');
                $('#request').removeAttr('href');
            }
        }else{
            if(len == 1){
                var checkedId = $('input[type="checkbox"]:checked').val();
                $('#donation').attr('href','donations.php?cid='+checkedId);
                $('#request').attr('href','requests.php?cid='+checkedId);
            }else{
                $('#donation').removeAttr('href');
                $('#request').removeAttr('href');
            }
        }
    });
	 $('#donation,#request').click(function(){
        var len = $('input[type="checkbox"]').filter(':checked').length;
        if(len != 1){
            alert("You have to check only one element.");
        }
    });
</script>