<?php
$radius = $tinggi = $volume = $luas_permukaan = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $radius = floatval($_POST['radius']);
    $tinggi = floatval($_POST['tinggi']);
    
    // Menghitung volume kerucut
    $volume = (1/3) * pi() * pow($radius, 2) * $tinggi;

    // Menghitung luas permukaan kerucut
    $sisi = sqrt(pow($radius, 2) + pow($tinggi, 2)); // panjang garis pelukis
    $luas_permukaan = pi() * $radius * ($radius + $sisi);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Kerucut</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="number"] {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
        }
        button:hover {
            background-color: #0056b3;
        }
        .result {
            margin-top: 20px;
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hitung Kerucut</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="radius">Jari-jari (r):</label>
            <input type="number" id="radius" name="radius" step="any" required>

            <label for="tinggi">Tinggi (h):</label>
            <input type="number" id="tinggi" name="tinggi" step="any" required>

            <button type="submit">Hitung</button>
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="result">
                <h2>Hasil:</h2>
                <p>Volume Kerucut: <?php echo number_format($volume, 2); ?> satuan kubik</p>
                <p>Luas Permukaan Kerucut: <?php echo number_format($luas_permukaan, 2); ?> satuan persegi</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>