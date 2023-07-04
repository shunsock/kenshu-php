<?php

declare(strict_types=1);

namespace App\Core;

use InvalidArgumentException;

class UploadedImageChecker
{
    // TODO: Change Class Array to Something Other...
    private array $image_name;
    private array $image_type;
    private array $image_base;

    public function __construct()
    {
        if (self::isUploadedImageValid()){
            $numOfUploadedImage = sizeof($_FILES["user-image"]["name"]);
            for ($i = 0; $i < $numOfUploadedImage; $i++) {
                $image_name[$i] = $_FILES["user-image"]["name"][$i];
                $image_type[$i] =  $_FILES["user-image"]["type"][$i];
                $image_base[$i] = $_FILES["user-image"]["tmp_name"][$i];
            }
        } else {
            throw new InvalidArgumentException(message: "画像のアップロードに失敗しました。");
        }
    }

    private static function isUploadedImageValid(): bool
    {
        $numOfUploadedImage = sizeof($_FILES["user-image"]["name"]);
        for ($i = 0; $i < $numOfUploadedImage; $i++) {
            if ($_FILES["user-image"]["error"][$i] !== UPLOAD_ERR_OK) {
                return false;
            }
            echo 'no error';
            if (!is_uploaded_file($_FILES["user-image"]["tmp_name"][$i])) {
                return false;
            }
            echo 'tem_name ok';
            if ($_FILES["user-image"]["type"][$i] !== "image/png" && $_FILES["user-image"]["type"][$i] !== "image/jpeg") {
                return false;
            }
            echo 'type ok';
            $image_info = getimagesize($_FILES["user-image"]["tmp_name"][$i]);
            if ($image_info === false) {
                return false;
            }
        }
        return true;
    }
    /*
     *   object type of array is only string
     */
    public function getImageName(): array
    {
        return $this->image_name;
    }

    /*
     * object type of array is only string
     */
    public function getImageType(): array
    {
        return $this->image_type;
    }

    /*
     * object type of array is only string
     */
    public function getImageBase(): array
    {
        return $this->image_base;
    }
}