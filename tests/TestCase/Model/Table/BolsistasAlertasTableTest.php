<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BolsistasAlertasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BolsistasAlertasTable Test Case
 */
class BolsistasAlertasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BolsistasAlertasTable
     */
    public $BolsistasAlertas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bolsistas_alertas',
        'app.alertas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('BolsistasAlertas') ? [] : ['className' => 'App\Model\Table\BolsistasAlertasTable'];
        $this->BolsistasAlertas = TableRegistry::get('BolsistasAlertas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BolsistasAlertas);

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
