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
    <!-- Home -->
   <section class="data keranjang" id="home">
        <div class="container">
        <h3 class = "top">Produk</h3>
            <div class="row">
                <table  border="3" cellspacing="0" class = "table">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>QTY</th>
                            <th>Status</th>
                            <th>Sub total</th>
                            <th width="150px">Aksi</th>
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
                            <td><?php echo ($row['keranjang_status'] == 0)? 'Tidak Aktif' : 'Aktif' ?></td>
                            <td>Rp. <?php echo number_format($row['subtotal'])?></td>
                            <td>
                            <a href="edit-wishlist.php?idp=<?php echo $row['product_id'] ?>" >Edit</a>||<a href="proses-hapus-wishlist.php?idp=<?php echo $row['product_id'] ?>" onclick="return confirm('Yakin ingin hapus ?')">Hapus</a>
                            </td>
                            
                        </tr>
                        <?php 
                            if($row['keranjang_status'] != 0){
                            $total += $row['subtotal'];
                            }
                          $total+= 15000;}}else{ 
                        ?>
                          <tr>
                            <td colspan="7" >Tidak ada data</td>
                          </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <!-- Content -->
    <section class="content" id="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 mb-5">
          <h3 class = "top d-flex justify-content-center">Profil</h3>
            <form action="" method="POST">
              <input type="text" name="nama" placeholder="Nama Lengkap" class="input-field mb-4" value="<?php echo $c->customer_name?>" required>
              <input type="text" name="hp" placeholder="No Hp" class="input-field mb-4" value="<?php echo $c->customer_telp?>" required>
              <input type="email" name="email" placeholder="Email" class="input-field mb-4" value="<?php echo $c->customer_email?>" required>
              <input type="text" name="alamat" placeholder="Alamat" class="input-field mb-4" value="<?php echo $c->customer_address?>" required>
            </form>
            <?php
              $nama   = $c->customer_name;
              $hp     = $c->customer_telp;
              $email  = $c->customer_email;
              $alamat = $c->customer_address;
            ?>
          </div>
          <div class="col-lg-6 mb-5">
          <h3 class = "top d-flex justify-content-center">Checkout</h3>
            <form action="" method="POST">
              <h3 class="input-field mb-4  d-flex justify-content-start">Ongkos Pengiriman : Rp. 15.000</h3>
              <h3 type="text" name="total" placeholder="Total" class="input-field mb-4">Total : Rp. <?php echo number_format($total)?></h3>
              <select name="pembanyaran" class="input-field" required>
                <option value="">--Metode Pembanyaran--</option>
                <option value="1">Tranfer Bank Manual</option>
                <option value="0">COD</option>
              </select>
              <input type="submit" name="submit" value="Submid" class="submid-btn mb-4">
            </form>
            <?php
              if(isset($_POST['submit'])){
                $pengiriman = $_POST['pengiriman'];
                $pembanyaran = $_POST['pembanyaran'];

                $wishlist = mysqli_query($conn, "SELECT * FROM tb_keranjang LEFT JOIN tb_customer USING (customer_id) LEFT JOIN tb_product USING (product_id) WHERE customer_id ='".$_SESSION['id']."'");
                $payment = mysqli_query($conn, "SELECT * FROM tb_order WHERE customer_id ='".$_SESSION['id']."'");


                  while($row =mysqli_fetch_array($wishlist)){
                    if($row['keranjang_status'] != 0){
                      if($pembanyaran == 0){
                        $insert_tb_order = mysqli_query($conn, "INSERT INTO tb_order(product_id,product_name,product_price,qty,method_payment,ongkir,customer_id,customer_name,customer_address,customer_telp,customer_email,	order_status) VALUE('".$row['product_id']."','".$row['product_name']."','".$row['product_price']."','".$row['qty']."','".$pembanyaran."','".$pengiriman."','".$_SESSION['id']."','".$nama."','".$alamat."','".$hp."','".$email."',2)");

                        $order = mysqli_query($conn, "SELECT * FROM tb_order WHERE product_id = '".$row['product_id']."' ");
                        while($row =mysqli_fetch_array($order)){
                          if($row['customer_id'] == $_SESSION['id'] ){
                          //if($insert_tb_order['customer_id'] == $_SESSION['id'] )
                            $insert_tb_konfirmasi = mysqli_query($conn, "INSERT INTO tb_payment(order_id,product_name,product_price,qty,customer_id,customer_name,customer_address,customer_telp,method_payment,payment_status) VALUE('".$row['order_id']."','".$row['product_name']."','".$row['product_price']."','".$row['qty']."','".$row['customer_id']."','".$row['customer_name']."','".$row['customer_address']."','".$row['customer_telp']."','".$pembanyaran."',1)");
                          }
                        }
                      }else{
                        $insert_tb_order = mysqli_query($conn, "INSERT INTO tb_order(product_id,product_name,product_price,qty,method_payment,ongkir,customer_id,customer_name,customer_address,customer_telp,customer_email,	order_status) VALUE('".$row['product_id']."','".$row['product_name']."','".$row['product_price']."','".$row['qty']."','".$pembanyaran."','".$pengiriman."','".$_SESSION['id']."','".$nama."','".$alamat."','".$hp."','".$email."',0)");

                        $order = mysqli_query($conn, "SELECT * FROM tb_order WHERE product_id = '".$row['product_id']."' ");
                        while($row =mysqli_fetch_array($order)){
                          if($row['customer_id'] == $_SESSION['id'] ){
                          //if($insert_tb_order['customer_id'] == $_SESSION['id'] )
                            $insert_tb_konfirmasi = mysqli_query($conn, "INSERT INTO tb_payment(order_id,product_name,product_price,qty,customer_id,customer_name,customer_address,customer_telp,method_payment,payment_status) VALUE('".$row['order_id']."','".$row['product_name']."','".$row['product_price']."','".$row['qty']."','".$row['customer_id']."','".$row['customer_name']."','".$row['customer_address']."','".$row['customer_telp']."','".$pembanyaran."',0)");
                          }
                        }

                      }

                      if($insert_tb_order && $insert_tb_konfirmasi){
                        echo '<script>alert("Pembelian berhasil")</script>';
                        echo'<script>window.location="pesanan.php"</script>';
                      }else{
                        echo'gagal'.mysqli_error($conn);
                      }
                    }
                  }
              } 
            ?>
            

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




    <script>
    </script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>