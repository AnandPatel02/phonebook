<?php

function isUserLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function getUserData($user_id)
{
    global $conn;

    $user_id = mysqli_real_escape_string($conn, $user_id);
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

function getContacts($user_id)
{
    global $conn;

    $user_id = mysqli_real_escape_string($conn, $user_id);
    $sql = "SELECT * FROM contact WHERE user_id = '$user_id'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $contacts = array();
        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }
        return $contacts;
    } else {
        return array();
    }
}


function addContact($user_id, $name, $contact_number, $email, $image)
{
    global $conn;

    $user_id = mysqli_real_escape_string($conn, $user_id);
    $name = mysqli_real_escape_string($conn, $name);
    $contact_number = mysqli_real_escape_string($conn, $contact_number);
    $email = mysqli_real_escape_string($conn, $email);
    $image = mysqli_real_escape_string($conn, $image);

    $sql = "INSERT INTO contact (user_id, name, contact_number, email, image) VALUES ('$user_id', '$name', '$contact_number', '$email', '$image')";

    return $conn->query($sql);
}


function updateContact($user_id, $contact_id, $name, $contact_number, $email, $image)
{
    global $conn;

    $name = mysqli_real_escape_string($conn, $name);
    $contact_number = mysqli_real_escape_string($conn, $contact_number);
    $email = mysqli_real_escape_string($conn, $email);

    if (!empty($image)) {
        $image = mysqli_real_escape_string($conn, $image);
        $sql = "UPDATE contact SET name = '$name', contact_number = '$contact_number', email = '$email', image = '$image' WHERE id = '$contact_id' AND user_id = '$user_id'";
        $result = $conn->query($sql);
    } else {
        $sql = "UPDATE contact SET name = '$name', contact_number = '$contact_number', email = '$email' WHERE id = '$contact_id' AND user_id = '$user_id'";
        $result = $conn->query($sql);
    }

    if ($result === true) {
        return true;
    } else {
        return false;
    }
}


function deleteContact($contact_id)
{
    global $conn;

    $contact_id = mysqli_real_escape_string($conn, $contact_id);

    $sql = "DELETE FROM contact WHERE id = '$contact_id'";

    return $conn->query($sql);
}
