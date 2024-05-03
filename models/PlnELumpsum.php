<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_sp".
 *
 * @property string $ID
 * @property string $WILAYAH
 * @property double $LUMPSUM
 */
class PlnELumpsum extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pln_e_lumpsum';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','WILAYAH','LUMPSUM'], 'required'],
            [['ID','WILAYAH'], 'string', 'max' => 255],
            [['LUMPSUM'], 'number', 'min' => 0],
            [['WILAYAH'], 'trim'],
            [['WILAYAH'], 'filter', 'filter'=>'strtoupper'],
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
            'TRANPORTASI_BANDARA_PELABUHAN' => 'Tranportasi Via Bandara/Pelabuhan',
            'TRANSPORTASI_TERMINAL' => 'Tranportasi Via Terminal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function validateUnique($attribute, $params)
    {
        $count = PlnELumpsum::find()
        ->select('ID')
        ->andWhere(['WILAYAH'=>$this->WILAYAH])
        ->andWhere(['!=','ID',$this->ID])
        ->count();

        if ($count > 0):
            $this->addError($attribute, ' Data sudah ada');
        endif;
        
    }
}
