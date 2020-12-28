<?php
ob_start();
session_start();
if(isset($_SESSION["id"])){
	include_once "headerAfter.php";
}else{
	include_once "headerBefore.php"; 
	// echo ("<script>window.open('login.php','_self')</script>");	
}
include_once "information.php";
$in=new information();
$in->setcategory('About US'); 
$inf= $in->getByCat();
?>
<div class="sub-banner">
</div>
<div class="about">
	<div class="container"> 
		<h3>About Us</h3>
		<div class="about-info">
			<div class="col-md-8 about-grids">
				<h4>Our Vision</h4>
				<p>Dignissimos at vero eos et accusamus et iusto odio ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecat officia. </p>		
			</div>
			<div class="col-md-4 about-grids">
					<h4>Our Mession</h4>
					<div class="pince">
						<div class="pince-left">
							<h5>01</h5>
						</div>
						<div class="pince-right">
							<p>Vero vulputate enim non justo posuere phasellus eget  mauris.</p>
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="pince">
						<div class="pince-left">
							<h5>02</h5>
						</div>
						<div class="pince-right">
							<p>Vero vulputate enim non justo posuere phasellus eget  mauris.</p>
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="pince">
						<div class="pince-left">
							<h5>03</h5>
						</div>
						<div class="pince-right">
							<p>Vero vulputate enim non justo posuere phasellus eget  mauris.</p>
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="pince">
						<div class="pince-left">
							<h5>04</h5>
						</div>
						<div class="pince-right">
							<p>Vero vulputate enim non justo posuere phasellus eget  mauris.</p>
						</div>
						<div class="clearfix"> </div>
					</div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>
<!-- //about -->
<?php include_once "footer.php";?>