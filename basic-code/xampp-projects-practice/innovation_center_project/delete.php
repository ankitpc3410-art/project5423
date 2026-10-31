<?php
require "config.php";
$id=(int)($_GET['id']??0);
$stmt=$conn->prepare("SELECT poster FROM innovation_projects WHERE id=?"); $stmt->bind_param("i",$id); $stmt->execute(); $r=$stmt->get_result()->fetch_assoc();
if($r){
  $del=$conn->prepare("DELETE FROM innovation_projects WHERE id=?"); $del->bind_param("i",$id); $del->execute();
  if($r['poster']!=='default.png' && is_file(__DIR__.'/uploads/'.$r['poster'])) unlink(__DIR__.'/uploads/'.$r['poster']);
}
header("Location: display.php"); exit;
?>