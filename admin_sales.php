<?php
require_once '_guards.php';
Guard::adminOnly();

require_once 'models/Sales.php';

$todaySales = Sales::getTodaySales();
$totalSales = Sales::getTotalSales();
$transactions = OrderItem::all();

if (isset($_POST['reset_sales'])) {
    Sales::resetSales();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sales</title>
    <link rel="icon" type="image/x-icon" href="icon.ico">
    <link rel="stylesheet" type="text/css" href="css/main-style.css">
    <link rel="stylesheet" type="text/css" href="css/admin-panel.css">
    <link rel="stylesheet" type="text/css" href="css/table-style.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="./js/datatable.js"></script>
    <script src="./js/main.js"></script>

    <style>
        .reset-button {
            background-color: #6295A2;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            transition-duration: 0.4s;
            cursor: pointer;
            border-radius: 4px;
        }

        .reset-button:hover {
            background-color: #A25772;
        }
    </style>
</head>

<body>
    <?php require 'templates/admin_header.php' ?>

    <div class="flex">
        <?php require 'templates/admin_navbar.php' ?>
        <main>

            <div class="flex">
                <div style="flex: 2; padding: 16px;">
                    <div class="subtitle">Sales Information</div>
                    <hr />

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Today's Sales</div>
                        </div>
                        <div class="card-content">
                            <?= $todaySales ?> PHP
                        </div>
                    </div>

                    <div class="card mt-16">
                        <div class="card-header">
                            <div class="card-title">Total Sales</div>
                        </div>
                        <div class="card-content">
                            <?= $totalSales ?> PHP
                        </div>
                    </div>

                    <form action="" method="post" onsubmit="return confirmReset();">
                        <input type="hidden" name="reset_sales_confirm" id="reset_sales_confirm" value="no">
                        <button type="submit" name="reset_sales" class="reset-button">
                            <i class="fa fa-refresh"></i> Reset Sales
                        </button>
                    </form>


                </div>
                <div style="flex: 5; padding: 16px">
                    <div class="subtitle">Transactions</div>
                    <hr />

                    <table id="transactionsTable">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $transaction) : ?>
                                <tr>
                                    <td><?= $transaction->product_name ?></td>
                                    <td><?= $transaction->quantity ?></td>
                                    <td><?= $transaction->price ?></td>
                                    <td><?= $transaction->quantity * $transaction->price ?> PHP</td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </main>
    </div>

    <script type="text/javascript">
        var dataTable = new simpleDatatables.DataTable("#transactionsTable");
    </script>

    <script>
        function confirmReset() {
            return confirm("Are you sure you want to reset the sales data?");
        }
    </script>

</body>

</html>