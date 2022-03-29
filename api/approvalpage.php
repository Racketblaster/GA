<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product</title>

    <!-- Bootstrap -->
    <link href="../självahemsidan/css/bootstrap-4.4.1.css" rel="stylesheet">

    <!-- Inported Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;400&display=swap" rel="stylesheet">

    <!-- style -->
    <link href="../självahemsidan/css/style.css" rel="stylesheet">
</head>

<body id="body">
    <!--Denna gör min Navbar-->
    <nav class="navbar navbar-expand-sm  fixed-top navbarColor">
        <a href="../självahemsidan/index.html">
            <img class="navbar-brand logo" alt="Picture not found." src="../självahemsidan/images/logga.png">
        </a>

        <!--Här så görs mina nav-items en hamburgermeny när skärmen blir liten-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!--Mina länkar-->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="../självahemsidan/index.html">Hem</a>
                </li>
            </ul>

        </div>

        <!-- shopping carten -->
        <a href="../api/addToCart.php">
            <img class="ShopCart" alt="Picture not found." src="../självahemsidan/images/bråCart.png">
        </a>
    </nav>

    <div class="background">
        <br>
        <br>
        <br>

        <!--Header-->
        <header class="container rounded col-lg-6 box prodTitel">
            Tack för att du handlar hos oss!
        </header>



        <br>
        <!--Information från köparen-->
        <section class="mb-4 col-lg-6 mx-auto box">
            <h2 class="h1-responsive font-weight-bold text-center my-4">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "remmacs_tech";
                $conn = mysqli_connect($servername, $username, $password, $database);

                session_start();

                $sql = 'SELECT * FROM products WHERE id IN (-1';
                foreach ($_SESSION["cart"] as $value) {
                    if (is_numeric($value["id"])) {
                        $sql = $sql . ", " . $value["id"];
                    }
                }
                $sql = $sql . ")";

                $result = $conn->query($sql);

                if (($result->num_rows) > 0) {
                    while ($row = $result->fetch_assoc()) {
                        foreach ($_SESSION["cart"] as $value) {
                            if ($row['id'] == $value['id']) {
                                $cartQuantity = $value['quantity'];
                                if ($cartQuantity <= $row['quantity']) {
                                    $quantityCart = $row['quantity'] - $cartQuantity;
                                    echo ("Tack för att du köpte: " . $cartQuantity . "st " . $row['name'] . " <br>");
                                    $sql = "UPDATE products SET quantity=" . $quantityCart . " WHERE id=" . $row['id'] . ";";
                                    $conn->query($sql);
                                } else {
                                    echo ("Produkten: " . $row['name'] . " var inte köpt. <br>");
                                }
                            }
                        }
                    }
                    $_SESSION["cart"] = [];
                }
                ?>
            </h2>
        </section>
        <!--Slutet av mitt kontakt formulär-->


        <!--Min fotter-->
        <footer class="container">
            <div class="row">
                <div class="text-center col-lg-6 offset-lg-3">
                    <p class="copyright">Copyright &copy; 2022 &middot; Remmacs tech</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../självahemsidan/js/jquery-3.4.1.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../självahemsidan/js/popper.min.js"></script>
    <script src="../självahemsidan/js/bootstrap-4.4.1.js"></script>

    <!--Här är min Java-Script-->
    <script src="../självahemsidan/js/productBuilder.js"></script>
    <script src="../självahemsidan/js/productPage.js"></script>
</body>

</html>