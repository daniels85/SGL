<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipamentosTable Test Case
 */
class EquipamentosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipamentosTable
     */
    public $Equipamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.equipamentos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Equipamentos') ? [] : ['className' => 'App\Model\Table\EquipamentosTable'];
        $this->Equipamentos = TableRegistry::get('Equipamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Equipamentos);

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
