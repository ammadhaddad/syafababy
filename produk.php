<?php
    error_reporting(0);
    session_start();
    include 'db.php';

    if($_SESSION['status_login'] != true){
      echo'<script>window.location="login.php"</script>';
  
      $query = mysqli_query($conn, "SELECT * FROM tb_customer WHERE customer_id = '".$_SESSION['id']."'");
      $c = mysqli_fetch_object($query);
    }
    $keranjang = mysqli_query($conn, "SELECT * FROM tb_keranjang WHERE customer_id ='".$_SESSION['id']."'");
    $k = mysqli_num_rows($keranjang);
    $admin = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id ='1' ");
    $a = mysqli_fetch_array($admin);
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

    <title>Produk || Syafa Baby & Moms</title>
  </head>
  <body>
  <!-- Navbar -->
  <header>
      <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid ">
          <a class="navbar-brand" href="#">
            <img src="photo/icon 2.png"/>
            <span>Syafa </span>Baby <span>&</span> Moms</a>
          <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link" aria-current="page" href="index.php">Home</a>
              <a class="nav-link active ms-3 me-3" href="produk.php">Product</a>
              <a class="nav-link" href="pesanan.php">Pesanan</a>
            </div>
          </div>
          <div class="icon-home justify-content-end">
                <a href="profil.php" class="name-customer">Hi, <?php echo $_SESSION['u_global']->customer_name?></a>
                <a href="profil.php"><i class='bx bx-user'></i></a>
                <a href="checkout.php"><i class='bx bx-shopping-bag ms-2 me-3'><?php echo $k?></i></a>
            </div>
        </div>
      </nav>
    </header>


    <!-- search -->
    <div class="search">
        <div class="container">
            <form action="produk.php">
                <input type="text" name="search" placeholder="Cari Produk" value="<?php echo $_GET['search']?>">
                <input type="hidden" name ="kat" value="<?php echo $_GET['kat']?>">
                <input type="submit" name="cari" value="Cari Produk">
            </form>
        </div>
    </div>
    <!-- produk -->
    <section class="produk">
      <div class="container">
        <div class="row text-center">
            <div class="col">
                <h1 class="heading d-flex justify-content-start">Our Product</h1>
            </div>
            <div class="box">
                <?php
                    if($_GET['search']!= '' || $_GET['kat']!= ''){
                        $where = "AND product_name LIKE '%".$_GET['search']."%' AND category_id LIKE '%".$_GET['kat']."%' ";
                    }
                    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 $where ORDER BY product_id DESC ");
                    if(mysqli_num_rows($produk) > 0){
                        while($p = mysqli_fetch_array($produk)){
                ?>
                    <a href="detail-produk.php?id=<?php echo $p['product_id'] ?>">
                        <div class="col-4" >
                          <img src="produk/<?php echo $p['product_image']?>">
                          <a class="nama d-flex justify-content-start mt-3"><?php echo substr($p['product_name'], 0,30) ?></a>
                          <div class="row">
                            <div class="col">
                              <a class="harga d-flex justify-content-end mb-4">Rp. <?php echo number_format($p['product_price'])?></a>
                            </div>
                            <a href="tambah-keranjang.php?id=<?php echo $p['product_id'] ?>"><button class="beli p-1 px-3">Tambah Ke keranjang</button></a>
                          </div>
                        </div>
                    </a>
                <?php }}else{ ?>
                    <p>Produk tidak ada</p>
                <?php } ?>
            </div>
        </div>  
      </div>
    </section>

    <!--footer-->
    <section class="footer"id="footer">
      <div class="conteriner">
        <div class="row">
          <div class="col">
            <a class="b-footer d-flex justify-content-center text-alight-center mt-5">Alamat</a>
            <a class="b-footer d-flex justify-content-center text-alight-center"><?php echo $a['admin_address'] ?></a>
            <a class="b-footer d-flex justify-content-center text-alight-center mt-3">Email</a>
            <a class="b-footer d-flex justify-content-center text-alight-center"><?php echo $a['admin_email'] ?></a>
            <a class="b-footer d-flex justify-content-center text-alight-center mt-3">No. HP</a>
            <a class="b-footer d-flex justify-content-center text-alight-center"><?php echo $a['admin_telp'] ?></a>
            <a class="b-footer d-flex justify-content-center text-alight-center mt-5 mb-2">Copyright &copy 2022 by Syafa Baby - DKI Jakarta</a>
          </div>
        </div>
      </div>
    </section>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
