<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lembur".
 *
 * @property string $ID
 * @property string $NO_INDUK
 * @property string $NAMA
 * @property string $ID_DATA_SPK
 * @property string $NO_SPK
 * @property string $ID_UNIT
 * @property string $UNIT_PLN
 * @property string $PENEMPATAN
 * @property string $JABATAN
 * @property double $WAKTU_KERJA
 * @property string $JENIS_LEMBUR
 * @property string $PEKERJAAN_LEMBUR
 * @property string $ALAMAT
 * @property double $LATITUDE
 * @property double $LONGITUDE
 * @property string $URAIAN_TUGAS_LEMBUR
 * @property string $EVIDENCE_LEMBUR
 * @property string $EVIDENCE_SPKL
 * @property string $EVIDENCE_REALISASI
 * @property double $JAM_AWAL_LEMBUR
 * @property double $JAM_AKHIR_LEMBUR
 * @property double $UPAH_PENGKALI
 * @property double $JUMLAH_JAM
 * @property string $TOTAL_UPAH_LEMBUR
 * @property string $STATUS_PENGAJUAN
 * @property string $TANGGAL_APPROVAL
 * @property string $USER
 * @property string $USER_APP
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class Lembur extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lembur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','NO_INDUK','NAMA','ID_DATA_SPK','NO_SPK','ID_UNIT','UNIT_PLN','PENEMPATAN','JABATAN','JENIS_LEMBUR','PEKERJAAN_LEMBUR','LATITUDE','LONGITUDE','URAIAN_TUGAS_LEMBUR','JAM_AWAL_LEMBUR','JAM_AKHIR_LEMBUR','UPAH_PENGKALI','JUMLAH_JAM','TOTAL_UPAH_LEMBUR','STATUS_PENGAJUAN','USER','USER_APP','CREATED_AT','UPDATED_AT'], 'required'],
            [['ID'], 'unique'],
            [['NO_INDUK'], 'exist', 'skipOnError' => false, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['NO_INDUK' => 'NO_INDUK']],
            [['EVIDENCE_REALISASI'],'required','on'=>'upload'],
            [['ID','NO_INDUK','NAMA','ID_DATA_SPK','NO_SPK','UNIT_PLN','PENEMPATAN','JABATAN','JENIS_LEMBUR','PEKERJAAN_LEMBUR','ALAMAT','STATUS_PENGAJUAN','USER','USER_APP'],'string'],
            [['ID_UNIT'],'string','max'=>6],
            [['JUMLAH_JAM'],'number','min'=>1,'max'=>4],
            [['LATITUDE','LONGITUDE'],'number',],
            [['TANGGAL_APPROVAL','TGL_REJECTED'],'safe'],
            [['EVIDENCE_REALISASI'], 'required','on'=>'realisasi'],
            ['ID', 'validateLembur'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'No. Lembur',
            'CREATED_AT' => 'Date Created',
            'TANGGAL_APPROVAL' => 'Date Approved',
            'TGL_REJECTED' => 'Date Rejected',
        //     'NO_SPKL' => 'No SPKL',
        //     'NO_INDUK' => 'No Induk',
        //     'NAMA' => 'Nama',
        //     'ID_DATA_SPK' => 'Id Data Spk',
        //     'NO_SPK' => 'No SPK',
        //     'ID_REGION' => 'Id Region',
        //     'ID_UNIT' => 'Id Unit',
        //     'JABATAN' =>  'Jabatan',
        //     'JABATAN_RAB' => 'Jabatan Rab',
        //     'UNIT_PLN' => 'Unit PLN',
        //     'PENEMPATAN' => 'Penempatan',
        //     'JAM_AWAL_LEMBUR' => 'Jam Awal Lembur',
        //     'JAM_AKHIR_LEMBUR' => 'Jam Akhir Lembur',
        //     'lembur' => 'Upah Pengkali',
        //     'JUMLAH_JAM' => 'Jumlah Jam',
        //     'TOTAL_UPAH_LEMBUR' => 'Total Upah Lembur',
        //     'STATUS_PENGAJUAN' => 'Status Approval',
        //     'UPDATED_AT' => 'Update At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpkku()
    {
        return $this->hasOne(Spk::className(), ['ID_DATA_SPK' => 'ID_DATA_SPK']);
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
    public function getAtasan()
    {
        $find = Admin::find()
        ->select('ID')
        ->andWhere(['OR',['JENIS'=>"7"],['JENIS'=>"8"]])
        ->andWhere('DATA_BAWAHAN LIKE "%'.$this->NO_INDUK.'%"')
        ->one();
        return isset($find->ID) ? $find->ID : null;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId()
    {
        $month = date('m');
        $year = date('Y');
        $number = '0001';
        $id = '/'.$month.'/HPI-LEMBUR/'.$year;

        $model = $this::find()->select('ID')
        ->where(['right(ID,19)'=>$id])
        ->orderBy(['ID'=>SORT_DESC])->one();
        
        if(!empty($model)):
            $noLembur = substr($model->ID,0,4);
            $noLembur++;
            $length = 4 - strlen($noLembur);
            $number = substr($number,0,$length).$noLembur;
        endif;
        
        return $number.$id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function validateLembur($attribute, $params)
    {
        //query sppd
        $query = Lembur::find()->select('ID');

        //duplikat tgl
        $countDupLem = $query
        ->andWhere(['!=','ID',$this->ID])
        ->andWhere(['NO_INDUK'=>$this->NO_INDUK])
        ->andWhere(['LEFT(JAM_AWAL_LEMBUR,10)'=>substr($this->JAM_AWAL_LEMBUR,0,10)])
        ->COUNT();

        if ($countDupLem > 0):
            $this->addError($attribute, ' Terjadi duplikasi tanggal lembur');
        endif;
        
    }
    
    public function getJumker()
    {
        $jamAwal = new \DateTime($this->JAM_AWAL_LEMBUR);
        $jamAkhir = new \DateTime($this->JAM_AKHIR_LEMBUR);

        $interval = $jamAwal->diff($jamAkhir);
        $jam = $interval->h;
        $menit = $interval->i;
        $menit = $menit < 30 ? 0 : ($menit < 45 ? 0.5 : 1);
        return $jam + $menit;
    }
    function getLemKer()
    {
        $total = ((1.5)/173)*$this->UPAH_PENGKALI;

        $jamSisa = $this->JUMLAH_JAM-1;

        if($jamSisa >= 0):
            $total = $total + (($jamSisa * 2)/173)*$this->UPAH_PENGKALI;
        endif;

        return $total;
    }
    function getLemLibNam()
    {
        $total = 0;

        $jamSisa = $this->JUMLAH_JAM-7;

        if($jamSisa >= 0):
            $total = ((7 * 2)/173)*$this->UPAH_PENGKALI;
        else:
            $total = (($this->JUMLAH_JAM * 2)/173)*$this->UPAH_PENGKALI;
        endif;

        if($jamSisa >= 1):
            $total = $total + (((1 * 3)/173)*$this->UPAH_PENGKALI);
        endif;

        $jamSisaEnd = $this->JUMLAH_JAM-8;

        if($jamSisaEnd >= 1):
            $total = $total + ((($jamSisaEnd * 4)/173)*$this->UPAH_PENGKALI);
        endif;

        return $total;
    }
    function getLemLibNasNam()
    {
        $total = 0;

        $jamSisa = $this->JUMLAH_JAM-5;

        if($jamSisa >= 0):
            $total = ((5 * 2)/173)*$this->UPAH_PENGKALI;
        else:
            $total = (($this->JUMLAH_JAM * 2)/173)*$this->UPAH_PENGKALI;
        endif;

        if($jamSisa >= 1):
            $total = $total + (((1 * 3)/173)*$this->UPAH_PENGKALI);
        endif;

        $jamSisaEnd = $this->JUMLAH_JAM-6;

        if($jamSisaEnd >= 1):
            $total = $total + ((($jamSisaEnd * 4)/173)*$this->UPAH_PENGKALI);
        endif;

        return $total;
    }
}