<?php


namespace app\models;


use app\services\Db;

class Image extends DbModel
{
    public $id;
    public $name;
    public $path;
    public $productId;
    public $avatar;


    public static $fileArray = 'myfile';

    public function __construct()
    {
        parent::__construct();
    }

    public static function getTableName()
    {
        return "images";
    }

    public static function add($id, bool $setAvatar = true)
    {
        $result = true;
        for ($i = 0; $i < count($_FILES[self::$fileArray]['name']); $i++) {
            self::upload($id, $i);
            $img = new static();
            $img->name = $_FILES[self::$fileArray]['name'][$i];
            $img->path = "/images/" . "$id/" . $_FILES[self::$fileArray]['name'][$i];
            $img->productId = $id;
            if ($setAvatar && $i == 0) {
                $img->avatar = 1;
            }
            if (!$img->save()) {
                $result = false;
            };
        }
        return $result;
    }

    private static function upload($id, $i)
    {
        if ($_FILES[self::$fileArray]['type'][$i] == "image/jpeg" || $_FILES[self::$fileArray]['type'][$i] == "image/png"
            && $_FILES[self::$fileArray]['size'][$i] < 10000000) {
            $tmp = $_FILES[self::$fileArray]['tmp_name'][$i];
            if (!file_exists(IMAGES_DIR . "$id/")) {
                mkdir(IMAGES_DIR . "$id/");
            }
            $filePath = IMAGES_DIR . "$id/" . $_FILES[self::$fileArray]['name'][$i];
            move_uploaded_file($tmp, $filePath);
        }
    }

    public static function getPersonalProperties()
    {
        $prop = parent::getPersonalProperties();
        $prop[] = 'fileArray';
        return $prop;
    }

    public static function deleteImgDir($src)
    {
        $dir = opendir($src);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $full = $src . '/' . $file;
                if (is_dir($full)) {
                    self::deleteImgDir($full);
                } else {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($src);
    }
    public static function getAllByProduct($id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE `productId` = :id";
        return Db::getInstance()->queryAll($sql, [':id' => $id]);
    }

    public static function getOneByProduct($id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE `productId` = :id";
        return Db::getInstance()->queryObject($sql, [':id' => $id], get_called_class());
    }


    public static function getAvatar($id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE `productId` = :id AND `avatar` = 1";
        return Db::getInstance()->queryObject($sql, [':id' => $id], get_called_class());
    }

    public function delete()
    {
        $fullSrc = IMAGES_DIR . $this->productId . "/" . $this->name;
        unlink($fullSrc);
        parent::delete();
    }

}