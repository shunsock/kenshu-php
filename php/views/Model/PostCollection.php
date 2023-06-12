<?php
declare(strict_types=1);

namespace App\Model;

use App\Core;
use ArrayObject;

// Note: PHPでは`Post[]`のような配列の宣言ができない
// REFERENCE: https://www.php.net/manual/ja/class.arrayobject.php
class PostCollection extends ArrayObject
{
    /**
     * @param Post[] $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct();
        foreach ($items as $item) {
            $this->append($item);
        }
    }

    /**
     * @param Post $value
     * @return void
     */
    public function append($value): void
    {
        $this->validate($value);
        parent::append($value);
    }

    /**
     * @param $key
     * @param Post $value
     * @return void
     */
    public function offsetSet($key, $value): void
    {
        $this->validate($value);
        parent::offsetSet($key, $value);
    }

    /**
     * @param Post $value
     * @return void
     */
    protected function validate($value): void
    {
        if (!$value instanceof Post) {
            throw new \InvalidArgumentException(message: 'Not an instance of Post');
        }
    }
}
