<?php 
  require_once '../config.php';
  global $CFG;
  require_once ('../lib.php');
  require_once ('../dblib.php');
  global $CFG;
  $as = requiredlogin();
  if(!$as){
    header('Location: '.$CFG->wwwroot.'/public/login.php');
  }
  $rs = isemployee();
  if(!$rs){
    var_dump("You are not authorized to view this page");
    exit;
  }
    
?>
<div class=row-fluid>
  <div class=span4>
    <?php //require_once 'adminpanel.php'; ?>
  </div>
  <div class=span12>
    <form class="form-horizontal" action='annotate.php' method="POST" enctype="multipart/form-data">
      <fieldset>
        <div id="legend">
          <legend class="">Upload File</legend>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="firstname">Student Name<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="firstname" name="firstname" placeholder="" class="input-large">
            <p class="help-block">Enter first and last name</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          
          <div class="controls">
            <input type="hidden" id="id" name="id" placeholder="" class="input-large">
            
          </div>
        </div>
        <div class="control-group">
          <!-- E-mail -->
          <label class="control-label" for="email">E-mail:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="email" name="email" placeholder="" class="input-larg">
            <p class="help-block">Please provide your E-mail</p>
          </div>
        </div>
        <!--<div class="control-group">
          <label class="control-label" for="essay">Essay name:<span style="color:red">*</span></label>
          <div class="controls">
            <input type="text" id="essay" name="essay" placeholder="" class="input-xlarge">
            <p class="help-block">Enter essay name</p>
          </div>
        </div>-->
        <div class="control-group">
        <label class="control-label"  for="firstname">Choose File:</label>
        <div class="controls">
      	 <div class="fileupload fileupload-new" data-prov ides="fileupload">
 			 <span class="btn btn-file"><span class="fileupload-new">Import File</span>
 			 <span class="fileupload-exists">Change</span><input type="file" id="file" name="file"/></span>
 			
  			<span class="fileupload-preview"></span>
            <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
         </div>
          <p class="help-block">Select .txt and .doc file only</p>
         <p class="help-block">OR</p>
         </div>
         </div>
          <div class="controls">
      	 	 <textarea id="textbox" name="text" cols="25" rows="5" placeholder="Copy and paste text here" class="input-large"></textarea>
  			  <p class="help-block"></p>
  		</div>
        <div class="control-group">
          <!-- Button -->
          <div class="controls">
            <button class="btn btn-success" name="submit" type="submit">Upload To Annotate</button>
            <!--<a href="index.php"><button class="btn btn-success" name="submit" type="submit">Go to Workspace</button></a>-->
         </div>
        </div>
    </form>
    </div>
</div>
<?php
 //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "admin";
  //Apply the template
  require_once "../master.php";
?>

<script>
$(document).ready(function(){
	$('.fileupload').fileupload();
	
});
</script>

