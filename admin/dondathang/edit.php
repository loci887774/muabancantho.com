<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Đơn đặt hàng</title>
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
                <?php
                include_once __DIR__ . '/../layouts/sidebar.php';
                ?>
            </div>
            <div class="col-8">
                <h1>Sửa Đơn đặt hàng</h1>
                <?php
                // 1. Mở kết nối
                include_once __DIR__ . '/../../dbconnect.php';
                // 2. Chuẩn bị câu lệnh
                $sqlSelectHinhThucThanhToan = "SELECT *
                                            FROM hinhthucthanhtoan;";
                // 3. Thực thi
                $resultHinhThucThanhToan = mysqli_query($conn, $sqlSelectHinhThucThanhToan);
                // 4. Phân tách dữ liệu thành mảng array trong PHP
                $arrDanhSachHinhThucThanhToan = [];
                while($row = mysqli_fetch_array($resultHinhThucThanhToan, MYSQLI_ASSOC)) {
                    $arrDanhSachHinhThucThanhToan[] = array(
                        'httt_ma' => $row['httt_ma'],
                        'httt_ten' => $row['httt_ten'],
                    );
                }
                // --------  Lấy dữ liệu khách hàng -----------
                // 2. Chuẩn bị câu lệnh
                $sqlSelectKhachHang = "SELECT *
                                    FROM khachhang;";
                // 3. Thực thi
                $resultKhachHang = mysqli_query($conn, $sqlSelectKhachHang);
                // 4. Phân tách dữ liệu thành mảng array trong PHP
                $arrDanhSachKhachHang = [];
                while($row = mysqli_fetch_array($resultKhachHang, MYSQLI_ASSOC)) {
                    $arrDanhSachKhachHang[] = array(
                        'kh_tendangnhap' => $row['kh_tendangnhap'],
                        'kh_ten' => $row['kh_ten'],
                        'kh_dienthoai' => $row['kh_dienthoai'],
                    );
                }
                // -------- Lấy dữ liệu sản phẩm ------------
                // 2. Chuẩn bị câu lệnh
                $sqlSelectSanPham = "SELECT *
                                    FROM sanpham;";
                $resultSanPham = mysqli_query($conn, $sqlSelectSanPham);
                $arrDanhSachSanPham = [];
                while($row = mysqli_fetch_array($resultSanPham, MYSQLI_ASSOC)) {
                    $arrDanhSachSanPham[] = array(
                        'sp_ma' => $row['sp_ma'],
                        'sp_ten' => $row['sp_ten'],
                        'sp_gia' => $row['sp_gia'],
                    );
                }
                // ------- Lấy dữ liệu đơn đặt hàng cũ -----------
                // 2. Chuẩn bị câu lệnh
                $dh_ma = $_GET['dh_ma'];
                $sqlSelectDonDatHangCu = "SELECT *
                                        FROM dondathang
                                        WHERE dh_ma = $dh_ma;";
                // 3. Thực thi
                $resultDonDatHangCu = mysqli_query($conn, $sqlSelectDonDatHangCu);
                // 4. Phân tách thành mảng Array PHP
                $rowDonDatHangCu = mysqli_fetch_array($resultDonDatHangCu, MYSQLI_ASSOC);
                
                // -------- Lấy dữ liệu chi tiết đơn hàng cũ -------------
                // 2. Chuẩn bị câu lệnh
                $sqlSelectChiTietDonDatHangCu = "SELECT spddh.*
                                                , sp.sp_ten
                                            FROM sanpham_dondathang spddh
                                            JOIN sanpham sp ON spddh.sp_ma = sp.sp_ma
                                            WHERE spddh.dh_ma = $dh_ma;";
                // 3. Thực thi
                $resultChiTietDonDatHangCu = mysqli_query($conn, $sqlSelectChiTietDonDatHangCu);
                // 4. Phân tách thành mảng array trong PHP
                $arrChiTietDonDatHangCu = [];
                while($row = mysqli_fetch_array($resultChiTietDonDatHangCu, MYSQLI_ASSOC)) {
                    $arrChiTietDonDatHangCu[] = array(
                        'sp_ma' => $row['sp_ma'],
                        'dh_ma' => $row['dh_ma'],
                        'sp_dh_soluong' => $row['sp_dh_soluong'],
                        'sp_dh_dongia' => $row['sp_dh_dongia'],
                        'sp_ten' => $row['sp_ten'],
                    );
                }
                // var_dump($arrChiTietDonDatHangCu);
                ?>
                <form name="frmCreate" id="frmCreate" method="post" action="">
                    <h3>Thông tin Đơn hàng</h3>
                    <div>
                        <label>Ngày lập</label>
                        <input type="datetime-local" name="dh_ngaylap" class="form-control"
                            value="<?= date('Y-m-d H:i', strtotime($rowDonDatHangCu['dh_ngaylap'])) ?>" />
                    </div>
                    <div>
                        <label>Ngày giao</label>
                        <input type="datetime-local" name="dh_ngaygiao" class="form-control"
                            value="<?= date('Y-m-d H:i', strtotime($rowDonDatHangCu['dh_ngaygiao'])) ?>" />
                    </div>
                    <div>
                        <label>Nơi giao</label>
                        <input type="text" name="dh_noigiao" class="form-control"
                            value="<?= $rowDonDatHangCu['dh_noigiao'] ?>" />
                    </div>
                    <div>
                        <label>Trạng thái thanh toán</label>
                        <p>#0: mới đặt, chưa thanh toán; #1: đã thanh toán</p>
                        <div class="d-flex">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="dh_trangthaithanhtoan" 
                                    id="dh_trangthaithanhtoan_1" value="0"
                                    <?= $rowDonDatHangCu['dh_trangthaithanhtoan'] == 0 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="dh_trangthaithanhtoan_1">
                                    Mới đặt hàng
                                </label>
                            </div>
                            <div class="form-check ms-4">
                                <input class="form-check-input" type="radio" name="dh_trangthaithanhtoan" 
                                    id="dh_trangthaithanhtoan_2" value="1"
                                    <?= $rowDonDatHangCu['dh_trangthaithanhtoan'] == 1 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="dh_trangthaithanhtoan_2">
                                    Đã thanh toán
                                </label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label>Hình thức thanh toán</label>
                        <select name="httt_ma" class="form-control">
                            <?php foreach($arrDanhSachHinhThucThanhToan as $httt): ?>
                                <option value="<?= $httt['httt_ma'] ?>"
                                    <?= $rowDonDatHangCu['httt_ma'] == $httt['httt_ma'] ? 'selected' : '' ?>>
                                    <?= $httt['httt_ten'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Khách hàng</label>
                        <select name="kh_tendangnhap" class="form-control">
                            <?php foreach($arrDanhSachKhachHang as $kh): ?>
                                <option value="<?= $kh['kh_tendangnhap'] ?>"
                                    <?= $rowDonDatHangCu['kh_tendangnhap'] == $kh['kh_tendangnhap'] ? 'selected' : '' ?>>
                                    <?= $kh['kh_ten'] ?> (<?= $kh['kh_dienthoai'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <h3>Thông tin chi tiết Đơn hàng</h3>
                    <div class="row">
                        <div class="col-4">
                            <div>
                                <label>Sản phẩm</label>
                                <select name="sp_ma" id="sp_ma" class="form-control">
                                    <?php foreach($arrDanhSachSanPham as $sp): ?>
                                        <option value="<?= $sp['sp_ma'] ?>" data-sp_gia="<?= $sp['sp_gia'] ?>">
                                            <?= $sp['sp_ten'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div>
                                <label>Số lượng mua</label>
                                <input type="number" id="soluongmua" class="form-control" />
                            </div>
                        </div>
                        <div class="col-4">
                            <div>
                                <label>Xử lý</label><br />
                                <button type="button" id="btnThemVaoDonHang" class="btn btn-secondary">
                                    Thêm vào đơn hàng
                                </button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="table-order-details">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="table-detail">
                            <!-- <tr>
                                <td colspan="5">Chưa có mặt hàng nào...</td>
                            </tr> -->
                            <?php foreach($arrChiTietDonDatHangCu as $ct): ?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="sp_ma[]" value="<?= $ct['sp_ma'] ?>" />
                                        <?= $ct['sp_ten'] ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <input type="hidden" name="sp_dh_soluong[]" value="<?= $ct['sp_dh_soluong'] ?>" />
                                        <?= number_format($ct['sp_dh_soluong'], 0, '.', ',') ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <input type="hidden" name="sp_dh_dongia[]" value="<?= $ct['sp_dh_dongia'] ?>" />
                                        <?= number_format($ct['sp_dh_dongia'], 0, '.', ',') ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?= number_format($ct['sp_dh_soluong'] * $ct['sp_dh_dongia'], 0, '.', ',') ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-delete-row">Xóa</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <a href="index.php" class="btn btn-outline-secondary">Quay về danh sách</a>
                    <button class="btn btn-primary" name="btnSave">Lưu</button>
                </form>
                <?php
                // Nếu người dùng bấm lưu
                if(isset($_POST['btnSave'])) {
                    // ------------ PARSE 1: UPDATE DON DAT HANG ----------------
                    // 1. Mở kết nối
                    $dh_ngaylap = $_POST['dh_ngaylap'];
                    $dh_ngaygiao = $_POST['dh_ngaygiao'];
                    $dh_noigiao = $_POST['dh_noigiao'];
                    $dh_trangthaithanhtoan = $_POST['dh_trangthaithanhtoan'];
                    $httt_ma = $_POST['httt_ma'];
                    $kh_tendangnhap = $_POST['kh_tendangnhap'];

                    // 2. Chuẩn bị câu lệnh UPDATE dondathang
                    $sqlUpdateDonDatHang = "UPDATE dondathang
                                    SET
                                        dh_ngaylap='$dh_ngaylap',
                                        dh_ngaygiao='$dh_ngaygiao',
                                        dh_noigiao='$dh_noigiao',
                                        dh_trangthaithanhtoan=$dh_trangthaithanhtoan,
                                        httt_ma=$httt_ma,
                                        kh_tendangnhap='$kh_tendangnhap'
                                    WHERE dh_ma=$dh_ma";
                    // var_dump($sqlInsertDonDatHang);die;

                    // 3. Thực thi câu lệnh
                    mysqli_query($conn, $sqlUpdateDonDatHang);

                    // ----------- PARSE 2: INSERT CAC CHI TIET DON DAT HANG -------------
                    // for($i = 0; $i < count($_POST['sp_ma']); $i++) {
                    //     // Chuẩn bị câu lệnh
                    //     $sp_ma = $_POST['sp_ma'][$i];
                    //     $sp_dh_soluong = $_POST['sp_dh_soluong'][$i];
                    //     $sp_dh_dongia = $_POST['sp_dh_dongia'][$i];

                    //     $sqlInsertSanPhamDonDatHang = "INSERT INTO sanpham_dondathang
                    //                         (sp_ma, dh_ma, sp_dh_soluong, sp_dh_dongia)
                    //                         VALUES ($sp_ma, $dh_ma, $sp_dh_soluong, $sp_dh_dongia);";

                    //     // Thực thi
                    //     mysqli_query($conn, $sqlInsertSanPhamDonDatHang);
                    // }

                    // 4. Điều hướng
                    // $_SESSION['flash_msg'] = "Đã thêm đơn đặt hàng <b>[$dh_ma]</b> thành công!";
                    // $_SESSION['flash_context'] = 'success';
                    // echo '<script>location.href = "index.php"</script>';
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
    <script>
        // Đợi HTML render xong thì mới thực thi
        $(function() {
            // Nhờ JQUERY tìm đối tượng nào đó (element), tìm thông qua CSS Selector
            // -> yêu cầu đăng ký sự kiện click
            $('#btnThemVaoDonHang').on('click', function() {
                // chuẩn bị dữ liệu
                var sp_ma = $('#sp_ma option:selected').val();
                var sp_ten = $('#sp_ma option:selected').text();
                var sp_gia = $('#sp_ma option:selected').attr('data-sp_gia');
                var soluongmua = $('#soluongmua').val();
                var thanhtien = sp_gia * soluongmua;
                
                // tạo mẫu html dòng TR
                var htmlTemplate = '<tr>';
                htmlTemplate += '<td><input type="hidden" name="sp_ma[]" value="'+ sp_ma +'" />'+ sp_ten +'</td>';
                htmlTemplate += '<td><input type="hidden" name="sp_dh_soluong[]" value="'+ soluongmua +'" />'+ soluongmua +'</td>';
                htmlTemplate += '<td><input type="hidden" name="sp_dh_dongia[]" value="'+ sp_gia +'" />'+ sp_gia +' đ</td>';
                htmlTemplate += '<td>'+ thanhtien +' đ</td>';
                htmlTemplate += '<td><button type="button" class="btn btn-danger btn-delete-row">Xóa</button></td>';
                htmlTemplate += '</tr>';

                // Nhờ JQUERY tìm element #table-detail
                // -> chèn vào bên trong 1 đoạn html nào đó
                $('#table-detail').append(htmlTemplate);

                // Clear bỏ input
                $('#soluongmua').val('');
                $('#sp_ma').val('');
            });

            // Nhờ Jquery tìm element #table-detail
            $('#table-detail').on('click', '.btn-delete-row', function() {
                // btn -> td   ->   tr
                $(this).parent().parent().remove();
            });
        });
    </script>
</body>
</html>