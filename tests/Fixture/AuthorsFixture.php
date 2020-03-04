<?php
declare(strict_types=1);

namespace WyriHaximus\TwigView\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * Authors fixture
 */
class AuthorsFixture extends TestFixture
{
    /**
     * fields property
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'name' => ['type' => 'string', 'default' => null],
        '_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]],
    ];

    /**
     * records property
     *
     * @var array
     */
    public $records = [
        ['name' => 'mariano'],
        ['name' => 'nate'],
        ['name' => 'larry'],
        ['name' => 'garrett'],
    ];
}
