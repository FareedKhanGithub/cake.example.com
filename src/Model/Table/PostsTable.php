<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;

/**
 * Posts Model
 *
 * @property \CakeDC\Users\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Post get($primaryKey, $options = [])
 * @method \App\Model\Entity\Post newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Post|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Post[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Post findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PostsTable extends Table
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

        $this->setTable('posts');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'className'=>'Users.Users',
            'foreignKey' => 'user_id'
        ]);
    }

    public function beforeMarshal($event, $data)
    {
        if (!isset($data['slug']) && !empty($data['title'])) {
            $data['slug'] = $this->createSlug($data['title']);
        }
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
            ->uuid('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255);


        $validator
            ->scalar('slug')
            ->maxLength('slug', 255);

        $validator
            ->scalar('meta_keywords')
            ->maxLength('meta_keywords', 255)
            ->allowEmptyString('meta_keywords');

        $validator
            ->scalar('meta_description')
            ->maxLength('meta_description', 255)
            ->allowEmptyString('meta_description');

        $validator
            ->scalar('body')
            ->allowEmptyString('body');

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
        //$rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * Returns a slug of a given field
     * @param string $title
     * @return string
     */



    public function createSlug($title)
    {
        return Text::slug(
            strtolower(
                substr($title, 0, 191)
            )
        );
    }

}
