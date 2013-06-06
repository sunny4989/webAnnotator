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
  
  if(isset($_POST['submit'])) {
  	//var_dump($_POST);
  	$name = isset($_POST["firstname"]); 
  	$email = isset($_POST['email']);
  	$essay = isset($_POST["essay"]);
  	$file = isset($_FILES["file"]);
  	$curr = date("F j,g:i a");
  	$date =strtotime($curr);
  	
  	$filename 		= @$_FILES["file"]["name"];
  	$filelocation 	= $CFG->dataroot.'/'.$_POST["firstname"]."-".$_POST["email"].'/';
  	
  	if(isset($_POST['submit'])&& $_POST['text'] =='') {
  		//var_dump($_POST);
  		//echo $filelocation;
  	$insert = -99;
  	//echo $filelocation;
  	//for pdf only 
	  	$allowedExts = array("doc","docx","txt","html");
	  	$extension = end(@explode(".", $_FILES["file"]["name"]));
	  	if ((( @$_FILES["file"]["type"] == "application/msword")
	  			|| (@$_FILES["file"]["type"] == "text/plain")
	  			|| (@$_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
	  			|| (@$_FILES["file"]["type"] == "text/html")
	  			)
	  			&& ($_FILES["file"]["size"] < 2*1024*1024)
	  			&& in_array($extension, $allowedExts)) {
	  		if ($_FILES["file"]["error"] > 0){
	  			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
	  		}else{
          if(@mkdir($filelocation , 0777)){}
	  			if (file_exists($CFG->dataroot.'/'.$_FILES["file"]["name"])){
	  				move_uploaded_file($_FILES["file"]["tmp_name"],
                                  $filelocation.@$_FILES["file"]["name"]);
            echo  '<div align="center" class="alert alert-waring">';
              echo  "File already exists & and is being updated."; 
            echo '</div>';
          }else{
	  			  move_uploaded_file($_FILES["file"]["tmp_name"],$filelocation.$filename);
            $sql = "INSERT IGNORE INTO `antr_essay`(`studentname`, `email`,`filename`, `subdate`,`annotext`)
            VALUES ('$_POST[firstname]','$_POST[email]','$filelocation$filename','$date','')";
            
            
            $insert=$DB->insert($sql);
            //var_dump($insert);exit;
            if (isset($insert)){
              echo  '<div align="center" class="alert alert-success">';
              echo "Essay added Successfully";
              echo '</div>';
            }	
	  			}
	  		}	
	  		}/*else{
	  		echo '<div class="alert alert-danger">';
	  			echo "Invalid file uploaded,Please upload once again, make sure file is doc,txt & size less then 2MB";
	  		echo '</div>';
	  	}*/	
  	
  }else{
  		 $sql = "INSERT IGNORE INTO `antr_essay`(`studentname`, `email`,`filename`, `subdate`,`annotext`)
            VALUES ('$_POST[firstname]','$_POST[email]','','$date','$_POST[text]')";
            $insert=$DB->insert($sql);
            //var_dump($insert);exit;
            if (isset($insert)){
              echo  '<div align="center" class="alert alert-success">';
              echo "Essay added Successfully";
              echo '</div>';
            }
  		
  	}
  	
  }
  if(isset($_POST['savebtn'])){
  	//var_dump($_POST);
  	$text = $_POST["text"]; 
  	$id = $_POST["id"]; 
  	$grade = $_POST["grade"];
  	$comments = $_POST["comments"];
  	$sql ="UPDATE `antr_essay` SET `annotext`='$_POST[text]',`grade`='$_POST[grade]',`comments`='$_POST[comments]'
    	       WHERE id=$id";
  	$update=$DB->update($sql);
          //var_dump($sql);exit;
            if (isset($update)){
              echo  '<div align="center" class="alert alert-success">';
              echo "Annotation added Successfully";
              echo '</div>';
            }
            header("loction:annotate.php");	
	  } 
	  
if (isset($_POST['mailbtn'])) {
	$text = $_POST["text"]; 
  	$id = $_POST["id"]; 
  	$grade = $_POST["grade"];
  	$comments = $_POST["comments"];
  	$sql ="UPDATE `antr_essay` SET `annotext`='$_POST[text]',`grade`='$_POST[grade]',`comments`='$_POST[comments]'
    	       WHERE id=$id";
  	$update=$DB->update($sql);
          
$to       = $_POST['email'];
$subject  = 'Essay Feedback';
$message  = "<html>
<head>
  <title>Annotated Essay</title>
</head>
<body>
	Hi $_POST[firstname],<br>

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
$myFile = @$filelocation.@$filename;
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
	<form action="" method="POST">
	<div class="controls">
      	 	 <textarea rows="15" cols="30" id="textbox" name="text" class="input-xlarge">
      	 	 <?php if (isset($_POST['submit'])&& $_POST['text'] ==''){
      	 	 	//var_dump($_POST);
      	 	 	echo parseWord($myFile);
      	 	 	
      	 	 }else { echo $_POST['text'];}?></textarea>
  			  <p class="help-block"></p>
  		</div>
  		<div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="grade">Grade:</label>
          <div class="controls">
            <input type="text" id="grade" name="grade" placeholder="" class="input-large">
            <p class="help-block">Grade Essay</p>
          </div>
        </div>
        
        <div class="control-group">
          <!-- Username -->
          
          <div class="controls">
            <input type="hidden" id="firstname" name="firstname" value="<?php echo $_POST["firstname"];?>" class="input-large">
            
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          
          <div class="controls">
            <input type="hidden" id="id" name="id" value="<?php echo @$insert;?>" class="input-large">
            
          </div>
        </div>
        <div class="control-group">
          <!-- E-mail -->
          <div class="controls">
            <input type="hidden" id="email" name="email" value="<?php echo $_POST['email'];?>" class="input-large">
          </div>
        </div>
        <div class="control-group">
          <!-- Username -->
          <label class="control-label"  for="comments">Comments:</label>
          <div class="controls">
           
            <input class="textbox" type="textbox" id="comments" name="comments" placeholder="">
            <p class="help-block">Give Comments</p>
          </div>
        </div>
        <div class="control-group">
          <!-- Button -->
          <div class="controls">
            <button class="btn btn-success" name="savebtn" type="submit">Save</button>
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
     $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-?'\n\r\t@\/\_\(\)]/","",$outtext);
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
