<!DOCTYPE html>
<html>
<head>
    <title>MP4 to WebM Converter</title>
</head>
<body>

<h2>Cheems Bread's MP4 to WebM Converter</h2> 
<h4>This might take up to 3 minutes.</h4>

<div class="center">
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="video" accept=".mp4">
        <button type="submit" name="convert">Convert to WebM</button>
        <link rel="stylesheet" href="styles.css">
    </form>

    <?php
        if (isset($_POST['convert'])) {
            if ($_FILES['video']['error'] === UPLOAD_ERR_OK) {
                // Set the paths for the uploaded and converted files
                $uploadedFile = $_FILES['video']['tmp_name'];
                $convertedFile = 'converted.webm';

                // Convert the uploaded file to WebM using FFmpeg
                exec("ffmpeg -i $uploadedFile -c:v libvpx-vp9 -b:v 0 -crf 10 -c:a libopus $convertedFile");

                // Prompt the user to download the converted file
                if (file_exists($convertedFile)) {
                    header('Content-Type: video/webm');
                    header('Content-Disposition: attachment; filename="' . basename($convertedFile) . '"');
                    header('Content-Length: ' . filesize($convertedFile));

                    ob_clean();
                    flush();
                    readfile($convertedFile);

                    // Delete the temporary converted file
                    unlink($convertedFile);
                    exit();
                } else {
                    echo "Error converting the file.";
                }
            } else {
                echo "Error uploading the file.";
            }
        }
    ?>
</div>

<div class="link">
    <a href="https://www.cheemsbread.xyz/">www.cheemsbread.xyz</a>
</div>

</body>
</html>
