<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

use MainBoard\Board;

$entry = new Board();
echo ($entry->createBoard());
