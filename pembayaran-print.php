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
      </div>
  </section>
    <script>window.print();</script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>