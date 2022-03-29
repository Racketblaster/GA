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
        <!--Sökfältet och sökknappen-->
        <div class="container rounded col-lg-8">
            <div class="input-group col-lg-8">
                <input id="search" type="search" class="form-control rounded" placeholder="Starta din sökning" aria-label="Search">
                <button id="search-button" type="button" class="btn btn-outline-light" onclick="searchProd()">Sök</button>
            </div>
            <!--Sök resultatet-->
            <table id="resultat" class="container rounded col-lg-8 box resultPos">
            </table>
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
        <header class="container rounded col-lg-4 box prodTitel">
            Din kundvagn
        </header>

        <br>
        <br>

        <main class="container">


            <table id="resultat" class="container rounded col-lg-8 box">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "remmacs_tech";
                $conn = mysqli_connect($servername, $username, $password, $database);

                session_start();
                #$_SESSION["idTag"] = $_POST["idTag"];


                if (empty($_SESSION["cart"])) {
                    $_SESSION["cart"] = [];
                }

                if (!empty($_POST["idTag"])) {
                    //echo "Add to cart....";
                    $key = array_search($_POST["idTag"], array_column($_SESSION["cart"], 'id'));
                    //echo "Key:" . $key . "<br>";

                    if (is_numeric($key)) {
                        //echo("Unsetting key " . $key);
                        array_splice($_SESSION["cart"], $key, 1);
                    }

                    $nyProdukt = array(
                        "id" => $_POST["idTag"],
                        "quantity" => $_POST["quantityTag"]
                    );
                    array_push($_SESSION["cart"], $nyProdukt);
                } elseif (!empty($_POST["removeIdFromCart"])) {
                    //echo "Remove from cart...";
                    $key = array_search($_POST["removeIdFromCart"], array_column($_SESSION["cart"], 'id'));
                    //echo "Key:" . $key . "<br>";

                    if (is_numeric($key)) {
                        //echo("Unsetting key " . $key);
                        array_splice($_SESSION["cart"], $key, 1);
                    }
                } else {
                    //echo "View cart...";
                }



                //Display cart

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
                            }
                        }
                        //echo ($row['name']);
                        echo ('<tr class="col-md-6">');
                        echo ('    <td class="sokBildKolumn"><img src="' . $row['picture'] . '"');
                        echo ('            class="sokBild"></td>');
                        echo ('    <td><a href="../självahemsidan/productPage.html?productId=' . $row["id"] . '" class="sokText">' . $row['name'] . ', ' . $cartQuantity . 'st (' . $row["price"] . 'kr/st) </a>' .
                            '<form action="../api/addToCart.php" method="post">
                    <input type="hidden" name="removeIdFromCart" id="removeIdFromCart" value="' . $row["id"] . '">
                    <input type="submit" value="Delete" class="btn btn-danger btn-md">
                    </form>');
                        echo ('</tr>');
                    }
                } else {
                    echo '<h3 class="container rounded col-lg-8 box centerText">Din kundvagn är tom</h3>';
                }
                ?>



            </table>
        </main>
        <br>

        <div class="col text-center">
            <button class="btn btn-success btn-lg" onclick="window.location.href='../api/buyproduct.php'">Gå till betalning</button>
        </div>

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
    <script src="../självahemsidan/js/index.js"></script>
</body>

</html>