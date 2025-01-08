<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuń Pytanie</title>
    <link rel="stylesheet" href="./../style.css">
</head>
<body>
    <h1>Usuń Pytanie z Ankiety</h1>

    <?php
    // Połączenie z bazą danych
    require __DIR__.'/../db.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $question_id = intval($_POST['question_id']);

        // Usuwanie odpowiedzi związanych z pytaniem
        $delete_responses_sql = "DELETE FROM responses WHERE question_id = $question_id";
        $conn->query($delete_responses_sql);

        // Usuwanie pytania
        $delete_question_sql = "DELETE FROM questions WHERE id = $question_id";
        if ($conn->query($delete_question_sql)) {
            echo "Pytanie zostało usunięte pomyślnie.";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    // Pobieranie pytań do wyświetlenia w formularzu
    $sql = "SELECT id, question_text FROM questions";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<form action='delete_question.php' method='POST'>";
        echo "<label for='question_id'>Wybierz pytanie do usunięcia:</label><br>";
        echo "<select id='question_id' name='question_id' required>";

        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['question_text']) . "</option>";
        }

        echo "</select><br><br>";
        echo "<button type='submit'>Usuń Pytanie</button>";
        echo "</form>";
    } else {
        echo "Brak pytań do usunięcia.";
    }

    $conn->close();
    ?>
</body>
</html>
