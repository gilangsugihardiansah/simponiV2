<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sppd".
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
 * @property string $PEKERJAAN
 * @property string $TGL_BERANGKAT
 * @property string $TGL_KEMBALI
 * @property string $JUMLAH_HARI
 * @property string $KOTA_ASAL
 * @property string $KOTA_TUJUAN
 * @property string $INSTANSI_TUJUAN
 * @property string $URAIAN_TUGAS
 * @property string $NAMA_ATASAN_PLN
 * @property string $NO_WA_ATASAN_PLN
 * @property string $EVIDENCE
 * @property string $TARIF_SPPD
 * @property string $STATUS_SPPD
 * @property double $TOTAL
 * @property string $STATUS_PENGAJUAN
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 * @property string $RATING
 *
 */
class PusharlisSppd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pusharlis_sppd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'NO_INDUK', 'NAMA','USER', 'ID_DATA_SPK', 'NO_SPK', 'JABATAN', 'PEKERJAAN', 'TGL_BERANGKAT', 'TGL_KEMBALI', 'JUMLAH_HARI', 'KOTA_ASAL', 'KOTA_TUJUAN', 'INSTANSI_TUJUAN', 'URAIAN_TUGAS', 'TOTAL', 'STATUS_PENGAJUAN', 'CREATED_AT', 'UPDATED_AT','PENEMPATAN','NAMA_ATASAN_PLN','NO_WA_ATASAN_PLN','TARIF_SPPD','STATUS_SPPD'], 'required'],
            [['RATING'], 'required','on'=>'rating'],
            [['RATING'], 'number'],
            [['EVIDENCE'], 'required', 'on' => 'create'],
            [['WBS'], 'required', 'on' => 'setujui'],
            [['ID', 'ALASAN'], 'required', 'on' => 'rejected'],
            [['STATUS_PENGAJUAN'], 'string', 'max' => 25],
            [['TOTAL'], 'number', 'min' => 0],
            [['ID', 'NO_INDUK', 'NAMA','USER', 'ID_DATA_SPK', 'NO_SPK', 'JABATAN', 'PEKERJAAN', 'JUMLAH_HARI', 'KOTA_ASAL', 'KOTA_TUJUAN', 'INSTANSI_TUJUAN', 'URAIAN_TUGAS','TARIF_SPPD','WBS', 'ALASAN'], 'string', 'max' => 255],
            [['KOTA_ASAL','KOTA_TUJUAN','INSTANSI_TUJUAN','URAIAN_TUGAS'], 'trim'],
            [['NO_INDUK'], 'exist', 'skipOnError' => false, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['NO_INDUK' => 'NO_INDUK']],
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
            'NAMA_ATASAN_PLN' => 'Nama pegawai yang diantar',
            'NO_WA_ATASAN_PLN' => 'Nomor WA pegawai yang diantar',
            'WBS' => 'No WBS',
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
        ->where(['right(ID,21)'=>$month.'/PLN-PUSHARLIS/'.$year])
        ->orderBy(['ID'=>SORT_DESC])->one();
        
        if(!empty($model)):
            $no = substr($model->ID,0,4);
            $no++;
            $length = 4 - strlen($no);
            $number = substr($number,0,$length).$no;
        endif;
        
        return $number.'/SPPD/'.$month.'/PLN-PUSHARLIS/'.$year;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function validateSppd($attribute, $params)
    {
        //query sppd
        $query = PusharlisSppd::find()->select('ID');

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
        return $this->hasOne(TarifDetail::className(), ['NO_SPK' => 'NO_SPK']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(DVal::className(), ['key' => 'STATUS_PENGAJUAN'])->andWhere(['TABLE'=>'pusharlis_sppd']);
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
    public function getFormatTgl($tanggal)
    {
        $bulan =['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $pecahkan = explode('-', $tanggal);
     
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    public function getBiayaadmin(){
        $biaya=$this->TOTAL*0.06;
        return $biaya;
    }

    public function getTotaladmin(){
        $biaya=($this->TOTAL*0.06)+$this->TOTAL;
        return $biaya;
    }

    public function getPajak(){
        $biaya=(($this->TOTAL*0.06)+$this->TOTAL)*0.11;
        return $biaya;
    }

    public function getTotalpajak(){
        $biaya=((($this->TOTAL*0.06)+$this->TOTAL)*0.11)+(($this->TOTAL*0.06)+$this->TOTAL);
        return $biaya;
    }

    public function getHari($hari){
        $arr=['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
        return $arr[$hari];
    }
}
