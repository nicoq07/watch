<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Empleados Model
 *
 * @method \App\Model\Entity\Empleado get($primaryKey, $options = [])
 * @method \App\Model\Entity\Empleado newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Empleado[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Empleado|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Empleado|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Empleado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Empleado[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Empleado findOrCreate($search, callable $callback = null, $options = [])
 */
class EmpleadosTable extends Table
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

        $this->setTable('empleados');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->integer('legajo')
            ->requirePresence('legajo', 'create')
            ->notEmpty('legajo')
            ->add('legajo', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 60)
            ->allowEmpty('nombre');

        $validator
            ->scalar('apellido')
            ->maxLength('apellido', 60)
            ->allowEmpty('apellido');

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
        $rules->add($rules->isUnique(['legajo']));

        return $rules;
    }
}
