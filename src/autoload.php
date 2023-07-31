<?php
    function autoloader(){
        $folderPath = __DIR__.'/modules';

        $files = scandir($folderPath);
        
        $files = array_diff($files, array('.', '..'));
        
        foreach ($files as $file) {
            $filePath = $folderPath."/".trim($file.PHP_EOL)."/index.php";

            if(file_exists($filePath)){
                require($filePath);
            } else {
                echo "No such file in the directory.";
            }
            
        }
    }

    autoloader();

?>