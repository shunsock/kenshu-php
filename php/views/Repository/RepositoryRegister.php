<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;

class RepositoryRegister
{
    public static function RegisterUser(
        string $user_name,
        string $email,
        string $password_hashed
    ): void
    {
        $query = "INSERT INTO users (name, email, password) VALUES (?,?,?)";
        self::query_run(
            query: $query
            , user_name: $user_name
            , email: $email
            , password_hashed: $password_hashed
        );
    }

    public static function query_run(
        string $query
        , string $user_name
        , string $email
        , string $password_hashed
    ): void
    {
        $db = CreateConnectionPDO::CreateConnection();
        $prepared = $db->prepare($query);
        $prepared->execute([$user_name, $email, $password_hashed]);
    }
}