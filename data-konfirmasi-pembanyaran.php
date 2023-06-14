<?php
  session_start();
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

   <!-- Home -->
   <section class="data pesanan" id="home">
        <div class="container">
        <h3 class = "top d-flex justify-content-center">Konfirmasi Pembanyaran</h3>
            <div class="row">
                <table  border="3" cellspacing="0" class = "table">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Order ID</th>
                            <th>Nama Produk</th>
                            <th>qty</th>
                            <th>Total</th>
                            <th>ID Pembeli</th>
                            <th>Nama Pembeli</th>
                            <th>Tgl. Pembelian</th>
                            <th>Status Pembanyaran</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            $payment = mysqli_query($conn, "SELECT * FROM tb_payment ORDER BY order_id DESC");
                            if(mysqli_num_rows($payment)>0){
                            while($row = mysqli_fetch_array($payment)){
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['order_id']?></td>
                            <td><?php echo $row['product_name']?></td>
                            <td><?php echo $row['qty']?></td>
                            <td>Rp.<?php echo number_format($subtotal = $row['product_price'] * $row['qty'])?></td>
                            <td><?php echo $row['customer_id']?></td>
                            <td><?php echo $row['customer_name']?></td>
                            <td><?php echo $row['order_date']?></td>
                            <td><?php echo ($row['payment_status'] == 0)? 'Belum Konfirmasi' : 'Sudah Konfirmasi' ?></td>
                            <td>
                                <a href="detail-konfirmasi.php?id=<?php echo $row['order_id'] ?>">Edit</a>
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
    </section>
    
  

    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
