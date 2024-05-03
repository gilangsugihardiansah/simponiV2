<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_sp".
 *
 * @property string $ID
 * @property string $ID_VP
 * @property string $NAMA
 */
class PlnEMsb extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pln_e_msb';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','NAMA','ID_VP'], 'required'],
            [['ID','NAMA','ID_VP'], 'string', 'max' => 255],
            [['NAMA'], 'trim'],
            [['NAMA'], 'filter', 'filter'=>'strtoupper'],
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
            'NAMA' => 'Nama Sub Bidang',
            'ID_VP' => 'VP',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function validateUnique($attribute, $params)
    {
        $count = PlnEMsb::find()
        ->select('ID')
        ->andWhere(['NAMA'=>$this->NAMA])
        ->andWhere(['ID_VP'=>$this->ID_VP])
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
}
