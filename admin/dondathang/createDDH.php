<?php session_start(); 

// chọn tên khách hàng 
include_once __DIR__ . '/../../dbconnect.php';

$slqSelectKH = "SELECT * FROM khachhang;";

$dataKH = mysqli_query($conn, $slqSelectKH);

$arrdataKH = [];

while($row = mysqli_fetch_array($dataKH, MYSQLI_ASSOC)) {
    $arrdataKH[] = array (
        'kh_tendangnhap' => $row['kh_tendangnhap'],
        'kh_ten' => $row['kh_ten'],
        'kh_dienthoai' => $row['kh_dienthoai']
    );
};

// chọn hình thức thanh toán 
$slqSelectHTTT = "SELECT * FROM hinhthucthanhtoan;";

$dataHTTT = mysqli_query($conn, $slqSelectHTTT);

$arrdataHTTT = [];

while($row = mysqli_fetch_array($dataHTTT, MYSQLI_ASSOC)) {
    $arrdataHTTT[] = array (
        'httt_ma' => $row['httt_ma'],
        'httt_ten' => $row['httt_ten'],
    );
};


//CHỌN SẢN PHẨM
$slqSelectSP = "SELECT * FROM sanpham;";

$dataSP = mysqli_query($conn, $slqSelectSP);

$arrdataSP = [];

while($row = mysqli_fetch_array($dataSP, MYSQLI_ASSOC)) {
    $arrdataSP[] = array (
        'sp_ma' => $row['sp_ma'],
        'sp_ten' => $row['sp_ten'],
        'sp_gia' => $row['sp_gia'],
    );
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách loại sản phẩm</title>
    <?php include_once __DIR__ . '/../layouts/styles.php'; ?>
</head>
<body>
    <div class="container-fluid">
        <!-- dòng header START -->
        <div class="row">
            <div class="col-12">
                <?php include_once __DIR__ . '/../layouts/header.php';?>
            </div>
        </div> <!-- dòng header END -->

        <!-- dòng SIDEBAR & CONTENT START -->
        <div class="row">
			<!-- sidebar -->
            <div class="col-4">
                <?php include_once __DIR__ . '/../layouts/sidebar.php'; ?>
            </div>

			<!-- content -->
            <div class="col-8">
                <form action="" method="post" name="frm-ddh" style="border: 3px dashed green; padding: 10px">
                    <h1>Thông tin Đơn hàng</h1>

                    <div class="">
                        <label for="dh_ten">Khách hàng</label>
                        <select name="kh_tendangnhap" id="kh_tendangnhap" class="form-select mb-3">
                            <option value="0">Vui lòng chọn tên khách hàng</option>
                            <?php foreach($arrdataKH as $kh):?>
                                <option value="<?= $kh['kh_tendangnhap'] ?>">
                                    <?=$kh['kh_ten'] ?>
                                    (<?=$kh['kh_dienthoai'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="dh_ngaylap">Ngày lập</label>
                            <input type="datetime-local" class="form-select">
                        </div>
                        <div class="col-4">
                            <label for="dh_ngaygiao">Ngày giao</label>
                            <input type="datetime-local" class="form-select">
                        </div>
                        <div class="col-4">
                            <label for="dh_noigiao">Nơi giao</label>
                            <input type="datetime-local" class="form-select">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Trạng thái thanh toán</label>
                            <br>
                           
                            <div class="form-check">
                                <input type="radio" name='dh_trangthaithanhtoan' id="dh_trangthaithanhtoan_1" value="1" class="form-check-input">
                                <label for="dh_trangthaithanhtoan_1" class="form-check-label">Chưa thanh toán</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name='dh_trangthaithanhtoan' id="dh_trangthaithanhtoan_2" value="2" class="form-check-input">
                                <label for="dh_trangthaithanhtoan_2" class="form-check-label">Đã thanh toán</label>
                            </div>        
                        </div>
                        <div class="col-6">
                            <label for="httt">Hình thức thanh toán</label>
                            <select name="httt_ma" id="httt_ma" class="form-select mb-3">
                            <option value="0">Vui lòng chọn hình thức thanh toán</option>
                            <?php foreach($arrdataHTTT as $httt):?>
                                <option value="<?= $httt['httt_ma'] ?>">
                                    <?=$httt['httt_ten'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        </div>
                    </div>

                    <hr>

                    <h3>Chi tiết đơn đặt hàng</h3>
                    
                    <div class="row">
                        <div class="col-4">
                            <label for="sp_ma">Sản phẩm</label>
                            <select name="sp_ma" id="sp_ma" class="form-select">
                                <option value="0">Chọn sản phẩm</option>
                                <?php foreach($arrdataSP as $sp):?>
                                    <option value="<?=$sp['sp_ma']?>" data-sp_gia="<?=$sp['sp_gia']?>">
                                        <?= $sp['sp_ten']?>
                                        (<?= number_format($sp['sp_gia'], '0', '.', ',')?>)
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="sp_soluong">Số lượng</label>
                            <input type="number" name="sp_soluong" id="sp_soluong" class="form-control">
                        </div>
                        <div class="col-4">
                            <label for="">Xử lý</label>
                            <button type="button" class="btn btn-primary " id="btnSave">Thêm vào đơn hàng</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table class="table-bordered mt-3" id="tblChiTietDonHang" width="100%" >
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>      
                            </table>
                            <button type="button" class="btn btn-primary mt-3">Lưu dữ liệu</button>
                        </div>
                    </div>
                </form>
            </div>


        <!-- dòng SIDEBAR & CONTENT END -->

        <!-- dòng FOOTER START -->
         <div class="row">
            <div class="col-12">
                <?php
                include_once __DIR__ . '/../layouts/footer.php';
                ?>
            </div>
         </div> <!-- dòng FOOTER END -->

    </div>

	<!-- nạp các file js ở cuối trang để tăng tốc độ tải trang -->
    <?php include_once __DIR__ . '/../layouts/scripts.php'; ?>

    <script>
        $(function() {
            $('#btnSave').click(function() {
                //1. thu thập thông tin
                var sp_ma = $('select#sp_ma option:selected').val();
                var sp_ten= $('select#sp_ma option:selected').text();
                var sp_gia= $('select#sp_ma option:selected').data('sp_gia');
                var sp_soluong = $('#sp_soluong').val();
                //alert(sp_ma);

                //2. tạo template HTML tr
                var htmlTemplate = '<tr>';
                htmlTemplate += '<td>'+ sp_ten + '<input type="hidden" name="sp_ma[]" value="'+ sp_ma +'" ></td>';
                htmlTemplate += '<td>'+ sp_soluong + '<input type="hidden" name="sp_dh_soluong[]" value="'+ sp_soluong +'" ></td>';
                htmlTemplate += '<td>'+ sp_gia + '<input type="hidden" name="sp_dh_dongia[]" value="'+ sp_gia +'" ></td>';
                htmlTemplate += '<td>'+ (sp_gia * sp_soluong) +'</td>';
                htmlTemplate += '<td><button type="button" name="sp_dh_dongia" class="btn btn-danger btn-delete-row">Xóa</button><td>';
                htmlTemplate += '</tr>';

                //3. chèn đoạn template HTML vào trong table
                $('#tblChiTietDonHang tbody').append(htmlTemplate);
            });

            //đăng kí sự kiện on để xóa một dòng
            $('#tblChiTietDonHang').on('click', '.btn-delete-row', function() {
                //button -> th -> tr
                $(this).parent().parent()[0].remove();
            });
        });
    </script>
</body>
</html>