<?php

declare(strict_types=1);

namespace App\Core;

use Exception;
use InvalidArgumentException;

class UploadedImageChecker
{
    private string $image_name;
    private string $image_type;
    private string $image_base;

    public function __construct()
    {
        if (self::isUploadedImageValid()){
            $this->image_name = $_FILES["user-image"]["name"];
            $this->image_type = $_FILES["user-image"]["type"];
            $this->image_base = $_FILES["user-image"]["tmp_name"];
        } else {
            throw new InvalidArgumentException(message: "画像のアップロードに失敗しました。");
        }
    }

    private static function isUploadedImageValid(): bool
    {
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
        $image_mime_type = $image_info["mime"];
        if (!str_starts_with($image_mime_type, "image/")) {
            return false;
        }
        return true;
    }

    public function getImageName(): string
    {
        return $this->image_name;
    }

    public function getImageType(): string
    {
        return $this->image_type;
    }

    public function getImageBase(): string
    {
        return $this->image_base;
    }
}