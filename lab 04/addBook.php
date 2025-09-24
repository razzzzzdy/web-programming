<?php
require_once "library.php";
$bookObj = new Library();

$errors = [];
$book = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book["title"] = trim($_POST["title"]);
    $book["author"] = trim($_POST["author"]);
    $book["genre"] = trim($_POST["genre"]);
    $book["publication_year"] = (int) $_POST["publication_year"];
    $book["publisher"] = trim($_POST["publisher"]);
    $book["copies"] = (int) ($_POST["copies"] ?? 1);

    if (empty($book["title"])) {
        $errors["title"] = "Title is required.";
    } elseif ($bookObj->isBookExist($book["title"])) {
        $errors["title"] = "This book already exists.";
    }

    if (empty($book["author"])) {
        $errors["author"] = "Author is required.";
    }

    if (empty($book["genre"])) {
        $errors["genre"] = "Genre is required.";
    }

    if (empty($book["publication_year"])) {
        $errors["publication_year"] = "Publication year is required.";
    } elseif ($book["publication_year"] > date("Y")) {
        $errors["publication_year"] = "Publication year cannot be in the future.";
    }

    if (empty($book["copies"]) || $book["copies"] < 1) {
        $book["copies"] = 1;
    }
    
    if (empty($errors)) {
        $bookObj->title = $book["title"];
        $bookObj->author = $book["author"];
        $bookObj->genre = $book["genre"];
        $bookObj->publication_year = $book["publication_year"];
        $bookObj->publisher = $book["publisher"];
        $bookObj->copies = $book["copies"];

        if ($bookObj->addBook()) {
            header("Location: viewBook.php");
            exit;
        } else {
            echo "Error saving book.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <link rel="stylesheet" href="addbook.css">
</head>
<body>
<div class="layout">
  <div class="container">
    <h1>Add Book</h1>
    <form method="post">
        <label>Title *</label>
        <input type="text" name="title" value="<?= $book["title"] ?? "" ?>">
        <p class="error"><?= $errors["title"] ?? "" ?></p>

        <label>Author *</label>
        <input type="text" name="author" value="<?= $book["author"] ?? "" ?>">
        <p class="error"><?= $errors["author"] ?? "" ?></p>

        <label>Genre *</label>
        <select name="genre">
            <option value="">--Select--</option>
            <option value="history" <?= (isset($book["genre"]) && $book["genre"]=="history")? "selected":"" ?>>History</option>
            <option value="science" <?= (isset($book["genre"]) && $book["genre"]=="science")? "selected":"" ?>>Science</option>
            <option value="fiction" <?= (isset($book["genre"]) && $book["genre"]=="fiction")? "selected":"" ?>>Fiction</option>
        </select>
        <p class="error"><?= $errors["genre"] ?? "" ?></p>

        <label>Publication Year *</label>
        <input type="number" name="publication_year" value="<?= $book["publication_year"] ?? "" ?>">
        <p class="error"><?= $errors["publication_year"] ?? "" ?></p>

        <label>Publisher</label>
        <input type="text" name="publisher" value="<?= $book["publisher"] ?? "" ?>">

        <label>Copies</label>
        <input type="number" name="copies" value="<?= $book["copies"] ?? 1 ?>">

        <button type="submit">Save Book</button>
    </form>
    <a href="viewBook.php">View Books</a>
  </div>
</div>
</body>
