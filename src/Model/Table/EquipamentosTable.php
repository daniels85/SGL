<?php
namespace App\Model\Table;

use App\Model\Entity\Equipamento;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Equipamentos Model
 *
 */
class EquipamentosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('equipamentos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('locals', [
            'className' => 'Locals',
            'bindingKey' => 'codLocal',
            'foreignKey' => 'codigo',
            'joinType' => 'INNER'
        ]);        

        $this->belongsTo('TipoEquipamentos', [
            'className' => 'TipoEquipamentos',
            'bindingKey' => 'tipo',
            'foreignKey' => 'id_tipo',
            'joinType' => 'INNER'
        ]);

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('nome', 'create')
            ->notEmpty('nome');

        $validator
            ->allowEmpty('status');

        $validator
            ->allowEmpty('codLocal');

        $validator
            ->allowEmpty('dataCompra');

        $validator
            ->allowEmpty('fornecedor');

        $validator
            ->allowEmpty('modelo');

        $validator
            ->allowEmpty('responsavel');

        $validator
            ->integer('tipo')
            ->requirePresence('tipo', 'create')
            ->notEmpty('tipo');

        $validator
            ->allowEmpty('tombo')
            ->add('tombo', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['tombo']));
        return $rules;
    }
}
