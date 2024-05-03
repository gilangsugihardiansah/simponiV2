<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_sp".
 *
 * @property string $ID
 * @property string $REGION
 * @property string $NEGARA
 */
class PlnENegara extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pln_e_negara';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','REGION','NEGARA'], 'required'],
            [['ID','REGION','NEGARA'], 'string', 'max' => 255],
            [['NEGARA'], 'trim'],
            [['NEGARA'], 'filter', 'filter'=>'strtoupper'],
            [['ID','NEGARA'], 'unique'],
            [['ID'], 'validateUnique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'TRANPORTASI_BANDARA_PELABUHAN' => 'Tranportasi Via Bandara/Pelabuhan',
            'TRANSPORTASI_TERMINAL' => 'Tranportasi Via Terminal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function validateUnique($attribute, $params)
    {
        $count = PlnENegara::find()
        ->select('ID')
        ->andWhere(['REGION'=>$this->REGION])
        ->andWhere(['NEGARA'=>$this->NEGARA])
        ->andWhere(['!=','ID',$this->ID])
        ->count();

        if ($count > 0):
            $this->addError($attribute, ' Data sudah ada');
        endif;
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReg()
    {
        return $this->hasOne(PlnERegion::className(), ['ID' => 'REGION']);
    }
}
