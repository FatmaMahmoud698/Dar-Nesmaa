<?php
ob_start();
session_start();
if(isset($_SESSION["id"])){
	include_once "headerAfter.php";
}else{
	// include_once "headerBefore.php"; 
	echo ("<script>window.open('login.php','_self')</script>");	
} ?>
<style>
	.active-tab{
		background-color: #00e58b;
	}
	.resp-tab-item {
		color: #000;
	}
	.resp-tab-item:hover {
	    background: #00bdbd;
	    border-color: #00bdbd;
	    color: #fff;
	}
	table{
		border-radius: 1em;
	}
	table td { 
        padding: 0.5rem !important; 
        border: 1px solid #D0D0D0 !important; 
        vertical-align: middle !important;
    } 
    table th { 
        padding: 0.5rem !important; 
        border: 1px solid #D0D0D0 !important;
        text-align: center; 
    } 
    tr:nth-child(even) {
	  background-color: #fff;
	}
</style>
<div class="grid_3 grid_5" style="padding: 15px;">
	<a class="btn btn-info" data-toggle="modal" data-target="#donationModal">Add Donation</a>
	<?php 
	include_once "donation.php";
	include_once "requestdelivery.php";
	include_once "clientwishlist.php";
	if(isset($_POST['donSubmit'])){
			$ds=new donations();
			$ds->setdesc($_POST['txtdesc']);
			$ds->setnote($_POST['txtnote']);
			$ds->setdate($_POST['txtdate']);
			$ds->setclientID($_SESSION["id"]);
			$msg=$ds->fastAdd();
			if($msg=="ok"){
				echo("<div class='alert alert-success' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>Donation added successfully, Please waiting our call.</div> ");	
			}else{
				echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There is a problem, please try again later.</div> ");
			}
		}
	if(isset($_POST['cDonation'])){
		$ds=new donations();
		$ds->setdonationID($_POST['delval']);
		$msg=$ds->Delete();
		if($msg=="ok"){
			echo("<div class='alert alert-success' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>Your item is Deleted.</div> ");	
		}else{
			echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There is a problem, please try again later.</div> ");
		}
	}
	if(isset($_POST['cRequest'])){
		$re=new requestdelivery();
		$re->setrequestID($_POST['delval']);
		$msg=$re->Delete();
		if($msg=="ok"){
			echo("<div class='alert alert-success' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>Your item is Deleted.</div> ");	
		}else{
			echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There is a problem, please try again later.</div> ");
		}
	}
	if(isset($_POST['cFavorite'])){
		$wi=new clientwishlist();
		$wi->setwishId($_POST['delval']);
		$msg=$wi->Delete();
		if($msg=="ok"){
			echo("<div class='alert alert-success' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>Your item is Deleted.</div> ");	
		}else{
			echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There is a problem, please try again later.</div> ");
		}
	}	
	?>
	<div class="but_list">
		<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs" style="padding: 15px;">
			<ul id="myTab" class="nav nav-tabs" role="tablist">
			  <li role="presentation" class="active"><a href="#donation" role="tab" id="donation-tab" data-toggle="tab" aria-controls="donation">Donation</a></li>
			  <li role="presentation"><a href="#request" id="request-tab" role="tab" data-toggle="tab" aria-controls="request" aria-expanded="true">Request</a></li>
			  <li role="presentation"><a href="#favorite" role="tab" id="favorite-tab" data-toggle="tab" aria-controls="favorite">Wishlist</a></li>
			</ul>
			<div id="myTabContent" class="tab-content" style="padding: 15px;background-color: #f8f8f8;border-radius: 15px;margin: 10px auto;">
			<div role="tabpanel" class="tab-pane fade in active" id="donation" aria-labelledby="donation-tab">
				<ul class="resp-tabs-list">
					<li id="dpending" class="resp-tab-item active-tab" onclick="currentStatus('dpending');"><span>Pending</span></li>
					<li id="dwaiting" class="resp-tab-item active-tab" onclick="currentStatus('dwaiting');"><span>Waiting</span></li>
					<li id="dapproved" class="resp-tab-item active-tab" onclick="currentStatus('dapproved');"><span>Approved</span></li>
					<li id="darrived" class="resp-tab-item active-tab" onclick="currentStatus('darrived');"><span>Completed</span></li>
					<li id="dcompleted" class="resp-tab-item active-tab" onclick="currentStatus('dcompleted');"><span>Completed</span></li>	
					<li id="dcancelled" class="resp-tab-item active-tab" onclick="currentStatus('dcancelled');"><span>Cancelled</span></li>						
				</ul>	
				<div class="clearfix"> </div>
				<table class="table">
					<tbody>
						<tr>
							<th>#</th>
							<th>Donation</th>
							<th>Date</th>
							<th>Delivery Name</th>
							<th>Status</th>
							<th>Guest Name</th>
							<th>Control</th>
						</tr>
						<?php 
							$do = new donations();
							$do->setclientID($_SESSION["id"]);
							$dona=$do->getBycl();
							$counter=0;
							while($donation=mysqli_fetch_assoc($dona)){ ?>
								<tr class="<?php echo 'd'.$donation['status']; ?>" style="text-align: center;">
									<td><?php echo ++$counter; ?></td>
									<td><?php echo $donation['desc']; ?></td>

									<td><?php if($donation['date']) echo $donation['date']; else echo 'Unset'; ?></td>

									<td><?php if($donation['deliveryID']) echo $donation['deliveryName']; else echo 'Unset'; ?></td>

									<td><?php echo $donation['status']; ?></td>

									<td><?php if($donation['guestID']){?>
										<?php echo $donation['guestName'];}else{echo "Unset";}?>
									</td>
									
									<td>
										<?php if($donation['status']=='pending'){?>
										<button class="btn btn-danger" onclick="changeRequest('donation',<?php echo $donation['donationID']?>);" data-toggle="modal" data-target="#deleteItem">
											<i class="fa fa-trash"></i> Delete
										</button>
									<?php }?>
									</td>
								</tr>

							<?php } ?>
					</tbody>
				</table>
			</div>	
			<div role="tabpanel" class="tab-pane fade" id="request" aria-labelledby="request-tab">
				<ul class="resp-tabs-list">
					<li id="pending" class="resp-tab-item active-tab" onclick="currentStatus('pending');"><span>Pending</span></li>
					<li id="waiting" class="resp-tab-item active-tab" onclick="currentStatus('waiting');"><span>Waiting</span></li>
					<li id="approved" class="resp-tab-item active-tab" onclick="currentStatus('approved');"><span>Approved</span></li>
					<li id="completed" class="resp-tab-item active-tab" onclick="currentStatus('completed');"><span>Completed</span></li>	
					<li id="cancelled" class="resp-tab-item active-tab" onclick="currentStatus('cancelled');"><span>Cancelled</span></li>						
				</ul>	
				<div class="clearfix"> </div>
				<table class="table">
					<tbody>
						<tr>
							<th>#</th>
							<th>Request</th>
							<th>Guest Name</th>
							<th>Delivery Date</th>
							<th>Delivery Name</th>
							<th>Status</th>
							<th>Control</th>
						</tr>
						<?php 
							$re = new requestdelivery();
							$re->setclientID($_SESSION["id"]);
							$requests=$re->getBycl();
							$counter=0;
							while($request=mysqli_fetch_assoc($requests)){?>
								<tr class="<?php echo $request['status']; ?>" style="text-align: center;">
									<td><?php echo ++$counter; ?></td>
									<td><a href="singleNeed.php?id=<?php echo $request['gneedId']; ?>"><?php echo $request['guestneedName']; ?></a></td>
									<td><?php echo $request['guestName']; ?></td>
									<td><?php if($request['date']) echo $request['date']; else echo 'Unset'; ?></td>
									<td><?php if($request['deliveryID']) echo $request['deliveryName']; else echo 'Unset'; ?></td>
									<td><?php echo $request['status']; ?></td>
									<td>
										<?php if($request['status']=='pending'){?>
										<button class="btn btn-danger" onclick="changeRequest('request',<?php echo $request['requestID']?>);" data-toggle="modal" data-target="#deleteItem">
											<i class="fa fa-trash"></i> Delete
										</button>
									<?php }?>
									</td>
								</tr>

							<?php }

						?>
					</tbody>
				</table>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="favorite" aria-labelledby="favorite-tab">
				<table class="table ">
					<tr>
						<th class="t-head head-it ">Need</th>
						<th class="t-head">count</th>
						<th class="t-head">Status</th>
						<th class="t-head">Priority</th>
						<th class="t-head">Control</th>
					</tr>
					<?php 
						$wi = new clientwishlist();
						$wi->setclientID($_SESSION["id"]);
						$wishes=$wi->getByclient();
						while($wish=mysqli_fetch_assoc($wishes)){
							$num=$wish['wishId']-1;
					?>
					<script>$(document).ready(function(c) {
						$('.close<?php echo $wish['wishId']; ?>').on('click', function(c){
							$('.cross<?php echo $num; ?>').fadeOut('slow', function(c){
								$('.cross<?php echo $num; ?>').remove();
							});
							});	  
						});
				    </script>
					<tr class="cross cross<?php echo $num; ?>" style="text-align: center;">
						<td class="ring-in">
							<a href="singleNeed.php?id=<?php echo $wish['gneedId']; ?>">
								<?php echo $wish['name']; ?>
							</a>
							<div class="clearfix"> </div>
							<div class="close close<?php echo $wish['wishId']; ?>"> <i class="fa fa-times" aria-hidden="true"></i></div>
						 </td>
						<td><?php echo $wish['count']; ?></td>
						<td><h3><span class="label label-info"><?php echo $wish['status']; ?></span></h3></td>
						<td><?php echo $wish['priority']; ?></td>

						<td>	
							<button class="btn btn-danger" onclick="changeRequest('favorite',<?php echo $wish['wishId']; ?>);" data-toggle="modal" data-target="#deleteItem">remove from favorite</button>
						</td>
						
					</tr>
					 <?php }?> 
				</table>
			</div>
			</div>
		</div>
	</div>
</div>
<div id="donationModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
  <div class="modal-content">
	    <div class="modal-header" style="border-radius: 6px;background-color:#00e58b">
	        <h4 class="modal-title">Add Donation</h4>
	    </div>
	    <form action="#" method="post">
	      	<div class="modal-body">
	        	<table class="table table-broder table-striped">
					<tr><td>Description</td>
						<td><input type="text" name="txtdesc" class="form-control" required/></td></tr>
					<tr><td>Date</td>
						<td><input type="date" name="txtdate" class="form-control" required/></td></tr>
					<tr><td>Any additional info </td>
						<td><textarea rows="3" name="txtnote" class="form-control" required> </textarea></td></tr>		
				</table>
	      	</div>
      		<div class="modal-footer">
      			<button type="submit" class="btn btn-primary" name="donSubmit">Add</button>
        		<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      		</div>
  		</form>
    </div>

  </div>
</div>
<div id="deleteItem" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="width: 75%;">
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
      			<button type="submit" class="btn btn-primary" id="deleItem" name="">Yes</button>
        		<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      		</div>
  		</form>
    </div>

  </div>
</div>
<script>

function currentStatus(status) {
	var sid = document.getElementById(status);
	var sclass = document.getElementsByClassName(status); 
	if ($(sid).hasClass("active-tab")) {
	    $(sclass).hide();
	    $(sid).removeClass("active-tab");
	} else {
	    $(sclass).show();
	    $(sid).addClass("active-tab");
	}
}
function changeRequest(ele,num){
	if(ele=='request'){
		$('#deleItem').attr('name', 'cRequest');
		$('#delval').attr('value', num);
	}else if(ele=='donation'){
		$('#deleItem').attr('name', 'cDonation');
		$('#delval').attr('value', num);
	}else if(ele=='favorite'){
		$('#deleItem').attr('name', 'cFavorite');
		$('#delval').attr('value', num);
	}
}	
</script>
<?php include_once "footer.php";?>