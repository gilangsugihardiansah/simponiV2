<?php

namespace app\models;

use Yii;

class Pegawai extends \yii\db\ActiveRecord
{  
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pegawai';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbsimponi');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO_INDUK','ID_DATA_SPK','STATUS_PEGAWAI','KD_AKTIF','ID_REGION','ID_UNIT','PENEMPATAN','STATUS_KERJA','NAMA','NAMA_P','NAMA_BANK','ATAS_NAMA','FTGL_LAHIR','REKENING', 'TGL_MASUK','PASSWORD', 'KAWIN','KELAMIN','HP'], 'required'],
            [['TGL_KAWIN', 'FTGL_LAHIR', 'TGL_MASUK', 'TGL_KELUAR', 'TGL_AWAL_KONTRAK', 'TGL_AKHIR_KONTRAK','TGL_APPROVAL','USIA','PENDAKHIR','JUR','SER','PENDAPATAN','TGL_TEST','TGLMASUKAWAL','TGLMASUKAKHIR','TGLKELUARAWAL','TGLKELUARAKHIR','JUMLAH_ANAK','TGL_MASUK_HPI','TGL_MASUK_LAMA','TGL_ABSEN','WAKTU_MASUK','WAKTU_KELUAR'], 'safe'],
            [['KD_AKTIF', 'JABATAN', 'PEKERJAAN','SPESIFIKASI_PEKERJAAN','SUB_PEKERJAAN', 'NAMA', 'NAMA_P', 'NO_KTP', 'KELAMIN', 'KAWIN', 'TP_LAHIR', 'ALAMAT', 'ALAMAT_DSKRG', 'TELP', 'HP', 'EMAIL', 'AGAMA', 'GOL_DAR', 'NAMA_BANK', 'REKENING', 'UNIT_PLN', 'NO_SPK', 'NO_SK', 'ATAS_NAMA', 'STATUS_PEGAWAI', 'STATUS_KERJA', 'ASURANSI_KESEHATAN', 'NO_ASURANSI_KESEHATAN','NO_VIRTUAL_ACCOUNT', 'WIL_ASURANSI_KESEHATAN', 'STATUS_PEM_ASKES', 'ASURANSI_TK', 'NO_ASURANSI_TK','NPP', 'WIL_ASURANSI_TK', 'STATUS_PEM_ASTK', 'PENEMPATAN', 'NO_KONTRAK','NO_REK_DPLK','TINGGI_BADAN','BERAT_BADAN','UKURAN_BAJU','UKURAN_CELANA','UKURAN_SEPATU','UKURAN_SARUNG_TANGAN','UKURAN_TOPI','IBU_KANDUNG','NO_CIF','STATUS_PKWT','LOKASI_ARSIP','ID_DATA_SPK','STATUS_ABSEN','SISA_CUTI','DIVISI','SUB_DIVISI','BERKAS_KTP','BERKAS_KK','BERKAS_NPWP','BERKAS_BUKTAB','BERKAS_IJAZAH','USER'], 'string', 'max' => 255],
            [['NO_INDUK','JENIS_USER'], 'string', 'max' => 30],
            [['ID_REGION'], 'string', 'max' => 10],
            [['ID_UNIT'], 'string', 'max' => 50],
            [['SPK_SK'], 'string', 'max' => 3],
            [['STATUS_APPROVAL'], 'string', 'max' => 1],
            [['KD_AKTIF'], 'exist', 'skipOnError' => true, 'targetClass' => KodeAktif::className(), 'targetAttribute' => ['KD_AKTIF' => 'KD_AKTIF']],
            [['FOTO'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,png,jpeg,pdf'],
            [['DPLK','PESANGON','RATING'], 'number'],
            [['NPWP'], 'string','length'=>15, 'message'=>"NPWP Harus 15 digit tanpa tanda baca"],
            [['NPWP'], 'trim'],
            ['NPWP', 'match', 'pattern' => '/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'KD_AKTIF' => 'Status Aktif',
            'NO_INDUK' => 'No  Induk',
            'ID_REGION' => 'Region',
            'ID_UNIT' => 'Unit',
            'JABATAN' => 'Jabatan',
            'PEKERJAAN' => 'Pekerjaan',
            'NAMA' => 'Nama Lengkap',
            'NAMA_P' => 'Nama  Panggilan',
            'NO_KTP' => 'No.  Ktp',
            'KELAMIN' => 'Jenis Kelamin',
            'KAWIN' => 'Stat. Pernikahan',
            'TGL_KAWIN' => 'Tgl.  Nikah',
            'FTGL_LAHIR' => 'Tgl.  Lahir',
            'TP_LAHIR' => 'Tempat  Lahir',
            'ALAMAT' => 'Alamat',
            'ALAMAT_DSKRG' => 'Alamat  Sekarang',
            'TELP' => 'No. Telp',
            'HP' => 'No. Hp',
            'EMAIL' => 'Email',
            'AGAMA' => 'Agama',
            'GOL_DAR' => 'Golongan  Darah',
            'TINGGI_BADAN' => 'Tinggi  Badan',
            'BERAT_BADAN' => 'Berat  Badan',
            'UKURAN_BAJU' => 'Ukuran  Baju',
            'UKURAN_CELANA' => 'Ukuran  Celana',
            'UKURAN_SEPATU' => 'Ukuran  Sepatu',
            'UKURAN_SARUNG_TANGAN' => 'Ukuran  Sarung  Tangan',
            'UKURAN_TOPI' => 'Ukuran  Topi',
            'NPWP' => 'Npwp',
            'NAMA_BANK' => 'Nama  Bank',
            'REKENING' => 'Rekening',
            'UNIT_PLN' => 'Unit  Pln',
            'SPK_SK' => 'Spk  Sk',
            'NO_SPK' => 'No  SPK',
            'NO_SK' => 'No  Sk',
            'ATAS_NAMA' => 'Atas  Nama',
            'STATUS_PEGAWAI' => 'Status  Pegawai',
            'TGL_MASUK' => 'Tanggal Awal Masa Kerja',
            'TGL_MASUK_HPI' => 'Tanggal Pertama di HPI',
            'TGL_MASUK_LAMA' => 'Tanggal Masa Kerja Vendor Lama',
            'STATUS_APPROVAL' => 'Status  Approval',
            'STATUS_KERJA' => 'Status  Kerja',
            'TGL_KELUAR' => 'Tanggal  Keluar',
            'ASURANSI_KESEHATAN' => 'Asuransi  Kesehatan',
            'NO_VIRTUAL_ACCOUNT' => 'No  Virtual  Account',
            'NO_ASURANSI_KESEHATAN' => 'No  Kartu Asuransi Kesehatan',
            'WIL_ASURANSI_KESEHATAN' => 'Wilayah Asuransi Kesehatan',
            'STATUS_PEM_ASKES' => 'Status  Pembayaran Asuransi Kesehatan',
            'ASURANSI_TK' => 'Asuransi Ketenagakerjaan',
            'NPP' => 'NPP',
            'NO_ASURANSI_TK' => 'No  Kartu Asuransi Ketenagakerjaan',
            'WIL_ASURANSI_TK' => 'Wilayah  Asuransi Ketenagakerjaan',
            'STATUS_PEM_ASTK' => 'Status  Pembayaran Asuransi Ketenagakerjaan',
            'NO_REK_DPLK' => 'Rekening  DPLK',
            'FOTO' => 'Foto',
            'PENEMPATAN' => 'Penempatan',
            'TGL_AWAL_KONTRAK' => 'Tanggal  Awal  Kontrak Kerja(Terakhir)',
            'TGL_AKHIR_KONTRAK' => 'Tanggal  Akhir  Kontrak(Terakhir)',
            'NO_KONTRAK' => 'No  Kontrak',
            'TGL_APPROVAL' => 'Tgl.  Approval',
            'TGL_TEST' => 'Tgl.  Test',
            'PASSWORD' => 'Password',
            'STATUS_USER'=>'Status User',
            'TARIF_SPPD'=>'Tarif SPPD',
            'TARIF_LEMBUR'=>'Tarif Lembur',
            'JUMLAH_ANAK'=> 'Jumlah Anak',
            'STATUS_ABSEN'=>'Status Absen',
            'SISA_CUTI'=> 'Sisa Cuti',
            'RATING'=> 'Rating',
            'DIVISI'=> 'Bidang',
            'SUB_DIVISI'=> 'Sub Bidang',
            'BERKAS_KTP' => 'Berkas KTP',
            'BERKAS_KK' => 'Berkas Kartu Keluarga',
            'BERKAS_NPWP' => 'Berkas NPWP',
            'BERKAS_BUKTAB' => 'Berkas Buku Tabungan',
            'BERKAS_IJAZAH' => 'Berkas Ijazah',
            'TGL_ABSEN'=>'Tanggal',
            'WAKTU_MASUK'=>'Waktu Absen MAsuk',
            'WAKTU_KELUAR'=>'Waktu Absen Keluar'
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
    public function getPayroll()
    {
        return $this->hasMany(Payroll::className(), ['NO_INDUK' => 'NO_INDUK']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNonshift()
    {
        return $this->hasOne(JamKerja::className(), ['JENIS' => 'JAM_KERJA']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShift()
    {
        return $this->hasOne(JamKerjaShift::className(), ['LEFT(jam_kerja_shift.JENIS,8)' => 'JAM_KERJA']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAktif()
    {
        return $this->hasOne(KodeAktif::className(), ['KD_AKTIF' => 'KD_AKTIF']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRat()
    {
        return $this->hasOne(Kinerja::className(), ['NO_INDUK' => 'NO_INDUK'])->orderBy(['kinerja.ID'=>SORT_DESC]);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSp()
    {
        // return SuratPeringatan::find()->andWhere(['NO_INDUK'=>$this->NO_INDUK])->andWhere(['<=','TANGGAL_MULAI',date('Y-m-d')])->andWhere(['>=','TANGGAL_BERAKHIR',date('Y-m-d')])->one();
        return $this->hasOne(SuratPeringatan::className(), ['NO_INDUK' => 'NO_INDUK'])->andWhere(['<=','surat_peringatan.TANGGAL_MULAI',date('Y-m-d')])->andWhere(['>=','surat_peringatan.TANGGAL_BERAKHIR',date('Y-m-d')])->orderBy(['TANGGAL_PENGAJUAN'=>SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsk()
    {
        $arr = ['0'=>'Dipotong','1'=>'Tidak Dipotong'];
        return isset($arr[$this->STATUS_PEM_ASKES]) ? $arr[$this->STATUS_PEM_ASKES] : '-';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAst()
    {
        $arr = ['0'=>'Dipotong','1'=>'Tidak Dipotong'];
        return isset($arr[$this->STATUS_PEM_ASKES]) ? $arr[$this->STATUS_PEM_ASKES] : '-';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKwn()
    {
        $arr = ['1'=>'Lajang','2'=>'Kawin','3'=>'Duda/Janda'];
        return isset($arr[$this->KAWIN]) ? $arr[$this->KAWIN] : '-';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgm()
    {
        $arr = ['1'=>'Islam','2'=>'Kristen','3'=>'Katolik','4'=>'Hindu','5'=>'Budha','6'=>'Kepercayaan'];
        return isset($arr[$this->AGAMA]) ? $arr[$this->AGAMA] : '-';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKlm()
    {
        $arr = ['1'=>'Pria','2'=>'Wanita'];
        return isset($arr[$this->KELAMIN]) ? $arr[$this->KELAMIN] : '-';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsia()
    {
        if($this->FTGL_LAHIR == '0000-00-00' AND $this->FTGL_LAHIR == '' AND $this->FTGL_LAHIR == null):
            return '0 Tahun 0 Bulan';
        else:
            $diff = date_diff(date_create($this->FTGL_LAHIR), date_create());
            return $diff->y.' Tahun '.$diff->m.' Bulan';
        endif;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUmur()
    {
        if($this->FTGL_LAHIR == '0000-00-00' AND $this->FTGL_LAHIR == '' AND $this->FTGL_LAHIR == null):
            return 0;
        else:
            $diff = date_diff(date_create($this->FTGL_LAHIR), date_create());
            return $diff->y;
        endif;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAbsenOne($tgl)
    {
        $model = Absen::find()->andWhere(['NO_INDUK'=>$this->NO_INDUK])->andWhere(['LEFT(WAKTU_MASUK,10)'=>$tgl])->one();
        if(!empty($model->WAKTU_MASUK)):
            return $model;
        endif;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoolAbsen($id,$tgl)
    {
        $count = Absen::find()->andWhere(['NO_INDUK'=>$id])->andWhere(['LEFT(WAKTU_MASUK,10)'=>$tgl])->count('NO_INDUK');
        return $count;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIsAbsen($dataProvider)
    {
        if(!empty(Yii::$app->request->get('LevellingAbsenSearch'))):
           $date = Yii::$app->request->get('LevellingAbsenSearch')['TGL_ABSEN'];
        else:
            $date = date('Y-m-d');
        endif;
        if($dataProvider->getCount() > 0):
            $count=0;
            foreach ($dataProvider->getModels() as $peg):
                $count += $this->getBoolAbsen($peg->NO_INDUK,$date);
            endforeach;
            return $count;
        else:
            return 0;
        endif;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdk()
    {
        return $this->hasOne(Pendidikan::className(), ['NO_INDUK' => 'NO_INDUK'])->orderBy(['akademis.ID_AKADEMIS'=>SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnk()
    {
        return $this->hasOne(Keluarga::className(), ['NO_INDUK' => 'NO_INDUK'])->where("SUTRIA NOT LIKE '%S%' AND SUTRIA NOT LIKE '%I%'")->orderBy(['keluarga.SUTRIA'=>SORT_DESC]);
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $model = static::findOne(['NO_INDUK' => $id]);
        if(isset($model->NO_INDUK)):
            $model->MODULES = static::getModules($model);
        endif;
        return $model;
    }


    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne($token);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $model = static::find()
        ->rightJoin('kode_aktif', 'kode_aktif.KD_AKTIF = pegawai.KD_AKTIF AND kode_aktif.KETERANGAN = "A"')
        ->andWhere(['pegawai.NO_INDUK' => $username])
        ->andWhere(['pegawai.STATUS_APPROVAL' => '1'])
        ->one();
        if(isset($model->NO_INDUK)):
            $model->MODULES = static::getModules($model);
        endif;
        return $model;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findLoginApi($id,$pass)
    {
        $model = static::find()
        ->rightJoin('kode_aktif', 'kode_aktif.KD_AKTIF = pegawai.KD_AKTIF AND kode_aktif.KETERANGAN = "A"')
        ->andWhere(['pegawai.NO_INDUK' => $id])
        ->andWhere(['pegawai.PASSWORD' => $pass])
        ->andWhere(['pegawai.STATUS_APPROVAL' => '1'])
        ->one();
        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if(Yii::$app->getSecurity()->validatePassword($password,$this->PASSWORD)){
            return true;
        }
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }
    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function getModules($model)
    {
        if(isset($model->NO_INDUK)):
            if($model->spkku->NO_SPK === '0160.Pj/HKM.00.001/PS/2019' OR $model->spkku->NO_SPK === '0135.Pj/DAN.01.03/C29000000/2021'):
                return 'pusertif';
            else:
                return 'hpi';
            endif;
        else:
            return 'hpi';
        endif;
    }

    public function getFormattgl($tanggal)
    {
        $bulan =['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $pecahkan = explode('-', $tanggal);
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
    public function getDay($date)
    {
        $date = ($date > 5) ? 6 : ($date+1);
        $datetime = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        return $datetime[$date];
    }

    public function numberToRomanRepresentation($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

}
