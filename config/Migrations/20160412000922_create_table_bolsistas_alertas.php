<?php

use Phinx\Migration\AbstractMigration;

class CreateTableBolsistasAlertas extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change() {

        $table = $this->table('bolsistas_alertas');

        $table->addColumn('matricula_bolsista', 'string', [
                'limit' => '80',
                'null' => false
            ]);

        $table->addColumn('alerta_id', 'integer', [
                'limit' => '11',
                'null' => false
            ]);       

        $table->create();
        
    }
}
