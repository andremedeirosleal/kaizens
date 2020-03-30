<?php   
  include($_SERVER['DOCUMENT_ROOT']."/kaizens/connections/kaizens_prd.php");	
  $code = $_REQUEST['code'];
  $field = $_REQUEST['field'];
  if($field == '1') $field = "bl_photo_before";
  if($field == '2') $field = "bl_photo_after";
  $sql = "SELECT id_register, $field FROM tb_register_photos WHERE id_register = " .$code ;
  $result = mysqli_query($con_kaizens_prd, $sql);
  $image = mysqli_fetch_object($result);
  Header( "Content-type: image/gif");
  echo $image->$field;  
?>