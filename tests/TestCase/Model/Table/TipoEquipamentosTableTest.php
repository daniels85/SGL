<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoEquipamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoEquipamentosTable Test Case
 */
class TipoEquipamentosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoEquipamentosTable
     */
    public $TipoEquipamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tipo_equipamentos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TipoEquipamentos') ? [] : ['className' => 'App\Model\Table\TipoEquipamentosTable'];
        $this->TipoEquipamentos = TableRegistry::get('TipoEquipamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoEquipamentos);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
