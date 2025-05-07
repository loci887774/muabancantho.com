<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách loại sản phẩm</title>
    <?php include_once __DIR__ . '/../layouts/styles.php'; ?>
    <style>
        .hinh-dai-dien{
            width: 200px;
        }
    </style>
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
                <h1>Danh sách loại sản phẩm</h1>
				
                <?php
				include_once __DIR__ . '/../../dbconnect.php';

                $sqlSelectHSP = "SELECT hsp.hsp_ma, 
                                        hsp.hsp_tentaptin, 
                                        sp.sp_ma, 
                                        sp.sp_ten, 
                                        sp.sp_gia
                                FROM hinhsanpham hsp
                                JOIN sanpham sp 
                                    ON hsp.sp_ma = sp.sp_ma;";

                $dataHSP = mysqli_query($conn, $sqlSelectHSP);

                $arrHSP = [];

                while($row = mysqli_fetch_array($dataHSP, MYSQLI_ASSOC)) {
                    $arrHSP[] = array (
                        'hsp_ma' => $row['hsp_ma'],
                        'hsp_tentaptin' => $row['hsp_tentaptin'],
                        'sp_ma' => $row['sp_ma'],
                        'sp_ten' => $row['sp_ten'],
                        'sp_gia' => $row['sp_gia']
                    );
                }
				?>

				<!-- HIỂN THỊ DỮ LIỆU  -->
                <?php if(isset($_SESSION['flash-msg']) ) {?>
                    <div class="alert alert-<?= $_SESSION['flash-context']?>">
                        <?= $_SESSION['flash-msg']?>
                    </div>
                <?php } ?>

                <?php unset($_SESSION['flash-msg']);?>

                <a href="createHinhSanPham.php" class="btn btn-primary">
                    Thêm mới +
                </a>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <td>Hình sản phẩm</td>
                        <td>Tên sản phẩm</td>
                        <td>Giá sản phẩm</td>
                    </tr>

                    <?php foreach($arrHSP as $hsp): ?>
                        <tr>
                            <td>
                                <img src="/muabancantho.com/admin/upload/<?= $hsp['hsp_tentaptin'] ?>" alt=""
                                class="hinh-dai-dien">
                            </td>
                            <td><?= $hsp['sp_ten'] ?></td>
                            <td><?= number_format($hsp['sp_gia'], '0', '.', ',') ?></td>
                            <td>
                                <!-- nút sửa  -->
                                <a href="editHinhSanPham.php?hsp_ma=<?= $hsp['hsp_ma'] ?>" class="btn btn-warning btn-editHSP">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <!-- nút xóa  -->
                                <a href="#" class="btn btn-danger btn-delete" data-hsp_ma="<?= $hsp['hsp_ma'] ?>">
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
            $('.btn-delete').click(function() {
                let hsp_ma = $(this).data('hsp_ma');
                Swal.fire({
                title: "Bạn có chắc muốn xóa?",
                text: "Bạn sẽ không thể khôi phục lại!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Có!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = "deleteHinhSanPham.php?hsp_ma=" + hsp_ma;
                    }
                });
            });
        });
    </script>

</body>
</html>

