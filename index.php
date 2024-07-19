<?php

declare(strict_types=1);

require 'DB.php';

$db = new DB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['truncateButton'])) {
        $db->TrancateList();
    } elseif (isset($_POST['id'])) {
        $db->toggleStatus((int)$_POST['id']);
    } else {
        $db->SaveDotolist();
    }

    header('Location: index.php');
    exit();
}

if (isset($_GET['complated'])) {
    $id = (int)$_GET['complated'];
    $db->StrikedUpdate($id, true);

    header('Location: index.php');
    exit();
}

if (isset($_GET['uncomplated'])) {
    $id = (int)$_GET['uncomplated'];
    $db->StrikedUpdate($id, false);

    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $db->DeleteList($id);

    header('Location: index.php');
    exit();
}

$userlist = $db->SendTodo();

$itemsPage = 5;
$itemtotal = count($userlist);
$pagesTotal = ceil($itemtotal / $itemsPage);

$PageCurrent = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($PageCurrent < 1) {
    $PageCurrent = 1;
} elseif ($PageCurrent > $pagesTotal) {
    $PageCurrent = $pagesTotal;
}

$offset = ($PageCurrent - 1) * $itemsPage;

$currentItems = array_slice($userlist, (int)$offset, $itemsPage);

require 'View.php';
