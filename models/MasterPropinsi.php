<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_propinsi".
 *
 * @property integer $id_propinsi
 * @property string $nama_propinsi
 */
class MasterPropinsi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_propinsi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_propinsi', 'nama_propinsi'], 'required'],
            [['id_propinsi'], 'integer'],
            [['nama_propinsi'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_propinsi' => 'Id Propinsi',
            'nama_propinsi' => 'Nama Propinsi',
        ];
    }
}
