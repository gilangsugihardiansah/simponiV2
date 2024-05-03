<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_sp".
 *
 * @property string $ID
 * @property string $REGION
 */
class PlnERegion extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pln_e_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','REGION'], 'required'],
            [['ID','REGION'], 'string', 'max' => 255],
            [['REGION'], 'trim'],
            [['REGION'], 'filter', 'filter'=>'strtoupper'],
            [['ID','REGION'], 'unique'],
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
        $count = PlnERegion::find()
        ->select('ID')
        ->andWhere(['REGION'=>$this->REGION])
        ->andWhere(['!=','ID',$this->ID])
        ->count();

        if ($count > 0):
            $this->addError($attribute, ' Data sudah ada');
        endif;
        
    }
}
