<?
require_once 'product.php';
require_once 'catalog.php';

session_start();

// Создаем каталог или используем существующий
if (!isset($_SESSION['catalog'])) {
    $_SESSION['catalog'] = new Catalog();
}

// Добавление товара (пример)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $id = count($_SESSION['catalog']->getProducts()) + 1;

    $product = new Product($id, $name, $category, $price);
    $_SESSION['catalog']->addProduct($product);
}

// Поиск и фильтрация
$searchQuery = isset($_POST['search']) ? $_POST['search'] : '';
$filterCategory = isset($_POST['category_filter']) ? $_POST['category_filter'] : '';

$products = $_SESSION['catalog']->filterAndSearch($searchQuery, $filterCategory);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог товаров</title>
</head>
<body>
    <h1>Каталог товаров</h1>

    <form method="post">
        <h3>Добавить товар</h3>
        <input type="text" name="name" placeholder="Название" required>
        <input type="text" name="category" placeholder="Категория" required>
        <input type="number" name="price" placeholder="Цена" required>
        <button type="submit" name="add_product">Добавить</button>
    </form>

    <form method="post">
        <h3>Поиск товаров</h3>
        <input type="text" name="search" placeholder="Поиск" value="<?= htmlspecialchars($searchQuery) ?>">
        <select name="category_filter">
            <option value="">Все категории</option>
            <option value="категория1" <?= $filterCategory === 'категория1' ? 'selected' : '' ?>>Категория 1</option>
            <option value="категория2" <?= $filterCategory === 'категория2' ? 'selected' : '' ?>>Категория 2</option>
        </select>
        <button type="submit">Найти</button>
    </form>

    <h3>Результаты</h3>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <?= 
                htmlspecialchars($product->name) ?> - <?= 
                htmlspecialchars($product->category) ?> - <?= 
                htmlspecialchars($product->price) ?> руб.
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>