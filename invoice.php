<?php
    include 'db.php';
    session_start();
    if($_SESSION['status_login'] != true){
      echo'<script>window.location="login.php"</script>';
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

    <title>Syafa Baby & Kids</title>
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
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
              <a class="nav-link ms-3 me-3" href="produk.php">Product</a>
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
                <input type="text" name="search" placeholder="Cari Produk">
                <input type="submit" name="cari" value="Cari Produk">
            </form>
        </div>
    </div>


   <!-- Home -->
   <section class="home" id="home">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 p-4">
          <h1 class="heading "><span>TOKO</span> SUSU</h1>
          <h2 class="imghome ms-2">
            <img src="photo/1.png"/>
          </h2>
        </div>
        <div class="col-lg-4">
          <div class="tengah">
            <h3 class="l1">
              <img src="photo/g2.png"/>
            </h3>
          <div class="subheading d-flex justify-content-center">Menjual beragam Susu Untuk Anak dan Ibu</div>
          </div>
        </div>
          <div class="col-lg-4 p-4">
            <div class="kanan">
            <h2 class="t1">Belanja <span>Cerdas</span></h2>
            <h2 class="t2">Harga <span>Grosir</h2>
            <h2 class="t3">Pilihan <span>Lengkap</h2>
            </div>
         </div>
        </div>
      </div>
    </section>

    <!-- kategori -->
    <section class="kategori section-margin">
      <div class="conrainer">
        <div class="row text-center">
            <div class="col">
                <h1 class="heading">Our Category</h1>
                <p class="subheading"> Available for all your needs</p>
            </div>
            <div class="box">
                <?php
                    $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id");
                    if(mysqli_num_rows($kategori) > 0){
                        while($k = mysqli_fetch_array($kategori)){
                ?>
                    <a href="produk.php?kat=<?php echo $k['category_id'] ?>">
                        <div class="col-5">
                            <i class='bx bx-category m-2' font-size = "2rem" ></i>
                            <p><?php echo $k['category_name']?></p>
                        </div>
                    </a>
                <?php }}else{ ?>
                    <p>Kategori tidak ada</p>
                <?php } ?>
            </div>
        </div>  
      </div>
    </section>

    <!-- produk -->
    <section class="produk section-margin">
      <div class="conrainer">
        <div class="row text-center">
            <div class="col">
                <h1 class="heading">Our Product</h1>
                <p class="subheading"> Available for all your needs</p>
            </div>
            <div class="box">
                <?php
                    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 ORDER BY product_id DESC LIMIT 6");
                    if(mysqli_num_rows($produk) > 0){
                        while($p = mysqli_fetch_array($produk)){
                ?>
                    <a href="detail-produk.php?id=<?php echo $p['product_id'] ?>">
                    <div class="col-4" style="width: 18rem;">
                      <img src="produk/<?php echo $p['product_image']?>" class="card-img-top" alt="#">
                      <div class="card-body">
                        <h5 class="card-title"><?php echo substr($p['product_name'], 0,30) ?></h5>
                        <p class="card-text">Rp. <?php echo number_format($p['product_price'])?></p>
                        <a href="tambah-keranjang.php?id=<?php echo $p['product_id'] ?>" class="btn btn-primary">Go somewhere</a>
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
