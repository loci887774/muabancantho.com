<?php
session_start();

include_once __DIR__ . '/../../dbconnect.php';

$nsx_ma = $_GET['nsx_ma'];

$sqlDeleteNSX = "DELETE FROM nhasanxuat WHERE nsx_ma = $nsx_ma;";

mysqli_query($conn, $sqlDeleteNSX);

$_SESSION['flash_msg'] = "Đã xóa thành công NSX <b>$nsx_ma</b>";
$_SESSION['flash_context'] = 'danger';

echo '<script> location.href = "index.php"; </script>';
?>