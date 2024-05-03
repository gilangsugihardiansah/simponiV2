<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jenis_user".
 *
 * @property double $ID
 * @property string $JENIS_USER
 */
class JenisUser extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jenis_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['JENIS_USER'], 'required'],
            [['JENIS_USER'], 'unique'],
            [['JENIS_USER'], 'trim'],
            [['JENIS_USER'], 'filter', 'filter'=>'strtoupper'],
            [['JENIS_USER'], 'string', 'max' => 255],
        ];
    }
}
