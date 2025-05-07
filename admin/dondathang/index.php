<?php session_start(); ?>

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

                <h1>Danh sách Đơn Đặt Hàng</h1>

                <a href="createDDH.php" class="btn btn-primary mb-3">Thêm mới +</a>

                <?php
                include_once __DIR__ . '/../../dbconnect.php';

                $sqlSelect = "
                            SELECT ddh.dh_ma, ddh.dh_ngaylap, ddh.dh_ngaygiao, ddh.dh_noigiao, ddh.dh_trangthaithanhtoan
                            , kh.kh_ten, kh.kh_dienthoai
                            , httt.httt_ten
                            , SUM(spddh.sp_dh_soluong * spddh.sp_dh_dongia) tong_thanh_tien
                            FROM dondathang ddh 
                                JOIN khachhang kh ON ddh.kh_tendangnhap = kh.kh_tendangnhap
                                JOIN hinhthucthanhtoan httt ON ddh.httt_ma = httt.httt_ma
                                JOIN sanpham_dondathang spddh ON spddh.dh_ma = ddh.dh_ma
                            GROUP BY ddh.dh_ma, ddh.dh_ngaylap, ddh.dh_ngaygiao, ddh.dh_noigiao, ddh.dh_trangthaithanhtoan, kh.kh_ten, kh.kh_dienthoai, httt.httt_ten;
                            ";

                $data = mysqli_query($conn, $sqlSelect);

                $arrDDH = [];

                while($row = mysqli_fetch_array($data, MYSQLI_ASSOC)) {
                    $arrDDH[] = array(
                        'dh_ma' => $row['dh_ma'],
                        'dh_ngaylap' => $row['dh_ngaylap'],
                        'dh_ngaygiao' => $row['dh_ngaygiao'],
                        'dh_noigiao' => $row['dh_noigiao'],
                        'dh_trangthaithanhtoan' => $row['dh_trangthaithanhtoan'],
                        'kh_ten' => $row['kh_ten'],
                        'kh_dienthoai' => $row['kh_dienthoai'],
                        'httt_ten' => $row['httt_ten'],
                        'tong_thanh_tien' => $row['tong_thanh_tien'],   
                    ); 
                };
                ?>

                <!-- TRÌNH DIỄN DỮ LIỆU  -->
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <td>Mã đơn hàng</td>
                        <td>Tên khách hàng</td>
                        <td>Ngày lập</td>
                        <td>Ngày giao</td>
                        <td>Nơi giao</td>
                        <td>Hình thức thanh toán</td>
                        <td>Tổng thành tiền</td>
                        <td>Trạng thái</td>
                        <td>Hành động</td>
                    </tr>

                    <?php foreach($arrDDH as $ddh):?>
                        <tr>
                            <td><?= $ddh['dh_ma'] ?></td>
                            <td>
                                <?= $ddh['kh_ten'] ?> <br>
                                (<?= $ddh['kh_dienthoai'] ?>)
                            </td>
                            <td><?= date('d-m-Y H:i:s', strtotime($ddh['dh_ngaylap']))?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($ddh['dh_ngaygiao'])) ?></td>
                            <td><?= $ddh['dh_noigiao'] ?></td>
                            <td><?= $ddh['httt_ten'] ?></td>
                            <td class="text-end">
                                <?= number_format($ddh['tong_thanh_tien'], '0', '.', ',') ?> đ
                            </td> 
                            <td>
                            <!-- kiểm tra trạng thái đơn hàng: 1-chưa; 2-thành công -->
                                <?php if($ddh['dh_trangthaithanhtoan'] == 1):?>
                                    <span class="badge text-bg-danger">Chưa xử lý</span> 
                                <?php else:?>
                                    <span class="badge text-bg-success">Đã giao</span>
                                <?php endif;?>
                            </td> 
                            <td>
                                <!-- kiểm tra trạng thái thanh toán để quyết định các nút bấm  -->
                                <?php if($ddh['dh_trangthaithanhtoan'] == 1):?>
                                    <a href="#" class="btn btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                <?php else:?>
                                    <a href="print.php?dh_ma=<?=$ddh['dh_ma']?>" class="btn btn-success">In</a>
                                <?php endif?>
                            </td>
                        </tr>
                    <?php endforeach;?> 
                </table>
				

				<!-- phân trang -->
				<nav aria-label="Page navigation example">
				  <ul class="pagination">
					<li class="page-item">
					  <a class="page-link" href="#" aria-label="Previous">
						<span aria-hidden="true">&laquo;</span>
					  </a>
					</li>
					<li class="page-item"><a class="page-link" href="#">1</a></li>
					<li class="page-item"><a class="page-link" href="#">2</a></li>
					<li class="page-item"><a class="page-link" href="#">3</a></li>
					<li class="page-item">
					  <a class="page-link" href="#" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
					  </a>
					</li>
				  </ul>
				</nav>
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
         </div> <!-- dòng FOOTER END -->

    </div>

	<!-- nạp các file js ở cuối trang để tăng tốc độ tải trang -->
    <?php include_once __DIR__ . '/../layouts/scripts.php'; ?>

	<script>
		$(document).ready(function() {
			$('.btn-deleteLoaiSanPham').click(function() {
				let lsp_ma = $(this).data('lsp_ma');

				Swal.fire({
					title: "Bạn có chắc muốn xóa?",
					text: "Bạn sẽ không thể khôi phục!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Có!"
					}).then((result) => {
						if (result.isConfirmed) {
							location.href = "deleteLoaiSanPham.php?lsp_ma=" + lsp_ma
							// Swal.fire({
							// title: "Đã xóa!",
							// text: "Sản phẩm đã được xóa khỏi database.",
							// icon: "success"
							// });
						}
					});
			});
			
		});
	</script>
</body>
</html>