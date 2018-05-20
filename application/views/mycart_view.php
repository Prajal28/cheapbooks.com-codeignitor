<?php
if(!isset($_SESSION['basket'])){
  $_SESSION['basket'] = array();
  
}
if($_GET['ISBN']!=null && $_GET['title'] != null){
  $isbn = $_GET['ISBN'];  
  if(!isset($_SESSION['basket'][$isbn])){
    $_SESSION['basket'][$isbn] = 1;
  }else{
    $quantityOfItem = $_SESSION['basket'][$isbn];
    $row = $_SESSION['searchResults'][$isbn];
    if($row['number'] > $quantityOfItem){
      $quantityOfItem = $quantityOfItem + 1;
      $_SESSION['basket'][$isbn] = $quantityOfItem;
    }
  }
  $totalCount = 0;
  foreach($_SESSION['basket'] as $key=>$value){
    $totalCount += $value;
  }  
  echo "Counter - " .$totalCount;  
}
?>
