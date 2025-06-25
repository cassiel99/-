<?php
/**
 * Скрипт для поиска и вывода всех файлов в папке /datafiles,
 * имена которых состоят из латинских букв и цифр, и имеют расширение .ixt.
 * @package FileScanner
 */

/**
 * Основная функция сканирования и вывода подходящих файлов.
 * @return void
 */
function listValidIxtFiles(): void
{
    // Путь к папке с файлами
    $directory = __DIR__ . '/datafiles';

    // Проверка на существование директории
    if (!is_dir($directory)) {
        echo "Папка /datafiles не найдена.\n";
        return;
    }

    // Получаем список всех файлов в директории
    $files = scandir($directory);
    $matchedFiles = [];

    // Перебираем каждый файл и фильтруем по регулярному выражению
    foreach ($files as $file) {
        // Проверка: имя должно состоять только из латинских букв/цифр и иметь расширение .ixt
        if (preg_match('/^[a-zA-Z0-9]+\.ixt$/', $file)) {
            $matchedFiles[] = $file;
        }
    }

    // Сортируем найденные файлы по имени
    sort($matchedFiles, SORT_STRING | SORT_FLAG_CASE);

    // Выводим список
    foreach ($matchedFiles as $fileName) {
        echo $fileName . PHP_EOL;
    }
}

// Вызов функции
listValidIxtFiles();
