<?php
/*
| Generated with: php lava migration create-migration create_products_table
| Columns follow Laboratory Exercise No. 6 exactly.
*/
class Create_products_table {

    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->database();
    }

    public function up()
    {
        $this->_lava->db->raw("
            CREATE TABLE IF NOT EXISTS products (
                id            INT(11) NOT NULL AUTO_INCREMENT,
                product_name  VARCHAR(100)  NOT NULL,
                description   TEXT          NULL,
                price         DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                quantity      INT(11)       NOT NULL DEFAULT 0,
                created_at    TIMESTAMP     NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public function down()
    {
        $this->_lava->db->raw("DROP TABLE IF EXISTS products");
    }
}
