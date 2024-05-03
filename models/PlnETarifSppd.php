<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_sp".
 *
 * @property string $COMPANY
 * @property string $ID
 * @property double $KONSUMSI
 * @property double $LAUNDRY
 * @property double $TRANPORTASI_BANDARA_PELABUHAN
 * @property double $TRANSPORTASI_TERMINAL
 */
class PlnETarifSppd extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pln_e_tarif_sppd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','COMPANY','KONSUMSI','LAUNDRY','TRANPORTASI_BANDARA_PELABUHAN','TRANSPORTASI_TERMINAL'], 'required'],
            [['ID','COMPANY'], 'string', 'max' => 255],
            [['KONSUMSI','LAUNDRY','TRANPORTASI_BANDARA_PELABUHAN','TRANSPORTASI_TERMINAL'], 'number', 'min' => 0],
            [['COMPANY'], 'trim'],
            [['COMPANY'], 'filter', 'filter'=>'strtoupper'],
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
        $count = PlnETarifSppd::find()
        ->select('ID')
        ->andWhere(['COMPANY'=>$this->COMPANY])
        ->andWhere(['!=','ID',$this->ID])
        ->count();

        if ($count > 0):
            $this->addError($attribute, ' Data sudah ada');
        endif;
        
    }
}
