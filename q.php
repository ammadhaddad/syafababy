<?php
  session_start();
  include 'db.php';
  if($_SESSION['status_login'] != true){
    echo'<script>window.location="login.php"</script>';
  }

  $order  = mysqli_query($conn, "SELECT * FROM tb_order JOIN tb_payment USING (order_id) WHERE order_id = '".$_GET['id']."' ");
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
              <a class="nav-link active me-4" href="data-pesanan.php">Pesanan</a>
              <a class="nav-link" href="data-konfirmasi-pembanyaran.php">Konfirmasi Pembanyaran</a>
            </div>
            <div class="icon-home ">
              <a href="profil-admin.php"><i class='bx bx-user' ></i></a>
              <a href="logout-admin.php"><i class='bx bx-log-out ms-2 me-3'></i></a>
            </div>
          </div>
        </div>
      </nav>
    </header>


    <!-- Content -->
    <div class="section">
      <div class="container">
        <h3 class = "top d-flex justify-content-center">Detail Pesanan</h3>
          <div class="row">
            <a class="d-pesanan pt-2">Order Id</a>
            <a class="input-field ms-3"><?php echo $o->order_id?></a>
            <a class="d-pesanan pt-2">Nama Produk</a>
            <a class="input-field ms-3"><?php echo $o->product_name?></a>
            <a class="d-pesanan pt-2">Harga Produk</a>
            <a class="input-field ms-3">Rp. <?php echo number_format($o->product_price)?></a>
            <a class="d-pesanan pt-2">Jumlah</a>
            <a class="input-field ms-3"><?php echo $o->qty?></a>
            <a class="d-pesanan pt-2">Metode Pembanyaran</a>
            <a class="input-field ms-3"><?php echo ($o->method_payment == 0)? 'COD' : 'Tranfer Bank Manual' ?></a>
            <a class="d-pesanan pt-2">Pengiriman</a>
            <a class="input-field ms-3"><?php echo ($o->ongkir == 0)? 'DLL' : 'Gratis Ongkir' ?></a>
            <a class="d-pesanan pt-2">ID Pembeli</a>
            <a class="input-field ms-3"><?php echo $o->customer_id?></a>
            <a class="d-pesanan pt-2">Nama Pembeli</a>
            <a class="input-field ms-3"><?php echo $o->customer_name?></a>
            <a class="d-pesanan pt-2">Alamat</a>
            <a class="input-field ms-3"><?php echo $o->customer_address?></a>
            <a class="d-pesanan pt-2">No. Telp</a>
            <a class="input-field ms-3"><?php echo $o->customer_telp?></a>
            <a class="d-pesanan pt-2">Tgl. Pembelian</a>
            <a class="input-field ms-3 mb-5"><?php echo $o->order_date?></a>
            <a class="d-pesanan pt-2">Bukti Pembanyaran</a>
            <img src ="payment/<?php echo $o->payment_proof?>">
            <form action="" method="POST">
            <a class="d-pesanan">Status Pesanan</a>
              <select name="status" class="input-field mb-5">
                  <option value="">--Pilih--</option>
                  <option value="4"<?php echo ($o->order_status == 4 )? 'selected': '' ?>>Sudah sampai Tujuan</option>
                  <option value="3"<?php echo ($o->order_status == 3 )? 'selected': '' ?>>Sudah di kurir</option>
                  <option value="2"<?php echo ($o->order_status == 2 )? 'selected': '' ?>>Menyiapkan Paket</option>
                  <option value="1"<?php echo ($o->order_status == 1 )? 'selected': '' ?>>Konfirmasi Pembayaran</option>
                  <option value="0"<?php echo ($o->order_status == 0 )? 'selected': '' ?>>Menunggu Pembayaran</option>
              </select>
              <input type="submit" name="submit" value="Submit" class="submid-btn mb-5">
            </form>
            <?php
            if(isset($_POST['submit'])){
              $status     = $_POST['status'];
              $update = mysqli_query($conn, "UPDATE tb_order SET order_status = '".$status."' WHERE order_id = '".$_GET['id']."' ");
              if($update){
                echo '<script>alert("Data berhasil diubah")</script>';
                echo'<script>window.location="data-pesanan.php"</script>';
              }else{
                  echo'gagal' .mysqli_error($conn);
              }
            }
            ?>
          </div>
      </div>
    </div>


    <script>
    </script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
      CKEDITOR.replace( 'deskripsi' );
    </script>
  </body>
</html>