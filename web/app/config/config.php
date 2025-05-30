<?php

(new DotEnv(__DIR__ . '/.env'))->load();

define('BASEURL', getenv('BASEURL'));
define('CA_CERT', getenv('CA_CERT'));


//DB
define('DB_HOST', getenv('DB_HOST'));
define('DB_PORT', getenv('DB_PORT'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));
