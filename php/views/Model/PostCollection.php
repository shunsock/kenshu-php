<?php
declare(strict_types=1);

namespace App\Model;

use App\Core;
use ArrayObject;
use InvalidArgumentException;

// Note: PHPでは`Post[]`のような配列の宣言ができない
// REFERENCE: https://www.php.net/manual/ja/class.arrayobject.php
class PostCollection extends ArrayObject
{
    public function __construct(array $items = [])
    {
        parent::__construct();
        foreach ($items as $item) {
            $this->append($item);
        }
    }

    public function append($value): void
    {
        $this->validate($value);
        parent::append($value);
    }

    public function offsetSet($key, $value): void
    {
        $this->validate($value);
        parent::offsetSet($key, $value);
    }

    protected function validate($value): void
    {
        if (!$value instanceof Post) {
            throw new InvalidArgumentException(message: 'Not an instance of Post');
        }
    }
}