<?php

namespace app\modules\api\models;

use Yii;

/**
 * This is the model class for table "airport".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $timezone
 */
class Airport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'airport';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'timezone'], 'required'],
            [['name', 'timezone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'timezone' => 'Timezone',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'timezone'
        ];
    }
}
