<?php
require_once '../config.php';
require_once '../lib.php';
  global $CFG;
  global $USER;
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
<?php
	if(isset($_REQUEST['slip_id'])){
		$slipid = $_REQUEST['slip_id'];
		$query = "SELECT * FROM employee_salary_slip WHERE slip_id = ".$slipid." ORDER BY slip_id desc";
		$rs = $DB->select($query);
		header("Content-type: application/pdf");
		header("Content-Disposition: inline; filename=".$rs['result'][0]['pdf_file_name']);
		@readfile($rs['result'][0]['pdf_file_location'].$rs['result'][0]['pdf_file_name']);
		exit;
	}
	
	?>

<?php
?>
<div class=row-fluid>
	<div class=span4>
		<?php require_once 'adminpanel.php'; ?>
	</div>
	<div class=span8>
		<h3>List of Salary slip</h3>
		<form method=get>
			<select name=employeeid>
 		<?php
 			$query = "SELECT * FROM employee"; 
			$rs = $DB->select($query);
			foreach ($rs['result'] as $key => $value) {
				echo '<option value="'.$value['id'].'">'.$value['first_name'].' '.$value['last_name'].'</option>';
			}
			?>
			</select>
			<button class='btn btn-info' type=submit name=submit>Get Salary Slip</button>
		</form>
			<?php
			if(isset($_REQUEST['submit'])){
				$eid = $_REQUEST['employeeid'];
				$query = "SELECT * FROM employee_salary_slip WHERE emp_id = $eid ORDER BY slip_id desc"; 
				$rs = $DB->select($query);
				//var_dump($rs);
		 		if ($rs['count']) {
	 		 	foreach ($rs['result'] as $key => $value) {
					$line = $value['pdf_file_name'];
					$line = substr($line,0,strlen($line)-4);
					echo "<div><form method=post>Get Salary Slip for \t".$line.": <input type=hidden name=slip_id value=".$value['slip_id']."><button class='btn btn-info' type='submit' name='submit' onClick='window.open('http://localhost/employee/admin/view_employee_salary_slip.php');' >View Salary Slip</button></form></div>";
					

				}
			}else{
				echo '<div class="alert alert-warning">';
			 		echo "No Salary Sleep uploaded";
				echo '</div>';
			}	
			}
 				
		?>	
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