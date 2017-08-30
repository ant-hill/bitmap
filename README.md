# bitmap

Simple library allows add, delete, check bits by offset.
In offset could be in range of 0 to PHP_INT_MAX


Simple usage:

```php

    $bitMapOffset = new BitMapOffset(4,/* Chunk size, max size for correct work is (PHP_INT_SIZE*8)-1 */);
    $bitMapArray =  new BitMapArray($bitMapOffset,[] /* BitMap Array */);

    $bitMapArray->add(3); // Add set 3rd bit at 1
    $bitMapArray->has(3); // Check for 3rd bit is set
    $bitMapArray->del(3); // Delete 3rd bit if exists
```