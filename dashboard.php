<?php
session_start();
require_once('connect.php');
require_once('functions.php');

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_data = getUserData($user_id);
$contacts = getContacts($user_id);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var searchInput = document.getElementById("search");
            var contactRows = document.getElementsByClassName("contact-row");

            searchInput.addEventListener("input", function() {
                var search = searchInput.value.toLowerCase();
                Array.from(contactRows).forEach(function(row) {
                    var name = row.getElementsByClassName("contact-name")[0].textContent.toLowerCase();
                    if (name.includes(search)) {
                        row.style.display = "table-row";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <h2 style="font-family: 'Oswald', sans-serif;" class="text-center mt-5">Contact Book</h2>
        <h4 class="text-right"><img src="./profile.png" width="50px"> <?php echo $user_data['username']; ?></h4>
        <input type="text" id="search" class="form-control mt-4" placeholder="Search">

        <table class="table table-striped mt-4">
            <tr>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php foreach ($contacts as $contact) { ?>
                <tr class="contact-row">
                    <td class="contact-name"><?php echo $contact['name']; ?></td>
                    <td><?php echo $contact['contact_number']; ?></td>
                    <td><?php echo $contact['email']; ?></td>
                    <td><img src="image/<?php echo $contact['image']; ?>" height='100px' width='100px'></td>

                    <td>
                        <a href="edit_contact.php?id=<?php echo $contact['id']; ?>" class="btn btn-outline-primary mt-4 ">Edit</a>
                        <a href="view_contact.php?id=<?php echo $contact['id']; ?>" class="btn btn-outline-secondary mt-4">View</a>
                        <a href="delete_contact.php?id=<?php echo $contact['id']; ?>" class="btn btn-outline-danger mt-4">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <a href="add_contact.php" class="btn btn-success">Add Contact</a>

        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>

</html>