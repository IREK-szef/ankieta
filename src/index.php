<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ankieta</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <header>
        <h1>Ankieta</h1>
        <p>Prosimy uważnie zapoznać się z pytaniami i wypełnić ankietę.</p>
        <hr>
    </header>
    <form action="submit_survey.php" method="POST">
        <?php
        
        // Połączenie z bazą danych
        require __DIR__.'/db.php';

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Pobieranie pytań z bazy danych
        $sql = "SELECT * FROM questions";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<label>" . $row['question_text'] . "</label>";

                if ($row['question_type'] == 'text') {
                    echo "<input type='text' name='question_{$row['id']}' required><br>";
                } elseif ($row['question_type'] == 'radio' || $row['question_type'] == 'select') {
                    $options = json_decode($row['options'], true);

                    if ($row['question_type'] == 'radio') {
                        foreach ($options as $option) {
                            echo "<input type='radio' name='question_{$row['id']}' value='{$option}' required> {$option}<br>";
                        }
                    } elseif ($row['question_type'] == 'select') {
                        echo "<select name='question_{$row['id']}' required>";
                        foreach ($options as $option) {
                            echo "<option value='{$option}'>{$option}</option>";
                        }
                        echo "</select><br>";
                    }
                }
            }
        }

        $conn->close();
        ?>
        <button type="submit">Wyślij</button>
    </form>
</body>
</html>
