<?php

// lấy thông tin khách hàng --------------------------------------------
include_once __DIR__ . '/../../dbconnect.php';

$dh_ma = $_GET['dh_ma'];

$sqlSelect_dh_ma = "
                    SELECT ddh.dh_ma, ddh.dh_ngaylap, ddh.dh_ngaygiao, ddh.dh_noigiao, ddh.dh_trangthaithanhtoan
                            , kh.kh_ten, kh.kh_dienthoai
                            , httt.httt_ten
                            , SUM(spddh.sp_dh_soluong * spddh.sp_dh_dongia) tong_thanh_tien
                    FROM dondathang ddh 
                        JOIN khachhang kh ON ddh.kh_tendangnhap = kh.kh_tendangnhap
                        JOIN hinhthucthanhtoan httt ON ddh.httt_ma = httt.httt_ma
                        JOIN sanpham_dondathang spddh ON spddh.dh_ma = ddh.dh_ma
                    GROUP BY ddh.dh_ma, ddh.dh_ngaylap, ddh.dh_ngaygiao, ddh.dh_noigiao, ddh.dh_trangthaithanhtoan, kh.kh_ten, kh.kh_dienthoai, httt.httt_ten
                    HAVING ddh.dh_ma = $dh_ma ;
                    ";

$dataSelect_dh_ma = mysqli_query($conn, $sqlSelect_dh_ma);

$rowSelect_dh_ma = mysqli_fetch_array($dataSelect_dh_ma, MYSQLI_ASSOC);

// lấy thông tin đơn hàng chi tiết --------------------------------------------
$sqlSelect_dh_chitiet = "
                SELECT sp.sp_ten,
                        lsp.lsp_ten,
                        nsx.nsx_ten,
                        spddh.sp_dh_soluong, spddh.sp_dh_dongia,
                        (spddh.sp_dh_soluong * spddh.sp_dh_dongia) thanh_tien,
                        spddh.sp_ma
                FROM sanpham_dondathang spddh
                JOIN sanpham sp ON spddh.sp_ma = sp.sp_ma
                JOIN loaisanpham lsp ON lsp.lsp_ma = sp.lsp_ma
                JOIN nhasanxuat nsx ON nsx.nsx_ma = sp.nsx_ma
                WHERE spddh.dh_ma = $dh_ma;
                ";

$dataSelect_dh_chitiet = mysqli_query($conn, $sqlSelect_dh_chitiet);

$arrdata = [];

while($row = mysqli_fetch_array($dataSelect_dh_chitiet, MYSQLI_ASSOC)) {
    $arrdata[] = array (
        'sp_ten' => $row['sp_ten'],
        'lsp_ten' => $row['lsp_ten'],
        'nsx_ten' => $row['nsx_ten'],
        'sp_dh_soluong' => $row['sp_dh_soluong'],
        'sp_dh_dongia' => $row['sp_dh_dongia'],
        'thanh_tien' => $row['thanh_tien']
    );
};
// var_dump($arrdata)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mẫu in</title>
    <!-- link khổ giấy in  -->
    <link href="/muabancantho.com/admin/assets/vendors/paper-css/paper.min.css" type="text/css" rel="stylesheet">
    <?php include_once __DIR__ . '/../layouts/styles.php'?>
    <style>@page { size: A5 }</style>

    <style>
        .canh-giua {
            text-align: center;
        }

        .canh-giua-tam {
            text-align: center;
            vertical-align: middle;
        }

        .canh-phai {
            text-align: end;
        }

        .font {
            font-family: Arial, Helvetica, sans-serif;
        }

        .color-chinh {
            color: rgb(17, 117, 55);
        }

        .color-phu {
            color: rgb(185, 64, 100);
        }

        .rong-cot {
            width: 180px;
        }
    </style>
</head>

<body class="A5">

  <section class="sheet padding-10mm">

    <table border="1px soild red" width="100%">
        <tr>
            <td width="30mm">
                <img src="/muabancantho.com/admin/assets/img/logo/1600w-zAryXCxAcKY.webp" alt="" width="80px">
            </td>
            <td>
                <h3 class="canh-giua font color-chinh">MUA BÁN CẦN THƠ</h3>
                <h6 class="canh-giua font color-phu">By: Loci-cute</h6>
            </td> 
        </tr>
    </table>

    <p>Thông tin khách hàng</p>
    <table border="1px soild red" width="100%" class="table table-bordered table-hover ">
        <tr>
            <td class="rong-cot">Khách hàng</td>
            <td><?= $rowSelect_dh_ma['kh_ten'] ?></td>
        </tr>
        <tr>
            <td class="rong-cot">Ngày lập</td>
            <td><?= date('d-m-Y H:i:s', strtotime($rowSelect_dh_ma['dh_ngaylap']) ) ?></td>
        </tr>
        <tr>
            <td class="rong-cot">Hình thức thành toán</td>
            <td><?= $rowSelect_dh_ma['httt_ten'] ?></td>
        </tr>
        <tr>
            <td class="rong-cot">Tổng thành tiền</td>
            <td><?= number_format($rowSelect_dh_ma['tong_thanh_tien'], '0', '.', ',') ?></td>
        </tr>
    </table>

    <p>Thông tin đơn hàng</p>
    <table class="table table-hover table-triped table-bordered"  width="100%">
        <tr>
            <td>STT</td>
            <td>Sản phẩm</td>
            <td>Số lượng</td>
            <td>Đơn giá</td>
            <td>Thành tiền</td>
        </tr>

        
            <?php foreach($arrdata as $index => $dhct): ?>
                <tr>
                    <td style="text-align: center; vertical-align: middle">
                        <?= $index + 1 ?>
                    </td>
                    <td>
                        <?= $dhct['sp_ten'] ?> <br>
                        <i>
                            <?= $dhct['lsp_ten'] ?> <br>
                            <?= $dhct['nsx_ten'] ?>
                        </i>
                    </td>
                    <td class="canh-giua-tam"> <?= $dhct['sp_dh_soluong'] ?> </td>
                    <td class="canh-phai canh-giua"> <?= number_format( $dhct['sp_dh_dongia'], '0', '.', ',') ?> </td>
                    <td class="canh-phai canh-giua"> <?= number_format( $dhct['thanh_tien'], '0', '.', ',') ?> </td>
                </tr>  
            <?php endforeach; ?>
            <tr>
                <td colspan="2">Tổng số: <?php count($arrdata)?></td>
                <td colspan="2">Tổng tiền:</td>
                <td><?= $rowSelect_dh_ma['tong_thanh_tien']?></td>
            </tr>
    </table>

    <p>Cảm ơn Quý khách</p>

  </section>

</body>
</html>