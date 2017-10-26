Dframe/FileStorage
===================

    #composer require dframe/filestorage

----------


Code
-------------
You can create own driver in example usage is mysql driver. 

POST from
```php 
<?php
namespace Controller;
/*
 * Dframe Route: myFileSystem/index | index.php?task=myFileSystem&action=index
 * 
 */

class MyFileSystem extends \Dframe\Controller 
{
    public function init(){
        $this->fileStorage = new \Dframe\FileStorage\Storage($this->loadModel('FileStorage/Drivers/DatabaseDriver'));
    }

    public function index(){
   
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                //Aktualizacja avatara
                $imagename = $_FILES['file']['name'];
                $size = $_FILES['file']['size'];
            
                $extension = strtolower(pathinfo($imagename, PATHINFO_EXTENSION)); //Walidacja Rozszerzenia
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $_FILES['file']['tmp_name']);  //Walidacja Mine
                finfo_close($finfo);
                if(!in_array($mime, array('image/jpeg', 'image/png', 'image/gif')) OR !in_array($extension,     array    ('jpeg', 'jpg', 'png', 'gif')));
                    exit('Wrong extension');
            
                $put = $this->fileStorage->put('local', $_FILES['file']['tmp_name'], 'images/path/name.'.$extension);
                if($put['return'] == true)
                    exit(json_encode(array('return' => '1', 'response' => 'File Upload OK')));
        
                exit(json_encode(array('return' => '0', 'response' => 'Error')));
        
                break;
        
            case 'DELETE':
        
                $drop = $this->fileStorage->drop('local', 'images/path/name.jpg'); // Filename+Extension
                if($drop['return'] == true)
                    exit(json_encode(array('return' => '1', 'response' => 'File Deleted')));
                
                exit(json_encode(array('return' => '0', 'response' => $drop['response'])));
        
                break;
            
            default:
        
                echo 'Upload Form <br>
                    <br>
                    <form action="" method="POST" enctype="multipart/form-data">
                        Select image to upload:
                        <input type="file" name="name" id="name">
                        <input type="submit" value="Upload Image" name="submit">
                    </form>';
        
                break;
        }
        
        public function image(){
            echo $this->fileStorage->image('images/path/name.jpg')->stylist('square')->size('250x250')->display();
            return;

        }
        
        public function render(){
            // Render file patch local: app/View/upload/images/path/name.jpg'
            exit($this->fileStorage->renderFile('images/path/name.jpg', 'local'));
        }
}

```



Mysql
------------

```mysql
-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 04 Cze 2017, 15:50
-- Wersja serwera: 5.7.16
-- Wersja PHP: 7.0.13-1~dotdeb+8.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `files`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `file_adapter` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_mime` varchar(127) NOT NULL,
  `last_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `files_cache`
--

CREATE TABLE `files_cache` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `file_cache_path` varchar(255) NOT NULL,
  `file_cache_mime` varchar(127) NOT NULL,
  `last_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD UNIQUE KEY `file_path` (`file_path`),
  ADD UNIQUE KEY `file_adapter` (`file_adapter`,`file_path`,`file_mime`),
  ADD KEY `id` (`file_id`);

--
-- Indexes for table `files_cache`
--
ALTER TABLE `files_cache`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_cache_path` (`file_cache_path`,`file_cache_mime`),
  ADD KEY `file_id` (`file_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT dla tabeli `files_cache`
--
ALTER TABLE `files_cache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

```
