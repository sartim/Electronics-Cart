<?php
session_start();
include_once("config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ELECTRONICS | Cart</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/heroic-features.css" rel="stylesheet">
    <link href="style/style.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">ELECTRONICS</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="products.php">Products</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!-- Page Content -->
<div class="container">
	<p>&nbsp;</p>
	<p>&nbsp;</p>
    <h1 align="center">View Cart</h1>
    <div class="cart-view-table-back">
        <form method="post" action="cart_update.php">
            <table width="100%"  cellpadding="6" cellspacing="0"><thead><tr><th>Quantity</th><th>Name</th><th>Price</th><th>Total</th><th>Remove</th></tr></thead>
                <tbody>
                <?php
                if(isset($_SESSION["cart_products"])) //check session var
                {
                    $total = 0; //set initial total value
                    $b = 0; //var for zebra stripe table
                    foreach ($_SESSION["cart_products"] as $cart_itm)
                    {
                        //set variables to use in content below
                        $product_name = $cart_itm["product_name"];
                        $product_qty = $cart_itm["product_qty"];
                        $product_price = $cart_itm["product_price"];
                        $product_code = $cart_itm["product_code"];
                        $product_color = $cart_itm["product_color"];
                        $subtotal = ($product_price * $product_qty); //calculate Price x Qty

                        $bg_color = ($b++%2==1) ? 'odd' : 'even'; //class for zebra stripe
                        echo '<tr class="'.$bg_color.'">';
                        echo '<td><input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" /></td>';
                        echo '<td>'.$product_name.'</td>';
                        echo '<td>'.$currency.$product_price.'</td>';
                        echo '<td>'.$currency.$subtotal.'</td>';
                        echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /></td>';
                        echo '</tr>';
                        $total = ($total + $subtotal); //add subtotal to total var
                    }

                    $grand_total = $total + $shipping_cost; //grand total including shipping cost
                    foreach($taxes as $key => $value){ //list and calculate all taxes in array
                        $tax_amount     = round($total * ($value / 100));
                        $tax_item[$key] = $tax_amount;
                        $grand_total    = $grand_total + $tax_amount;  //add tax val to grand total
                    }

                    $list_tax       = '';
                    foreach($tax_item as $key => $value){ //List all taxes
                        $list_tax .= $key. ' : '. $currency. sprintf("%01.2f", $value).'<br />';
                    }
                    $shipping_cost = ($shipping_cost)?'Shipping Cost : '.$currency. sprintf("%01.2f", $shipping_cost).'<br />':'';
                }
                ?>
                <tr><td colspan="5"><span style="float:right;text-align: right;"><?php echo $shipping_cost. $list_tax; ?>Amount Payable : <?php echo sprintf("%01.2f", $grand_total);?></span></td></tr>
                <tr><td colspan="5"><a href="index.php" class="button">Add More Items</a><button type="submit">Update</button></td></tr>
                </tbody>
            </table>
            <input type="hidden" name="return_url" value="<?php
            $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            echo $current_url; ?>" />
        </form>
    </div>

    <hr>

    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; ELECTRONICS 2015</p>
                <p>Developed by  <a href="http://tymevotec.somee.com/">TYMEVOTEC</a></p>
            </div>
        </div>
    </footer>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
