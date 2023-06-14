<?php
  session_start();
  include 'db.php';
  if($_SESSION['status_login'] != true){
    echo'<script>window.location="login.php"</script>';
  }
  $query = mysqli_query($conn, "SELECT * FROM tb_customer WHERE customer_id = '".$_SESSION['id']."'");
  $c = mysqli_fetch_object($query);
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

    <title>Profil || Syafa Baby & Mom</title>
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
    <section class="profil" id="profil">
      <div class="container">
        <h3 class = "top d-flex justify-content-center">Profil</h3>
          <div class="row">
            <form action="" method="POST">
              <input type="text" name="nama" placeholder="Nama Lengkap" class="input-field mb-4" value="<?php echo $c->customer_name?>" required>
              <input type="text" name="user" placeholder="Username" class="input-field mb-4" value="<?php echo $c->username?>" required>
              <input type="text" name="hp" placeholder="No Hp" class="input-field mb-4" value="<?php echo $c->customer_telp?>" required>
              <input type="email" name="email" placeholder="Email" class="input-field mb-4" value="<?php echo $c->customer_email?>" required>
              <input type="text" name="alamat" placeholder="Alamat" class="input-field mb-4" value="<?php echo $c->customer_address?>" required>
              <input type="submit" name="submit" value="Ubah Profil" class="profile-btn mb-4">
              <a href="logout.php" class="profile-btn mb-4" onclick="return confirm('Yakin ingin Keluar ?')">Keluar</a>
            </form>
            <?php
              if(isset($_POST['submit'])){

                $nama   = $_POST['nama'];
                $user   = $_POST['user'];
                $hp     = $_POST['hp'];
                $email  = $_POST['email'];
                $alamat = $_POST['alamat'];

                $update = mysqli_query($conn, "UPDATE tb_customer SET customer_name = '".$nama."',username = '".$user."',customer_telp = '".$hp."',customer_email = '".$email."',customer_address = '".$alamat."' WHERE customer_id = '".$c->customer_id."' ");

                if($update){
                  echo '<script>alert("Ubah data berhasil")</script>';
                  echo'<script>window.location="profil.php"</script>';
                }else{
                  echo'gagal'.mysqli_error($conn);
                }
              }
            ?>
          <h3 class = "top d-flex justify-content-center mt-5">Ubah Password</h3>
          <div class="row">
            <form action="" method="POST">
              <input type="password" name="pass-old" class="input-field mb-4" placeholder="Password Lama" required>
              <input type="password" name="pass-new" class="input-field mb-4" placeholder="Password Baru" required>
              <input type="password" name="confirm-pass-new" class="input-field mb-4" placeholder="Konfirmasi Password Baru" required>
              <input type="submit" name="ubah-password" value="Ubah Profil" class="profile-btn mb-4">
            </form>
            <?php
              if(isset($_POST['ubah-password'])){

                $passlama           = $_POST['pass-old'];
                $passbaru           = $_POST['pass-new'];
                $konformasipass     = $_POST['confirm-pass-new'];

                if($passlama = $c->password AND $passbaru = $konformasipass ){
                  $update = mysqli_query($conn, "UPDATE tb_customer SET password = '".$passbaru."' WHERE customer_id = '".$c->customer_id."' ");

                  if($update){
                    echo '<script>alert("Ubah data berhasil")</script>';
                    echo'<script>window.location="profil.php"</script>';
                  }else{
                    echo'gagal'.mysqli_error($conn);
                  }
                  
                }else{
                  echo'gagal'.mysqli_error($conn);
                  echo '<script>alert("Password Salah")</script>';
                }
              }
            ?>
            
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


    <script>
    </script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>