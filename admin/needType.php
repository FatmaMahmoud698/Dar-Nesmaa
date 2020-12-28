<?php 
ob_start();
session_start();
if(!isset($_SESSION["admin_id"])){
    echo ("<script>window.open('adminLogin.php','_self')</script>"); 
}
include '../needs.php';
include_once "../needCat.php";
if(isset($_POST['getallData'])){
	$id=$_POST['getId'];	
	$cne=new needs();
	$cnee=$cne->GetAll();
	while($cneed=mysqli_fetch_assoc($cnee)){
		echo("<option value='".$cneed['needId']."' ");
		if($id==$cneed['needId']) echo " selected ";
		echo(">".$cneed['name']."</option>");
	}

	exit();
}
if(isset($_POST['needId'])){	
	$cne=new needs();
	$cnee=$cne->GetAll();
	while($cneed=mysqli_fetch_assoc($cnee)){
		echo("<option value='".$cneed['needId']."' required>".$cneed['name']."</option>");
	}
	exit();
}
if(isset($_POST['needIdEdit'])){
	if($_POST['type']=='sub'){	
		$cene=new needscategory();
		$cene->setneedIdCat($_POST['needIdEdit']);
		$cenee=$cene->getById();
		$ceneed=mysqli_fetch_assoc($cenee);
		echo json_encode($ceneed);

	}elseif($_POST['type']=='main'){
		$cne=new needs();
		$cne->setneedId($_POST['needIdEdit']);
		$cnee=$cne->getById();
		$cneed=mysqli_fetch_assoc($cnee);
		echo json_encode($cneed);
	}
	exit();
}
include_once "header.php";

?>

<div class="span9">
					<div class="content">
						<?php 
							if(isset($_POST['deleItem'])){
								if($_POST['deltyp']=='sub'){
									$re=new needscategory();
									$re->setneedIdCat($_POST['delval']);
									$msg=$re->Delete();
									if($msg=="ok")
										echo("<div class='alert alert-success' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>Your item is Deleted.</div> ");	
									else
										echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There is a problem, please try again later.</div> ");
								}else{
									$cne=new needs();
									$cne->setneedId($_POST['delval']);
									$re=new needscategory();
									$re->setneedId($_POST['delval']);
									$sub=$re->getByNeedId();
									$subb=mysqli_fetch_assoc($sub);
									if(count($subb)>0)
										echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There are Categories for this item please delete them first.</div> ");
									else{
										$msg = $cne->Delete();
										if($msg=='ok')
											echo("<div class='alert alert-success' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>Your item is Deleted.</div> ");
										else echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There is a problem, please try again later.</div> ");
									}
								}								
							}
						if(isset($_POST['addItem'])){
							if($_POST['type']=='main'){
								$nne=new needs();
								$nne->setname($_POST['name']);
								$msg=$nne->Add();
								if($msg=='ok')
									echo("<div class='alert alert-success' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>Your item is Added.</div> ");
								else echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There is a problem, please try again later.</div> ");
							}else if($_POST['type']=='sub'){
								$ncne=new needscategory();
								$ncne->setname($_POST['name']);
								$ncne->setneedId($_POST['category']);
								$msg=$ncne->Add();
								if($msg=='ok')
									echo("<div class='alert alert-success' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>Your item is Added.</div> ");
								else echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There is a problem, please try again later.</div> ");
							}
						}
						if(isset($_POST['updateItem'])){
							if($_POST['typecat']=='main'){
								$cne=new needs();
								$cne->setneedId($_POST['editId']);
								$cne->setname($_POST['name']);
								$msg=$cne->Update();
								if($msg=='ok')
									echo("<div class='alert alert-success' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>Your item is Updated.</div> ");
								else echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There is a problem, please try again later.</div> ");
							}elseif($_POST['typecat']=='sub'){
								$ncne=new needscategory();
								$ncne->setname($_POST['name']);
								$ncne->setneedIdCat($_POST['editId']);
								$msg=$ncne->Update();
								if($msg=='ok')
									echo("<div class='alert alert-success' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>Your item is Updated.</div> ");
								else echo("<div class='alert alert-danger' style='text-align: center;width: 50%;margin: auto;border-radius:30px'>There is a problem, please try again later.</div> ");
							}
						}
						$ne=new needs();
						$nee=$ne->GetAll();
							?>
						<div class="module">
							<div class="module-head">
								<h3>Needs Type</h3><br>
								<button id="new" class="btn btn-success" data-target="#needModal" data-toggle="modal">Add</button>
								<button id="edit" class="btn btn-success" data-target="#needModal">Edit</button>
								<button id="delete" class="btn btn-danger" data-target="#delmodal">Delete</button>
							</div>
							<div class="module-body table">
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Type Name</th>
											<th>Parent Name</th>
										</tr>
									</thead>
									<tbody>
										<?php while($need=mysqli_fetch_assoc($nee)){ ?>
										<tr class="gradeA">
											<td><input type="checkbox" class="check" value="<?php echo $need['needId']; ?>"></td>
											<td><?php echo $need['name']; ?></td>
											<td>-</td>
										</tr>
										<?php $cne=new needscategory();
											$cne->setneedId($need['needId']);
											$cnee=$cne->getByNeedId();
											while($cneed=mysqli_fetch_assoc($cnee)){ ?>
											<tr class="gradeA">
											<td class="sub"><input type="checkbox" id="subty<?php echo $cneed['needIdCat']; ?>" class="check" value="<?php echo $cneed['needIdCat']; ?>"></td>
											<td><?php echo $cneed['name']; ?></td>
											<td><?php echo $need['name']; ?></td>
										</tr>
										<?php }
										}?>
									</tbody>
								</table>
							</div>
						</div><!--/.module-->

					<br />
						
					</div><!--/.content-->
</div><!--/.span9-->
<div id="delmodal" class="modal fade" role="dialog" style="width: 35%; display: none;">
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
      			<input type="hidden" id="deltyp" name="deltyp" value="">
      			<button type="submit" class="btn btn-primary" name="deleItem">Yes</button>
        		<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      		</div>
  		</form>
    </div>

  </div>
</div>
<div id="needModal" class="modal" role="dialog" style="display: none;">
  <div class="modal-dialog">

    <!-- Modal content-->
  <div class="modal-content">
	    <div class="modal-header" style="border-radius: 6px;background-color:#00e58b">
	        <h4 class="modal-title">Add Category</h4>
	    </div>
	    <form action="#" method="post">
	      	<div class="modal-body">
	      		<div class="row-fluid">
					<div class="control-group">
						<label class="control-label">Name</label>
						<div class="controls">
							<input type="text" class="span8" name="name" id="needName" required="">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Type</label>
						<div class="controls">
							<select  name="type" id="type" class="span8" required="">
								<option value="">....</option>
								<option value="main">Main</option>
								<option value="sub">Sub Type</option>
							</select>
						</div>
					</div>				
					<div class="control-group">
						<label class="control-label">Category</label>
						<div class="controls" >
							<select  name="category" id="category" class="span8">
								<option value="">....</option>
							</select>
						</div>
					</div>
				</div>	
	      	</div>
      		<div class="modal-footer">
      			<input type="hidden" name="typecat" id="typecat">
      			<input type="hidden" name="editId" id="editId">
      			<button type="submit" class="btn btn-primary" id="add" name="addItem">Add</button>
      			<button type="submit" class="btn btn-primary" id="update"name="updateItem" style="display: none;">Update</button>
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
                var object = $('input[type="checkbox"]:checked').parent('td').prop('className');
                $('#edit').attr('data-toggle','modal');
                $('#delete').attr('data-toggle','modal');
                $('#delval').val(checkedId);
                if(object.length>11){$('#deltyp').val('sub');}else{$('#deltyp').val('main');}
            }else{
                $('#edit').removeAttr('data-toggle');
                $('#delete').removeAttr('data-toggle');
                $('#delval').val('');
                $('#deltyp').val('');
            }
        }else{
            if(len == 1){
                var checkedId = $('input[type="checkbox"]:checked').val();
                var object = $('input[type="checkbox"]:checked').parent('td').prop('className');
                $('#edit').attr('data-toggle','modal');
                $('#delete').attr('data-toggle','modal');
                $('#delval').val(checkedId);
                if(object.length>11){$('#deltyp').val('sub');}else{$('#deltyp').val('main');}
            }else{
                $('#edit').removeAttr('data-toggle');
                $('#delete').removeAttr('data-toggle');
                $('#delval').val('');
                $('#deltyp').val('');
            }
        }
    });
	$('#edit').click(function(){
        var len = $('input[type="checkbox"]').filter(':checked').length;
        var id=$('#delval').val();
        if(len != 1){
            alert("You have to check only one element.");
        }else{
        	var type=$('#deltyp').val();
        	if(type=='sub'){
        		var t='sub';
        		$.ajax({
	            type: "POST",
	            url: "needType.php",
	            data: {needIdEdit: id,type: t},
	            cache: false,
	            success: function (result) { 
	                var data = jQuery.parseJSON(result);
	                $("#needName").val(data.name);
	                $("#type").val('sub'); 
	                getAllCat(data.needId);
	                $("#typecat").val('sub');
	                $("#editId").val(data.needIdCat);
	                $("#add").hide();
	                $("#update").show();
	                $("#type").prop('disabled', true);
	                $("#category").prop('disabled', true);

	            }
	        });
        	}else{
        		var t='main';
        		$.ajax({
		            type: "POST",
		            url: "needType.php",
		            data: {needIdEdit: id,type: t},
		            cache: false,
		            success: function (result) { 
		                var data = jQuery.parseJSON(result);
		                $("#needName").val(data.name);
		                $("#type").val('main');
		                $("#category").empty();
	    				$("#category").append("<option value=''>....</option>");
	    				$("#typecat").val('main');
	    				$("#editId").val(data.needId);
	    				$("#add").hide();
	                	$("#update").show();
	                	$("#type").prop('disabled', true);
	                	$("#category").prop('disabled', true);
		            }
	           	});
        	}
        }
    });
    $('#delete').click(function(){
    	var len = $('input[type="checkbox"]').filter(':checked').length;
        var id=$('#delval').val();
        if(len != 1){
            alert("You have to check only one element.");
        }
    });
    function getAllCat(id){
    	var check='ok';
    	$.ajax({
            type: "POST",
            url: "needType.php",
            data: {getallData: check, getId: id},
            cache: false,
            success: function (result) {
                    $("#category").empty();
                    $('#category').attr("required", "required");
                    $("#category").append("<option value=''>....</option>");
                    $("#category").append(result);
            }
        });
    }
	$('#type').change(function(){
        var ne = $('#type').val();
        if(ne=='sub'){
	        $.ajax({
	            type: "POST",
	            url: "needType.php",
	            data: {needId: ne},
	            cache: false,
	            success: function (result) {
	                if(result==0){
	                    $("#category").empty();
	                    $("#category").append("<option value=''>....</option>");
	                    $('#category').attr("required", "required"); 
	                }else{
	                    $("#category").empty();
	                    $('#category').attr("required", "required");
	                    $("#category").append("<option value=''>....</option>");
	                    $("#category").append(result);   
	                }
	            }
	        });
	    }else{
	    	$("#category").empty();
	        $("#category").append("<option value=''>....</option>");
	        $('#category').removeAttr("required");
	    }
    }); 
$('#new').click(function(){
        $("#needName").val('');
        $("#type").val(''); 
        $("#category").empty();
	    $("#category").append("<option value=''>....</option>");
	    $("#update").hide();
	    $("#add").show();
	    $("#type").prop('disabled', false);
	                $("#category").prop('disabled', false);
    }); 
</script>