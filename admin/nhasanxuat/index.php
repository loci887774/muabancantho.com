<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhà sản xuất</title>
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
            <!-- sidebar  -->
            <div class="col-4">
                <?php
                include_once __DIR__ . '/../layouts/sidebar.php';
                ?>
            </div>

            <!-- content  -->
            <div class="col-8">
                <h1>Nhà sản xuất</h1>
                
                <?php
                include_once __DIR__ . '/../../dbconnect.php';

                $sqlSelectNSX = "SELECT * FROM nhasanxuat;";

                $dataNSX = mysqli_query($conn, $sqlSelectNSX);

                $arrNSX = [];

                while($row = mysqli_fetch_array($dataNSX, MYSQLI_ASSOC)) {
                    $arrNSX[] = array (
                        'nsx_ma' => $row['nsx_ma'],
                        'nsx_ten' => $row['nsx_ten']
                    );         
                }
                ?>
               
                <!-- Kiểm tra session  -->
                <?php if(isset($_SESSION['flash_msg'])) { ?>
                    <div class="alert alert-<?=$_SESSION['flash_context']?>" role="alert">
                        <?=$_SESSION['flash_msg']; ?>
                    </div>
                <?php } ?>

                <!-- xóa session cũ mỗi khi reload  -->
                <?php unset($_SESSION['flash_msg']); ?>

                <a href="createNSX.php" class="btn btn-primary">
                    Thêm mới
                    <i class="fa-solid fa-plus"></i>
                </a>

                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <td>MÃ</td>
                        <td>Tên NSX</td>
                        <td></td>
                    </tr>
                    
                    <?php foreach($arrNSX as $nsx): ?>
                        <tr>
                            <td><?= $nsx['nsx_ma'] ?></td>
                            <td><?= $nsx['nsx_ten'] ?></td>
                            <td>
                                <a href="editNSX.php?nsx_ma=<?= $nsx['nsx_ma'] ?>" class="btn btn-warning"> 
                                    <!-- <i class="bi bi-pen-fill"></i>  -->
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-deleteNSX" data-nsx_ma="<?= $nsx['nsx_ma'] ?>">
                                    <i class="bi bi-trash">XÓA</i> 
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </table>
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

    <!-- nạp các file js ở cuối trang để tăng tốc độ tải trang -->
    <?php
    include_once __DIR__ . '/../layouts/scripts.php';
    ?>

    <script>
        $(document).ready(function() {
            $('.btn-deleteNSX').click(function() {

                let nsx_ma = $(this).data('nsx_ma');
                
                Swal.fire({
                title: "Bạn có chắc muốn xóa?",
                text: "Bạn sẽ không thể phục hồi!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Có!"
                }).then((result) => {
                if (result.isConfirmed) {
                    location.href = "deleteNSX.php?nsx_ma=" + nsx_ma;
                }
                });
            });
        });
    </script>
</body>
</html>