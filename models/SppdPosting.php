<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sppd".
 *
 * @property string $NO_SPPD
 * @property string $NO_INDUK
 * @property string $NAMA
 * @property string $ID_REGION
 * @property string $ID_UNIT
 * @property string $JUMLAH_HARI
 * @property string $STATUS_APPROVAL
 * @property string $TGL_APPROVAL
 * @property string $UANG_SAKU
 * @property string $KONSUMSI
 * @property string $LAUNDRY
 * @property string $PENGINAPAN
 * @property double $TOTAL
 * @property double $TRANSPORTASI
 * @property double $NOMINAL
 * @property string $NO_SAP
 * @property string $TGL_SAP
 * @property string $STATUS_PEM_ICON
 * @property string $TGL_PEM_ICON
 * @property string $STATUS_BAYAR
 * @property string $TGL_BAYAR
 * @property string $STATUS_POSTING
 */
class SppdPosting extends \yii\db\ActiveRecord
{
    public $FISRT_DATE,$END_DATE;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sppd';
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
            [['NO_SPPD'], 'required'],
            [['PASSWORD'],'trim'],
            [['PASSWORD'],'string','min'=>'6'],
            [['TGL_APPROVAL', 'TGL_SAP', 'TGL_PEM_ICON', 'TGL_BAYAR','TGL_POSTING_UNIT','TGL_POSTING_SDM','TGL_POSTING_KEU','TGL_POSTING_AKT','TGL_BAPP','FISRT_DATE','END_DATE',], 'safe'],
            [['TOTAL', 'TRANSPORTASI', 'NOMINAL','POTONGAN_BANK', 'UANG_SAKU', 'KONSUMSI', 'LAUNDRY', 'PENGINAPAN', 'JUMLAH_HARI'], 'number'],
            [['NO_SPPD', 'NAMA', 'ID_REGION', 'ID_UNIT', 'STATUS_APPROVAL', 'NO_SAP', 'STATUS_PEM_ICON', 'STATUS_BAYAR','APP','KODE_GL','INTERNAL_ORDER','NO_TRANSAKSI','BA_PEMERIKSAAN_PEKERJAAN','PEMBAYARAN'], 'string', 'max' => 255],
            [['NO_INDUK'], 'string', 'max' => 15],
            [['STATUS_POSTING'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NO_SPPD' => 'No  Sppd',
            'NO_INDUK' => 'No  Induk',
            'NAMA' => 'Nama',
            'ID_REGION' => 'Id  Region',
            'ID_UNIT' => 'Id  Unit',
            'JUMLAH_HARI' => 'Jumlah  Hari',
            'STATUS_APPROVAL' => 'Status  Approval',
            'TGL_APPROVAL' => 'Tgl  Approval',
            'UANG_SAKU' => 'Uang  Saku',
            'KONSUMSI' => 'Konsumsi',
            'LAUNDRY' => 'Laundry',
            'PENGINAPAN' => 'Penginapan',
            'TOTAL' => 'Total',
            'TRANSPORTASI' => 'Transportasi',
            'NOMINAL' => 'Nominal',
            'NO_SAP' => 'No  Sap',
            'TGL_SAP' => 'Tgl  Sap',
            'STATUS_PEM_ICON' => 'Status  Pem  Icon',
            'TGL_PEM_ICON' => 'Tgl  Pem  Icon',
            'STATUS_BAYAR' => 'Status  Bayar',
            'TGL_BAYAR' => 'Tgl  Bayar',
            'PEMBAYARAN' => 'Pembayaran',
            'STATUS_POSTING' => 'Status  Posting',
            'TGL_POSTING_UNIT' => 'Tgl  Posting Cabang',
            'TGL_POSTING_SDM' => 'Tgl  Posting SDM',
            'TGL_POSTING_AKT' => 'Tgl  Posting Akuntansi',
            'TGL_POSTING_KEU' => 'Tgl  Posting Keuangan',
            'TGL_BAPP' => 'Tgl  Pembuatan BAPP',
            'APP'=>'Application',
            'KODE_GL' => 'Kode GL',
            'INTERNAL_ORDER' => 'I/O',
            'NO_TRANSAKSI'=>'No. Transaksi',
            'BA_PEMERIKSAAN_PEKERJAAN'=>'BA PEMERIKSAAN PEKERJAAN',
            'PASSWORD'=>'Password',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['NO_INDUK' => 'NO_INDUK']);
    }

    public static function getTotal($provider, $fieldName)
    {
        $total = 0;

        foreach ($provider as $item) {
            $total += $item[$fieldName];
        }

        return $total;
    }
}
