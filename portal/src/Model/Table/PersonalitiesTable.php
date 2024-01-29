<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Personalities Model
 *
 * @property \App\Model\Table\JobsTable&\Cake\ORM\Association\BelongsToMany $Jobs
 *
 * @method \App\Model\Entity\Personality newEmptyEntity()
 * @method \App\Model\Entity\Personality newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Personality> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Personality get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Personality findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Personality patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Personality> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Personality|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Personality saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Personality>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Personality>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Personality>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Personality> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Personality>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Personality>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Personality>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Personality> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PersonalitiesTable extends Table
{
    /**
     * Initialize method
     *
     * @param  array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('personalities');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany(
            'Jobs', [
            'className' => 'Jobs',
            'joinTable' => 'jobs_personalities',
            'foreignKey' => 'personality_id',
            'targetForeignKey' => 'job_id'
            ]
        );
    }

    /**
     * Default validation rules.
     *
     * @param  \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('sort_order')
            ->notEmptyString('sort_order');

        $validator
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        return $validator;
    }
}
