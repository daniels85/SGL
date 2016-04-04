<?php
namespace App\Model\Table;

use App\Model\Entity\UserLocal;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserLocals Model
 *
 */
class UserLocalsTable extends Table
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

        $this->table('user_locals');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Locals', [
            'className' => 'Locals',
            'foreignKey' => 'codigo',
            'bindingKey' => 'local_codigo',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Users', [
            'className' => 'Users',
            'foreignKey' => 'matricula',
            'bindingKey' => 'user_matricula',
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
            ->allowEmpty('user_matricula');

        $validator
            ->allowEmpty('local_codigo');

        return $validator;
    }
}
