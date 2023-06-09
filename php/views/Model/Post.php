<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\NumberInt;

class Post
{
    private int $id;
    private string $title;
    private int $user_id;
    private string $thumbnail;
    private string $body;
    private string $created_at;
    private string $updated_at;
    private string $user_name;

    public function __construct(
        int    $id,
        string $title,
        int    $user_id,
        string $thumbnail,
        string $body,
        string $created_at,
        string $updated_at,
        string $user_name
    )
    {
        $id_checked = new NumberInt($id);
        $this->id = $id_checked->getValue();

        $this->title = $title;

        $user_id_checked = new NumberInt($user_id);
        $this->user_id = $user_id_checked->getValue();

        $this->thumbnail = $thumbnail;

        $this->body = $body;

        $this->created_at = $created_at;

        $this->updated_at = $updated_at;

        $this->user_name = $user_name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function getUserName(): string
    {
        return $this->user_name;
    }
}