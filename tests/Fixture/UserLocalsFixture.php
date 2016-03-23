<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserLocalsFixture
 *
 */
class UserLocalsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_matricula' => ['type' => 'string', 'length' => 80, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'local_codigo' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'user_matricula' => ['type' => 'index', 'columns' => ['user_matricula'], 'length' => []],
            'local_codigo' => ['type' => 'index', 'columns' => ['local_codigo'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'user_locals_ibfk_1' => ['type' => 'foreign', 'columns' => ['user_matricula'], 'references' => ['users', 'matricula'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'user_locals_ibfk_2' => ['type' => 'foreign', 'columns' => ['local_codigo'], 'references' => ['locals', 'codigo'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'user_matricula' => 'Lorem ipsum dolor sit amet',
            'local_codigo' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
