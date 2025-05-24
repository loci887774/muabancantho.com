<?php
session_start();

// 1. Mở kết nối
include_once __DIR__ . '/../../dbconnect.php';
// 2. Chuẩn bị câu lệnh
$dh_ma = $_GET['dh_ma'];
$sqlDeleteCon = "DELETE FROM sanpham_dondathang
                WHERE dh_ma = $dh_ma;";
// 3. Thực thi
mysqli_query($conn, $sqlDeleteCon);

// --------- Xóa cha ---------
// 2. Chuẩn bị câu lệnh
$sqlDeleteCha = "DELETE FROM dondathang
                WHERE dh_ma = $dh_ma;";
// 3. Thực thi
mysqli_query($conn, $sqlDeleteCha);
// 4. Điều hướng
$_SESSION['flash_msg'] = "Đã xóa đơn đặt hàng <b>[$dh_ma]</b> thành công!";
$_SESSION['flash_context'] = 'success';
echo '<script>location.href = "index.php"</script>';
?>