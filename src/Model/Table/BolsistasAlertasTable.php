<?php
namespace App\Model\Table;

use App\Model\Entity\BolsistasAlerta;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BolsistasAlertas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Alertas
 */
class BolsistasAlertasTable extends Table
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

        $this->table('bolsistas_alertas');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Alertas', [
            'foreignKey' => 'alerta_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'matricula',
            'bindingKey' => 'matricula_bolsista',
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
            ->requirePresence('matricula_bolsista', 'create')
            ->notEmpty('matricula_bolsista');

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
        $rules->add($rules->existsIn(['alerta_id'], 'Alertas'));
        return $rules;
    }
}
