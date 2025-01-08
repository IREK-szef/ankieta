-- Tabela przechowująca pytania
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_text VARCHAR(255) NOT NULL,
    question_type ENUM('radio', 'select', 'text') NOT NULL,
    options TEXT NULL -- Opcje będą przechowywane jako JSON dla pytań typu 'radio' i 'select'
);

-- Tabela przechowująca odpowiedzi
CREATE TABLE responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    response_text TEXT NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(id)
);
