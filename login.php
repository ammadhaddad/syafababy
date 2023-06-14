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

    <title>Login || Syafa Baby & Mom</title>
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
          <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
            <div class="navbar-nav me-5">
              <a class="nav-link-login  me-4" aria-current="page" href="dashboard.php">Butuh bantuan?</a>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <!-- login -->
    <section class="login">
      <div class="container mb-5" id="loginpage">
        <div class="row">
          <div class="imglatar">
            <div class="imglogin">
              <img src="photo/1.png" alt="#">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4">
            <div class="kiri1">
              <h1 class="kotak1"></h1>
            </div>
          </div>
          <div class="col-lg-4 px-10">
            <div class="tengah1">
              <h1 class="kotak1"></h1>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="formlogin"> 
              <div class="form-box">
                <div class="button-box">
                  <div id="btn"></div>
                  <button type="button" class="toggle-btn" onclick="login()">Log In</button>
                  <button type="button" class="toggle-btn" onclick="register()">Register</button>
                </div>
                <div class="social-icon" href="#">
                  <img src="photo/f.png">
                  <img src="photo/t.png">
                  <img src="photo/g.png" alt="#">
                </div>
                <form id="login" method= "POST" class="input-group">
                  <input type="text" name="user" class="input-field" placeholder="Username" required>
                  <input type="password" name="pass" class="input-field" placeholder="Enter password" required>
                  <input type="checkbox" class="check-box"><span>Remember Password</span>
                  <button type="submit" name="submit" class="submid-btn ms-4" >Log In</button>
                </form>
                <?php
                      if(isset($_POST['submit'])){
                          session_start();
                          include 'db.php';
                          $user_customer_login = mysqli_real_escape_string($conn, $_POST['user']);
                          $pass_customer_login = mysqli_real_escape_string($conn, $_POST['pass']);

                          $cek = mysqli_query($conn, "SELECT * FROM  tb_customer WHERE username = '".$user_customer_login."' AND password = '".$pass_customer_login."'");

                          if(mysqli_num_rows($cek) > 0 ) {
                              $d = mysqli_fetch_object($cek);
                              $_SESSION['status_login'] = true;
                              $_SESSION['u_global'] = $d;
                              $_SESSION['id'] = $d->customer_id;
                              echo'<script>window.location="index.php"</script>';

                          }else{
                              echo'<script>alert("Username atau password Anda salah!")</script>';
                          }
                      }
                  ?>
                <form id="register" method= "POST" class="input-group">
                  <input type="text" class="input-field" placeholder="Username" name="user" required>
                  <input type="email" class="input-field" placeholder="Email" name="email"required>
                  <input type="password" name="pass" class="input-field" placeholder="Enter password" required>
                  <input type="checkbox" class="check-box"><span>I agree to the terms & conditions</span>
                  <button type="submit" name="register" class="submid-btn ms-4">Register</button>
                </form>
                <?php
                  if(isset($_POST['register'])){
                    session_start();
                    include 'db.php';
                    $user_customer_register = mysqli_real_escape_string($conn, $_POST['user']);
                    $email_customer_register = mysqli_real_escape_string($conn, $_POST['email']);
                    $pass_customer_register = mysqli_real_escape_string($conn, $_POST['pass']);
                    
                    $insert = mysqli_query($conn, "INSERT INTO tb_customer(username, customer_email, password) 
                    VALUE('".$user_customer_register."','".$email_customer_register."','".$pass_customer_register."')");

                    if($insert){
                      echo '<script>alert("Anda Berhasil Membuat Akun")</script>';
                      echo'<script>window.location="index.php"</script>';
                    }else{
                      echo'gagal' .mysqli_error($conn);
                    }
                  }
                
                ?>
                
            </div>
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
            <a class="b-footer d-flex justify-content-center text-alight-center">Jl.xxxxxxxxxxxxxxxx</a>
            <a class="b-footer d-flex justify-content-center text-alight-center mt-3">Email</a>
            <a class="b-footer d-flex justify-content-center text-alight-center">syafababy@gmail.com</a>
            <a class="b-footer d-flex justify-content-center text-alight-center mt-3">No. HP</a>
            <a class="b-footer d-flex justify-content-center text-alight-center">08xxxxxxxxxx</a>
            <a class="b-footer d-flex justify-content-center text-alight-center mt-5 mb-2">Copyright &copy 2022 by Syafa Baby - DKI Jakarta</a>
          </div>
        </div>
      </div>
    </section>
    <script>
    var x = document.getElementById("login");
        var y = document.getElementById("register");
        var z = document.getElementById("btn");

        function register(){
            x.style.left ="-400px";
            y.style.left ="50px";
            z.style.left ="110px";
        }
        function login(){
            x.style.left ="50px";
            y.style.left ="450px";
            z.style.left ="0px";
        }
    </script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
