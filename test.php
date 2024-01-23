<?php

// REST API для генерации случайного числа:

class RandomNumberGenerator {
    private $numbers = [];

    public function random() {
        $randomNumber = rand();
        $id = uniqid();
        $this->numbers[$id] = $randomNumber;
        return ['id' => $id, 'number' => $randomNumber];
    }

    public function get($id) {
        return isset($this->numbers[$id]) ? $this->numbers[$id] : null;
    }
}

$generator = new RandomNumberGenerator();

// REST API
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'random') {
            header('Content-Type: application/json');
            echo json_encode($generator->random());
        } elseif ($_GET['action'] === 'get' && isset($_GET['id'])) {
            header('Content-Type: application/json');
            echo json_encode($generator->get($_GET['id']));
        }
    }
}

// Парсер для сайта https://flyfoods.ru/:

class FlyFoodsParser {
    public function parse($url) {
        $html = file_get_contents($url);

        $dishes = [
            ['name' => 'Dish1', 'price' => 100, 'image_url' => 'image1.jpg', 'description' => 'Description1'],
            ['name' => 'Dish2', 'price' => 150, 'image_url' => 'image2.jpg', 'description' => 'Description2'],
            // ...
        ];

        return $dishes;
    }
}

// Пример использования
$parser = new FlyFoodsParser();
$url = 'https://flyfoods.ru/';
$dishes = $parser->parse($url);

// Вывод результата
header('Content-Type: application/json');
echo json_encode($dishes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

?>