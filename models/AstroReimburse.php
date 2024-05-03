<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sppd".
 *
 * @property string $ID
 * @property string $NO_INDUK
 * @property string $NO_KTP
 * @property string $NAMA
 * @property string $NO_SPK
 * @property string $JABATAN
 * @property string $PEKERJAAN
 * @property string $PENEMPATAN
 * @property string $KETERANGAN
 * @property string $TGL_SERVICE
 * @property string $NO_POL
 * @property string $EVIDENCE
 * @property double $NOMINAL
 * @property string $USER
 * @property string $STATUS_PENGAJUAN
 * @property string $CREATED_AT
 * @property string $TGL_APPROVED
 * @property string $TGL_REJECTED
 * @property string $UPDATED_AT
 *
 */
class AstroReimburse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'astro_reimburse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'NO_INDUK', 'NAMA', 'NO_KTP', 'NO_SPK', 'JABATAN', 'PEKERJAAN', 'PENEMPATAN', 'KETERANGAN', 'TGL_SERVICE', 'NO_POL', 'NOMINAL','USER','STATUS_PENGAJUAN','CREATED_AT','UPDATED_AT'], 'required'],
            [['EVIDENCE'], 'required', 'on' => 'create'],
            [['STATUS_PENGAJUAN'], 'string', 'max' => 25],
            [['ID'], 'string', 'max' => 100],
            [['NOMINAL'], 'number', 'min' => 0],
            [[ 'TGL_SERVICE','TGL_APPROVED','TGL_REJECTED', 'CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['KETERANGAN'], 'string'],
            [['ID', 'NO_INDUK', 'NAMA', 'NO_SPK', 'JABATAN', 'PEKERJAAN', 'PENEMPATAN'], 'string', 'max' => 255],
            [['TGL_SERVICE'], 'trim'],
            [['NO_INDUK'], 'exist', 'skipOnError' => false, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['NO_INDUK' => 'NO_INDUK']],
            ['ID', 'validateReim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CREATED_AT' => 'Tanggal Pengajuan',
            'UPDATE_AT' => 'Terakhir diubah',
            'TGL_APPROVED' => 'Tanggal DIsetujui',
            'TGL_REJECTED' => 'Tanggal Ditolak',
            // 'NAMA' => 'Nama',
            // 'NAMA_KEL' => 'Nama Keluarga',
            // 'SUTRIA' => 'Hubungan Keluarga',
            // 'KELAMIN' => 'Jenis Kelamin',
            // 'LAHIR' => 'Tempat Lahir',
            // 'TGL' => 'Tanggal Lahir',
            // 'PENDD_AKHIR' => 'Pendidikan Akhir',
            // 'PEKERJAAN' => 'Pekerjaan',
            // 'STATUS_BPJS' => 'Status Bpjs',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function validateReim($attribute, $params)
    {
        //query sppd
        $query = AstroReimburse::find()->select('ID');

        $lastMonth = date('Y-m-d', strtotime( '-3 month' , strtotime ( $this->TGL_SERVICE )) );

        //duplikat tgl
        $count = $query->andWhere(['>=','TGL_SERVICE',$lastMonth])->andWhere(['<=','TGL_SERVICE',$this->TGL_SERVICE])
        ->andWhere(['AND',
            ['!=','STATUS_PENGAJUAN','2'],
            ['!=','ID',$this->ID],
            ['NO_INDUK'=>$this->NO_INDUK]])
        ->COUNT();

        if ($count > 0):
            $this->addError($attribute, ' Pengajuan tidak dapat dilakukan, pengajuan service minimal setiap 3 bulan sekali ');
        endif;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeg()
    {
        return $this->hasOne(Pegawai::className(), ['NO_INDUK' => 'NO_INDUK']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarif()
    {
        return $this->hasOne(TarifSppd::className(), ['ID' => 'TARIF_SPPD']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatVal()
    {
        $findStatus = DVal::find()->andWhere(['KEY'=>'STATUS_APP_ASTRO'])->one();
        $arr = explode(";",$findStatus->VALUE);

        return isset($arr[$this->STATUS_PENGAJUAN]) ? $arr[$this->STATUS_PENGAJUAN] : $arr[2];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormatTgl($tanggal)
    {
        $bulan =['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $pecahkan = explode('-', $tanggal);
     
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
}
