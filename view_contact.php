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
?>

<!DOCTYPE html>
<html>

<head>
    <title>Contact Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2 style="font-family: 'Oswald', sans-serif;" class="text-center">All Details</h2>

        <a href="dashboard.php" class="mt-4 btn btn-primary">Back</a>

        <table class="table mt-5">
            <tr>
                <th>Name </th>
                <td><?php echo $contact['name']; ?></td>
            </tr>
            <tr>
                <th>Contact Number</th>
                <td><?php echo $contact['contact_number']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $contact['email']; ?></td>
            </tr>
            <tr>
                <th>Image</th>
                <td>
                    <?php if (!empty($contact['image'])) { ?>
                        <img src="image/<?php echo $contact['image']; ?>" alt="Image" width="100px" height="100">
                    <?php } else { ?>
                        Image Not Found !!
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>