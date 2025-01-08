<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Pytanie</title>
    <link rel="stylesheet" href="./../style.css">
</head>
<body>
    <h1>Dodaj Pytanie do Ankiety</h1>
    <form action="add_question.php" method="POST">
        <label for="question_text">Treść pytania:</label><br>
        <input type="text" id="question_text" name="question_text" required><br><br>

        <label for="question_type">Typ pytania:</label><br>
        <select id="question_type" name="question_type" required>
            <option value="text">Tekst</option>
            <option value="radio">Radio</option>
            <option value="select">Select</option>
        </select><br><br>

        <label for="options">Opcje (dla 'radio' i 'select', oddzielone przecinkami):</label><br>
        <input type="text" id="options" name="options"><br><br>

        <button type="submit">Dodaj Pytanie</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require __DIR__.'/../db.php';

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $question_text = $conn->real_escape_string($_POST['question_text']);
        $question_type = $conn->real_escape_string($_POST['question_type']);
        $options = $conn->real_escape_string($_POST['options']);
        $options_json = $options ? json_encode(explode(',', $options)) : null;

        $sql = "INSERT INTO questions (question_text, question_type, options) VALUES ('$question_text', '$question_type', '$options_json')";

        if ($conn->query($sql)) {
            echo "Pytanie zostało dodane pomyślnie.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>
