<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BolsistasAlertasFixture
 *
 */
class BolsistasAlertasFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'matricula_bolsista' => ['type' => 'string', 'length' => 80, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'alerta_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'matricula_bolsista' => ['type' => 'index', 'columns' => ['matricula_bolsista'], 'length' => []],
            'alerta_id' => ['type' => 'index', 'columns' => ['alerta_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'bolsistas_alertas_ibfk_1' => ['type' => 'foreign', 'columns' => ['matricula_bolsista'], 'references' => ['users', 'matricula'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'bolsistas_alertas_ibfk_2' => ['type' => 'foreign', 'columns' => ['alerta_id'], 'references' => ['alertas', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
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
            'matricula_bolsista' => 'Lorem ipsum dolor sit amet',
            'alerta_id' => 1
        ],
    ];
}
