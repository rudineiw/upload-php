<?php
// Fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Tutoriais
// https://packagist.org/packages/coffeecode/uploader
// https://www.youtube.com/watch?v=zz3wDgQVo90
require __DIR__ . "/vendor/autoload.php";

$upload = new CoffeeCode\Uploader\Image("uploads", "images", false); // false para não criar pastas automáticas de ano e mês

$files = $_FILES;

// Single image
if (!empty($files['image'])) {
    $file = $files['image'];
    //var_dump($file);

    if (empty($file['type']) || !in_array($file['type'], $upload::isAllowed())) {
        echo '<p>Selecione uma imagem válida: jpg, jpeg, png</p>';
    } else {
        $uploaded = $upload->upload($file, pathinfo($file['name'], PATHINFO_FILENAME), 800, (['jpg' => 85, 'png' => 9])); // localização da imagem
        echo '<img src="'.$uploaded.'" width="500" />';
        //echo '<br>' . $uploaded;
    }
}

// Multiple images
if (!empty($files['images'])) {
    $images = $files['images'];

    for ($i = 0; $i < count($images['type']); $i++) {
        foreach (array_keys($images) as $keys) {
            $imageFiles[$i][$keys] = $images[$keys][$i];
        }
    }

    foreach ($imageFiles as $file) {
        if (empty($file['type'])) {
            echo '<p>Selecione uma imagem válida: jpg, jpeg, png</p>';
        } elseif (!in_array($file['type'], $upload::isAllowed())) {
            echo '<p>O arquivo '.$file['name'].' não é uma imagem válida: jpg, jpeg, png</p>';
        } else {
            $uploaded = $upload->upload($file, pathinfo($file['name'], PATHINFO_FILENAME), 800, (['jpg' => 85, 'png' => 9])); // localização da imagem
            echo '<img src="'.$uploaded.'" width="500" />';
            //echo '<br>' . $uploaded;
        }
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  
    <div class="container">
        <h1>PHP Upload</h1>
        <p>Upload e redimensionamento de imagem usando PHP e Composer.</p>
    </div>

    <hr>

    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fs-1">Single Image</label>
                <input type="file" name="image" accept="image/png, image/jpg, image/jpeg" class="form-control">
            </div>
            <button type="submit" name="enviar" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <hr>

    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fs-1">Multiple Images</label>
                <input type="file" name="images[]" multiple min="1" max="100" accept="image/png, image/jpg, image/jpeg" class="form-control">
            </div>
            <button type="submit" name="enviar" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <hr>

    <div class="container">
        <p>upload_max_filesize: <?php echo ini_get('upload_max_filesize'); ?></p>
        <p>max_file_uploads: <?php echo ini_get('max_file_uploads'); ?></p>
        <p>post_max_size: <?php echo ini_get('post_max_size'); ?></p>
        <p>data e hora: <?php echo date("d/m/Y H:i:s"); ?></p>       
    </div> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
