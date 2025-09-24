<?php
require_once "library.php";
$bookObj = new Library();

$search = $_GET['search'] ?? '';
$genre = $_GET['genre'] ?? '';
$books = $bookObj->viewBook($search, $genre);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book</title>
    <link rel="stylesheet" href="viewBook.css">
</head>
<body>
    <div class="container">
        <h1>List of Books</h1>

        <form method="get" class="search-form">
            <input type="text" name="search" placeholder="Search by title/author..." value="<?= htmlspecialchars($search) ?>">
            <select name="genre">
                <option value="">All Genres</option>
                <option value="history" <?= $genre=='history'?'selected':'' ?>>History</option>
                <option value="science" <?= $genre=='science'?'selected':'' ?>>Science</option>
                <option value="fiction" <?= $genre=='fiction'?'selected':'' ?>>Fiction</option>
            </select>
            <button type="submit">Search</button>
            <a href="viewBook.php"><button type="button">Reset</button></a>
        </form>

        <table class="table">
            <tr>
                <td>No.</td>
                <td>Title</td>
                <td>Author</td>
                <td>Genre</td>
                <td>Publication Year</td>
                <td>Publisher</td>
                <td>Copies</td>
            </tr>
            <?php
                $no_counter = 1;
                foreach ($books as $book) {
            ?> 
                    <tr>
                        <td><?= $no_counter++ ?></td>
                        <td><?= $book["title"] ?></td>
                        <td><?= $book["author"] ?></td>
                        <td><?= $book["genre"] ?></td>
                        <td><?= $book["publication_year"] ?></td>
                        <td><?= $book["publisher"] ?></td>
                        <td><?= $book["copies"] ?></td>
                    </tr>
            <?php
                }
            ?>
        </table>
        <br>
        <button><a href="addBook.php">Add Book</a></button>
    </div>
</body>
</html>
