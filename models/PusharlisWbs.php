<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wsb".
 *
 * @property string $WSB
 * @property string $KETERANGAN
 */
class PusharlisWbs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wsb';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbpusharlis');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['WSB'], 'required'],
            [['WSB'], 'unique'],
            [['WSB'], 'trim'],
            [['WSB', 'KETERANGAN'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'WSB' => 'No. WBS',
            'KETERANGAN' => 'Keterangan',
        ];
    }
}
