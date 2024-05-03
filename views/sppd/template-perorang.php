<?php
use app\models\Sppd;

$model = new Sppd();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Rekap Perjalanan Dinas</title>
</head>

<body style="border: 0.1pt solid #ccc"> 
    <div class="container-fluid" style="font-family:'Calibri'; font-size: 12px; border-collapse: collapse; padding : 20px;">
    <table align="left" style="width: 100%; margin-bottom:20px; font-size: 14px;">
        <tr>
            <td colspan="10" align="center"><b>PT. HALEYORA POWERINDO</b></td>
        </tr>
        <tr>
            <td colspan="10" align="center"><b>REKAP PERHITUNGAN PERJALANAN DINAS ( SPPD )</b></td>
        </tr>
        <tr>
            <td >NAMA</td>
            <td >:</td>
            <td ><?=$nama?></td>
        </tr>
        <tr>
            <td >NO_INDUK</td>
            <td >:</td>
            <td ><?=$searchModelDetail->NO_INDUK?></td>
        </tr>
        <tr>
            <td >JABATAN</td>
            <td >:</td>
            <td ><?=$jabatan?></td>
        </tr>
        <tr>
            <td >PENEMPATAN</td>
            <td >:</td>
            <td ><?=$penempatan?></td>
        </tr>
        <tr>
            <td >PERIODE BULAN</td>
            <td >:</td>
            <td ><?=$tgl?></td>
        </tr>
        <tr>
        <td colspan="10" align="center"><b>SPPD</b></td>
        </tr>
    </table>

    <br/>
    <table align="left" style="width: 100%; margin-bottom:20px;">
        <tr style="line-height:30px;">
            <th rowspan="2" style="border: 1px solid #17202A; text-align:center;"><b>TGL</b></th>
            <th rowspan="2" style="border: 1px solid #17202A; text-align:center;"><b>HARI</b></th>
            <th rowspan="2" style="border: 1px solid #17202A; text-align:center;"><b>DAERAH TUJUAN SPPD</b></th>
            <th rowspan="2" style="border: 1px solid #17202A; text-align:center;"><b>KETERANGAN SPPD</b></th>
            <th colspan="2" style="border: 1px solid #17202A; text-align:center;"><b>UANG SAKU</b></th>
            <th colspan="2" style="border: 1px solid #17202A; text-align:center;"><b>PENGINAPAN</b></th>
            <th colspan="2" style="border: 1px solid #17202A; text-align:center;"><b>JUMLAH</b></th>
        </tr>

        <tr style="line-height:30px;">
            <th style="border: 1px solid #17202A; text-align:center;"><b>hari</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>75.000</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>hari</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>200.000</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>hari</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>TOTAL</b></th>
        </tr>
        <?php
            $sumHariUangSaku = 0;
            $sumUangSaku = 0;
            $sumHariPenginapan = 0;
            $sumPenginapan = 0;
            $sumHariTotal = 0;
            $sumTotal = 0;
            foreach ($dataProviderDetail->getModels() as $key => $value):
        ?>
        <tr>
            <td style="border: 1px solid #17202A; text-align:center;"><?=substr($value->TGL,-2)?></td>
            <td style="border: 1px solid #17202A; padding-left: 0.5em;"><?=$model->getHari(date('l', strtotime($value->TGL)))?></td>
            <td style="border: 1px solid #17202A; padding-left: 0.5em;"><?=$value->TUJUAN_SPPD?></td>
            <td style="border: 1px solid #17202A; padding-left: 0.5em;"><?=$value->KETERANGAN_SPPD?></td>
            <td style="border: 1px solid #17202A; text-align:center;"><?=$value->HARI_UANG_SAKU?></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><?=Yii::$app->formatter->asDecimal($value->UANG_SAKU, 0)?></td>
            <td style="border: 1px solid #17202A; text-align:center;"><?=$value->HARI_PENGINAPAN?></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><?=Yii::$app->formatter->asDecimal($value->PENGINAPAN, 0)?></td>
            <td style="border: 1px solid #17202A; text-align:center;"><?=$value->HARI_TOTAL?></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><?=Yii::$app->formatter->asDecimal($value->TOTAL, 0)?></td>
        </tr>
        <?php
            // $sumTotal = $sumTotal + $value->TOTAL;
            // $sumAdmin = $sumTotal + $value->biayaadmin;
            // $sumTotalAdmin = $sumTotal + $value->totaladmin;
            // $sumPajak = $sumTotal + $value->pajak;
            // $sumTotalPajak = $sumTotal + $value->totalpajak;
            $sumHariUangSaku = $sumHariUangSaku + $value->HARI_UANG_SAKU;
            $sumUangSaku = $sumUangSaku + $value->UANG_SAKU;
            $sumHariPenginapan = $sumHariPenginapan + $value->HARI_PENGINAPAN;
            $sumPenginapan = $sumPenginapan + $value->PENGINAPAN;
            $sumHariTotal = $sumHariTotal + $value->HARI_TOTAL;
            $sumTotal = $sumTotal + $value->TOTAL;
            endforeach;
        ?>
        <tr style="line-height:30px;">
            <td colspan="4" style="border: 1px solid #17202A; text-align:center;"><b>TOTAL</b></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><b><?=Yii::$app->formatter->asDecimal($sumHariUangSaku, 0)?></b></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><b><?=Yii::$app->formatter->asDecimal($sumUangSaku, 0)?></b></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><b><?=Yii::$app->formatter->asDecimal($sumHariPenginapan, 0)?></b></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><b><?=Yii::$app->formatter->asDecimal($sumPenginapan, 0)?></b></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><b><?=Yii::$app->formatter->asDecimal($sumHariTotal, 0)?></b></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><b><?=Yii::$app->formatter->asDecimal($sumTotal, 0)?></b></td>
        </tr>

    </table>
    </div>
</body>
</html>