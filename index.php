<?php
$host = "localhost";
$user = "user@localhost";
$pass = "user";
$dbname = "FormDataDB";

// Povezivanje sa bazom
$conn = new mysqli($host, $user, $pass, $dbname);

// Provera konekcije
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Primanje podataka iz forme
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $podaci = $_POST;

    // Čuvanje podataka u JSON fajlu
    file_put_contents('podaci.json', json_encode($podaci));

    // Čuvanje podataka u bazi podataka
    $stmt = $conn->prepare("INSERT INTO formData (data) VALUES (?)");
    $stmt->bind_param('s', json_encode($podaci));

    if ($stmt->execute()) {
        echo "Podaci uspešno sačuvani!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
