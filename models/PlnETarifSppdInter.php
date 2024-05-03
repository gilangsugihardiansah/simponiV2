<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_sp".
 *
 * @property string $ID
 * @property string $REGION
 * @property double $KONSUMSI
 * @property double $UANG_SAKU
 */
class PlnETarifSppdInter extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pln_e_tarif_sppd_inter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','REGION','KONSUMSI','UANG_SAKU'], 'required'],
            [['ID','REGION'], 'string', 'max' => 255],
            [['KONSUMSI','UANG_SAKU'], 'number', 'min' => 0],
            [['REGION'], 'trim'],
            [['REGION'], 'filter', 'filter'=>'strtoupper'],
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
        $count = PlnETarifSppdInter::find()
        ->select('ID')
        ->andWhere(['REGION'=>$this->REGION])
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
