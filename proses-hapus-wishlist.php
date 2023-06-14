<?php
    include 'db.php';

    if(isset($_GET['idp'])){
        $delete = mysqli_query($conn, "DELETE FROM tb_keranjang WHERE product_id = '".$_GET['idp']."' ");

        echo'<script>window.location="checkout.php"</script>';
    }

?>