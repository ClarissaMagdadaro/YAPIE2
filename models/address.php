<?php

class Address {
    private $connDb;
    private $user_id;
    private $addr_line1;
    private $addr_line2;
    private $city;
    private $region;
    private $postal_code;
    private $country;
    private $addr_type;

    // Constructor
    public function __construct($connDb, $user_id, $addr_line1, $addr_line2, $city, $region, $postal_code, $country, $addr_type) {
        $this->connDb = $connDb;
        $this->user_id = $user_id;
        $this->addr_line1 = $addr_line1;
        $this->addr_line2 = $addr_line2;
        $this->city = $city;
        $this->region = $region;
        $this->postal_code = $postal_code;
        $this->country = $country;
        $this->addr_type = $addr_type;
    }

    // Save the address
    public function save() {
        try {
            $sql = "INSERT INTO address (user_id, addr_line1, addr_line2, city, region, postal_code, country, addr_type)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connDb->prepare($sql);
            $stmt->execute([$this->user_id, $this->addr_line1, $this->addr_line2, $this->city, $this->region, $this->postal_code, $this->country, $this->addr_type]);
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
}
?>