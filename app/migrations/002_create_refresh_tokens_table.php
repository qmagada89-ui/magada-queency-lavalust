<?php
/*
| Generated with: php lava migration create-migration create_refresh_tokens_table
| (Skip if your project already ships a refresh_tokens migration.)
*/
class Create_refresh_tokens_table {

    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->database();
    }

    public function up()
    {
        $this->_lava->db->raw("
            CREATE TABLE IF NOT EXISTS refresh_tokens (
                id          INT(11) NOT NULL AUTO_INCREMENT,
                user_id     INT(11) NOT NULL,
                token       TEXT NOT NULL,
                expires_at  DATETIME NOT NULL,
                jti         VARCHAR(64) NULL,
                PRIMARY KEY (id),
                KEY idx_refresh_user (user_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public function down()
    {
        $this->_lava->db->raw("DROP TABLE IF EXISTS refresh_tokens");
    }
}
