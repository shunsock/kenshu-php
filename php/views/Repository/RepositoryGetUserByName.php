<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\CreateConnectionPDO;
use App\Model\User;
use InvalidArgumentException;

class RepositoryGetUserByName implements RepositoryInterface
{
    public static function getUserByName(string $user_name): User
    {
        $query = 'SELECT * FROM users WHERE name = ?';
        $users = self::query_run(query: $query, params: ["name" => $user_name]);

        // if there are no user have input name, throw exception
        if (count($users) === 0) {
            throw new InvalidArgumentException();
        }

        $id = (int) $users[0]['id'];
        $name = $users[0]['name'];
        $email = $users[0]['email'];
        $password = $users[0]['password'];
        $updated_at = $users[0]['updated_at'];
        $created_at = $users[0]['created_at'];
        $deleted_at = $users[0]['deleted_at'];
        return new User(
            id: $id
            , name: $name
            , email: $email
            , password: $password
            , created_at: $created_at
            , updated_at: $updated_at
            , deleted_at: $deleted_at
        );
    }

    /**
     * @param $query
     * @param $params
     * @return array
     */
    public static function query_run($query, $params = []): array
    {
        $db = CreateConnectionPDO::CreateConnection();
        $name = $params["name"];
        $prepared = $db->prepare($query);
        $prepared->execute([$name]);
        return $prepared->fetchAll();
    }
}