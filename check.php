<?php
$issues = [];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('.'));
foreach ($iterator as $file) {
    if ($file->isFile() && !str_contains($file->getPathname(), 'node_modules') && !str_contains($file->getPathname(), 'vendor') && !str_contains($file->getPathname(), '.git') && !str_contains($file->getPathname(), 'storage')) {
        $path = $file->getRealPath();
        $ext = $file->getExtension();
        if (in_array($ext, ['php', 'js', 'css', 'json', 'env', 'md'])) {
            $c = file_get_contents($path);
            $hasReplacementChar = str_contains($c, "\xEF\xBF\xBD");
            
            if ($hasReplacementChar) {
                $issues[] = [
                    'file' => $file->getPathname(),
                    'replacement_char' => $hasReplacementChar
                ];
            }
        }
    }
}
echo json_encode($issues, JSON_PRETTY_PRINT);
