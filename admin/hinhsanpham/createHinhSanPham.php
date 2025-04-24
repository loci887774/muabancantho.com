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
                include_once __DIR__ . '/../../dbconnect.php';

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

                <form action="" method="post" name="frm-hinhsanpham">
                    <div>
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
                </form>
            </div>
        </div>
    </div>
    

    
    
    

<?php include_once __DIR__  . '/../layouts/scripts.php'?>
</body>
</html>