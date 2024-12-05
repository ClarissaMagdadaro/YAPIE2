<?php

class Cart
{
    private $connDb;
    private $user_id;
    private $product_id;
    private $price;
    private $qty;
    private $discount;
    private $line_total;

    # Constructor
    public function __construct($connDb, $user_id, $product_id, $price, $qty, $discount)
    {
        $this->connDb = $connDb;
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->price = $price;
        $this->qty = $qty;
        $this->discount = $discount;
        $this->line_total = ($price - $discount) * $qty;
    }

    # Save item to the cart
    public function save()
    {
        try {
            $sql = "INSERT INTO cart (user_id, product_id, price, qty, discount, line_total) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->connDb->prepare($sql);
            $stmt->execute([$this->user_id, $this->product_id, $this->price, $this->qty, $this->discount, $this->line_total]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    # Get cart items by user ID
    public static function getCartItemsByUserId($connDb, $user_id)
    {
        try {
            $sql = "SELECT * FROM cart WHERE user_id = ?";
            $stmt = $connDb->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    # Update quantity of an item in the cart
    public function updateQty($new_qty)
    {
        try {
            $this->qty = $new_qty;
            $this->line_total = ($this->price - $this->discount) * $this->qty;

            $sql = "UPDATE cart SET qty = ?, line_total = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $this->connDb->prepare($sql);
            $stmt->execute([$this->qty, $this->line_total, $this->user_id, $this->product_id]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    # Remove item from the cart
    public function remove()
    {
        try {
            $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
            $stmt = $this->connDb->prepare($sql);
            $stmt->execute([$this->user_id, $this->product_id]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>