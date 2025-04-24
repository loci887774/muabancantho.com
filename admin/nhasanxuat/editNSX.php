<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa nhà sản xuất</title>
    <?php
    include_once __DIR__ . '/../layouts/styles.php';
    ?>
</head>
<body>
    <div class="container-fluid">
        <!-- dòng header START -->
        <div class="row">
            <div class="col-12">
                <?php
                include_once __DIR__ . '/../layouts/header.php';
                ?>
            </div>
        </div>
        <!-- dòng header END -->

        <!-- dòng SIDEBAR & CONTENT START -->
        <div class="row">
            <!-- sidebar  -->
            <div class="col-4">
                <?php
                include_once __DIR__ . '/../layouts/sidebar.php';
                ?>
            </div>

            <!-- content  -->
            <div class="col-8">

            <!-- LẤY NỘI DUNG CỦA NSX TRƯỚC KHI CẬP NHẬT -->
            <?php
            include_once __DIR__ . '/../../dbconnect.php';

            $nsx_ma = $_GET['nsx_ma'];

            $sqlSelectNSXcu = "SELECT * FROM nhasanxuat WHERE nsx_ma = $nsx_ma;";

            $dataNSXcu = mysqli_query($conn, $sqlSelectNSXcu);

            $rowNSXcu = mysqli_fetch_array($dataNSXcu, MYSQLI_ASSOC);
            // 'nsx_ma' => $rowNSXcu['nsx_ma'];
            // 'nsx_ten' => $rowNSXcu['nsx_ten'];
            ?>

            <!-- form nhập nsx mới  -->
            <h1>Cập nhật nhà sản xuất</h1>
            <form action="" name="frm-them-nsx" method="post">
                <label for="nsx_ten">Tên NSX</label>
                <input type="text" id="nsx_ten" name="nsx_ten" class="form-control mb-3" value="<?= $rowNSXcu['nsx_ten'] ?>">

                <button id="btnSaveNSX-update" name="btnSaveNSX-update" class="btn btn-primary mb-3">Cập nhật</button>
            </form>
                
                
                <?php
                if(isset($_POST['btnSaveNSX-update']) ){ 

                    $nsx_ma = $_GET['nsx_ma'];
                    $nsx_ten = $_POST['nsx_ten'];

                    $sqlUpdateNSX = "UPDATE nhasanxuat
                                    SET nsx_ten='$nsx_ten'
                                    WHERE nsx_ma = $nsx_ma ;";
                
                    $dataNSX = mysqli_query($conn, $sqlUpdateNSX );

                    $_SESSION['flash_msg'] = "Đã cập nhật thành công nhà sản xuất <b>$nsx_ten</b>";
                    $_SESSION['flash_context'] = "success";


                    echo'<script> location.href = "index.php";
                        </script>';
                }               
                ?>                
            </div>
        </div>
        <!-- dòng SIDEBAR & CONTENT END -->

        <!-- dòng FOOTER START -->
         <div class="row">
            <div class="col-12">
                <?php
                include_once __DIR__ . '/../layouts/footer.php';
                ?>
            </div>
         </div>
        <!-- dòng FOOTER END -->
    </div>

    <!-- nạp các file js ở cuối trang để tăng tốc độ tải trang -->
    <?php
    include_once __DIR__ . '/../layouts/scripts.php';
    ?>
</body>
</html>