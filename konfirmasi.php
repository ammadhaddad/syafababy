<?php
  session_start();
  include 'db.php';
  if($_SESSION['status_login'] != true){
    echo'<script>window.location="login.php"</script>';
  }
  $payment  = mysqli_query($conn, "SELECT * FROM tb_payment JOIN tb_order USING (order_id) WHERE order_id = '".$_GET['id']."' ");
  $p = mysqli_fetch_array($payment);
  $admin = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id = '1'");
  $a =  mysqli_fetch_object($admin);
  $keranjang = mysqli_query($conn, "SELECT * FROM tb_keranjang WHERE customer_id ='".$_SESSION['id']."'");
  $k = mysqli_num_rows($keranjang);
  $customer = mysqli_query($conn, "SELECT * FROM tb_customer WHERE customer_id ='".$_SESSION['id']."'");
  $c = mysqli_fetch_object($customer);
  $order = mysqli_query($conn, "SELECT * FROM tb_order WHERE order_id = '".$_GET['id']."'");
  $o = mysqli_fetch_object($order);
?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--CKeditor 4-->
    <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Averia+Sans+Libre&family=Sue+Ellen+Francisco&family=Work+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Boxicon -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <!-- Costum CSS -->
        <link rel="stylesheet" href="css/style.css">

    <title>Syafa Baby & Mom</title>
  </head>
  <body>
      <!-- Navbar -->
      <header>
      <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid ">
          <a class="navbar-brand" href="dashboard.php">
            <img src="photo/icon 2.png"/>
            <span>Syafa </span>Baby <span>&</span> Moms</a>
          <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
            <div class="navbar-nav me-5">
              <a class="nav-link me-4" aria-current="page" href="dashboard.php">Home</a>
              <a class="nav-link me-4" href="data-produk.php">Data Product</a>
              <a class="nav-link me-4" href="data-kategori.php">Data Kategori</a>
              <a class="nav-link me-4" href="data-pesanan.php">Pesanan</a>
              <a class="nav-link active" href="data-konfirmasi-pembanyaran.php">Konfirmasi Pembanyaran</a>
            </div>
            <div class="icon-home ">
              <a href="profil-admin.php"><i class='bx bx-user' ></i></a>
              <a href="logout-admin.php"><i class='bx bx-log-out ms-2 me-3'></i></a>
            </div>
          </div>
        </div>
      </nav>
    </header>

  <!--content-->
  <section class="content" id="content">
      <div class="conteiner">
            <div class="row">
              <div class="col-lg-6">
                <div class="container">
                    <a class="b-footer d-flex  text-alight-center mt-5">Bill From :</a>
                    <a class="b-footer d-flex  text-alight-center mt-2"><?php echo $a->admin_name?></a>
                    <a class="b-footer d-flex  text-alight-center mt-1"><?php echo $a->admin_address?></a>
                    <a class="b-footer d-flex  text-alight-center mt-1"><?php echo $a->admin_email ?></a>
                    <a class="b-footer d-flex  text-alight-center mt-1"><?php echo $a->admin_telp?></a>
                </div>
                <div class="container">
                    <a class="b-footer d-flex  text-alight-center mt-5">Bill To :</a>
                    <a class="b-footer d-flex  text-alight-center mt-2"><?php echo $c->customer_name?></a>
                    <a class="b-footer d-flex  text-alight-center mt-1"><?php echo $c->customer_address?></a>
                    <a class="b-footer d-flex  text-alight-center mt-1"><?php echo $c->customer_email ?></a>
                    <a class="b-footer d-flex  text-alight-center mt-1"><?php echo $c->customer_telp?></a>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="container">
                    <img src="photo/1.png" alt="#">
                </div>
                <div class="container">
                    <a class="b-footer d-flex  text-alight-center mt-2"> Order ID :<?php echo $o->order_id?></a>
                    <a class="b-footer d-flex  text-alight-center mt-1">Tanggal :<?php echo $o->order_date?></a>
                    <a class="b-footer d-flex  text-alight-center mt-2"> Bank BCA : 505050505050</a>
                </div>
              </div>
            </div>
            <div class="row mt-5 ">
                <table  border="3" cellspacing="0" class = "table ms-4">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>QTY</th>
                            <th>Total</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $wishlist = mysqli_query($conn, "SELECT * FROM tb_order LEFT JOIN tb_customer USING (customer_id) LEFT JOIN tb_product USING (product_id) WHERE customer_id ='".$_SESSION['id']."' and order_id = '".$_GET['id']."'");
                            
                            
                            $no = 1;
                            $row =mysqli_fetch_array($wishlist)
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['product_name']?></td>
                            <td>Rp. <?php echo number_format($row['product_price'])?></td>
                            <td><a href="produk/<?php echo $row['product_image'] ?>"target="_blank"><img src="produk/<?php echo $row['product_image'] ?>" width="50px"></a></td>
                            <td><?php echo $row['qty']?></td>
                            <td>Rp. <?php echo number_format($row['qty'] * $row['product_price'])?></td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>

          <div class="container">
            <div class="row">
              <div class="col">
              <a class="d-pesanan pt-2">Bukti Pembanyaran</a>
              <form action="" method="POST"enctype="multipart/form-data">
                <img src="payment/<?php echo $p['payment_proof'] ?>" width="100px">
                <br>
                <a class="d-pesanan pt-2">Status Pembanyaran</a>
                <select name="status" class="input-field">
                    <option value="">--Status Pembayaran--</option>
                    <option value="1"<?php echo ($p['payment_status'] == 1 )? 'selected': '' ?>>Sudah Konfirmasi</option>
                    <option value="0"<?php echo ($p['payment_status'] == 0 )? 'selected': '' ?>>Belum Konfirmasi</option>
                </select>
                <a href="data-pesanan.php" class="submid-btn mb-5 d-flex justify-content-center">Submit</a>
              </div>
            </div>
          </div>
      </div>
  </section>


    

    <script>
    </script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
      CKEDITOR.replace( 'deskripsi' );
    </script>
  </body>
</html>