<?php 
  require_once '../config.php';
  global $CFG;
  require_once ('../lib.php');
  require_once ('../dblib.php');
  //require_once('uploadfile.php');
  global $CFG;
  $id =-99;
  if(isset($_REQUEST['id']))
  {
  	$id = $_REQUEST['id'];
  }else{
  	echo 'no id set';
  	exit;
  }
  $sql="SELECT `annotext`, `grade`,`comments` 
  		FROM `antr_essay` 
  		WHERE id=$id";
  $getdata=$DB->select($sql);
  //var_dump($getdata);
  foreach ($getdata['result'] as $key){
  ?>
	<div class="controls">
      	 	 <textarea rows="15" cols="30" id="textbox" name="text" class="input-xlarge" value=""><?php echo (htmlspecialchars($key['annotext']));?></textarea>
  			  <p class="help-block"></p>
  		</div>
  		<div class="control-group">
          <label class="control-label"  for="Grade">Grade:<?php echo $key['grade'];?></label>
        </div>
        <div class="control-group">
          <label class="control-label"  for="firstname">Comments:<br><?php echo (htmlspecialchars($key['comments']));?></label>
          
        </div>
  <?php }?>
<?php

 //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "admin";
  //Apply the template
  require_once "../master.php";
  ?>
