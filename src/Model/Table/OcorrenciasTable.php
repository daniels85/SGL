<?php
namespace App\Model\Table;

use App\Model\Entity\Ocorrencia;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ocorrencias Model
 *
 */
class OcorrenciasTable extends Table
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

        $this->table('ocorrencias');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->requirePresence('tomboEquipamento', 'create')
            ->notEmpty('tomboEquipamento');

        $validator
            ->requirePresence('descricao', 'create')
            ->notEmpty('descricao');

        $validator
            ->requirePresence('geradoPor', 'create')
            ->notEmpty('geradoPor');

        $validator
            ->allowEmpty('encaminhamento');

        $validator
            ->allowEmpty('dataEncaminhamento');

        $validator
            ->allowEmpty('previsaoDeRetorno');

        $validator
            ->allowEmpty('observacoes');

        $validator
            ->allowEmpty('dataOcorrencia');

        return $validator;
    }
}
