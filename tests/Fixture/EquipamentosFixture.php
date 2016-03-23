<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EquipamentosFixture
 *
 */
class EquipamentosFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'nome' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'status' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'codLocal' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'dataCompra' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'fornecedor' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'modelo' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'responsavel' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tombo' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'codLocal' => ['type' => 'index', 'columns' => ['codLocal'], 'length' => []],
            'tipo' => ['type' => 'index', 'columns' => ['tipo'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tombo' => ['type' => 'unique', 'columns' => ['tombo'], 'length' => []],
            'equipamentos_ibfk_1' => ['type' => 'foreign', 'columns' => ['codLocal'], 'references' => ['locals', 'codigo'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'equipamentos_ibfk_2' => ['type' => 'foreign', 'columns' => ['tipo'], 'references' => ['tipo_equipamentos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'nome' => 'Lorem ipsum dolor sit amet',
            'status' => 'Lorem ipsum dolor sit amet',
            'codLocal' => 'Lorem ipsum dolor sit amet',
            'dataCompra' => 'Lorem ip',
            'fornecedor' => 'Lorem ipsum dolor sit amet',
            'modelo' => 'Lorem ipsum dolor sit amet',
            'responsavel' => 'Lorem ipsum dolor sit amet',
            'tipo' => 1,
            'tombo' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
