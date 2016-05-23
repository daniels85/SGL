<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany('UserLocals', [
            'className' => 'UserLocals',
            'foreignKey' => 'user_matricula',
            'bindingKey' => 'matricula',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Equipamentos', [
            'className'     => 'Equipamentos',
            'foreignKey'    => 'responsavel',
            'bindingKey'    => 'matricula',
            'joinType'      => 'INNER'
        ]);

        $this->hasMany('Locals', [
            'className' => 'Locals',
            'foreignKey' => 'codigo',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Alertas', [
            'className' => 'Alertas',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('BolsistasAlertas', [
            'className' => 'BolsistasAlertas',
            'foreignKey' => 'matricula_bolsista',
            'bindingKey' => 'matricula',
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
            ->requirePresence('username', 'create')
            ->notEmpty('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->requirePresence('matricula', 'create')
            ->notEmpty('matricula')
            ->add('matricula', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('role', 'create')
            ->notEmpty('role');

        $validator
            ->allowEmpty('cadastradoPor');

        $validator
            ->dateTime('dataDeCadastro');

        $validator
            ->dateTime('ultimaVezAtivo');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['matricula']));
        return $rules;
    }

    public function ola(){
        var_dump($this->get(1)->nome);
    }
}
