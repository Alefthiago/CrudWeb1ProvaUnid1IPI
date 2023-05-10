<?php 
    $id = $_GET["id"];
    $copy = tempnam("../../csv/","");
    $temp = fopen($copy, "w");
    if ($temp) {
        $arquivo = "../../csv/livros.csv";
        $fp = fopen($arquivo, "r");
        if ($fp) {
            while(($row = fgetcsv($fp)) !== false) {
                if ($row[0] == $id) {
                    continue;
                }
                fputcsv($temp, $row);
            }
            fclose($temp);
            fclose($fp);
            rename($copy, $arquivo);
            header("location: /src/crud/add.php", true, 302);
        }
    }