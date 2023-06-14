<?php
  session_start();
  error_reporting(0);
  include 'db.php';
  if($_SESSION['status_login'] != true){
    echo'<script>window.location="login.php"</script>';
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


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
            </div>
            <div class="icon-home ">
              <a href="profil-admin.php"><i class='bx bx-user' ></i></a>
              <a href="logout-admin.php"><i class='bx bx-log-out ms-2 me-3'></i></a>
            </div>
          </div>
        </div>
      </nav>
    </header>

   <!-- Home -->
   <section class="data pesanan" id="home">
      <div class="container">
        <h3 class = "top d-flex justify-content-center">Data Pesanan</h3>
        <ul class="nav nav-tabs" id="myTab" role="tablist"> 
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="menunggu-tab" data-bs-toggle="tab" data-bs-target="#menunggu" type="button" role="tab" aria-controls="menunggu" aria-selected="false">Menunggu Pembayaran</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="konfirmasi-tab" data-bs-toggle="tab" data-bs-target="#konfirmasi" type="button" role="tab" aria-controls="konfirmasi" aria-selected="false">Konfirmasi Pembayaran</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Menyiapkan Paket</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Dalam Pengiriman</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="finish-tab" data-bs-toggle="tab" data-bs-target="#finish" type="button" role="tab" aria-controls="finish" aria-selected="false">Sudah Diterima</button>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="menunggu" role="tabpanel" aria-labelledby="menunggu-tab">
          <div class="row">
                  <table  border="3" cellspacing="0" class = "table">
                      <thead>
                          <tr>
                              <th width="60px">No</th>
                              <th>Order ID</th>
                              <th>Nama Produk</th>
                              <th>qty</th>
                              <th>Total</th>
                              <th>ID Pelanggan</th>
                              <th>Tgl. Pembelian</th>
                              <th>Status Pesanan</th>
                              <th width="150px">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                              $no = 1;
                              $produk = mysqli_query($conn, "SELECT * FROM tb_order WHERE order_status = '0' ORDER BY order_id DESC");
                              if(mysqli_num_rows($produk)>0){
                              while($row = mysqli_fetch_array($produk)){
                          ?>
                          <tr>
                              <td><?php echo $no++ ?></td>
                              <td><?php echo $row['order_id']?></td>
                              <td><?php echo $row['product_name']?></td>
                              <td><?php echo $row['qty']?></td>
                              <td>Rp.<?php echo number_format($subtotal = $row['product_price'] * $row['qty'] + 15000 + $row['order_id'])?></td>
                              <td><?php echo $row['customer_id']?></td>
                              <td><?php echo $row['order_date']?></td>
                              <td>
                                  <?php 
                                      if($row['order_status'] == 0){
                                        echo 'Menunggu Pembayaran';
                                    }else if($row['order_status'] == 1){
                                        echo 'Konfirmasi Pembayaran';
                                    }else if($row['order_status'] == 2){
                                        echo 'Menyiapkan Paket';
                                    }else if($row['order_status'] == 3){
                                        echo 'Sudah di kurir';
                                    }else{
                                        echo 'Sudah sampai Tujuan';
                                    }
                                  ?>
                              </td>
                              <td>
                                  <a href="detail-pesanan.php?id=<?php echo $row['order_id'] ?>" class="detail-btn d-flex justify-content-center;">Detail</a>
                              </td>
                          </tr>
                          <?php }}else{ ?>
                            <tr>
                              <td colspan="8">Tidak ada data</td>
                            </tr>
                          <?php } ?>
                      </tbody>
                  </table>
          </div>
        </div>
        <div class="tab-pane fade" id="konfirmasi" role="tabpanel" aria-labelledby="konfirmasi-tab">
          <div class="row">
                  <table  border="3" cellspacing="0" class = "table">
                      <thead>
                          <tr>
                              <th width="60px">No</th>
                              <th>Order ID</th>
                              <th>Nama Produk</th>
                              <th>qty</th>
                              <th>Total</th>
                              <th>ID Pelanggan</th>
                              <th>Tgl. Pembelian</th>
                              <th>Status Pesanan</th>
                              <th width="150px">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                              $no = 1;
                              $produk = mysqli_query($conn, "SELECT * FROM tb_order JOIN tb_payment USING (order_id) WHERE order_status = '1' and payment_status = '0' ORDER BY order_id DESC");
                              if(mysqli_num_rows($produk)>0){
                              while($row = mysqli_fetch_array($produk)){
                          ?>
                          <tr>
                              <td><?php echo $no++ ?></td>
                              <td><?php echo $row['order_id']?></td>
                              <td><?php echo $row['product_name']?></td>
                              <td><?php echo $row['qty']?></td>
                              <td>Rp.<?php echo number_format($subtotal = $row['product_price'] * $row['qty']+ 15000 + $row['order_id'])?></td>
                              <td><?php echo $row['customer_id']?></td>
                              <td><?php echo $row['order_date']?></td>
                              <td>
                                  <?php 
                                      if($row['order_status'] == 0){
                                        echo 'Menunggu Pembayaran';
                                      }else if($row['order_status'] == 1){
                                        echo 'Konfirmasi Pembayaran';
                                      }else if($row['order_status'] == 2){
                                        echo 'Menyiapkan Paket';
                                      }else if($row['order_status'] == 3){
                                        echo 'Sudah di kurir';
                                      }else{
                                        echo 'Sudah sampai Tujuan';
                                      }
                                  ?>
                              </td>
                              <td>
                                  <a href="detail-konfirmasi.php?id=<?php echo $row['order_id'] ?>" class="detail-btn d-flex justify-content-center;">Detail</a>
                              </td>
                          </tr>
                          <?php }}else{ ?>
                            <tr>
                              <td colspan="8">Tidak ada data</td>
                            </tr>
                          <?php } ?>
                      </tbody>
                  </table>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="row">
                  <table  border="3" cellspacing="0" class = "table">
                      <thead>
                          <tr>
                              <th width="60px">No</th>
                              <th>Order ID</th>
                              <th>Nama Produk</th>
                              <th>qty</th>
                              <th>Total</th>
                              <th>ID Pelanggan</th>
                              <th>Tgl. Pembelian</th>
                              <th>Status Pesanan</th>
                              <th width="150px">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                              $no = 1;
                              $produk = mysqli_query($conn, "SELECT * FROM tb_order join tb_payment using(order_id) WHERE order_status = '2' and payment_status = '1' ORDER BY order_id DESC");
                              if(mysqli_num_rows($produk)>0){
                              while($row = mysqli_fetch_array($produk)){
                          ?>
                          <tr>
                              <td><?php echo $no++ ?></td>
                              <td><?php echo $row['order_id']?></td>
                              <td><?php echo $row['product_name']?></td>
                              <td><?php echo $row['qty']?></td>
                              <td>Rp.<?php echo number_format($subtotal = $row['product_price'] * $row['qty']+ 15000 + $row['order_id'])?></td>
                              <td><?php echo $row['customer_id']?></td>
                              <td><?php echo $row['order_date']?></td>
                              <td>
                                  <?php 
                                      if($row['order_status'] == 0){
                                        echo 'Menunggu Pembayaran';
                                    }else if($row['order_status'] == 1){
                                        echo 'Konfirmasi Pembayaran';
                                    }else if($row['order_status'] == 2){
                                        echo 'Menyiapkan Paket';
                                    }else if($row['order_status'] == 3){
                                        echo 'Sudah di kurir';
                                    }else{
                                        echo 'Sudah sampai Tujuan';
                                    }
                                  ?>
                              </td>
                              <td>
                                  <a href="status-pesanan.php?id=<?php echo $row['order_id'] ?>" class="detail-btn d-flex justify-content-center;">Detail</a>
                              </td>
                          </tr>
                          <?php }}else{ ?>
                            <tr>
                              <td colspan="8">Tidak ada data</td>
                            </tr>
                          <?php } ?>
                      </tbody>
                  </table>
            </div>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
          <div class="row">
                  <table  border="3" cellspacing="0" class = "table">
                      <thead>
                          <tr>
                              <th width="60px">No</th>
                              <th>Order ID</th>
                              <th>Nama Produk</th>
                              <th>qty</th>
                              <th>Total</th>
                              <th>ID Pelanggan</th>
                              <th>Tgl. Pembelian</th>
                              <th>Status Pesanan</th>
                              <th width="150px">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                              $no = 1;
                              $produk = mysqli_query($conn, "SELECT * FROM tb_order join tb_payment using(order_id) WHERE order_status = '3' and payment_status = '1' ORDER BY order_id DESC");
                              if(mysqli_num_rows($produk)>0){
                              while($row = mysqli_fetch_array($produk)){
                          ?>
                          <tr>
                              <td><?php echo $no++ ?></td>
                              <td><?php echo $row['order_id']?></td>
                              <td><?php echo $row['product_name']?></td>
                              <td><?php echo $row['qty']?></td>
                              <td>Rp.<?php echo number_format($subtotal = $row['product_price'] * $row['qty'] + 15000 + $row['order_id'])?></td>
                              <td><?php echo $row['customer_id']?></td>
                              <td><?php echo $row['order_date']?></td>
                              <td>
                                  <?php 
                                      if($row['order_status'] == 0){
                                        echo 'Menunggu Pembayaran';
                                    }else if($row['order_status'] == 1){
                                        echo 'Konfirmasi Pembayaran';
                                    }else if($row['order_status'] == 2){
                                        echo 'Menyiapkan Paket';
                                    }else if($row['order_status'] == 3){
                                        echo 'Sudah di kurir';
                                    }else{
                                        echo 'Sudah sampai Tujuan';
                                    }
                                  ?>
                              </td>
                              <td>
                                  <a href="detail-pesanan.php?id=<?php echo $row['order_id'] ?>" class="detail-btn d-flex justify-content-center;">Detail</a>
                              </td>
                          </tr>
                          <?php }}else{ ?>
                            <tr>
                              <td colspan="8">Tidak ada data</td>
                            </tr>
                          <?php } ?>
                      </tbody>
                  </table>
            </div>
        </div>
        <div class="tab-pane fade" id="finish" role="tabpanel" aria-labelledby="contact-tab">
          <div class="row">
                  <table  border="3" cellspacing="0" class = "table">
                      <thead>
                          <tr>
                              <th width="60px">No</th>
                              <th>Order ID</th>
                              <th>Nama Produk</th>
                              <th>qty</th>
                              <th>Total</th>
                              <th>ID Pelanggan</th>
                              <th>Tgl. Pembelian</th>
                              <th>Status Pesanan</th>
                              <th width="150px">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                              $no = 1;
                              $produk = mysqli_query($conn, "SELECT * FROM tb_order join tb_payment using(order_id) WHERE order_status = '4' and payment_status = '1' ORDER BY order_id DESC");
                              if(mysqli_num_rows($produk)>0){
                              while($row = mysqli_fetch_array($produk)){
                          ?>
                          <tr>
                              <td><?php echo $no++ ?></td>
                              <td><?php echo $row['order_id']?></td>
                              <td><?php echo $row['product_name']?></td>
                              <td><?php echo $row['qty']?></td>
                              <td>Rp.<?php echo number_format($subtotal = $row['product_price'] * $row['qty'] + 15000 + $row['order_id'])?></td>
                              <td><?php echo $row['customer_id']?></td>
                              <td><?php echo $row['order_date']?></td>
                              <td>
                                  <?php 
                                      if($row['order_status'] == 0){
                                        echo 'Menunggu Pembayaran';
                                    }else if($row['order_status'] == 1){
                                        echo 'Konfirmasi Pembayaran';
                                    }else if($row['order_status'] == 2){
                                        echo 'Menyiapkan Paket';
                                    }else if($row['order_status'] == 3){
                                        echo 'Sudah di kurir';
                                    }else{
                                        echo 'Sudah sampai Tujuan';
                                    }
                                  ?>
                              </td>
                              <td>
                                  <a href="detail-pesanan.php?id=<?php echo $row['order_id'] ?>" class="detail-btn d-flex">Detail</a>
                              </td>
                          </tr>
                          <?php }}else{ ?>
                            <tr>
                              <td colspan="8">Tidak ada data</td>
                            </tr>
                          <?php } ?>
                      </tbody>
                  </table>
          </div>
        </div>    
      </div>
    </section>
    
  

    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
