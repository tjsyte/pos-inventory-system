<?php

require_once __DIR__.'/../_init.php';

class Sales
{
    public static function getTodaySales()
    {
        global $connection;

        $sql_command = ("
            SELECT 
                SUM(order_items.quantity*order_items.price) as today,
                DATE_FORMAT(orders.created_at, '%Y-%m-%d') as _date
            FROM 
                `order_items` 
            INNER JOIN 
                orders on order_items.order_id = orders.id 
            WHERE Date(created_at)=Curdate()
            GROUP BY 
                _date;
        ");

        $stmt = $connection->prepare($sql_command);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll();

        if (count($result) >= 1) {
            return $result[0]['today'];
        }

        return 0;
    }

    
    public static function getTotalSales()
    {
        global $connection;

        $sql_command = "SELECT SUM(quantity*price) as total FROM order_items";

        $stmt = $connection->prepare($sql_command);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll();

        if (count($result) >= 1) {
            return $result[0]['total'];
        }

        return 0;
    }

    public static function resetSales() {
        global $connection;

        $sql_command = "TRUNCATE TABLE order_items";

        $stmt = $connection->prepare($sql_command);
        $stmt->execute();
    }

    public static function addSale($productId, $quantity, $price) {
    global $connection;

    $sql_command = 'INSERT INTO order_items (product_id, quantity, price) VALUES (:product_id, :quantity, :price)';
    $stmt = $connection->prepare($sql_command);
    $stmt->bindParam('product_id', $productId);
    $stmt->bindParam('quantity', $quantity);
    $stmt->bindParam('price', $price);
    $stmt->execute();
}


}