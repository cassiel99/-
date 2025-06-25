<?php

/**
 * Финальный класс Init, предназначенный для создания, заполнения и выборки данных из таблицы test.
 * Наследование от этого класса невозможно.
 */
final class Init
{
    /**
     * @var PDO Подключение к базе данных
     */
    private PDO $pdo;

    /**
     * Конструктор класса.
     * Устанавливает подключение к БД и вызывает методы создания и заполнения таблицы.
     *@throws PDOException В случае ошибки подключения или запроса.
     */
    public function __construct()
    {
        // Подключение к SQLite (можно заменить на MySQL при необходимости)
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->create(); // Создаёт таблицу
        $this->fill();   // Заполняет таблицу случайными данными
    }

    /**
     * Создаёт таблицу test с 5 полями:
     * id, name, age, score, result.
     * Метод недоступен извне класса.
     * @return void
     */
    private function create(): void
    {
        $sql = "
            CREATE TABLE test (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT,
                age INTEGER,
                score REAL,
                result TEXT
            );
        ";
        $this->pdo->exec($sql);
    }

    /**
     * Заполняет таблицу test случайными данными.
     * Метод недоступен извне класса.
     * @return void
     */
    private function fill(): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO test (name, age, score, result) VALUES (?, ?, ?, ?)");
        $results = ['normal', 'success', 'fail', 'error'];

        for ($i = 0; $i < 10; $i++) {
            $name   = 'User' . rand(1, 100);
            $age    = rand(18, 60);
            $score  = rand(50, 100) / 1.5;
            $result = $results[array_rand($results)];
            $stmt->execute([$name, $age, $score, $result]);
        }
    }

    /**
     * Получает записи из таблицы test, у которых значение поля result — 'normal' или 'success'.
     * @return array Массив подходящих строк таблицы.
     */
    public function get(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM test WHERE result IN ('normal', 'success')");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// ==== Пример использования ====

// $init = new Init();
// print_r($init->get());
