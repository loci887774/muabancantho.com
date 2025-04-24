<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm</title>
    <?php include_once __DIR__ . '/../layouts/styles.php'?>
</head>
<body>
    <div class="container-fluid">
        <!-- header -->
        <div class="row">
            <div class="col-12">
                <?php include_once __DIR__ . '/../layouts/header.php' ?>
            </div>
        </div> <!-- header end-->

        <!-- sidebar and content -->
        <div class="row">
            <!-- sidebar -->
            <div class="col-3">
                <?php include_once __DIR__ . '/../layouts/sidebar.php' ?>
            </div> <!-- sidebar end -->

            <!-- content -->
            <div class="col-9">
                <h1>Sản phẩm</h1>

                <!-- kiểm tra sesion và hiển thị thông báo thành công -->
                <?php if(isset($_SESSION['flash_msg'])) { ?>
                    <div class="alert alert-<?= $_SESSION['flash_context']?>" role="alert">
                        <?= $_SESSION['flash_msg']?>
                    </div>
                <?php } ?>

                <!-- xóa session mỗi khi reload trang -->
                <?php unset($_SESSION['flash_msg']); ?>

                <?php 
                include_once __DIR__ . '/../../dbconnect.php';

                $sqlSanPham = "SELECT * FROM sanpham;";

                $data = mysqli_query($conn, $sqlSanPham);

                $arrDanhSachSanPham = [];

                while($row = mysqli_fetch_array($data, MYSQLI_ASSOC)) {
                    $arrDanhSachSanPham[] = array (
                        'sp_ma' => $row['sp_ma'],
                        'sp_ten' => $row['sp_ten'],
                        'sp_gia' => $row['sp_gia'],
                        'sp_giacu' => $row['sp_giacu'],
                        'sp_mota_ngan' => $row['sp_mota_ngan'],
                        'sp_mota_chitiet' => $row['sp_mota_chitiet'],
                        'sp_ngaycapnhat' => $row['sp_ngaycapnhat'],
                        'sp_soluong' => $row['sp_soluong'],
                        'lsp_ma' => $row['lsp_ma'],
                        'nsx_ma' => $row['nsx_ma'],
                        'km_ma' => $row['km_ma']
                    );
                }
                ?>

                <!-- nút thêm mới sản phẩm  -->
                <a href="createSanPham.php" class="btn btn-primary">Thêm sản phẩm
                    <i class="fa-solid fa-plus"></i>
                </a>

                <!-- hiển thị dữ liệu  -->
                <table class="table table-striped table-hover table-bordered">
					<tr>
                        <td>Mã</td>
                        <td>Tên</td>
                        <td>Giá</td>
                        <td>Giá cũ</td>
                        <td>Mô tả</td>
                        <td>Mô tả chi tiết</td>
                        <td>Ngày cập nhật</td>
                        <td>Số lượng</td>
                        <td>Loại sản phẩm</td>
                        <td>NSX</td>
                        <td>Mã khuyến mãi</td>
                    </tr>

                    <?php foreach($arrDanhSachSanPham as $sp):?>
                        <tr>
                            <td><?= $sp['sp_ma']?></td>
                            <td><?= $sp['sp_ten']?></td>
                            <td><?= $sp['sp_gia']?></td>
                            <td><?= $sp['sp_giacu']?></td>
                            <td><?= $sp['sp_mota_ngan']?></td>
                            <td><?= $sp['sp_mota_chitiet']?></td>
                            <td><?= $sp['sp_ngaycapnhat']?></td>
                            <td><?= $sp['sp_soluong']?></td>
                            <td><?= $sp['lsp_ma']?></td>
                            <td><?= $sp['nsx_ma']?></td>
                            <td><?= $sp['km_ma']?></td>
                            <td>
                                <!-- nút chỉnh sửa -->
                                <a href="editSanPham.php?sp_ma=<?= $sp['sp_ma'] ?>" class="btn btn-warning">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <!-- nút xóa -->
                                <a href="#" class="btn btn-danger btn-deleteSanPham" data-sp_ma= <?= $sp['sp_ma'] ?> >
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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
                
            </div><!-- content end -->  
        </div> <!-- sidebar and content end-->

        <!-- footer -->
        <div class="row">
            <div class="col-12">
                <?php include_once __DIR__ . '/../layouts/footer.php' ?>
            </div>
        </div> <!-- footer end-->
    </div>

    <?php include_once __DIR__ . '/../layouts/scripts.php'; ?>

    <script>
        $(document).ready(function() {
            $('.btn-deleteSanPham').click(function() {
                let sp_ma = $(this).data('sp_ma');
                
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
                            location.href = "deleteSanPham.php?sp_ma=" + sp_ma
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