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

        /**
     * Visszaadja a csoportok fastruktúráját tömbben, kihagyva a törölt elemeket.
     *
     * Ezzel a metódussal lekérhetőek a csoportok úgy, hogy a parents - child kapcsolatok is látszanak.
     *
     * Ha kell csak a legfelső szintű (ős) csoportokat adja vissza, ebben az esetben $onlyRoots= true szükséges. 
     * Alapból az egész hierarchiát visszaadja (childokkal).
     *
     * @param bool $onlyRoots Ha true, csak a legfelső csoportokat adja vissza, childs nélkül.
     *                        Ha false, akkor az egész fa visszajön, minden leszármazottal.
     * @return array A csoportok hierarchiája tömbként, ahol a parents alatt ott vannak a childok (children mezőben).
     */
    public static function getHierarchy($onlyRoots = false)
    {
        $query = static::find()->where(['is_deleted' => 0])->asArray()->all();
        $groups = [];

        foreach ($query as $item) {
            $item['children'] = [];
            $groups[$item['id']] = $item;
        }

        foreach ($groups as $id => &$group) {
            if ($group['parent_id'] && isset($groups[$group['parent_id']])) {
                $groups[$group['parent_id']]['children'][] = &$group;
            }
        }
        unset($group);

        $result = [];
        foreach ($groups as $id => $group) {
            if (!$group['parent_id']) {
                if ($onlyRoots) {
                    $groupCopy = $group;
                    $groupCopy['children'] = []; // csak a főcsoportot adja vissza, gyerekek nélkül
                    $result[] = $groupCopy;
                } else {
                    $result[] = $group;
                }
            }
        }

        return $result;
    }

}
