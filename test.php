<?php
  session_start();
  include 'db.php';
  if($_SESSION['status_login'] != true){
    echo'<script>window.location="login.php"</script>';
  }
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

    <title>Pesanan || Syafa Baby & Mom</title>
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
              <a class="nav-link active" href="pesanan.php">Pesanan</a>
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
                            $wishlist = mysqli_query($conn, "SELECT * FROM tb_keranjang LEFT JOIN tb_customer USING (customer_id) LEFT JOIN tb_product USING (product_id) WHERE customer_id ='".$_SESSION['id']."'");
                            
                            
                            $no = 1;
                            $total = 0;
                            if(mysqli_num_rows($wishlist)>0){
                            while($row =mysqli_fetch_array($wishlist)){
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['product_name']?></td>
                            <td>Rp. <?php echo number_format($row['product_price'])?></td>
                            <td><a href="produk/<?php echo $row['product_image'] ?>"target="_blank"><img src="produk/<?php echo $row['product_image'] ?>" width="50px"></a></td>
                            <td><?php echo $row['qty']?></td>
                            <td>Rp. <?php echo number_format($row['subtotal'])?></td>
                            
                        </tr>
                        <?php 
                            if($row['keranjang_status'] != 0){
                            $total += $row['subtotal'];
                            }}}else{ 
                        ?>
                          <tr>
                            <td colspan="7" >Tidak ada data</td>
                          </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>

          <div class="container">
            <div class="row">
              <div class="col">
              <a class="d-pesanan pt-2">Bukti Pembanyaran</a>
              <form action="" method="POST"enctype="multipart/form-data">
                <input type="hidden" name="foto" value="<?php echo $o->payment_proof?>" > 
                <input type="file" name="gambar" class="input-field">
                <input type="submit" name="submit" value="Submit" class="submid-btn mb-4">
              </form>
              <?php
              if(isset($_POST['submit'])){
                // menampung inputan dari form
                $foto     = $_POST['foto'];

                // menampung data file yang diupload
                $filename = $_FILES['gambar']['name'];
                $tmp_name = $_FILES['gambar']['tmp_name'];

                if($filename != ''){
                  $type1 = explode('.', $filename);
                  $type2 = $type1[1];

                  $newname = 'payment'.time().'.'.$type2;

                  // menampung data format file yang diizinkan
                  $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');
                  // validasi format file
                  if(!in_array($type2, $tipe_diizinkan)){
                      echo '<script>alert("Format file tidak diizinkan")</script>';
                  }else{

                  // proses upload file sekaligus insert ke database
                    unlink('./payment/' .$foto);
                    move_uploaded_file($tmp_name, './payment/'.$newname);
                    $namagambar = $newname;
                  }
                }else{

                  $namagambar = $foto;

                }
                $updatepayment = mysqli_query($conn, "UPDATE tb_payment SET payment_proof = '".$newname."' WHERE order_id = '".$_GET['id']."'");
                $updateorder = mysqli_query($conn, "UPDATE tb_order SET order_status = 1 WHERE order_id = '".$_GET['id']."'");
                if($updatepayment && $updateorder){
                  echo '<script>alert("Data berhasil ditambahkan")</script>';
                  echo'<script>window.location="pesanan.php"</script>';
                }else{
                    echo'gagal' .mysqli_error($conn);
                }
                
              }
            ?>
              </div>
            </div>
          </div>
          <a href="pembayaran-print.php?id=<?php echo $_GET['id'] ?>">Cetak</a>
      </div>
  </section>


    
    <!--footer-->
    <section class="footer"id="footer">
      <div class="container">
        <div class="row">
          <div class="col">
            <a class="b-footer d-flex justify-content-center text-alight-center mt-5">Alamat</a>
            <a class="b-footer d-flex justify-content-center text-alight-center"><?php echo $a->admin_address?></a>
            <a class="b-footer d-flex justify-content-center text-alight-center mt-3">Email</a>
            <a class="b-footer d-flex justify-content-center text-alight-center"><?php echo $a->admin_email ?></a>
            <a class="b-footer d-flex justify-content-center text-alight-center mt-3">No. HP</a>
            <a class="b-footer d-flex justify-content-center text-alight-center"><?php echo $a->admin_telp?></a>
            <a class="b-footer d-flex justify-content-center text-alight-center mt-5 mb-2">Copyright &copy 2022 by Syafa Baby - DKI Jakarta</a>
          </div>
        </div>
      </div>
    </section>
    
  


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>