<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AlertasFixture
 *
 */
class AlertasFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'dataAlerta' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'descricao' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'geradoPor' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'statusAlerta' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'tomboEquipamento' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'bolsistaResponsavel' => ['type' => 'string', 'length' => 80, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'bolsistaResponsavel' => ['type' => 'index', 'columns' => ['bolsistaResponsavel'], 'length' => []],
            'tomboEquipamento' => ['type' => 'index', 'columns' => ['tomboEquipamento'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'alertas_ibfk_1' => ['type' => 'foreign', 'columns' => ['bolsistaResponsavel'], 'references' => ['users', 'matricula'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'alertas_ibfk_2' => ['type' => 'foreign', 'columns' => ['tomboEquipamento'], 'references' => ['equipamentos', 'tombo'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'dataAlerta' => 'Lorem ip',
            'descricao' => 'Lorem ipsum dolor sit amet',
            'geradoPor' => 'Lorem ipsum dolor sit amet',
            'statusAlerta' => 'Lorem ipsum dolor sit amet',
            'tomboEquipamento' => 'Lorem ipsum dolor sit amet',
            'bolsistaResponsavel' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
