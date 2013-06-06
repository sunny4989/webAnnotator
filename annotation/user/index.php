<?php 
  require_once ('../config.php');
  require_once ('../dblib.php');
  require_once ('../lib.php');
  global $DB;
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
  

  $sql = "SELECT * 
  		  FROM `antr_essay`" ;
  $result=$DB->select($sql);
  //var_dump($result);
  if(isset($_GET['id'])){
  	$eid =  $_GET['id'];
  	$sql = "SELECT * 
  		  FROM `antr_essay` WHERE id=$eid" ;
  	
  	$result=$DB->select($sql);
  	
  	//var_dump($result);
  	foreach ($result['result'] as $key){
  	$directory = $CFG->dataroot.'/'.$key["studentname"]."-".$key["email"].'/';
  	//var_dump($directory);exit;
  	 function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
       } 
     } 
     reset($objects); 
     rmdir($dir); 
   } 
 } 
  rrmdir($directory);

    /*if (@unlink($directory)){
        header('Location: index.php');
    }else {
        die('An error occured');
    }*/
  	}
  	$query = "DELETE FROM `antr_essay` WHERE id=$eid";
  	$rs = $DB->delete($query);
  	
  	
  	if($rs){
  		echo '<div align="center" class="alert alert-success">';
  			echo "Essay deleted Successfully";
  		echo '</div>';
  		header('URL='.$CFG->wwwroot.'/user/index.php');
  	}else{
  		echo '<div class="alert alert-danger">';
  			echo "Something went wrong";
  		echo '</div>';
  	}
  }
  
  /*
   * Query to get employee details
   */
  
  	$sql = "SELECT * 
  		  FROM `antr_essay`" ;
  	$result=$DB->select($sql);
  	
  

?>
<div class=row-fluid>
  <div class=span3>
    <?php //require_once 'panel.php'; ?>
  </div>
  <div class=span11>
    <form class="form-horizontal" action='<?php echo $CFG->wwwroot?>/user/uploadfile.php' method="POST">
      <fieldset>
        <div id="legend">
          <legend>Annotate
          <form class="form-horizontal" action='' method="POST">
          <button class="btn btn-success" name='submit' type=submit>Load New Essay</button>
          
          </form>
          </legend>
        </div>
        <div class="btn-toolbar">
</div>
<div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
           <th>Student</th>
          <th>Submitted Date</th>
          <th>Grade</th>
          <th>Status</th>
		  <!--<th>Email</th>-->
          <th>Action</th>
          <th style="width: 36px;"></th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $i = 1;
        foreach ($result['result'] as $key){?>
        <!--<a href="<?php echo $CFG->wwwroot?>/user/annotate.php?id=<?php echo $key['id']?>&&file=<?php $key['filename']?>">-->
        <tr>
          <td><?php echo $i++;?></td>
          <td><?php echo $key['studentname']."-".$key['email']?></td>
          <td><?php $date = date_default_timezone_set('Asia/Kolkata'); echo date("F j,g:i a",$key['subdate']);?></td>
          <td><?php if(isset($key['grade']) && $key['grade']!=0){
          	echo $key['grade'];
          }else{
          	echo "No Grade";
          }
          	
          
          	
          	
          	?></td>

          <td><?php /*if (isset($key['subdate'])) {
          				echo "Pending";
          			}*/
          			if (isset($key['grade']) && $key['grade'] !=0){
          				echo "Annotated";
          			}else{
          				echo "Pending";
          			}
          
          
          ?></td>
          <!--</a>-->
          <!--<td><form action="" method="POST"><button class="btn btn-success" id="mail" name='submit' type=submit>Send</button></form></td>-->
          <td>
              <a href="<?php echo $CFG->wwwroot?>/user/editannotation.php?id=<?php echo $key['id']?>"><i class="icon-pencil"></i></a>
              <a href="<?php echo $CFG->wwwroot?>/user/index.php?id=<?php echo $key['id']?>" role="button" data-toggle="modal"onclick="return confirm('Are you sure you want to delete?')"><i class="icon-remove"></i></a>
          </td>
        </tr>
       <?php }?>
       
      </tbody>
    </table>
</div>
<div id="example" class="modal hide fade in" style="display: none; ">  
	<div class="modal-header">  
		<a class="close" data-dismiss="modal">×</a>  
		<h3>Write Mail here</h3>  
	</div>  
	<div class="modal-body">
		<textarea Placeholder="Comment here"></textarea>                 
	</div>  
	<div class="modal-footer">  
		<a href="#" class="btn btn-success">Send mail</a>  
		<a href="#" class="btn" data-dismiss="modal">Close</a>  
	</div>  
</div> 
<!--
<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Delete Confirmation</h3>
    </div>
    <div class="modal-body">
        <p class="error-text">Are you sure you want to delete the user?</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-danger" data-dismiss="modal" onclick="">Delete</button>
    </div>
</div>-->
       </fieldset>
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
	var $modal = $('.modal').modal({
    show: false
    });
	$('#mail').on('click', function() {
    $modal.modal('show');
   
    
});
});
</script>