<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_sp".
 *
 * @property string $ID
 * @property string $CHARGE_CODE
 * @property string $NAMA_PEKERJAAN
 * @property string $ID_VP
 * @property string $ID_MSB
 */
class PlnEChargeCode extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pln_e_charge_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','CHARGE_CODE','NAMA_PEKERJAAN','ID_VP','ID_MSB'], 'required'],
            [['NAMA_PEKERJAAN'], 'string'],
            [['ID','CHARGE_CODE','ID_VP','ID_MSB'], 'string', 'max' => 255],
            [['NAMA_PEKERJAAN'], 'trim'],
            [['ID'], 'unique'],
            [['ID'], 'validateUnique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CHARGE_CODE' => 'Charge Code',
            'NAMA_PEKERJAAN' => 'Pekerjaan',
            'ID_VP' => 'VP',
            'ID_MSB' => 'MSB',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function validateUnique($attribute, $params)
    {
        $count = PlnEChargeCode::find()
        ->select('ID')
        ->andWhere(['CHARGE_CODE'=>$this->CHARGE_CODE])
        ->andWhere(['ID_VP'=>$this->ID_VP])
        ->andWhere(['ID_MSB'=>$this->ID_MSB])
        ->andWhere(['!=','ID',$this->ID])
        ->count();

        if ($count > 0):
            $this->addError($attribute, ' Data sudah ada');
        endif;
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVp()
    {
        return $this->hasOne(PlnEVp::className(), ['ID' => 'ID_VP']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMsb()
    {
        return $this->hasOne(PlnEMsb::className(), ['ID' => 'ID_MSB']);
    }
}
