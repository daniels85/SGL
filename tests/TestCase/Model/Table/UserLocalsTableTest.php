<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserLocalsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserLocalsTable Test Case
 */
class UserLocalsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserLocalsTable
     */
    public $UserLocals;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_locals'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserLocals') ? [] : ['className' => 'App\Model\Table\UserLocalsTable'];
        $this->UserLocals = TableRegistry::get('UserLocals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserLocals);

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
