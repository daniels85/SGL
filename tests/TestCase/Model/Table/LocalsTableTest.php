<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocalsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocalsTable Test Case
 */
class LocalsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LocalsTable
     */
    public $Locals;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.locals'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Locals') ? [] : ['className' => 'App\Model\Table\LocalsTable'];
        $this->Locals = TableRegistry::get('Locals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Locals);

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
