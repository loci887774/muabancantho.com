<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm nhà sản xuất</title>
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
            <!-- form nhập nsx mới  -->
            <h1>Thêm nhà sản xuất</h1>
            <form action="" name="frm-them-nsx" method="post">
                <label for="nsx_ten">Tên NSX</label>
                <input type="text" id="nsx_ten" name="nsx_ten" class="form-control mb-3">

                <button id="btnSaveNSX" name="btnSaveNSX" class="btn btn-primary mb-3">Lưu</button>
            </form>
                
                
                <?php
                if(isset($_POST['btnSaveNSX']) ){
                    include_once __DIR__ . '/../../dbconnect.php';

                    $nsx_ten = $_POST['nsx_ten'];

                    $sqlInsertNSX = "INSERT INTO nhasanxuat(nsx_ten) 
                                    VALUES ('$nsx_ten');";
                
                    $dataNSX = mysqli_query($conn, $sqlInsertNSX);

                    $_SESSION['flash_msg'] = "Đã thêm thành công nhà sản xuất <b>$nsx_ten</b>";
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