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
        'tombo' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'status' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => 'Funcionando', 'comment' => '', 'precision' => null, 'fixed' => null],
        'codLocal' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'fornecedor' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'modelo' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'responsavel' => ['type' => 'string', 'length' => 80, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'dataDeCompra' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'codLocal' => ['type' => 'index', 'columns' => ['codLocal'], 'length' => []],
            'tipo' => ['type' => 'index', 'columns' => ['tipo'], 'length' => []],
            'responsavel' => ['type' => 'index', 'columns' => ['responsavel'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tombo' => ['type' => 'unique', 'columns' => ['tombo'], 'length' => []],
            'equipamentos_ibfk_1' => ['type' => 'foreign', 'columns' => ['codLocal'], 'references' => ['locals', 'codigo'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
            'equipamentos_ibfk_2' => ['type' => 'foreign', 'columns' => ['tipo'], 'references' => ['tipo_equipamentos', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
            'equipamentos_ibfk_3' => ['type' => 'foreign', 'columns' => ['responsavel'], 'references' => ['users', 'matricula'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
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
            'tombo' => 'Lorem ipsum dolor sit amet',
            'status' => 'Lorem ipsum dolor sit amet',
            'codLocal' => 'Lorem ipsum dolor sit amet',
            'fornecedor' => 'Lorem ipsum dolor sit amet',
            'modelo' => 'Lorem ipsum dolor sit amet',
            'responsavel' => 'Lorem ipsum dolor sit amet',
            'tipo' => 1,
            'dataDeCompra' => '2016-05-24 23:09:34'
        ],
    ];
}
