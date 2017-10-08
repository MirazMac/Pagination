<?php

/**
 * Sample Use of PaginationLinks with PDO and SQLite
 * Works with other databases like MySQL, MSSQL etc. too!
 *
 * @package PaginantionLinks
 */

require_once '../src/Pagination.php';

use MirazMac\Pagination\Pagination;

// Database file path
$db_file = __DIR__ .'/demoDataBase.sqlite';

// Connect to database using PDO
$db = new PDO('sqlite:'.$db_file);

// Current page number
$current_page = (int)@$_GET['page'];

// Number of items/rows per page
$items_per_page = 10;

// Fetch Number of total items from database
$sql = "SELECT COUNT(id) AS total_count FROM demoTable";
$query = $db->prepare($sql);
$query->execute();

$total_items = $query->fetch()['total_count'];

// Create pagination instance
$pagination = new Pagination($total_items, $current_page);
$pages = $pagination->parse();

// Get offset number
$start = $pagination->offset();
// Query the database to fetch paginated rows
$sql = "SELECT * FROM `demoTable` LIMIT $start, $items_per_page";
$query = $db->prepare($sql);
$query->execute();

while ($row = $query->fetch()) {
    echo '<pre>';
    echo $row['id'].'.';
    echo $row['name'];
    echo '</pre>';
}

echo '<hr/>';

echo $pagination->renderHtml();
