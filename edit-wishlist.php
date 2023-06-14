<?php
  session_start();
  include 'db.php';
  if($_SESSION['status_login'] != true){
    echo'<script>window.location="login.php"</script>';
  }
  $wishlist = mysqli_query($conn, "SELECT * FROM tb_keranjang JOIN tb_customer USING (customer_id) JOIN tb_product USING (product_id) WHERE  product_id = '".$_GET['idp']."' ");
  $w = mysqli_fetch_object($wishlist);

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
          <a class="navbar-brand" href="#">
            <img src="photo/icon 2.png"/>
            <span>Syafa </span>Baby <span>&</span> Moms</a>
          <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link " aria-current="page" href="index.php">Home</a>
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


    <!-- Content -->
    <div class="section">
      <div class="container">
        <h3 class = "top d-flex justify-content-center">Edit Wishlist</h3>
          <div class="row">
            <form action="" method="POST"enctype="multipart/form-data">
              <h4 class = "input-field">Nama Produk : <?php echo $w->product_name?></h4>
              <h4 class = "input-field"> Harga Per Produck : Rp. <?php echo number_format($w->product_price)?></h4>
              <img src ="produk/<?php echo $w->product_image?>" width="100px">
              <input type="hidden" name="foto" value="<?php echo $w ->product_image?>" >
              <input type="number" min="0" name="qty" placeholder="Kuantitas" class="input-field" value="<?php echo $w->qty?>"required>
              <select name="status" class="input-field">
                <option value="">--Pilih--</option>
                <option value="1"<?php echo ($w->product_status == 1 )? 'selected': '' ?>>Aktif</option>
                <option value="0"<?php echo ($w->product_status == 0 )? 'selected': '' ?>>TIdak Aktif</option>
              </select>
                <input type="submit" name="submit" value="Submit" class="submid-btn mb-4">
            </form>
            <?php
              if(isset($_POST['submit'])){
                // menampung inputan dari form
                $qty        = $_POST['qty'];
                $status     = $_POST['status'];
                $subtotal = $w->product_price * $qty;
                //query update data produk
                $update = mysqli_query($conn, "UPDATE tb_keranjang SET qty = '".$qty."',keranjang_status = '".$status."', subtotal = '".$subtotal."' WHERE product_id = '".$_GET['idp']."' ");

                if($update){
                    echo '<script>alert("Data berhasil diubah")</script>';
                    echo'<script>window.location="checkout.php"</script>';
                }else{
                    echo'gagal' .mysqli_error($conn);
                }

              }


              
            ?>
          </div>
      </div>
    </div>
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


    <script>
    </script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
      CKEDITOR.replace( 'deskripsi' );
    </script>
  </body>
</html>