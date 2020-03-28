<?php   
  include($_SERVER['DOCUMENT_ROOT']."/kaizens/connections/kaizens_prd.php");	
  $code = $_REQUEST['code'];
  $field = $_REQUEST['field'];
  $sql = "SELECT id_register, $field FROM tb_registers WHERE id_register = " .$code ;
  $result = mysqli_query($con_kaizens_prd, $sql);
  $image = mysqli_fetch_object($result);
  Header( "Content-type: image/gif");
  echo $image->$field;  
?>