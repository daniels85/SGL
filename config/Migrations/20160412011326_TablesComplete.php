<?php
use Migrations\AbstractMigration;

class TablesComplete extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('users');
        $table
            ->addColumn('nome', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('matricula', 'string', [
                'default' => null,
                'limit' => 80,
                'null' => false,
            ])
            ->addColumn('role', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('cadastradoPor', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('dataDeCadastro', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('ultimaVezAtivo', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'matricula',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'username',
                ],
                ['unique' => true]
            )
            ->create();

        $table = $this->table('locals');
        $table
            ->addColumn('nome', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('codigo', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('tipo', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addIndex(
                [
                    'codigo',
                ],
                ['unique' => true]
            )
            ->create();

        $table = $this->table('equipamentos');
        $table
            ->addColumn('nome', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('tombo', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => 'Funcionando',
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('codLocal', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('fornecedor', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('modelo', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('responsavel', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('tipo', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('dataDeCompra', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'tombo',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'codLocal',
                ]
            )
            ->addIndex(
                [
                    'tipo',
                ]
            )
            ->create();

        $table = $this->table('tipo_equipamentos');
        $table
            ->addColumn('nome', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('descricao', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addIndex(
                [
                    'nome',
                ],
                ['unique' => true]
            )
            ->create();

        $table = $this->table('alertas');
        $table
            ->addColumn('descricao', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('geradoPor', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('statusAlerta', 'string', [
                'default' => 'Pedente',
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('tomboEquipamento', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('dataAlerta', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'tomboEquipamento',
                ]
            )
            ->addIndex(
                [
                    'id',
                ]
            )
            ->create();

        $table = $this->table('user_locals');
        $table
            ->addColumn('user_matricula', 'string', [
                'default' => null,
                'limit' => 80,
                'null' => true,
            ])
            ->addColumn('local_codigo', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addIndex(
                [
                    'local_codigo',
                ]
            )
            ->addIndex(
                [
                    'user_matricula',
                ]
            )
            ->create();

        $table = $this->table('ocorrencias');
        $table
            ->addColumn('tomboEquipamento', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('descricao', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('geradoPor', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('encaminhamento', 'string', [
                'default' => null,
                'limit' => 80,
                'null' => true,
            ])
            ->addColumn('dataEncaminhamento', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('previsaoDeRetorno', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('observacoes', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('dataOcorrencia', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addIndex(
                [
                    'tomboEquipamento',
                ]
            )
            ->addIndex(
                [
                    'geradoPor',
                ]
            )
            ->create();

        $this->table('equipamentos')
            ->addForeignKey(
                'codLocal',
                'locals',
                'codigo',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->addForeignKey(
                'tipo',
                'tipo_equipamentos',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();

        $this->table('alertas')
            ->addForeignKey(
                'tomboEquipamento',
                'equipamentos',
                'tombo',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('user_locals')
            ->addForeignKey(
                'local_codigo',
                'locals',
                'codigo',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_matricula',
                'users',
                'matricula',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('ocorrencias')
            ->addForeignKey(
                'tomboEquipamento',
                'equipamentos',
                'tombo',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

    }

    public function down()
    {
        $this->table('equipamentos')
            ->dropForeignKey(
                'codLocal'
            )
            ->dropForeignKey(
                'tipo'
            );

        $this->table('alertas')
            ->dropForeignKey(
                'tomboEquipamento'
            );

        $this->table('user_locals')
            ->dropForeignKey(
                'local_codigo'
            )
            ->dropForeignKey(
                'user_matricula'
            );

        $this->table('ocorrencias')
            ->dropForeignKey(
                'tomboEquipamento'
            );

        $this->dropTable('users');
        $this->dropTable('locals');
        $this->dropTable('equipamentos');
        $this->dropTable('tipo_equipamentos');
        $this->dropTable('alertas');
        $this->dropTable('user_locals');
        $this->dropTable('ocorrencias');
    }
}
