<?php

declare(strict_types=1);

namespace App\Core;

use InvalidArgumentException;

class UploadedImageChecker
{
    // TODO: Change Class Array to Something Other...
    private array $image_name = [];
    private array $image_type = [];
    private array $image_base = [];

    public function __construct()
    {
        if (self::isUploadedImageValid() === false) {
            throw new InvalidArgumentException(message: "画像のアップロードに失敗しました。");
        }
        if (is_array($_FILES["user-image"]["name"])) {
            $numOfUploadedImage = sizeof($_FILES["user-image"]["name"]);
            for ($i = 0; $i < $numOfUploadedImage; $i++) {
                $this->image_names[$i] = $_FILES["user-image"]["name"][$i];
                $this->image_types[$i] =  $_FILES["user-image"]["type"][$i];
                $this->image_bases[$i] = $_FILES["user-image"]["tmp_name"][$i];
            }
        } else {
            $this->image_names[0] = (string) $_FILES["user-image"]["name"];
            $this->image_types[0] =  (string) $_FILES["user-image"]["type"];
            $this->image_bases[0] = (string) $_FILES["user-image"]["tmp_name"];
        }
    }

    private static function isUploadedImageValid(): bool
    {
        // NOTE: $_FILES['user-image] is not array when only one file is uploaded.
        if (is_array($_FILES["user-image"]["name"])) {
            $numOfUploadedImage = sizeof($_FILES["user-image"]["name"]);
            for ($i = 0; $i < $numOfUploadedImage; $i++) {
                if ($_FILES["user-image"]["error"][$i] !== UPLOAD_ERR_OK) {
                    return false;
                }
                if (!is_uploaded_file($_FILES["user-image"]["tmp_name"][$i])) {
                    return false;
                }
                if ($_FILES["user-image"]["type"][$i] !== "image/png" && $_FILES["user-image"]["type"][$i] !== "image/jpeg") {
                    return false;
                }
                $image_info = getimagesize($_FILES["user-image"]["tmp_name"][$i]);
                if ($image_info === false) {
                    return false;
                }
            }
        } else {
            if ($_FILES["user-image"]["error"] !== UPLOAD_ERR_OK) {
                return false;
            }
            if (!is_uploaded_file($_FILES["user-image"]["tmp_name"])) {
                return false;
            }
            if ($_FILES["user-image"]["type"] !== "image/png" && $_FILES["user-image"]["type"] !== "image/jpeg") {
                return false;
            }
            $image_info = getimagesize($_FILES["user-image"]["tmp_name"]);
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