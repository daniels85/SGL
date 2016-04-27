<?php
namespace App\Model\Table;

use App\Model\Entity\Alerta;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Alertas Model
 *
 */
class AlertasTable extends Table
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

        $this->table('alertas');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('BolsistasAlertas', [
            'foreignKey' => 'id',
            'bindingKey' => 'alerta_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Equipamentos', [
            'foreignKey' => 'tombo',
            'bindingKey' => 'tomboEquipamento',
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
            ->allowEmpty('dataAlerta');

        $validator
            ->requirePresence('descricao', 'create')
            ->notEmpty('descricao');

        $validator
            ->requirePresence('geradoPor', 'create')
            ->notEmpty('geradoPor');

        $validator
            ->allowEmpty('statusAlerta');

        $validator
            ->requirePresence('tomboEquipamento', 'create')
            ->notEmpty('tomboEquipamento');

        $validator
            ->allowEmpty('bolsistaResponsavel');

        return $validator;
    }
}
