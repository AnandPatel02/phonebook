<?php
session_start();
require_once('connect.php');
require_once('functions.php');

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $contact_number = $_POST["contact_number"];
    $email = $_POST["email"];
    $image = $_FILES["image"]["name"];
    $target_dir = "image/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    if (addContact($user_id, $name, $contact_number, $email, $image)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Error occurred while adding the contact.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <script>
        function checkInputLength(input) {
            if (input.value.length > input.maxLength) {
                input.value = input.value.slice(0, input.maxLength);
            }
        }
    </script>
    <div class="container">
        <h2 style="font-family: 'Oswald', sans-serif;" class="text-center mt-4">Add Contact</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <label for="name" class="form-label">Name:</label>
            <input type="text" autocomplete="off" class="form-control" id="name" name="name" required><br>

            <label for="contact_number" class="form-label">Contact Number:</label>
            <input type="number" autocomplete="off" oninput="checkInputLength(this)" maxlength="10" class="form-control" id="contact_number" name="contact_number" required><br>

            <label for="email" class="form-label">Email:</label>
            <input type="email" autocomplete="off" class="form-control" id="email" name="email" required><br>

            <label for="image" class="form-label">Image:</label>
            <input type="file" class="form-control" id="image" value="image/<?php $contact['image']; ?>" name="image"><br>

            <input type="submit" class="btn btn-primary" style="padding: 10px 20px;" value="Add">
        </form>
    </div>
</body>

</html>