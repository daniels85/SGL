<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AlertasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AlertasTable Test Case
 */
class AlertasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AlertasTable
     */
    public $Alertas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('Alertas') ? [] : ['className' => 'App\Model\Table\AlertasTable'];
        $this->Alertas = TableRegistry::get('Alertas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Alertas);

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
}
