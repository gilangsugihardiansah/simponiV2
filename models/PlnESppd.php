<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sppd".
 *
 * @property string $ID
 * @property string $NO_INDUK
 * @property string $NAMA
 * @property string $USER
 * @property string $PENEMPATAN
 * @property string $ID_DATA_SPK
 * @property string $NO_SPK
 * @property string $JABATAN
 * @property string $PEKERJAAN
 * @property string $TGL_BERANGKAT
 * @property string $TGL_KEMBALI
 * @property string $JUMLAH_HARI
 * @property string $JENIS_SPPD
 * @property int $IS_LUMPSUM
 * @property string $WILAYAH
 * @property string $ASAL
 * @property string $TUJUAN
 * @property string $JENIS_TRANPORTASI
 * @property string $INSTANSI_TUJUAN
 * @property string $URAIAN_TUGAS
 * @property string $EVIDENCE
 * @property double $KONSUMSI
 * @property double $LAUNDRY
 * @property double $TRANPORTASI
 * @property double $UANG_SAKU
 * @property double $LUMPSUM
 * @property double $TOTAL
 * @property double $KURS_DOLAR
 * @property double $NOMINAL
 * @property string $ID_CHARGE_CODE
 * @property string $CHARGE_CODE
 * @property string $VP
 * @property string $MSB
 * @property string $RATING
 * @property string $STATUS_PENGAJUAN
 * @property string $CREATED_AT
 * @property string $TGL_REKOMENDASI
 * @property string $TGL_APPROVAL
 * @property string $TGL_REJECTED
 * @property string $ALASAN
 * @property string $TGL_BAYAR
 * @property string $UPDATED_AT
 *
 */
class PlnESppd extends \yii\db\ActiveRecord
{
    public $WIL_LOKAL, $WIL_INTER, $TUJUAN_LOKAL, $TUJUAN_INTER;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pln_e_sppd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'NO_INDUK', 'NAMA','USER','PENEMPATAN', 'ID_DATA_SPK', 'NO_SPK', 'JABATAN', 'PEKERJAAN', 'TGL_BERANGKAT', 'TGL_KEMBALI', 'JUMLAH_HARI','JENIS_SPPD','IS_LUMPSUM', 'ASAL', 'TUJUAN', 'INSTANSI_TUJUAN', 'URAIAN_TUGAS','ID_CHARGE_CODE', 'CHARGE_CODE', 'VP', 'MSB', 'STATUS_PENGAJUAN', 'CREATED_AT', 'UPDATED_AT'], 'required'],
            [['RATING'], 'required','on'=>'rating'],
            [['RATING'], 'number'],
            [['EVIDENCE'], 'required', 'on' => 'create'],
            [['KURS_DOLAR'], 'required', 'on' => 'setujui-inter'],
            [['ID', 'ALASAN'], 'required', 'on' => 'rejected'],
            [['ID', 'NO_INDUK', 'NAMA','USER','PENEMPATAN', 'ID_DATA_SPK', 'NO_SPK', 'JABATAN', 'PEKERJAAN','JENIS_SPPD', 'WILAYAH', 'ASAL', 'TUJUAN', 'INSTANSI_TUJUAN','JENIS_TRANPORTASI', 'URAIAN_TUGAS','ID_CHARGE_CODE', 'CHARGE_CODE', 'VP', 'MSB','ALASAN','WIL_LOKAL','WIL_INTER','TUJUAN_LOKAL','TUJUAN_INTER'], 'string', 'max' => 255],
            [['TGL_BERANGKAT','TGL_KEMBALI'], 'date', 'format' => 'php:Y-m-d'],
            [[ 'KONSUMSI', 'LAUNDRY', 'TRANPORTASI', 'UANG_SAKU','LUMPSUM','TOTAL','NOMINAL'], 'number', 'min' => 0],
            [[ 'JUMLAH_HARI','KURS_DOLAR'], 'number', 'min' => 1],
            // ['IS_LUMPSUM', 'boolean'],
            [['CREATED_AT','TGL_REKOMENDASI','TGL_APPROVAL','TGL_REJECTED','TGL_BAYAR','UPDATED_AT'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['STATUS_PENGAJUAN'], 'string', 'max' => 25],
            [['ASAL','TUJUAN','INSTANSI_TUJUAN','URAIAN_TUGAS'], 'trim'],
            [['ASAL','TUJUAN','INSTANSI_TUJUAN'], 'filter', 'filter'=>'strtoupper'],
            ['WILAYAH', 'required', 'when' => function ($model) {
                return ($model->IS_LUMPSUM === 1 || $model->JENIS_SPPD == "INTERNASIONAL" );
            }],
            ['JENIS_TRANPORTASI', 'required', 'when' => function ($model) {
                return ($model->JENIS_SPPD == "BIASA" || $model->JENIS_SPPD == "KONSINYERING" );
            }],
            [['NO_INDUK'], 'exist', 'skipOnError' => false, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['NO_INDUK' => 'NO_INDUK']],
            [['ID_CHARGE_CODE'], 'exist', 'skipOnError' => false, 'targetClass' => PlnEChargeCode::className(), 'targetAttribute' => ['ID_CHARGE_CODE' => 'ID']],
            ['ID', 'validateSppd'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'No SPPD',
            'CREATED_AT' => 'Tanggal dibuat',
            'UPDATED_AT' => 'Terakhir diubah',
            'ALASAN' => 'Alasan ditolak',
            'RATING' => 'Rating Pelayanan',
            'TGL_APPROVAL' => 'Tanggal Konfirmasi',
            'WILAYAH' => 'Region Tujuan',
            'WIL_LOKAL' => 'Region Tujuan',
            'WIL_INTER' => 'Region Tujuan',
            'TUJUAN_LOKAL' => 'Kota Tujuan',
            'TUJUAN_INTER' => 'Negara Tujuan',
            'ASAL' => 'Negara/Kota Asal',
            'TUJUAN' => 'Negara/Kota Tujuan',
            'IS_LUMPSUM' => 'Lumpsum',
            'LUMPSUM' => 'Nominal Lumpsum',
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
    public function getId()
    {
        $month = date('m');
        $year = date('Y');
        $number = '0001';

        $model = $this::find()->select('ID')
        ->where(['right(ID,7)'=>$month.'/'.$year])
        ->orderBy(['ID'=>SORT_DESC])->one();
        
        if(!empty($model)):
            $no = substr($model->ID,0,4);
            $no++;
            $length = 4 - strlen($no);
            $number = substr($number,0,$length).$no;
        endif;
        
        return $number.'/SPPD/PLN-E/'.$month.'/'.$year;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function validateSppd($attribute, $params)
    {
        //query sppd
        $query = PlnESppd::find()->select('ID');

        //duplikat tgl
        $countDupSpd = $query->where(['OR',
            ['AND',['<=','TGL_BERANGKAT',$this->TGL_BERANGKAT],['>=','TGL_KEMBALI',$this->TGL_BERANGKAT]],
            ['AND',['<=','TGL_BERANGKAT',$this->TGL_KEMBALI],['>=','TGL_KEMBALI',$this->TGL_KEMBALI]],
            ['AND',['>=','TGL_BERANGKAT',$this->TGL_BERANGKAT],['<=','TGL_KEMBALI',$this->TGL_KEMBALI]]])
        ->andWhere(['AND',
            ['!=','STATUS_PENGAJUAN','4'],
            ['!=','ID',$this->ID],
            ['NO_INDUK'=>$this->NO_INDUK]])
        ->COUNT();

        if ($countDupSpd > 0):
            $this->addError($attribute, ' Terjadi duplikasi tanggal keberangkatan/ tanggal kembali');
        endif;

        $dt1 = new \DateTime($this->TGL_BERANGKAT);
        $dt2 = new \DateTime($this->TGL_KEMBALI);
        $interval = $dt1->diff($dt2);
        $this->JUMLAH_HARI =$interval->d + 1;
        
        if($this->JENIS_SPPD == "BIASA" || $this->JENIS_SPPD == "KONSINYERING"): 

            $data = PlnETarifSppd::find()->andWhere(['COMPANY'=>'PLN E'])->One();
            $malam = $this->JUMLAH_HARI-1;

            $this->KONSUMSI = 0 ;
            if($this->JENIS_SPPD == "BIASA"): 
                $this->KONSUMSI = isset($data->KONSUMSI) ? ($data->KONSUMSI * $this->JUMLAH_HARI) :  0 ;
            endif;

            $this->LAUNDRY = isset($data->LAUNDRY) ? ($data->LAUNDRY * $malam) :  0 ;

            $bp = isset($data->TRANPORTASI_BANDARA_PELABUHAN) ? $data->TRANPORTASI_BANDARA_PELABUHAN :  0 ;
            $tm = isset($data->TRANSPORTASI_TERMINAL) ? $data->TRANSPORTASI_TERMINAL :  0 ;
            
            $this->TRANPORTASI = 0;
            if($this->JENIS_TRANPORTASI == "BANDARA/PELABUHAN"): 
                $this->TRANPORTASI = $bp;
            elseif($this->JENIS_TRANPORTASI == "TERMINAL"): 
                $this->TRANPORTASI = $tm;
            endif;
            
            $this->TOTAL = $this->KONSUMSI + $this->LAUNDRY + $this->TRANPORTASI;

            $this->LUMPSUM = 0;
            if($this->IS_LUMPSUM):
                $dataLumpsum = PlnELumpsum::find()->andWhere(['WILAYAH'=>$this->WILAYAH])->One();
                $this->LUMPSUM = isset($dataLumpsum->LUMPSUM) ? ($dataLumpsum->LUMPSUM * $malam) :  0;
            else:
                $this->WILAYAH = null;
            endif;
            
            $this->NOMINAL = $this->TOTAL+ $this->LUMPSUM;
        elseif($this->JENIS_SPPD == "INTERNASIONAL"):
            $this->LUMPSUM = 0;
            $this->JENIS_TRANPORTASI = null;
            $this->KURS_DOLAR = $this->KURS_DOLAR == null ? 1 : $this->KURS_DOLAR;
            $data = PlnETarifSppdInter::find()->andWhere(['REGION'=>$this->WILAYAH])->One();
            $this->KONSUMSI = isset($data->KONSUMSI) ? ($data->KONSUMSI * $this->JUMLAH_HARI) :  0 ;
            $this->UANG_SAKU = isset($data->UANG_SAKU) ? ($data->UANG_SAKU * $this->JUMLAH_HARI) :  0 ;
            $this->TOTAL = $this->KONSUMSI + $this->UANG_SAKU;
            $this->NOMINAL = $this->TOTAL * $this->KURS_DOLAR;
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
    public function getBid()
    {
        return $this->hasOne(PlnEMsb::className(), ['ID' => 'MSB']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUs()
    {
        return $this->hasOne(Admin::className(), ['UNIT' => 'MSB']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCc()
    {
        return $this->hasOne(PlnEChargeCode::className(), ['ID' => 'ID_CHARGE_CODE']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(DVal::className(), ['KEY' => 'STATUS_PENGAJUAN'])->andWhere(['TABLE'=>'pln_e_sppd']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenis()
    {
        return $this->hasOne(DVal::className(), ['KEY' => 'JENIS_SPPD'])->andWhere(['TABLE'=>'pln_e_sppd']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoWa()
    {
        return DVal::find()->andWhere(['KEY' => 'WhatsApp'])->andWhere(['TABLE'=>'pln_e_sppd'])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWil()
    {
        if($this->JENIS_SPPD == "INTERNASIONAL"):
            $data = PlnERegion::find()->select('REGION')->andWhere(['ID'=>$this->WILAYAH])->one();
            return isset($data->REGION) ? $data->REGION : null;
        else: 
            return $this->WILAYAH;
        endif;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColors()
    {
        $arr = ['1'=>'#0dcaf0','2'=>'#1B5DAA','3'=>'#198754','4'=>'#dc3545'];
        return $arr[$this->STATUS_PENGAJUAN];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIsLump()
    {
        $arr = ['0'=>'Tidak','1'=>'Ya'];
        return $arr[$this->IS_LUMPSUM];
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

    public function getHari($hari){
        $arr=['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
        return $arr[$hari];
    }
}
