<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_spk".
 *
 * @property string $ID_DATA_SPK
 * @property string $ID_REGION
 * @property string $ID_UNIT
 * @property string $UNIT_PLN
 * @property string $STATUS_PEGAWAI
 * @property string $NO_SPK
 * @property string $JUDUL_SPK
 * @property string $JABATAN
 * @property string $SPESIFIKASI_PEKERJAAN
 * @property string $SUB_PEKERJAAN
 * @property string $PEKERJAAN
 * @property string $KD_AKTIF
 * @property double $UPAH_POKOK
 * @property double $TUNJANGAN_TRANSPORT
 * @property double $TUNJANGAN_PROFESI
 * @property double $TUNJANGAN_JABATAN
 * @property string $TUNJANGAN_1_NAMA
 * @property double $TUNJANGAN_1
 * @property string $TUNJANGAN_2_NAMA
 * @property double $TUNJANGAN_2
 * @property string $TUNJANGAN_3_NAMA
 * @property double $TUNJANGAN_3
 * @property string $TUNJANGAN_4_NAMA
 * @property double $TUNJANGAN_4
 * @property string $TUNJANGAN_5_NAMA
 * @property double $TUNJANGAN_5
 * @property string $TUNJANGAN_6_NAMA
 * @property double $TUNJANGAN_6
 * @property string $TUNJANGAN_7_NAMA
 * @property double $TUNJANGAN_7
 * @property string $NPP
 * @property double $POTONGAN_BPJS_KT
 * @property string $NO_VIRTUAL_ACCOUNT
 * @property double $POTONGAN_BPJS_KES
 * @property double $POTONGAN_PPH_21
 * @property string $POTONGAN_1_NAMA
 * @property double $POTONGAN_1
 * @property string $POTONGAN_2_NAMA
 * @property double $POTONGAN_2
 * @property string $POTONGAN_3_NAMA
 * @property double $POTONGAN_3
 * @property string $POTONGAN_4_NAMA
 * @property double $POTONGAN_4
 * @property string $POTONGAN_5_NAMA
 * @property double $POTONGAN_5
 * @property string $POTONGAN_6_NAMA
 * @property double $POTONGAN_6
 * @property string $POTONGAN_7_NAMA
 * @property double $POTONGAN_7
 * @property integer $JUMLAH_PEGAWAI
 * @property double $UMK
 * @property double $KOEFISIEN
 * @property string $STAT_PEM_BPJS_KT
 * @property string $STAT_PEM_BPJS_KES
 * @property string $PERHITUNGAN_DPLK
 * @property string $JABATAN_RAB
 * @property string $INTERNAL_ORDER
 * @property string $INTERNAL_ORDER_DESC
 * @property double $POT_IURAN_BPJS_KES_TK
 * @property double $POT_IURAN_BPJS_KES_PR
 * @property double $POT_IURAN_BPJS_KT_TK
 * @property double $POT_IURAN_BPJS_KT_PR
 * @property double $POT_IURAN_BPJS_KT_JKK
 * @property double $POT_IURAN_BPJS_KT_JKM
 * @property double $POT_IURAN_JPN_TK
 * @property double $POT_IURAN_JPN_PR
 * @property string $STATUS_APPROVAL
 * @property string $APP
 *
 * @property DataUnit $iDUNIT
 */
class Spk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_spk';
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
            [['ID_DATA_SPK', 'NO_SPK'], 'required'],
            [['UPAH_POKOK', 'TUNJANGAN_TRANSPORT', 'TUNJANGAN_PROFESI', 'TUNJANGAN_JABATAN', 'TUNJANGAN_1', 'TUNJANGAN_2', 'TUNJANGAN_3', 'TUNJANGAN_4', 'TUNJANGAN_5', 'TUNJANGAN_6', 'TUNJANGAN_7', 'POTONGAN_BPJS_KT', 'POTONGAN_BPJS_KES', 'POTONGAN_PPH_21', 'POTONGAN_1', 'POTONGAN_2', 'POTONGAN_3', 'POTONGAN_4', 'POTONGAN_5', 'POTONGAN_6', 'POTONGAN_7', 'UMK', 'KOEFISIEN', 'POT_IURAN_BPJS_KES_TK', 'POT_IURAN_BPJS_KES_PR', 'POT_IURAN_BPJS_KT_TK', 'POT_IURAN_BPJS_KT_PR', 'POT_IURAN_BPJS_KT_JKK', 'POT_IURAN_BPJS_KT_JKM', 'POT_IURAN_JPN_TK', 'POT_IURAN_JPN_PR'], 'number'],
            [['JUMLAH_PEGAWAI'], 'integer'],
            [['ID_DATA_SPK'], 'string', 'max' => 10],
            [['ID_REGION'], 'string', 'max' => 2],
            [['ID_UNIT'], 'string', 'max' => 4],
            [['UNIT_PLN', 'STATUS_PEGAWAI', 'NO_SPK', 'JUDUL_SPK', 'JABATAN', 'SPESIFIKASI_PEKERJAAN', 'SUB_PEKERJAAN', 'PEKERJAAN', 'KD_AKTIF', 'TUNJANGAN_1_NAMA', 'TUNJANGAN_2_NAMA', 'TUNJANGAN_3_NAMA', 'TUNJANGAN_4_NAMA', 'TUNJANGAN_5_NAMA', 'TUNJANGAN_6_NAMA', 'TUNJANGAN_7_NAMA', 'NPP', 'NO_VIRTUAL_ACCOUNT', 'POTONGAN_1_NAMA', 'POTONGAN_2_NAMA', 'POTONGAN_3_NAMA', 'POTONGAN_4_NAMA', 'POTONGAN_5_NAMA', 'POTONGAN_6_NAMA', 'POTONGAN_7_NAMA', 'STAT_PEM_BPJS_KT', 'STAT_PEM_BPJS_KES', 'PERHITUNGAN_DPLK', 'JABATAN_RAB', 'INTERNAL_ORDER', 'INTERNAL_ORDER_DESC','APP'], 'string', 'max' => 255],
            [['STATUS_APPROVAL'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_DATA_SPK' => 'Id  Data  Spk',
            'ID_REGION' => 'Id  Region',
            'ID_UNIT' => 'Id  Unit',
            'UNIT_PLN' => 'Unit  Pln',
            'STATUS_PEGAWAI' => 'Status  Pegawai',
            'NO_SPK' => 'No  Spk',
            'JUDUL_SPK' => 'Judul  Spk',
            'JABATAN' => 'Jabatan',
            'SPESIFIKASI_PEKERJAAN' => 'Spesifikasi  Pekerjaan',
            'SUB_PEKERJAAN' => 'Sub  Pekerjaan',
            'PEKERJAAN' => 'Pekerjaan',
            'KD_AKTIF' => 'Kd  Aktif',
            'UPAH_POKOK' => 'Upah  Pokok',
            'TUNJANGAN_TRANSPORT' => 'Tunjangan  Transport',
            'TUNJANGAN_PROFESI' => 'Tunjangan  Profesi',
            'TUNJANGAN_JABATAN' => 'Tunjangan  Jabatan',
            'TUNJANGAN_1_NAMA' => 'Tunjangan 1  Nama',
            'TUNJANGAN_1' => 'Tunjangan 1',
            'TUNJANGAN_2_NAMA' => 'Tunjangan 2  Nama',
            'TUNJANGAN_2' => 'Tunjangan 2',
            'TUNJANGAN_3_NAMA' => 'Tunjangan 3  Nama',
            'TUNJANGAN_3' => 'Tunjangan 3',
            'TUNJANGAN_4_NAMA' => 'Tunjangan 4  Nama',
            'TUNJANGAN_4' => 'Tunjangan 4',
            'TUNJANGAN_5_NAMA' => 'Tunjangan 5  Nama',
            'TUNJANGAN_5' => 'Tunjangan 5',
            'TUNJANGAN_6_NAMA' => 'Tunjangan 6  Nama',
            'TUNJANGAN_6' => 'Tunjangan 6',
            'TUNJANGAN_7_NAMA' => 'Tunjangan 7  Nama',
            'TUNJANGAN_7' => 'Tunjangan 7',
            'NPP' => 'Npp',
            'POTONGAN_BPJS_KT' => 'Potongan  Bpjs  Kt',
            'NO_VIRTUAL_ACCOUNT' => 'No  Virtual  Account',
            'POTONGAN_BPJS_KES' => 'Potongan  Bpjs  Kes',
            'POTONGAN_PPH_21' => 'Potongan  Pph 21',
            'POTONGAN_1_NAMA' => 'Potongan 1  Nama',
            'POTONGAN_1' => 'Potongan 1',
            'POTONGAN_2_NAMA' => 'Potongan 2  Nama',
            'POTONGAN_2' => 'Potongan 2',
            'POTONGAN_3_NAMA' => 'Potongan 3  Nama',
            'POTONGAN_3' => 'Potongan 3',
            'POTONGAN_4_NAMA' => 'Potongan 4  Nama',
            'POTONGAN_4' => 'Potongan 4',
            'POTONGAN_5_NAMA' => 'Potongan 5  Nama',
            'POTONGAN_5' => 'Potongan 5',
            'POTONGAN_6_NAMA' => 'Potongan 6  Nama',
            'POTONGAN_6' => 'Potongan 6',
            'POTONGAN_7_NAMA' => 'Potongan 7  Nama',
            'POTONGAN_7' => 'Potongan 7',
            'JUMLAH_PEGAWAI' => 'Jumlah  Pegawai',
            'UMK' => 'Umk',
            'KOEFISIEN' => 'Koefisien',
            'STAT_PEM_BPJS_KT' => 'Stat  Pem  Bpjs  Kt',
            'STAT_PEM_BPJS_KES' => 'Stat  Pem  Bpjs  Kes',
            'PERHITUNGAN_DPLK' => 'Perhitungan  Dplk',
            'JABATAN_RAB' => 'Jabatan  Rab',
            'INTERNAL_ORDER' => 'Internal  Order',
            'INTERNAL_ORDER_DESC' => 'Internal  Order  Desc',
            'POT_IURAN_BPJS_KES_TK' => 'Pot  Iuran  Bpjs  Kes  Tk',
            'POT_IURAN_BPJS_KES_PR' => 'Pot  Iuran  Bpjs  Kes  Pr',
            'POT_IURAN_BPJS_KT_TK' => 'Pot  Iuran  Bpjs  Kt  Tk',
            'POT_IURAN_BPJS_KT_PR' => 'Pot  Iuran  Bpjs  Kt  Pr',
            'POT_IURAN_BPJS_KT_JKK' => 'Pot  Iuran  Bpjs  Kt  Jkk',
            'POT_IURAN_BPJS_KT_JKM' => 'Pot  Iuran  Bpjs  Kt  Jkm',
            'POT_IURAN_JPN_TK' => 'Pot  Iuran  Jpn  Tk',
            'POT_IURAN_JPN_PR' => 'Pot  Iuran  Jpn  Pr',
            'STATUS_APPROVAL' => 'Status  Approval',
        ];
    }
}
