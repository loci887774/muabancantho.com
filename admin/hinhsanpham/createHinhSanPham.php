<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo hình sản phẩm</title>
    <?php include_once __DIR__  . '/../layouts/styles.php'?>
    
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
                ?>

                <form action="" method="post" name="frm-hinhsanpham" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="sp_ma"></label>
                        <select name="sp_ma" id="sp_ma" class="form-select">
                            <option value="">Chọn sản phẩm</option>
                            <?php foreach($arrSanPham as $sp): ?>
                                <option value="<?= $sp['sp_ma'] ?>">
                                    <?= $sp['sp_ten'] ?> 
                                    ( <?= number_format($sp['sp_gia']), 0, '.', ',' ?>) 
                                </option>
                            <?php endforeach; ?>
                        </select>                
                    </div>

                    <div class="mb-3">
                        <label for="hsp-tenteptin">Hình sản phẩm</label>
                        <input type="file" class="form-control" name="hsp_tenteptin" id="hsp_tenteptin">
                    </div>

                    <div class="mb-3">
                        <button name="bntSaveHinhSanPham" class="btn btn-primary">Lưu</button>
                    </div>

                    <?php
                    if(isset($_POST['bntSaveHinhSanPham']) ) {
                        //nếu người dùng có chọn tập tin nào chưa?
                        if(isset($_FILES['hsp_tenteptin']) ) {
                            //Thiết lập múi giờ VN
                            date_default_timezone_set('Asia/Ho_Chi_Minh');

                            //Chuẩn bị đường dẫn đến thư muc mong đợi chứa những tệp tin mà người dùng upload file
                            $upload_dir = __DIR__ . '/../upload/';
                            //các thuộc tính của file
                            // $_FILES['hsp_tenteptin']['name']:       tên của file khi upload
                            // $_FILES['hsp_tenteptin']['type']:       kiểu file 
                            // $_FILES['hsp_tenteptin']['tmp_name']:   đường dẫn đến file tạm trên web server
                            // $_FILES['hsp_tenteptin']['error']:      trạng thái upload, 0 => ko có lỗi
                            // $_FILES['hsp_tenteptin']['size']:       kích thước file

                            //kiểm tra file upload có lỗi không
                            if($_FILES['hsp_tenteptin']['error'] > 0) {
                                echo'Lỗi upload file'; 
                                die;
                            } else {
                                //File đã upload lên server thành công với tên tạm gì đó do web server tự sinh
                                $hsp_tenteptin = date('Ymd_His') . '_' . $_FILES['hsp_tenteptin']['name'];

                                //Di chuyển file từ thư mục tạm của XAMPP -> vào thư mục bạn mong đợi
                                move_uploaded_file($_FILES['hsp_tenteptin']['tmp_name'], $upload_dir . $hsp_tenteptin);
                            }


                            //ĐƯA ẢNH LÊN DB
                            $sp_ma = $_POST['sp_ma'];

                            $sqlInsertHSP = "INSERT INTO hinhsanpham(hsp_tentaptin, sp_ma)
                                            VALUES ('$hsp_tenteptin', $sp_ma)";

                                
                            mysqli_query($conn, $sqlInsertHSP);

                            echo'<script>location.href = "index.php";</script>';

                        }
                    } 
                    ?>
                </form>
            </div>
        </div>
    </div> 

<?php include_once __DIR__  . '/../layouts/scripts.php'?>
</body>
</html>