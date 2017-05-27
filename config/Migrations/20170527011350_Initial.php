<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {

        $this->table('alertas')
            ->addColumn('descricao', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('observacoes', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('geradoPor', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('statusAlerta', 'string', [
                'default' => 'Pendente',
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('tomboEquipamento', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('dataAlerta', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
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

        $this->table('bolsistas_alertas')
            ->addColumn('matricula_bolsista', 'string', [
                'default' => null,
                'limit' => 80,
                'null' => false,
            ])
            ->addColumn('alerta_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(
                [
                    'alerta_id',
                ]
            )
            ->addIndex(
                [
                    'matricula_bolsista',
                ]
            )
            ->create();

        $this->table('equipamentos')
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
            ->addColumn('dataDeCompra', 'date', [
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
                    'responsavel',
                ]
            )
            ->addIndex(
                [
                    'tipo',
                ]
            )
            ->create();

        $this->table('locals')
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

        $this->table('ocorrencias')
            ->addColumn('tomboEquipamento', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('descricao', 'text', [
                'default' => null,
                'limit' => null,
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
            ->addColumn('dataEncaminhamento', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('previsaoDeRetorno', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('observacoes', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('dataOcorrencia', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
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

        $this->table('tipo_equipamentos')
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

        $this->table('user_locals')
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

        $this->table('users')
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
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 100,
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
            ->addColumn('dataDeCadastro', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
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
                    'email',
                ],
                ['unique' => true]
            )
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

        $this->table('bolsistas_alertas')
            ->addForeignKey(
                'alerta_id',
                'alertas',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'matricula_bolsista',
                'users',
                'matricula',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

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
                'responsavel',
                'users',
                'matricula',
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
    }

    public function down()
    {
        $this->table('alertas')
            ->dropForeignKey(
                'tomboEquipamento'
            );

        $this->table('bolsistas_alertas')
            ->dropForeignKey(
                'alerta_id'
            )
            ->dropForeignKey(
                'matricula_bolsista'
            );

        $this->table('equipamentos')
            ->dropForeignKey(
                'codLocal'
            )
            ->dropForeignKey(
                'responsavel'
            )
            ->dropForeignKey(
                'tipo'
            );

        $this->table('ocorrencias')
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

        $this->dropTable('alertas');
        $this->dropTable('bolsistas_alertas');
        $this->dropTable('equipamentos');
        $this->dropTable('locals');
        $this->dropTable('ocorrencias');
        $this->dropTable('tipo_equipamentos');
        $this->dropTable('user_locals');
        $this->dropTable('users');
    }
}
