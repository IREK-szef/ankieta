<?php
require __DIR__.'/db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

foreach ($_POST as $key => $value) {
    if (strpos($key, 'question_') === 0) {
        $question_id = str_replace('question_', '', $key);
        $response_text = $conn->real_escape_string($value);

        $sql = "INSERT INTO responses (question_id, response_text) VALUES ('$question_id', '$response_text')";
        if (!$conn->query($sql)) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dziękujemy!</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <header>
        <h1>Dziękujemy za wypełnienie ankiety !</h1>
    </header>
    <img src="./kot.webp" alt="Kot wymiotuje musem">
    <footer>
        <a href="/view_results.php">Zobacz wyniki</a>
    </footer>
</body>
</html>