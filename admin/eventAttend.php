<?php 
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
include_once "../event.php";
include_once "../eventattend.php";
?>

<div class="span9">
					<div class="content">
						<?php
						if(isset($_GET['id'])){
							$re=new event();
							$re->seteventId($_GET['id']);
							$evn=$re->getById();
							$evnx=mysqli_fetch_assoc($evn);
							$name_event=$evnx['name'];
							$ev=new eventattend();
							$ev->seteventId($_GET['id']);
							$eve=$ev->getbyev();

						}else{
							header("location: events.php");
						}
						?>
						<div class="module">
							<div class="module-head">
								<h3><?php echo 'Attent of '.$name_event.' event.'?></h3><br>
							</div>
							<div class="module-body table">
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Client Name</th>
										</tr>
									</thead>
									<tbody>
										<?php $counter=0;
										while($event=mysqli_fetch_assoc($eve)){ ?>
										<tr class="gradeA">
											<td><?php echo ++$counter; ?></td>
											<td><?php echo $event['name'] ?></td>
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