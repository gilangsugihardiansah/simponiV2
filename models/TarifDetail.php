<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tarif_detail".
 *
 * @property int $TID_TARIF
 * @property string $NO_SPK
 */
class TarifDetail extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tarif_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_TARIF','NO_SPK','COMPANY'], 'required'],
            [['NO_SPK'], 'unique'],
            [['ID_TARIF'], 'number', 'min' => 0],
            [['NO_SPK','COMPANY'], 'string'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarifNominal()
    {
        return $this->hasOne(TarifSppd::className(), ['ID' => 'ID_TARIF']);
    }

}
