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
              <a class="nav-link active me-4" href="data-produk.php">Data Product</a>
              <a class="nav-link me-4" href="data-kategori.php">Data Kategori</a>
              <a class="nav-link me-4" href="data-pesanan.php">Pesanan</a>
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
        <h3 class = "top d-flex justify-content-center">Tambah Produk</h3>
          <div class="row">
            <form action="" method="POST"enctype="multipart/form-data">
              <select name="kategori" class="input-field" required>
                <option value="">--Pilih--</option>
                  <?php
                    $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                          while($r = mysqli_fetch_array($kategori)){
                  ?>
                <option value="<?php echo $r['category_id'] ?>"><?php echo $r['category_name'] ?></option>
                  <?php } ?>
              </select>
              <input type="text" name="nama" placeholder="Nama Produk" class="input-field" required>
              <input type="text" name="harga" placeholder="Harga" class="input-field" required>
              <input type="file" name="gambar" class="input-field" required>
              <textarea name="deskripsi" placeholder="Deskripsi" class="input-field"></textarea>
              <select name="status" class="input-field">
                <option value="">--Pilih--</option>
                <option value="1">Aktif</option>
                <option value="0">TIdak Aktif</option>
              </select>
                <input type="submit" name="submit" value="Submit" class="submid-btn mb-4">
            </form>
            <?php
              if(isset($_POST['submit'])){
                // menampung inputan dari form
                $kategori   = $_POST['kategori'];
                $nama       = $_POST['nama'];
                $harga      = $_POST['harga'];
                $deskripsi  = $_POST['deskripsi'];
                $status     = $_POST['status'];

                // menampung data file yang diupload
                $filename = $_FILES['gambar']['name'];
                $tmp_name = $_FILES['gambar']['tmp_name'];

                $type1 = explode('.', $filename);
                $type2 = $type1[1];

                $newname = 'produk'.time().'.'.$type2;

                // menampung data format file yang diizinkan
                $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');
                // validasi format file
                if(!in_array($type2, $tipe_diizinkan)){
                    echo '<script>alert("Format file tidak diizinkan")</script>';
                }else{

                // proses upload file sekaligus insert ke database
                  move_uploaded_file($tmp_name, './produk/'.$newname);
                  $insert = mysqli_query($conn, "INSERT INTO tb_product   VALUES(null, '".$kategori."', '".$nama."', '".$harga."', '".$deskripsi."', '".$newname."', '".$status."', null )");
                      if($insert){
                        echo '<script>alert("Data berhasil ditambahkan")</script>';
                        echo'<script>window.location="data-produk.php"</script>';
                      }else{
                          echo'gagal' .mysqli_error($conn);
                      }
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