<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
 *
 * @property string $id
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property string|null $body
 * @property string|null $user_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \CakeDC\Users\Model\Entity\User $user
 */
class Post extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'slug' => true,
        'meta_keywords' => true,
        'meta_description' => true,
        'body' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'user' => true
    ];
}
