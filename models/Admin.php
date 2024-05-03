<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_pengguna".
 *
 * @property string $ID
 * @property string $USERNAME
 * @property string $PASSWORD
 * @property string $NAMA
 * @property string $DATA_BAWAHAN
 * @property string $JENIS
 * @property string $COMPANY
 * @property string $UNIT
 */
class Admin extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $MSB;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USERNAME'], 'unique'],
            [['USERNAME', 'NAMA', 'PASSWORD', 'JENIS', 'COMPANY','UNIT'], 'required'],
            [['PASSWORD'], 'string','min'=>6],
            [['USERNAME', 'NAMA','PASSWORD','JENIS', 'COMPANY','UNIT','MSB'], 'string', 'max' => 255],
            [['USERNAME', 'NAMA','PASSWORD','JENIS', 'COMPANY'], 'trim'],
            [['NAMA', 'COMPANY'], 'filter', 'filter'=>'strtoupper'],
            [['DATA_BAWAHAN'], 'validateUnique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'USERNAME' => 'Username',
            'PASSWORD' => 'Password',
            'NAMA' => 'Nama',
            'DATA_BAWAHAN' => 'Data Bawahan',
            'JENIS' => 'Jenis  User',
            'COMPANY'=>'Company',
            'UNIT'=>'Unit PLN/Bidang'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJen()
    {
        return $this->hasOne(JenisUser::className(), ['ID' => 'JENIS']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBidang()
    {
        if($this->JENIS == '13'):
            $data = PlnEMsb::find()->select('NAMA')->andWhere(['ID'=>$this->unit])->one();
            return isset($data->NAMA) ? $data->NAMA : null;
        else: 
            return $this->UNIT;
        endif;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCom()
    {
        return ['1'=>'HPI','2'=>'JATENG','3'=>'JATENG','4'=>'PUSHARLIS','5'=>'ASTRO','6'=>'JATENG','7'=>'HP','8'=>'HP','9'=>'creator','10'=>'PUSHARLIS','11'=>'PUSHARLIS','12'=>'PLN E','13'=>'PLN E','14'=>'PLN E'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueCompany()
    {
        return isset($this->com[$this->JENIS]) ? $this->com[$this->JENIS] : null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return ['1'=>'SEMUA UNIT','2'=>'SEMUA UNIT','3'=>$this->UNIT,'4'=>'PUSHARLIS','5'=>'PT ASTRO TECHNOLOGIES INDONESIA','6'=>'SEMUA UNIT','7'=>'PT HALEYORA POWER','8'=>'PT HALEYORA POWER','9'=>'creator','10'=>$this->UNIT,'11'=>$this->UNIT,'12'=>'PLN E','13'=>$this->MSB,'14'=>'PLN E'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueUnit()
    {
        return isset($this->unit[$this->JENIS]) ? $this->unit[$this->JENIS] : null;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiteIndex()
    {
        return ['1'=>'index','2'=>'index-jateng','3'=>'index-jateng','4'=>'index-pusharlis','5'=>'index-astro','6'=>'index-jateng','7'=>'index-hp','8'=>'index-hp','9'=>'index-creator','10'=>'index-pusharlis','11'=>'index-pusharlis','12'=>'index-pln-e','13'=>'index-pln-e','14'=>'index-pln-e'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueIndex()
    {
        return isset($this->siteIndex[$this->JENIS]) ? $this->siteIndex[$this->JENIS] : null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValueBawahan()
    {
        if( ($this->JENIS == "7" OR $this->JENIS == "8") AND !empty($this->DATA_BAWAHAN)): 
            return implode(";", $this->DATA_BAWAHAN);
        else:
            return "SEMUA TENAGA KERJA";
        endif;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function validateUnique($attribute, $params)
    {
        if($this->JENIS == "7" OR $this->JENIS == "8"): 
            $bawahans = explode(";", $this->DATA_BAWAHAN);
            $queryWhere = null;
            foreach ($bawahans as $key => $value):
                $queryWhere = $queryWhere.'DATA_BAWAHAN LIKE "%'.$value.'%" OR ';
            endforeach;
            $queryWhere = substr($queryWhere, 0, (strlen($queryWhere)-3) );
            
            $count = Admin::find()
            ->select('ID')
            ->andWhere(['OR',['JENIS'=>"7"],['JENIS'=>"8"]])
            ->andWhere($queryWhere)
            ->andWhere(['!=','ID',$this->ID])
            ->count();

            if ($count > 0):
                $this->addError($attribute, ' Duplikat data bawahan, satu pegawai tidak boleh memiliki lebih dari satu admin');
            endif;
        endif;
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQueryBawahan()
    {
        if($this->JENIS == "7"): 
            $bawahans = explode(";", $this->DATA_BAWAHAN);
            $queryWhere = null;
            foreach ($bawahans as $key => $value):
                $queryWhere = $queryWhere.'pegawai.NO_INDUK LIKE "%'.$value.'%" OR ';
            endforeach;
            $queryWhere = substr($queryWhere, 0, (strlen($queryWhere)-3) );
            
            return $queryWhere;
        endif;
        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDataPegawai($nik)
    {
        return Pegawai::findOne($nik);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['ID' => $id]);
    }


    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne($token);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()
        ->andWhere(['USERNAME' => $username])
        ->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return true;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword()
    {
        return Yii::$app->security->generatePasswordHash($this->PASSWORD);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    private function cryptPassword($password)
    {
        return crypt($password,$this->PASSWORD);
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->PASSWORD === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if($this->cryptPassword($password) == $this->PASSWORD):
            return true;
        else:
            return false;
        endif;
    }
}