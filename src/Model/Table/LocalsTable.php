<?php
namespace App\Model\Table;

use App\Model\Entity\Local;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Locals Model
 *
 */
class LocalsTable extends Table
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

        $this->table('locals');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany('Equipamentos', [
            'foreignKey' => 'codLocal',
            'bindingKey' => 'codigo',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('UserLocals', [
            'className' => 'UserLocals',
            'foreignKey' => 'local_codigo',
            'bindingKey' => 'codigo',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Users', [
            'joinType' => 'INNER'
        ]);

        $this->hasMany('TipoEquipamentos', [
            'foreignKey' => 'id',
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
            ->requirePresence('codigo', 'create')
            ->notEmpty('codigo')
            ->add('codigo', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('tipo', 'create')
            ->notEmpty('tipo');

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
        $rules->add($rules->isUnique(['codigo']));
        return $rules;
    }
}
