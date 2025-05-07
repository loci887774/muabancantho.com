<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật hình sản phẩm</title>
    <?php include_once __DIR__  . '/../layouts/styles.php'?>

    <style>
        .anh-muon-sua{
            width: 500px;
            border: 3px dashed red;
        }
    </style>

</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include_once __DIR__  . '/../layouts/header.php'?>
            </div>
        </div>

        <div class="row">
            <div class="col-3">
                <?php include_once __DIR__  . '/../layouts/sidebar.php'?>
            </div>

            <!-- CONTENT -->
            <div class="col-9">

            <!-- lấy thông tin sản phẩm để user chọn  -->
                <?php
                include_once __DIR__  . '/../../dbconnect.php';

                $sqlSelectSanPham =  "SELECT * FROM sanpham;";

                $dataSanPham = mysqli_query($conn, $sqlSelectSanPham);

                $arrSanPham = [];

                while($row = mysqli_fetch_array($dataSanPham, MYSQLI_ASSOC)) {
                    $arrSanPham[] = array (
                        'sp_ma' => $row['sp_ma'],
                        'sp_ten' => $row['sp_ten'],
                        'sp_gia' => $row['sp_gia']
                    );
                }

                // LẤY THÔNG TIN ẢNH CŨ 
                $hsp_ma = $_GET['hsp_ma'];

                $sqlDongMuonSua = "SELECT * FROM hinhsanpham WHERE hsp_ma = $hsp_ma";

                $dataDongMuonSua = mysqli_query($conn, $sqlDongMuonSua);
            
                $rowDongMuonSua = mysqli_fetch_array($dataDongMuonSua, MYSQLI_ASSOC);

                ?>

                <h1>Cập nhật hình sản phẩm</h1>
                <form action="" method="post" name="frm-hinhsanpham" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="sp_ma"></label>
                        <select name="sp_ma" id="sp_ma" class="form-select">    

                            <?php foreach($arrSanPham as $sp): ?>

                                <?php if($rowDongMuonSua['sp_ma'] == $sp['sp_ma']):?> 
                                    <option value="<?= $sp['sp_ma'] ?>" selected >
                                        <?= $sp['sp_ten'] ?> 
                                        ( <?= number_format($sp['sp_gia']), 0, '.', ',' ?>) 
                                    </option>

                                <?php else: ?>
                                    <option value="<?= $sp['sp_ma'] ?>">
                                        <?= $sp['sp_ten'] ?> 
                                        ( <?= number_format($sp['sp_gia']), 0, '.', ',' ?>) 
                                    </option>

                                <?php endif; ?>

                            <?php endforeach; ?>

                        </select>                
                    </div>

                    <!-- ảnh cũ  -->
                    <div class="mb-3">
                        <img src="/muabancantho.com/admin/upload/<?= $rowDongMuonSua['hsp_tentaptin'] ?>" alt="" class="anh-muon-sua">
                    </div>

                    <!-- ảnh cần cập nhật  -->
                    <div class="mb-3">
                        <label for="hsp_tentaptin">Cập nhật ảnh</label>
                        <input type="file" class="form-control" name="hsp_tentaptin" id="hsp_tentaptin">
                    </div>

                    <div class="mb-3">
                        <button name="bntSaveHinhSanPham" class="btn btn-primary">Lưu</button>
                    </div>


                    <!-- ĐƯA ẢNH LÊN FILE UPLOAD VÀ DATABASE  -->
                    <?php
                    if(isset($_POST['bntSaveHinhSanPham']) ) {

                        //Lưu trữ lại hình cũ - chỉ đổi tên sản phẩm
                        $hsp_tentaptin = $rowDongMuonSua['hsp_tentaptin'];

                        //kiểm tra xem user có chọn tập tin chưa
                        if( isset($_FILES['hsp_tentaptin']) && !empty($_FILES['hsp_tentaptin']['name']) ) {

                            //Thiết lập múi giờ VN
                            date_default_timezone_set('Asia/Ho_Chi_Minh');

                            $upload_dir = __DIR__ . '/../upload/';

                            if($_FILES['hsp_tentaptin']['error'] > 0) {
                                echo'Lỗi upload file'; 
                                die;
                            } else {
                                // xóa file ảnh trên thư mục upload để tránh file rác
                                $file_path_delete = $upload_dir . $rowDongMuonSua['hsp_tentaptin'];

                                //kiểm tra đường dẫn có tồn tại không rồi xóa đường dẫn đó
                                if(file_exists($file_path_delete)) {
                                    unlink($file_path_delete);
                                }

                                //File đã upload lên server thành công với tên tạm gì đó do web server tự sinh
                                $hsp_tentaptin = date('Ymd_His') . '_' . $_FILES['hsp_tentaptin']['name'];

                                //Di chuyển file từ thư mục tạm của XAMPP -> vào thư mục bạn mong đợi
                                move_uploaded_file($_FILES['hsp_tentaptin']['tmp_name'], $upload_dir . $hsp_tentaptin);
                            }
                        }

                        //2. ĐƯA ẢNH LÊN DB
                        $sp_ma = $_POST['sp_ma'];

                        $sqlInsertHSP = "UPDATE hinhsanpham
                                            SET
                                                hsp_tentaptin = '$hsp_tentaptin',
                                                sp_ma = $sp_ma
                                            WHERE hsp_ma = $hsp_ma;";
                            
                        mysqli_query($conn, $sqlInsertHSP);

                        echo'<script>location.href = "index.php";</script>';
                    } 
                    ?>
                </form>
            </div>
        </div>
    </div>


<?php include_once __DIR__  . '/../layouts/scripts.php'?>
</body>
</html>