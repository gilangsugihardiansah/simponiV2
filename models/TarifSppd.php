<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_sp".
 *
 * @property int $ID
 * @property double $TARIF_AKOMODASI
 * @property double $TARIF_MENGINAP
 * @property string $COMPANY
 */
class TarifSppd extends \yii\db\ActiveRecord
{
    public $NO_SPK;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tarif_sppd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TARIF_AKOMODASI','TARIF_MENGINAP','COMPANY'], 'required'],
            [['TARIF_AKOMODASI','TARIF_MENGINAP'], 'number', 'min' => 0],
            [['COMPANY'], 'string'],
            [['NO_SPK'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'TARIF_AKOMODASI' => 'Akomodasi',
            'TARIF_MENGINAP' => 'Penginapan',
        ];
    }
}
