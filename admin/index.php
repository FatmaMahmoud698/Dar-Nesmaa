<?php session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include_once "header.php";
?>
 <div class="span9">
                        <div class="content">
                            <div class="btn-controls">
                            	<div class="btn-box-row row-fluid">
                                    <a href="requests.php" class="btn-box big span4"><i class=" icon-random"></i><b></b>
                                        <p class="text-muted">
                                            Requests</p>
                                    </a><a href="guests.php" class="btn-box big span4"><i class="icon-user"></i><b></b>
                                        <p class="text-muted">
                                            Guests</p>
                                    </a><a href="delegates.php" class="btn-box big span4"><i class="icon-money"></i><b></b>
                                        <p class="text-muted">
                                            Delivery</p>
                                    </a>
                                </div>
                                <div class="btn-box-row row-fluid">
                                    <div class="span8">
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <a href="needs.php" class="btn-box small span4"><i class="icon-tasks"></i><b>Needs</b>
                                                </a><a href="clients.php" class="btn-box small span4"><i class="icon-group"></i><b>Clients</b>
                                                </a><a href="donations.php" class="btn-box small span4"><i class="icon-tasks"></i><b>Donations</b>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <a href="events.php" class="btn-box small span4"><i class="icon-save"></i><b>Events</b>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/.content-->
                    </div>
<?php include_once "footer.php";
?>