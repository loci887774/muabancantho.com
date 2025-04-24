<?php
session_start();

include_once __DIR__ . '/../../dbconnect.php';

$sp_ma = $_GET['sp_ma'];

$sqlDeleteSanPham = "DELETE FROM sanpham WHERE sp_ma = $sp_ma;";

mysqli_query($conn, $sqlDeleteSanPham);

$_SESSION['flash_msg'] = "Đã xóa sản phẩm <b>$sp_ma</b> thành công!";
$_SESSION['flash_context'] = 'danger';

header('Location: index.php');
exit();
?>