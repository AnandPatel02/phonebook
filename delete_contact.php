<?php
session_start();
require_once('connect.php');
require_once('functions.php');

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$contact_id = $_GET['id'];

$contacts = getContacts($user_id);

$contact = null;
foreach ($contacts as $cont) {
    if ($cont['id'] == $contact_id) {
        $contact = $cont;
        break;
    }
}

if (!$contact) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['confirm_delete'])) {
    deleteContact($contact_id);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
</head>
<style>
    .delete {
        width: 450px;
        text-align: center;
        height: 200px;
        background-color: rgb(255, 255, 255);
        padding: 30px;
        border-radius: 30px;
        box-shadow: 0px 0px 40px rgba(0, 0, 0, 0.256);
        margin-top: 230px;
        margin-left: 400px;
    }

    .delete p {
        margin-top: 30px;
    }
</style>

<body>
    <div class="container">
        <form class="delete" method="POST" action="#">
            <p class="text-danger">Are you want to delete this contact?</p>
            <input type="submit" class="btn btn-danger" name="confirm_delete" value="Delete">
            <a href="dashboard.php" class="btn btn-success">Cancel</a>
        </form>

    </div>
</body>

</html>