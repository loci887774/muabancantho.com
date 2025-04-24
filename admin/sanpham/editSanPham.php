<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật sản phẩm</title>
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
            <div class="col-4">
                <?php include_once __DIR__ . '/../layouts/sidebar.php'; ?>
            </div>

            <div class="col-8">
                <h1>Cập nhật sản phẩm</h1>

                <!-- php truy vấn loại sản phẩm -->
                <?php
                include_once __DIR__ . '/../../dbconnect.php';

                $sp_ma = $_GET['sp_ma'];
                
                $sqlSanPhamCu = "SELECT * FROM sanpham 
                                WHERE sp_ma = $sp_ma;";

                $data = mysqli_query($conn, $sqlSanPhamCu);

                
                $dataSanPhamCu = mysqli_fetch_array($data, MYSQLI_ASSOC);


                // php truy vấn loại sản phẩm
                $sqlSelectLoaiSanPham = "SELECT * FROM loaisanpham;";

                $dataLoaiSanPham = mysqli_query($conn, $sqlSelectLoaiSanPham);

                $arrDanhSachLoaiSanPham = [];

                while($row = mysqli_fetch_array($dataLoaiSanPham, MYSQLI_ASSOC)) {
                    $arrDanhSachLoaiSanPham[] = array(
                        'lsp_ma' => $row['lsp_ma'],
                        'lsp_ten' => $row['lsp_ten']
                    );
                }   

                // php truy vấn nhà sản xuất
                $sqlSelectNhaSanXuat = "SELECT * FROM nhasanxuat;";

                $dataNhaSanXuat = mysqli_query($conn, $sqlSelectNhaSanXuat);

                $arrDanhSachNhaSanXuat = [];

                while($row = mysqli_fetch_array($dataNhaSanXuat, MYSQLI_ASSOC)) {
                    $arrDanhSachNhaSanXuat[] = array (
                        'nsx_ma' => $row['nsx_ma'],
                        'nsx_ten' => $row['nsx_ten']
                    );
                } 

                //truy vấn khuyến mãi
                $sqlSlectKhuyenMai = "SELECT * FROM khuyenmai;";

                $dataKhuyenMai = mysqli_query($conn, $sqlSlectKhuyenMai);

                $arrDanhSachKhuyenMai = [];

                while($row = mysqli_fetch_array($dataKhuyenMai, MYSQLI_ASSOC) ) {
                    $arrDanhSachKhuyenMai[] = array (
                        'km_ma' => $row['km_ma'],
                        'km_ten' => $row['km_ten'],
                        'km_noidung' => $row['km_noidung'],
                        'km_tungay' => $row['km_tungay'],
                        'km_denngay' => $row['km_denngay']   
                    );
                }
                ?>


                <form action="" method="post" name='frmCreate'>

                    <div class="mb-3">
                        <label for="lsp_ma" class="form-label">Loại sản phẩm</label>
                        <select name="lsp_ma" id="lsp_ma" class="form-control" required>
                            <option value="">Chọn loại sản phẩm</option>
                            <?php foreach($arrDanhSachLoaiSanPham as $lsp): ?>
                                
                                <?php if($lsp['lsp_ma'] == $dataSanPhamCu['lsp_ma']): ?>
                                    <option value="<?= $lsp['lsp_ma'] ?>" selected>
                                        <?= $lsp['lsp_ten'] ?>
                                    </option>

                                    <?php else: ?>
                                        <option value="<?= $lsp['lsp_ma'] ?>" >
                                            <?= $lsp['lsp_ten'] ?>
                                        </option>

                                    <?php endif; ?>                            
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nsx_ma" class="form-label">Nhà sản xuất</label>
                        <select name="nsx_ma" id="nsx_ma" class="form-control" required>
                            <option value="">Chọn nhà sản xuất</option>
                            <?php foreach($arrDanhSachNhaSanXuat as $nsx): ?>
                                <?php if($nsx['nsx_ma']  == $dataSanPhamCu['nsx_ma']):?>
                                    <option value="<?= $nsx['nsx_ma'] ?>" selected>
                                        <?= $nsx['nsx_ten'] ?>
                                    </option>
                                <?php else: ?>  
                                    <option value="<?= $nsx['nsx_ma'] ?>" >
                                        <?= $nsx['nsx_ten'] ?>
                                    </option>
                                    <?php endif; ?>                       
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="km_ma" class="form-label">Khuyến mãi</label>
                        
                        <select name='km_ma' id='km_ma' class='form-control' require >
                            <option value="">Chọn hình thức khuyến mãi</option>
                            <?php foreach($arrDanhSachKhuyenMai as $km):?>
                                <?php if($km['km_ma'] == $dataSanPhamCu['km_ma']):?>
                                    <option value='<?=$km['km_ma']?>' selected>
                                        <?=$km['km_ten']?>
                                        <?=$km['km_noidung']?>
                                        (
                                            <!-- hàm strtotime() chuyển đổi chuỗi ngày tháng sang định dạng timestamp -->
                                            <?= date('d/m/Y', strtotime($km['km_tungay'])) ?> 
                                            - <?= date('d/m/Y', strtotime($km['km_denngay'])) ?>
                                        )
                                    </option>
                                <?php else:?>
                                    <option value='<?=$km['km_ma']?>'>
                                        <?=$km['km_ten']?>
                                        <?=$km['km_noidung']?>
                                        (
                                            <!-- hàm strtotime() chuyển đổi chuỗi ngày tháng sang định dạng timestamp -->
                                            <?= date('d/m/Y', strtotime($km['km_tungay'])) ?> 
                                            - <?= date('d/m/Y', strtotime($km['km_denngay'])) ?>
                                        )
                                    </option>
                                <?php endif; ?>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sp_ten" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="sp_ten" name="sp_ten" 
                            value="<?= $dataSanPhamCu['sp_ten'] ?>">
                    </div>
                    <div class="row gia">
                        <div class="col-4 mb-3">
                            <label for="sp_gia" class="form-label">Giá sản phẩm</label>
                            <input type="number" class="form-control" id="sp_gia" name="sp_gia"  
                                value="<?= $dataSanPhamCu['sp_gia'] ?>">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="sp_giacu" class="form-label">Giá cũ</label>
                            <input type="number" class="form-control" id="sp_giacu" name="sp_giacu"  
                                value="<?= $dataSanPhamCu['sp_giacu'] ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sp_mota_ngan" class="form-label">Mô tả ngắn</label>
                        <textarea class="form-control" id="sp_mota_ngan" name="sp_mota_ngan">
                            <?= $dataSanPhamCu['sp_mota_ngan'] ?>
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="sp_mota_chitiet" class="form-label">Mô tả chi tiết</label>
                        <textarea class="form-control" id="sp_mota_chitiet" name="sp_mota_chitiet">
                            <?= $dataSanPhamCu['sp_mota_chitiet'] ?>
                        </textarea>
                    </div>
                    <div class="col-2 mb-3">
                        <label for="sp_soluong" class="form-label">Số lượng</label>
                        <input type="number" class="form-control" id="sp_soluong" name="sp_soluong"
                            value="<?= $dataSanPhamCu['sp_soluong'] ?>"> 
                    </div>

                    <div>
                        <a href="index.php" class="btn btn-outline-secondary">Quay về danh sách</a>
                        <button class="btn btn-primary" name="btnSave">Lưu</button>
                    </div>
                </form>   
                <?php
                    //đặt múi giờ
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    //kiểm tra người dùng nhấn nút save
                    if( isset($_POST['btnSave']) ) {
                        //1. mở kết nối
                        include_once __DIR__. '/../../dbconnect.php';
                        //2. chuẩn bị câu lệnh
                        $lsp_ma = $_POST['lsp_ma'];
                        $nsx_ma = $_POST['nsx_ma'];
                        $sp_ten = $_POST['sp_ten'];
                        $sp_gia = $_POST['sp_gia'];
                        $sp_giacu = empty($_POST['sp_giacu']) ? 'NULL' : $_POST['sp_giacu'];
                        $sp_mota_ngan = $_POST['sp_mota_ngan'];
                        $sp_mota_chitiet = $_POST['sp_mota_chitiet'];
                        $sp_soluong = $_POST['sp_soluong'];
                        $km_ma =empty( $_POST['km_ma']) ? 'NULL' : $_POST['km_ma'];
                        $sp_ngaycapnhat = date('Y-m-d H:i:s');

                        $sqlUpdate = "
                            UPDATE sanpham
                            SET
                                sp_ten='$sp_ten',
                                sp_gia= $sp_gia,
                                sp_giacu= $sp_giacu,
                                sp_mota_ngan='$sp_mota_ngan',
                                sp_mota_chitiet='$sp_mota_chitiet',
                                sp_ngaycapnhat = '$sp_ngaycapnhat' ,
                                sp_soluong= $sp_soluong,
                                lsp_ma= $lsp_ma,
                                nsx_ma= $nsx_ma,
                                km_ma= $km_ma
                            WHERE sp_ma= $sp_ma;";
                        //3. thực thi câu lệnh
                        mysqli_query($conn, $sqlUpdate);
                        //4.thành công
                        //4.1 lưu session thông báo
                        $_SESSION['flash_msg'] = "Đã cập nhật sản phẩm <b>$sp_ten</b> thành công!";
                        $_SESSION['flash_context'] = "success";
                        //4.2 điều hướng về trang sản phẩm
                        echo "<script>
                           location.href = 'index.php';
                        </script>";

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

    <?php
    include_once __DIR__ . '/../layouts/scripts.php';
    ?>
</body>
</html>