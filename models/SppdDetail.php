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
 * @property string $KOTA_ASAL
 * @property string $KOTA_TUJUAN
 * @property string $INSTANSI_TUJUAN
 * @property string $URAIAN_TUGAS
 * @property string $NAMA_ATASAN_PLN
 * @property string $NO_WA_ATASAN_PLN
 * @property string $EVIDENCE
 * @property string $TARIF_SPPD
 * @property double $TOTAL
 * @property string $STATUS_PENGAJUAN
 * @property string $TGL_PENGAJUAN
 * @property string $TGL_APPROVAL
 * @property string $UPDATE_AT
 * @property string $RATING
 *
 */
class SppdDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sppd_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID',], 'required'],
            [['TOTAL','UANG_SAKU','PENGINAPAN'], 'number', 'min' => 0],
            [[ 'TGL',], 'safe'],
            [['ID', 'NO_INDUK', 'NAMA', 'JABATAN', 'PENEMPATAN', 'TUJUAN_SPPD', 'KETERANGAN_SPPD', 'HARI_UANG_SAKU', 'HARI_PENGINAPAN', 'HARI_TOTAL'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'iD',
            'UPDATE_AT' => 'Terakhir diubah',
            'RATING' => 'Rating Pelayanan',
            'TGL_APPROVAL' => 'Tanggal Konfirmasi',
            'NAMA_ATASAN_PLN' => 'Nama pegawai yang diantar',
            'NO_WA_ATASAN_PLN' => 'Nomor WA pegawai yang diantar',
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
        ->where(['right(ID,17)'=>$month.'/PLN-PUSAT/'.$year])
        ->orderBy(['ID'=>SORT_DESC])->one();
        
        if(!empty($model)):
            $noSppd = substr($model->ID,0,4);
            $noSppd++;
            $length = 4 - strlen($noSppd);
            $number = substr($number,0,$length).$noSppd;
        endif;
        
        return $number.'/SPPD/'.$month.'/PLN-PUSAT/'.$year;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function validateSppd($attribute, $params)
    {
        //query sppd
        $query = Sppd::find()->select('ID');

        //duplikat tgl
        $countDupSpd = $query->where(['OR',
            ['AND',['<=','TGL_BERANGKAT',$this->TGL_BERANGKAT],['>=','TGL_KEMBALI',$this->TGL_BERANGKAT]],
            ['AND',['<=','TGL_BERANGKAT',$this->TGL_KEMBALI],['>=','TGL_KEMBALI',$this->TGL_KEMBALI]],
            ['AND',['>=','TGL_BERANGKAT',$this->TGL_BERANGKAT],['<=','TGL_KEMBALI',$this->TGL_KEMBALI]]])
        ->andWhere(['AND',
            ['!=','STATUS_PENGAJUAN','Ditolak'],
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
    public function getStat()
    {
        return ['Pengajuan'=>'Pengajuan','Rekomendasi'=>'Rekomendasi','Disetujui'=>'Disetujui','Ditolak'=>'Ditolak'];
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
