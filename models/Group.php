<?php

// models/Group.php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "group".
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property int $is_deleted
 */
class Group extends ActiveRecord
{
    public static function tableName()
    {
        return 'group';
    }

    public static function getHierarchy($onlyRoots = false)
    {
        $query = static::find()->where(['is_deleted' => 0])->asArray()->all();
        $groups = [];

        foreach ($query as $item) {
            $groups[$item['id']] = $item + ['children' => []];
        }

        foreach ($groups as $id => &$group) {
            if ($group['parent_id'] && isset($groups[$group['parent_id']])) {
                $groups[$group['parent_id']]['children'][] = &$group;
            }
        }

        $result = [];
        foreach ($groups as $group) {
            if ($onlyRoots && $group['parent_id']) continue;
            if (!$group['parent_id']) $result[] = $group;
        }

        return $result;
    }
}
