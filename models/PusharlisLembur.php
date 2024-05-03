<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lembur".
 *
 * @property string $ID
 * @property string $WBS
 * @property string $NO_INDUK
 * @property string $NAMA
 * @property string $USER
 * @property string $PENEMPATAN
 * @property string $ID_DATA_SPK
 * @property string $NO_SPK
 * @property string $JABATAN
 * @property string $JENIS_LEMBUR
 * @property string $PEKERJAAN_LEMBUR
 * @property string $ALAMAT
 * @property double $LATITUDE
 * @property double $LONGITUDE
 * @property string $URAIAN_TUGAS_LEMBUR
 * @property double $JAM_AWAL_LEMBUR
 * @property double $JAM_AKHIR_LEMBUR
 * @property double $UPAH_PENGKALI
 * @property double $JUMLAH_JAM
 * @property string $TOTAL_UPAH_LEMBUR
 * @property string $EVIDENCE_LEMBUR
 * @property string $EVIDENCE_REALISASI
 * @property string $STATUS_PENGAJUAN
 * @property string $ALASAN
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class PusharlisLembur extends \yii\db\ActiveRecord
{
    public $EVIDENCE_SPKL;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pusharlis_lembur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','NO_INDUK','NAMA','ID_DATA_SPK','NO_SPK','PENEMPATAN','JABATAN','JENIS_LEMBUR','PEKERJAAN_LEMBUR','LATITUDE','LONGITUDE','URAIAN_TUGAS_LEMBUR','JAM_AWAL_LEMBUR','JAM_AKHIR_LEMBUR','UPAH_PENGKALI','JUMLAH_JAM','TOTAL_UPAH_LEMBUR','STATUS_PENGAJUAN','USER','CREATED_AT','UPDATED_AT'], 'required'],
            [['ID'], 'unique'],
            [['NO_INDUK'], 'exist', 'skipOnError' => false, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['NO_INDUK' => 'NO_INDUK']],
            [['EVIDENCE_LEMBUR'], 'required', 'on' => 'create'],
            [['WBS'], 'required', 'on' => 'setujui'],
            [['ID', 'ALASAN'], 'required', 'on' => 'rejected'],
            [['EVIDENCE_REALISASI'],'required','on'=>'upload'],
            [['ID','NO_INDUK','NAMA','ID_DATA_SPK','NO_SPK','PENEMPATAN','JABATAN','JENIS_LEMBUR','PEKERJAAN_LEMBUR','ALAMAT','USER', 'ALASAN'],'string'],
            [['STATUS_PENGAJUAN'],'string', 'max' => 1],
            [['JUMLAH_JAM'],'number','min'=>1,'max'=>4],
            [['LATITUDE','LONGITUDE'],'number',],
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
            'CREATED_AT' => 'Tanggal dibuat',
            'UPDATED_AT' => 'Terakhir diubah',
            'ALASAN' => 'Alasan ditolak',
            'WBS' => 'No WBS',
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
    public function getStatus()
    {
        return $this->hasOne(DVal::className(), ['key' => 'STATUS_PENGAJUAN'])->andWhere(['TABLE'=>'pusharlis_lembur']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColors()
    {
        $arr = ['1'=>'#FFC107','2'=>'#0dcaf0','3'=>'#1B5DAA','4'=>'#198754','5'=>'#dc3545'];
        return isset($arr[$this->STATUS_PENGAJUAN]) ? $arr[$this->STATUS_PENGAJUAN] : '#dc3545';
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId()
    {
        $month = date('m');
        $year = date('Y');
        $number = '0001';

        $model = $this::find()->select('ID')
        ->where(['right(ID,17)'=>$month.'/PUSHARLIS/'.$year])
        ->orderBy(['ID'=>SORT_DESC])->one();
        
        if(!empty($model)):
            $no = substr($model->ID,0,4);
            $no++;
            $length = 4 - strlen($no);
            $number = substr($number,0,$length).$no;
        endif;
        
        return $number.'/LEMBUR/'.$month.'/PUSHARLIS/'.$year;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function validateLembur($attribute, $params)
    {
        //query sppd
        $query = PusharlisLembur::find()->select('ID');

        //duplikat tgl
        $countDupLem = $query
        ->andWhere(['!=','ID',$this->ID])
        ->andWhere(['NO_INDUK'=>$this->NO_INDUK])
        ->andWhere(['!=','STATUS_PENGAJUAN','5'])
        ->andWhere(['OR',
            ['AND',['<=','JAM_AWAL_LEMBUR',$this->JAM_AWAL_LEMBUR],['>=','JAM_AKHIR_LEMBUR',$this->JAM_AWAL_LEMBUR]],
            ['AND',['<=','JAM_AWAL_LEMBUR',$this->JAM_AKHIR_LEMBUR],['>=','JAM_AKHIR_LEMBUR',$this->JAM_AKHIR_LEMBUR]],
            ['AND',['>=','JAM_AWAL_LEMBUR',$this->JAM_AWAL_LEMBUR],['<=','JAM_AKHIR_LEMBUR',$this->JAM_AKHIR_LEMBUR]]])
        ->COUNT();

        if ($countDupLem > 0):
            $this->addError($attribute, ' Terjadi duplikasi jam lembur');
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