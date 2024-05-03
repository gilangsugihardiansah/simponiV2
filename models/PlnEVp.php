<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_sp".
 *
 * @property string $ID
 * @property string $NAMA
 * @property string $VP
 */
class PlnEVp extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pln_e_vp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','NAMA','VP'], 'required'],
            [['ID','NAMA','VP'], 'string', 'max' => 255],
            [['VP', 'NAMA'], 'trim'],
            [['NAMA', 'VP'], 'filter', 'filter'=>'strtoupper'],
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
            'NAMA' => 'Nama Divisi',
            'VP' => 'Nama Pejabat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function validateUnique($attribute, $params)
    {
        $count = PlnEVp::find()
        ->select('ID')
        ->andWhere(['NAMA'=>$this->NAMA])
        ->andWhere(['VP'=>$this->VP])
        ->andWhere(['!=','ID',$this->ID])
        ->count();

        if ($count > 0):
            $this->addError($attribute, ' Data sudah ada');
        endif;
        
    }
}
