<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyniki Ankiety</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <h1>Wyniki Ankiety</h1>

    <?php
    // Połączenie z bazą danych
    require __DIR__.'/db.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT q.question_text, r.response_text, COUNT(r.response_text) as response_count 
            FROM questions q 
            JOIN responses r ON q.id = r.question_id 
            GROUP BY q.id, r.response_text 
            ORDER BY q.id, response_count DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $current_question = null;

        while ($row = $result->fetch_assoc()) {
            if ($current_question != $row['question_text']) {
                if ($current_question !== null) {
                    echo "</ul>";
                }
                $current_question = $row['question_text'];
                echo "<h2>" . htmlspecialchars($current_question) . "</h2><ul>";
            }
            echo "<li>" . htmlspecialchars($row['response_text']) . " - " . $row['response_count'] . " odpowiedzi</li>";
        }
        echo "</ul>";
    } else {
        echo "Brak wyników.";
    }

    $conn->close();
    ?>
</body>
</html>
