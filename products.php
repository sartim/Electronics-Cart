<?php
session_start();
include_once("config.php");


//current URL of the Page. cart_update.php redirects back to this URL
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ELECTRONICS | Products</title>

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
<div class="container">
    <div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <h1 align="center">Products </h1>

        <!-- View Cart Box Start -->
        <?php
        if(isset($_SESSION["cart_products"]) && count($_SESSION["cart_products"])>0)
        {
            echo '<div class="cart-view-table-front" id="view-cart">';
            echo '<h3>Your Shopping Cart</h3>';
            echo '<form method="post" action="cart_update.php">';
            echo '<table width="100%"  cellpadding="6" cellspacing="0">';
            echo '<tbody>';

            $total =0;
            $b = 0;
            foreach ($_SESSION["cart_products"] as $cart_itm)
            {
                $product_name = $cart_itm["product_name"];
                $product_qty = $cart_itm["product_qty"];
                $product_price = $cart_itm["product_price"];
                $product_code = $cart_itm["product_code"];
                $product_color = $cart_itm["product_color"];
                $bg_color = ($b++%2==1) ? 'odd' : 'even'; //zebra stripe
                echo '<tr class="'.$bg_color.'">';
                echo '<td>Qty <input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" /></td>';
                echo '<td>'.$product_name.'</td>';
                echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /> Remove</td>';
                echo '</tr>';
                $subtotal = ($product_price * $product_qty);
                $total = ($total + $subtotal);
            }
            echo '<td colspan="4">';
            echo '<button type="submit">Update</button><a href="view_cart.php" class="button">Checkout</a>';
            echo '</td>';
            echo '</tbody>';
            echo '</table>';

            $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
            echo '</form>';
            echo '</div>';

        }
        ?>
        <!-- View Cart Box End -->


        <!-- Products List Start -->
        <?php
        $results = $mysqli->query("SELECT product_code, product_name, product_desc, product_img_name, price FROM products ORDER BY id ASC");
        if($results){
            $products_item = '<ul class="products">';
//fetch results set as object and output HTML
            while($obj = $results->fetch_object())
            {
                $products_item .= <<<EOT
	<li class="product">
	<form method="post" action="cart_update.php">
	<div class="product-content"><h3>{$obj->product_name}</h3>
	<div class="product-thumb"><img src="images/{$obj->product_img_name}"></div>
	<div class="product-desc">{$obj->product_desc}</div>
	<div class="product-info">
	Price {$currency}{$obj->price}

	<fieldset>

	<label>
		<span>Color</span>
		<select name="product_color">
		<option value="Black">Black</option>
		<option value="Silver">Silver</option>
		</select>
	</label>

	<label>
		<span>Quantity</span>
		<input type="text" size="2" maxlength="2" name="product_qty" value="1" />
	</label>

	</fieldset>
	<input type="hidden" name="product_code" value="{$obj->product_code}" />
	<input type="hidden" name="type" value="add" />
	<input type="hidden" name="return_url" value="{$current_url}" />
	<div align="center">
	<button type="submit" class="add_to_cart">Add</button>
	<p>&nbsp;</p>
	<button type="submit" class="#">View</button></div>
	</div></div>
	</form>
	</li>
EOT;
            }
            $products_item .= '</ul>';
            echo $products_item;
        }
        ?>
        <!-- Products List End -->
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