<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật loại sản phẩm</title>

    <?php include_once __DIR__ . '/../layouts/styles.php'?>
</head>
<body>
    <div class="container-fluid">
        <!-- dòng header START -->
         <div class="row">
            <div class="col-12">
                <?php include_once __DIR__ . '/../layouts/header.php'?>
            </div> <!-- dòng header END -->
         </div>
        

        
        <div class="row">

            <!-- dòng SIDEBAR -->
            <div class="col-4">
                <?php include_once __DIR__ . '/../layouts/sidebar.php'?>
            </div> <!-- dòng SIDEBAR END -->

            <!-- content -->
            <div class="col-8">
                <h1>Cập nhật loại Sản Phẩm</h1>
               

                <!-- hiển thị lại thông tin loại sản phẩm -->
                <?php
                include_once __DIR__ . '/../../dbconnect.php';

                $lsp_ma = $_GET['lsp_ma'];

                $sqlSelectLoaiSanPham = "SELECT * FROM loaisanpham WHERE lsp_ma=$lsp_ma";

                $executeLoaiSanPhamCu = mysqli_query($conn, $sqlSelectLoaiSanPham);

                $dataLoaiSanPhamCu = mysqli_fetch_array($executeLoaiSanPhamCu, MYSQLI_ASSOC);
                ?>

                <form action="" method="post" name="frmLoaiSanPham" >
                    <div class="mb-3">
                        <label for="lsp_ten">Tên loại sản phẩm</label>
                        <input type="text" name="lsp_ten" id="lsp_ten" class="form-control" 
                            value="<?= $dataLoaiSanPhamCu['lsp_ten']?>">
                    </div>

                    <div class="mb-3">
                        <label for="lsp_mota">Mô tả</label>
                        <input type="text" name="lsp_mota" id="lsp_mota" class="form-control" 
                            value="<?= $dataLoaiSanPhamCu['lsp_mota']?>" >
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary" name='btnSaveLoaiSanPham'>Lưu</button>
                    </div>
                </form>  

                <?php
                if(isset($_POST['btnSaveLoaiSanPham']) ) {
                    include_once __DIR__ . '/../../dbconnect.php';

                    $lsp_ten = $_POST['lsp_ten'];
                    $lsp_mota = $_POST['lsp_mota'];

                    $sqlUpdateLoaiSanPham = "
                    UPDATE loaisanpham 
                    SET 
                        lsp_ten = '$lsp_ten',
                        lsp_mota = '$lsp_mota'
                    WHERE lsp_ma = $lsp_ma;
                    ";

                    mysqli_query($conn, $sqlUpdateLoaiSanPham);

                    $_SESSION['flash_msg'] = "Đã cập nhật loại sản phẩm <b>$lsp_ten</b> thành công!";
                    $_SESSION['flash_context'] = "success";

                    echo "<script>location.href = 'index.php'; </script>";

                }
                ?>
            </div>
        </div>
         
        <!-- dòng FOOTER START -->
        <div class="row">
            <div class="col-12">
                <?php include_once __DIR__ . '/../layouts/footer.php'; ?>
            </div>
         </div>
        <!-- dòng FOOTER END -->
    </div>

	<!-- nạp các file js ở cuối trang để tăng tốc độ tải trang -->
    <?php include_once __DIR__ . '/../layouts/scripts.php'; ?>

    </div>
</body>
</html>