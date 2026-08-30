<?php
// fix_filenames.php
// Script untuk menyamakan nama file dengan nama Class di dalamnya

$dir = __DIR__ . '/protected'; // Target folder (biasanya di protected)
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$count = 0;

echo "<pre>";
echo "Mulai scanning di: $dir \n\n";

foreach ($iterator as $file) {
    // Skip folder navigasi (. dan ..)
    if ($file->isDir()) continue;

    // Hanya proses file .php
    if (pathinfo($file->getFilename(), PATHINFO_EXTENSION) !== 'php') continue;

    $content = file_get_contents($file->getPathname());

    // Regex untuk mencari 'class NamaClass'
    // Menangkap kata setelah 'class'
    if (preg_match('/^\s*class\s+(\w+)/m', $content, $matches)) {
        $className = $matches[1];
        $currentFileName = $file->getFilename();
        $correctFileName = $className . '.php';

        // Cek jika nama file beda (case-sensitive compare)
        if ($currentFileName !== $correctFileName) {
            $oldPath = $file->getPathname();
            $newPath = $file->getPath() . '/' . $correctFileName;

            // Rename file
            rename($oldPath, $newPath);
            echo "[FIXED] $currentFileName -> $correctFileName \n";
            $count++;
        }
    }
}

echo "\nSelesai! Total file diperbaiki: $count";
echo "</pre>";