<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ETHOS Transaction Check</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">ETHOS-Check</a>
</nav>

<main role="main" class="container" style="margin-top:100px;">

    <div class="starter-template">
        <div class="container">
            <div class="row">
                <?php
                include("ethoschecker.class.php");
                include("transactionchecker.class.php");
                $ethosChecker = new EthosChecker();
                echo $ethosChecker->run();
                ?>
            </div>
        </div>
    </div>

</main><!-- /.container -->

<script src="js/bootstrap.min.js"></script>


</body>
</html>