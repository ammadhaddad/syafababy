<?php
    session_start();
    error_reporting(0);
    include 'db.php';
    if($_SESSION['status_login'] != true){
      echo'<script>window.location="login.php"</script>';
    }
    $customer = mysqli_query($conn, "SELECT * FROM  tb_customer WHERE customer_id = '".$_SESSION['id']."'");
    $c = mysqli_fetch_array($customer);
    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '".$_GET['id']."' ");
    $p = mysqli_fetch_array($produk);
    $keranjang = mysqli_query($conn, "SELECT * FROM tb_keranjang WHERE customer_id = '".$_SESSION['id']."'AND product_id = '".$_GET['id']."'");
    $k = mysqli_fetch_array($keranjang);

    if($k['product_id'] != $p['product_id']){

      $insertcart = mysqli_query($conn, "INSERT INTO tb_keranjang(customer_id, customer_name, product_id, product_name, keranjang_status,qty) SELECT'".$c['customer_id']."','".$c['customer_name']."','".$p['product_id']."','".$p['product_name']."', 0,0");

      if($insertcart){
        echo '<script>alert("Berhasil Menambahkan ke Keranjang")</script>';
        echo'<script>window.location="produk.php"</script>';
      }else{
        echo'gagal' .mysqli_error($conn);
      }
    }else{
      echo '<script>alert("Produk sudah ada di Keranjang")</script>';
      echo'<script>window.location="produk.php"</script>';
    }
    
?>