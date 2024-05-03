<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "d_val".
 *
 * @property double $ID
 * @property string $NAMA
 * @property string $VALUE
 * @property string $DESCRIPTION
 * @property string $TABLE
 */
class DVal extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'd_val';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['JENIS_USER'], 'required'],
            // [['JENIS_USER'], 'unique'],
            // [['JENIS_USER'], 'trim'],
            // [['JENIS_USER'], 'filter', 'filter'=>'strtoupper'],
            [['KEY','VALUE','DESCRIPTION','TABLE'], 'string', 'max' => 255],
        ];
    }
}
