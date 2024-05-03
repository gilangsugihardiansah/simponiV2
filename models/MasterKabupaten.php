<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_kabupaten".
 *
 * @property integer $id_kabupaten
 * @property string $nama_kabupaten
 * @property integer $id_propinsi
 */
class MasterKabupaten extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_kabupaten';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_kabupaten', 'nama_kabupaten', 'id_propinsi'], 'required'],
            [['id_kabupaten', 'id_propinsi'], 'integer'],
            [['nama_kabupaten'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_kabupaten' => 'Id Kabupaten',
            'nama_kabupaten' => 'Nama Kabupaten',
            'id_propinsi' => 'Id Propinsi',
        ];
    }
}
