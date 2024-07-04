<?php

require_once __DIR__ . '/user.class.php';

class LibraryService
{
    public function getFileContent($file_path)
    {
        if (file_exists($file_path)) {
            return file_get_contents($file_path);
        } else {
            return false;
        }
    }

    public function saveFileContent($file_path, $content)
    {
        return file_put_contents($file_path, $content);
    }
}
?>
