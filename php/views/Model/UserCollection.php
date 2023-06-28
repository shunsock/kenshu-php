<?php
declare(strict_types=1);

namespace App\Model;

use ArrayObject;
use InvalidArgumentException;

// Note: PHPでは`User[]`のような配列の宣言ができない
// REFERENCE: https://www.php.net/manual/ja/class.arrayobject.php
class UserCollection extends ArrayObject
{
    /**
     * @param User[] $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct();
        foreach ($items as $item) {
            $this->append($item);
        }
    }

    /**
     * @param User $value
     * @return void
     */
    public function append($value): void
    {
        $this->validate($value);
        parent::append($value);
    }

    /**
     * @param $key
     * @param  $value
     * @return void
     */
    public function offsetSet($key, $value): void
    {
        $this->validate($value);
        parent::offsetSet($key, $value);
    }

    /**
     * @param User $value
     * @return void
     */
    protected function validate(User $value): void
    {
        if (!$value instanceof User) {
            throw new InvalidArgumentException(message: 'Not an instance of User');
        }
    }
}
