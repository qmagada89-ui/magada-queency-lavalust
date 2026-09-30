<?php
/*
| Generated with: php lava migration create-migration create_users_table
| Keep the file name the generator gave you; paste this class in.
| (Skip this file if your project already ships a users migration —
|  check with: php lava migration status)
*/
class Create_users_table {

    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->database();
    }

    public function up()
    {
        $this->_lava->db->raw("
            CREATE TABLE IF NOT EXISTS users (
                id          INT(11) NOT NULL AUTO_INCREMENT,
                username    VARCHAR(50)  NOT NULL UNIQUE,
                email       VARCHAR(100) NOT NULL UNIQUE,
                password    VARCHAR(255) NOT NULL,
                role        VARCHAR(20)  DEFAULT 'user',
                created_at  TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public function down()
    {
        $this->_lava->db->raw("DROP TABLE IF EXISTS users");
    }
}
