<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OcorrenciasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OcorrenciasTable Test Case
 */
class OcorrenciasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OcorrenciasTable
     */
    public $Ocorrencias;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ocorrencias'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Ocorrencias') ? [] : ['className' => 'App\Model\Table\OcorrenciasTable'];
        $this->Ocorrencias = TableRegistry::get('Ocorrencias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ocorrencias);

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
