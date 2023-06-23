<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;
use App\Core\StringArray;
use InvalidArgumentException;
use PDO;

class RepositoryRegister
{
    public static function RegisterUser(
        string $user_name,
        string $email,
        string $password_hashed
    ): void
    {
        $user_names = self::getAllUserName();
        if ($user_names->isExist($user_name)) {
            throw new InvalidArgumentException(message: "user name already exists");
        }

        // code below have possible to throw PDOException
        self::InsertUserData(
            user_name: $user_name
            , email: $email
            , password_hashed: $password_hashed
        );
    }

    public static function getAllUserName(): StringArray
    {
        // code below have possible to throw PDOException
        $query = "SELECT name FROM users";
        $db = CreateConnectionPDO::CreateConnection();
        $prepared = $db->prepare($query);
        $prepared->execute();
        $user_names = $prepared->fetchAll(mode: PDO::FETCH_COLUMN, args: 0);

        // code below have possible to throw Invalid Argument Exception
        return new StringArray($user_names);
    }

    public static function InsertUserData(
        string   $user_name
        , string $email
        , string $password_hashed
    ): void
    {
        $query = "INSERT INTO users (name, email, password) VALUES (?,?,?)";
        $db = CreateConnectionPDO::CreateConnection();
        $prepared = $db->prepare($query);
        $prepared->execute([$user_name, $email, $password_hashed]);
    }
}