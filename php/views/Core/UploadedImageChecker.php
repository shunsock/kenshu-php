<?php

declare(strict_types=1);

namespace App\Core;

use InvalidArgumentException;

class UploadedImageChecker
{
    // TODO: Change Class Array to Something Other...
    private array $image_names = [];
    private array $image_types = [];
    private array $image_bases = [];

    private string $image_name;
    private string $image_type;
    private string $image_base;

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
            $this->image_name = (string) $_FILES["user-image"]["name"];
            $this->image_type =  (string) $_FILES["user-image"]["type"];
            $this->image_base = (string) $_FILES["user-image"]["tmp_name"];
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
    public function getImageNames(): array
    {
        return $this->image_names;
    }

    /*
     * object type of array is only string
     */
    public function getImageTypes(): array
    {
        return $this->image_types;
    }

    /*
     * object type of array is only string
     */
    public function getImageBases(): array
    {
        return $this->image_bases;
    }
    public function getImage(): string
    {
        return $this->image_base;
    }
    public function getImageName(): string
    {
        return $this->image_name;
    }
    public function getImageType(): string
    {
        return $this->image_type;
    }
}