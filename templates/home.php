<?php
if(!isset($_SESSION)){ 
        session_start(); 
} 
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/bootstrap.css" type="text/css">
		<link rel="stylesheet" href="../css/datatables.css" type="text/css">
		<link rel="stylesheet" href="../css/my.css" type="text/css">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<!--<link rel="stylesheet" href="../fonts/*" type="text/css">-->
	</head>
	<body>
		 
<!-- Main content -->
	<div class="row jumbotron container-fluid">
		<div class="col-sm-9 ">
			<h1>Chikungunya Virus Tracking</h1>
		</div>
		<div class="col-sm-3">
			<button type="button" id ="btn_access" class="btn btn-default btn-lg jumbotron">
				<!--span id="icon_login" class="glyphicon glyphicon-off" aria-hidden="true"></span-->
			</button>
		</div>
	</div>
	<div class="container-fluid main-container">
	    <section class="content">
	        <!-- START CUSTOM TABS -->
	          <div class="row">
	            <div class="col-sm-12">
	              <!-- Custom Tabs -->
	              <div class="nav-tabs-custom">
	                <ul class="nav nav-tabs nav-justified" id ='nav_tabs'>
	                  <li id="ti0" class="ctabs active"><a id='link0' href="#tab_0" data-toggle="tab">Display</a></li>
	                  <li id="ti1" class="ctabs" ><a id='link1' href="#tab_1" data-toggle="tab">Add</a></li>
	                  <li id="ti2" class="ctabs" ><a id='link2' href="#tab_2" data-toggle="tab">Modify</a></li>
	                </ul>
	                <div class="tab-content">
	                  <div class="tab-pane active" id="tab_0">
	                      <div id="table_container"></div>
	                  </div><!-- /.tab-pane -->
	                  <div class="tab-pane" id="tab_1">
	                    <form class="form-horizontal" id="insert_form">
							<fieldset>
							<legend>Registration</legend>

							<div class="form-group">
							  <label class="col-md-4 control-label" for="input_name">Name</label>  
							  <div class="col-md-4">
							  <input id="input_name" name="input_name" type="text" placeholder="e.g. stfn bdho" class="form-control input-md">
							  </div>
							</div>

							<div class="form-group">
							  <label class="col-md-4 control-label" for="input_age">Age</label>  
							  <div class="col-md-4">
							  <input id="input_age" name="input_age" type="text" placeholder="e.g. 21" class="form-control input-md">
							  </div>
							</div>

							<div class="form-group">
							  <label class="col-md-4 control-label" for="radio_sex">Sex</label>
							  <div class="col-md-4"> 
							    <label class="radio-inline" for="radio_sex-0">
							      <input type="radio" name="radio_sex" id="radio_sex-0" value="M" checked="checked">
							      Male
							    </label> 
							    <label class="radio-inline" for="radio_sex-1">
							      <input type="radio" name="radio_sex" id="radio_sex-1" value="F">
							      Female
							    </label>
							  </div>
							</div>

							<div class="form-group">
							  <label class="col-md-4 control-label" for="input_address">Address</label>  
							  <div class="col-md-4">
							  <input id="input_address" name="input_address" type="text" placeholder="e.g. St. Agustine" class="form-control input-md">
							  </div>
							</div>

							<div class="form-group">
							  <label class="col-md-4 control-label" for="input_phone">Phone</label>  
							  <div class="col-md-4">
							  <input id="input_phone" name="input_phone" type="text" placeholder="e.g. 555 5555" class="form-control input-md"> 
							  </div>
							</div>

							<div class="form-group">
							  <label class="col-md-4 control-label" for="input_diagnosis">Diagnosis</label>
							  <div class="col-md-4">                     
							    <textarea class="form-control" id="input_diagnosis" name="input_diagnosis"></textarea>
							  </div>
							</div>

							<div class="form-group">
							  <label class="col-md-4 control-label" for="radio_referral">Referral</label>
							  <div class="col-md-4"> 
							    <label class="radio-inline" for="radio_referral-0">
							      <input type="radio" name="radio_referral" id="radio_referral-0" value="Y" checked="checked">
							      Y
							    </label> 
							    <label class="radio-inline" for="radio_referral-1">
							      <input type="radio" name="radio_referral" id="radio_referral-1" value="N">
							      N
							    </label>
							  </div>
							</div>

							<div class="form-group">
							  <label class="col-md-4 control-label" for="input_symptoms">Symptoms</label>
							  <div class="col-md-4">                     
							    <textarea class="form-control" id="input_symptoms" name="input_symptoms"></textarea>
							  </div>
							</div>

							<div class="form-group">
							  <label class="col-md-4 control-label" for="input_notes">Notes</label>
							  <div class="col-md-4">                     
							    <textarea class="form-control" id="input_notes" name="input_notes"></textarea>
							  </div>
							</div>

							<div class="form-group " id='date-container-onset'>
							</div>
							<div class="form-group " id='date-container-seen'>
							</div>

							<div class="form-group">
							  <label class="col-md-4 control-label" for="input_lon">Lon</label>  
							  <div class="col-md-4">
							  <input id="input_lon" name="input_lon" type="number" placeholder="e.g. 1.5" class="form-control input-md"> 
							  </div>
							</div>

							<div class="form-group">
							  <label class="col-md-4 control-label" for="input_lat">Lat</label>  
							  <div class="col-md-4">
							  <input id="input_lat" name="input_lat" type="number" placeholder="e.g. 2.1" class="form-control input-md"> 
							  </div>
							</div>

							<div class="form-group">
							 <div class="col-md-4"></div>
							  <div class="col-md-8">
							    <button id="btn_save" type="button" name="btn_save" class="btn btn-info">Done</button>
							  </div>
							</div>

							</fieldset>
						</form>

	                  </div><!-- /.tab-pane -->

	                  <div class="tab-pane" id="tab_2">
	                    <div class="col-md-3"></div>
	                    <div class="col-md-6"><h2>To edit a record, look for the desired record in display, and select the edit button</h2></div>
	                  </div><!-- /.tab-pane -->
	                 
	                </div><!-- /.tab-content -->
	              </div><!-- nav-tabs-custom -->
	            </div><!-- /.col -->
	          </div> <!-- /.row -->
	          <!-- END CUSTOM TABS -->
	    </section><!-- /.content -->

	    <div id="err_box"  class="hide alert alert-danger" role="alert" >
			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			  <span class="sr-only">Error:</span>
			  You do not have access, please login by clicking the login button to the top right
		</div>

		 <div id="success_box"  class="hide alert alert-success" role="alert" >
			  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			  <span class="sr-only">Success:</span>
			  You have inserted/updated the subject's data
		</div>
		<div id="warn_box"  class="hide alert alert-warning" role="alert" >
			  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			  <span class="sr-only">Warning:</span>
			  Could not insert/update subject's data
		</div>

		<div class="modal fade" id="modal_delete" tabindex="-1" role="dialog">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">Are you sure you want to delete ?</h4>
		      </div>
		      <div  class="modal-body">
		      	<b><p>Record:</p></b>
		     	<code id="modal_delete_body"></code>
		     
		      </div>
		      <div class="modal-footer">
		        <button type="button" id="btn_delete_cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
		        <button type="button" id="btn_delete_confirm" class="btn btn-primary" data-dismiss="modal">Confirm</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	</div>

		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.js"></script>
		<script type="text/javascript" src="../js/datatables.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap-datepicker.min.js"></script>
		<script type="text/javascript" src="../js/home.js"></script>
	</body>
</html>