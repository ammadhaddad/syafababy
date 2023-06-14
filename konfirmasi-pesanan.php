<?php
    include 'db.php';

    if(isset($_GET['id'])){
        $delete = mysqli_query($conn, "UPDATE  tb_order SET order_status = '4' WHERE order_id = '".$_GET['id']."'");
        echo '<script>alert("Paket Telah Diterima")</script>';
        echo'<script>window.location="pesanan.php"</script>';
    }


?>