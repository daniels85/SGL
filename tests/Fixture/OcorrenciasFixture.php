<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OcorrenciasFixture
 *
 */
class OcorrenciasFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'tomboEquipamento' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'descricao' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'geradoPor' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'encaminhamento' => ['type' => 'string', 'length' => 80, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'dataEncaminhamento' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'previsaoDeRetorno' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'observacoes' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'dataOcorrencia' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'geradoPor' => ['type' => 'index', 'columns' => ['geradoPor'], 'length' => []],
            'tomboEquipamento' => ['type' => 'index', 'columns' => ['tomboEquipamento'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'ocorrencias_ibfk_1' => ['type' => 'foreign', 'columns' => ['geradoPor'], 'references' => ['users', 'matricula'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ocorrencias_ibfk_2' => ['type' => 'foreign', 'columns' => ['tomboEquipamento'], 'references' => ['equipamentos', 'tombo'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'tomboEquipamento' => 'Lorem ipsum dolor sit amet',
            'descricao' => 'Lorem ipsum dolor sit amet',
            'geradoPor' => 'Lorem ipsum dolor sit amet',
            'encaminhamento' => 'Lorem ipsum dolor sit amet',
            'dataEncaminhamento' => 'Lorem ip',
            'previsaoDeRetorno' => 'Lorem ip',
            'observacoes' => 'Lorem ipsum dolor sit amet',
            'dataOcorrencia' => 'Lorem ip'
        ],
    ];
}
