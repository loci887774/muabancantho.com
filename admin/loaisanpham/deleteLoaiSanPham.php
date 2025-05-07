<?php
session_start();

include_once __DIR__ . '/../../dbconnect.php';

$lsp_ma = $_GET['lsp_ma'];

$sqlDelete = "DELETE FROM loaisanpham WHERE lsp_ma = $lsp_ma;";

mysqli_query($conn, $sqlDelete);

$_SESSION['flash_msg'] = "Đã xóa loại sản phẩm <b>$lsp_ma</b> thành công!";
$_SESSION['flash_context'] = "danger";

echo '<script>
        location.href = "index.php";
    </script>';
?> 

