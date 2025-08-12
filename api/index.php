<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test HTML + PHP</title>
</head>
<body>
    <h1>Halo, ini HTML!</h1>

    <?php
        echo "<p>Halo, ini teks dari PHP!</p>";
        echo "<p>Tanggal sekarang: " . date("d-m-Y H:i:s") . "</p>";
    ?>
</body>
</html>
