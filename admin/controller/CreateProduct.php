<?php
require_once ("../config/Config.php");
require_once (ROOT_PATH . "core/init.php");


if (empty($_SESSION['admin_security_token'])) {
    $_SESSION['admin_security_token'] = bin2hex(random_bytes(32));
}

header('Content-Type: application/json');

$headers = apache_request_headers();
if (isset($headers['CsrfToken'])) {
    if (!hash_equals($headers['CsrfToken'], $_SESSION['admin_security_token'])) {
        exit(json_encode(['error' => 'Wrong CSRF token.']));
        die();
    }
} else {
    exit(json_encode(['error' => 'No CSRF token.']));
    die();
}

//check if there is a post
if(isset($_POST)){
  // sanitize the post
  $validation_error = false;
  foreach($_POST as $key => $value){
    // sanitze the inputs
    $sanitized_value = sanitize($value, 'string');
    //check if the value is not Empty
    if($sanitized_value != ''){//replace the post value with the sanitizes value
      $_POST[$key] = $sanitized_value;
    }else{
      $validation_error = true;
    }
  }
}else{
  exit(json_encode(['error' => 'No Input Specified.']));
  die();
}

// check if there is any dirty input
if(isset($validation_error) && $validation_error == true){
  exit(json_encode(['error' => 'Faulty Input.']));
  die();
}

//check for the form_picture
if(!isset($_FILES['product_picture'])){
  exit(json_encode(['error' => 'Please upload product picture.']));
  die();
}else{
  //check the file type
  $extension = pathinfo($_FILES['product_picture']['name'], PATHINFO_EXTENSION);
  $file_type = array('jpg','png','jpeg');
  if(!in_array($extension, $file_type)){
    exit(json_encode(['error' => 'Unsupported picture format']));
    die();
  }

  //check the size of the picture
  list($len, $bre,) = getimagesize($_FILES['product_picture']['tmp_name']);
  if($len < 1024 || $bre < 1024){
    exit(json_encode(['error' => 'Please upload product picture of at least 1024px X 1024px for a better resolution']));
    die();
  }
}

//Process the request
try{
  extract($_POST);
  //save the picture of the item
  $upload_dir = "../../images/product_picture/"; // instatate the directory to move the picture file to
  $file_name= $product_name."_".$product_price."_".date('Y-m-d').".".pathinfo($_FILES['product_picture']['name'], PATHINFO_EXTENSION); // Save the picture file with the title
  $tmp = $_FILES['product_picture']['tmp_name'];// get the temporary name of the PDF file
  $file_path = $upload_dir.$file_name;
  //move the picture tothe permanet folder
  try{
      move_uploaded_file($tmp,$file_path);
  }catch(Exception $e){
      die($e->getMessage());
  }

  //create the product
  $create_product = new Crud();
  $create_product
  ->create('products', array(
    'product_name' => $product_name,
    'product_category' => $product_category,
    'product_price' => $product_price,
    'product_description' => $product_desc,
    'product_picture' => $file_name,
    'added_by' => $_SESSION['admin_id'],
    'date_added' =>  date('Y-m-d')
  ));
  Session::flash('product_created', $product_name.' was created successfully!');
  exit(json_encode(['success' => 'created']));
  die();

}catch(Exception $e){
  die($e->getMessage());
}
