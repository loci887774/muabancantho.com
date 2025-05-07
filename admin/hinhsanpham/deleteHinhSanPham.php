<?php

    use Dom\Mysql;

    session_start(); 

    include_once __DIR__ . '/../../dbconnect.php';

    $hsp_ma = $_GET['hsp_ma'];

    //------------------- XÓA FILE ẢNH TRONG TẬP TIN UPLOAD -------------------
    $sqlDongMuonXoa = "SELECT * FROM hinhsanpham WHERE hsp_ma = $hsp_ma";

    $dataDongMuonXoa = mysqli_query($conn, $sqlDongMuonXoa);

    $rowDongMuonXoa = mysqli_fetch_array($dataDongMuonXoa, MYSQLI_ASSOC);

    // xóa file ảnh trên thư mục upload để tránh file rác
    $upload_dir = __DIR__ .'/../upload/';
    $file_path_delete = $upload_dir . $rowDongMuonXoa['hsp_tentaptin'];

    //kiểm tra đường dẫn có tồn tại không rồi xóa đường dẫn đó
    if(file_exists($file_path_delete)) {
        unlink($file_path_delete);
    }

    //------------------- XÓA FILE ẢNH TRONG DATABASE -------------------

    $sqlDeleteHSP = "DELETE FROM hinhsanpham WHERE hsp_ma = $hsp_ma";

    mysqli_query($conn, $sqlDeleteHSP);

    $_SESSION['flash-msg'] = "Đã xóa thành công ảnh <b>$hsp_ma</b>";
    $_SESSION['flash-context'] = "danger";

    echo'
        <script> location.href = "index.php" </script>
    ';

?>

