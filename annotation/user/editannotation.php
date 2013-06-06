<?php 
  require_once '../config.php';
  global $CFG;
  require_once ('../lib.php');
  require_once ('../dblib.php');
  //require_once('uploadfile.php');
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
  
  if(isset($_GET['id'])){
  	$id =  $_GET['id'];
  	$sql = "SELECT * 
  		  FROM `antr_essay` WHERE id=$id" ;
  	
  	$result=$DB->select($sql);
  	//var_dump($result);
 	
  }
  foreach ($result['result'] as $key){
  	$myFile = $key['filename'];
  }
    if(isset($_POST['submit'])){
    	
    	$text		=$_POST['text'];
    	$grade		=$_POST['grade'];
    	$comments	=$_POST['comments'];
    	$sql ="UPDATE `antr_essay` SET `annotext`='$text',`grade`=$grade,`comments`='$comments'
    	       WHERE id=$id";
    	$update=$DB->update($sql);
    	//var_dump($update);EXIT;
            //var_dump($sql);
            if (isset($update)){
              echo  '<div align="center" class="alert alert-success">';
              echo "Annotation Updated Successfully";
              echo '</div>';
            }	
	  }
	if (isset($_POST['mailbtn'])) {
  	$sql ="UPDATE `antr_essay` SET `annotext`='$_POST[text]',`grade`='$_POST[grade]',`comments`='$_POST[comments]'
    	       WHERE id=$id";
  	$update=$DB->update($sql);
          //var_dump($sql);exit;
            /*if (isset($update)){
              echo  '<div align="center" class="alert alert-success">';
              echo "Annotation added Successfully";
              echo '</div>';
            }*/
  foreach ($result['result'] as $key){
$to       = $key['email'];
  
$subject  = 'Essay Feedback';
$message  = "<html>
<head>
  <title>Annotated Essay</title>
</head>
<body>
	Hi $key[studentname],<br>

	Instructor has annotated the essay you submitted for annotate.<br>

    Your annotated essay, along wth annotations and comments, is available at the following link:

    <p><a href='$CFG->wwwroot/user/viewannotation.php?id=$id'>click here</a></p>
	
	
    Thanks,<br>
    Instructor
</body>
</html>";
$headers  = 'From:mallu048@gmail.com' . "\r\n" .
			'Reply-To: sender@gmail.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
 if (mail($to, $subject, $message, $headers)){
              echo  '<div align="center" class="alert alert-success">';
              echo "Email sent";
              echo '</div>';
            }else{
            	echo  '<div align="center" class="alert alert-danger">';
              	echo "Email not sent";
              	echo '</div>';
            }
            
}
	}

	  

 //var_dump($myFile);
 
	?>
	
	<div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="Grade"></label>
          <div class="controls">
            <a href="uploadfile.php"><button class="btn btn-success" name='submit' type=submit>Load New Essay</button></a>
            <a href="index.php"><button class="btn btn-success" name='submit' type=submit>Go to workspace</button></a>
            <p class="help-block"></p>
          </div>
        </div>
        <?php foreach ($result['result'] as $key){?>
	<form action="" method="POST">
	<div class="controls">
      	 	 <textarea rows="15" cols="30" id="textbox" name="text" class="input-xlarge"><?php echo (htmlspecialchars($key['annotext']));?></textarea>
  			  <p class="help-block"></p>
  		</div>
  		<div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="Grade">Grade:</label>
          <div class="controls">
            <input type="text" id="grade" name="grade" value="<?php echo $key['grade'];?>" placeholder="">
            <p class="help-block">Grade the essay</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="Comments">Comments:</label>
          <div class="controls">
            <input class="textbox "type="textbox" value="<?php echo $key['comments'];}?>" id="comments" name="comments">
            <p class="help-block">Give Comments</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Button -->
          <div class="controls">
            <button class="btn btn-success" name="submit" type="submit">Save</button>
            <button class="btn btn-success" name="mailbtn" type="submit">Send mail</button>
            <!--<a href="index.php"><button class="btn btn-success" name="submit" type="submit">Go to Workspace</button></a>-->
         </div>
        </div>
        </form>
  <?php
  function parseWord($userDoc) {
    $fileHandle = fopen($userDoc, "r");
    $line = @fread($fileHandle, filesize($userDoc));   
    $lines = explode(chr(0x0D),$line);
    $outtext = "";
    foreach($lines as $thisline)
      {
        $pos = strpos($thisline, chr(0x00));
        if (($pos !== FALSE)||(strlen($thisline)==0))
          {
          } else {
            $outtext .= $thisline." ";
          }
      }
     $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
    return $outtext;
}
?>
<?php

 //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "admin";
  //Apply the template
  require_once "../master.php";
  ?>
