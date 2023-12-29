<?php require_once("config.php");
require_once("router.php");
require_once("rb-sqlite.php");

$init_db = !file_exists(DB_FILE);

R::setup('sqlite:'.DB_FILE);
R::freeze(true);

/* check connection */
if (!R::testConnection()) {
    die('{"status": "false", "message": "Failed to connect to database"}');
}

if ($init_db) {
    R::exec('CREATE TABLE feedbacks (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(50),
        email VARCHAR(50),
        feedback VARCHAR(250),
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
    )');
}
?>