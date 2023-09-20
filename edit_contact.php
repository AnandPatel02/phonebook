<?php
session_start();
require_once('connect.php');
require_once('functions.php');

if (!isUserLoggedIn()) {
    header("Location: index.php");
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

$name = $contact['name'];
$contact_number = $contact['contact_number'];
$email = $contact['email'];
$image = $contact['image'];

$name_err = $contact_number_err = $email_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty(trim($_POST["contact_number"]))) {
        $contact_number_err = "Please enter a contact number.";
    } else {
        $contact_number = trim($_POST["contact_number"]);
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty($name_err) && empty($contact_number_err) && empty($email_err)) {
        $image = $_FILES['image']['name'];
        $temp_image = $_FILES['image']['tmp_name'];
        $image_directory = 'image/';

        if (!empty($image)) {
            if (!empty($contact['image'])) {
                unlink($image_directory . $contact['image']);
            }

            move_uploaded_file($temp_image, $image_directory . $image);
        }

        updateContact($user_id, $contact_id, $name, $contact_number, $email, $image);

        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2 class="text-center mt-4" style="font-family: 'Oswald', sans-serif;">Edit Contacts</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $contact_id; ?>" enctype="multipart/form-data">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $contact['name']; ?>" required><br>

            <label for="contact_number" class="form-label">Contact Number:</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $contact['contact_number']; ?>" required><br>

            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $contact['email']; ?>" required><br>

            <label for="image" class="form-label">Image:</label>
            <input type="file" class="form-control" id="image" name="image">
            <br><br>

            <input type="submit" name="update_image" class="btn btn-primary" value="Update">
        </form>
    </div>
</body>

</html>