<?php
use app\models\Sppd;
use app\models\SppdDetailSearch;

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
            <td colspan="12" align="center"><b>REKAPITULASI PERHITUNGAN SPPD TENAGA KERJA DI <?=$searchModel->PENEMPATAN?></b></td>
        </tr>
        <tr>
        <td colspan="12" align="center"><b>BULAN <?=$tgl?></b></td>
        </tr>
    </table>
    <br/>
    <table align="left" style="width: 100%; margin-bottom:20px;">
        <tr style="line-height:30px;">
            <th style="border: 1px solid #17202A; text-align:center;"><b>No.</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>Nomor Induk</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>Nama</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>Jabatan</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>Penempatan</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>Bank</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>Nomor Rekening</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>SPPD</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>BIAYA ADMIN (6%)</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>JUMLAH</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>PAJAK PPN (11%)</b></th>
            <th style="border: 1px solid #17202A; text-align:center;"><b>TOTAL</b></th>
        </tr>
        <?php
            $sumTotal = 0;
            $sumAdmin = 0;
            $sumTotalAdmin = 0;
            $sumPajak = 0;
            $sumTotalPajak = 0;
            foreach ($dataProvider->getModels() as $key => $value):
        ?>
        <tr>
            <td style="border: 1px solid #17202A; text-align:center;"><?=$key+1?></td>
            <td style="border: 1px solid #17202A; text-align:center;"><?=$value->NO_INDUK?></td>
            <td style="border: 1px solid #17202A; padding-left: 0.5em;"><?=$value->NAMA?></td>
            <td style="border: 1px solid #17202A; padding-left: 0.5em;"><?=$value->peg->spkku->JABATAN?></td>
            <td style="border: 1px solid #17202A; padding-left: 0.5em;"><?=$value->PENEMPATAN?></td>
            <td style="border: 1px solid #17202A; text-align:center;"><?=$value->peg->NAMA_BANK?></td>
            <td style="border: 1px solid #17202A; text-align:center;"><?=$value->peg->REKENING?></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><?=Yii::$app->formatter->asDecimal($value->TOTAL, 0)?></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><?=Yii::$app->formatter->asDecimal($value->biayaadmin, 0)?></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><?=Yii::$app->formatter->asDecimal($value->totaladmin, 0)?></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><?=Yii::$app->formatter->asDecimal($value->pajak, 0)?></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><?=Yii::$app->formatter->asDecimal($value->totalpajak, 0)?></td>
        </tr>
        <?php
            $sumTotal = $sumTotal + $value->TOTAL;
            $sumAdmin = $sumAdmin + $value->biayaadmin;
            $sumTotalAdmin = $sumTotalAdmin + $value->totaladmin;
            $sumPajak = $sumPajak + $value->pajak;
            $sumTotalPajak = $sumTotalPajak + $value->totalpajak;
            endforeach;
        ?>
        <tr style="line-height:30px;">
            <td colspan="7" style="border: 1px solid #17202A; text-align:center;"><b>TOTAL</b></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><b><?=Yii::$app->formatter->asDecimal($sumTotal, 0)?></b></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><b><?=Yii::$app->formatter->asDecimal($sumAdmin, 0)?></b></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><b><?=Yii::$app->formatter->asDecimal($sumTotalAdmin, 0)?></b></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><b><?=Yii::$app->formatter->asDecimal($sumPajak, 0)?></b></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><b><?=Yii::$app->formatter->asDecimal($sumTotalPajak, 0)?></b></td>
        </tr>

    </table>
    <table class="table-borderless" style="width:90%; margin: 0 auto; font-weight:bold;">
        <tbody>
            <tr>
                <td colspan="3" class="center">&nbsp;</td>
                <td style="width:220px;">&nbsp;</td>
                <td colspan="3" class="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center">MENGETAHUI</td>
                <td colspan="6">&nbsp;</td>
                <td colspan="3" style="text-align:center">Yogyakarta, <?=$model->getFormatTgl(date('Y-m-d'))?></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center"><?=$searchModel->PENEMPATAN?></td>
                <td colspan="6">&nbsp;</td>
                <td colspan="3" style="text-align:center">PT. HALEYORA POWERINDO</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center">&nbsp;</td>
                <td colspan="6">&nbsp;</td>
                <td colspan="3" style="text-align:center">MANAGER CABANG</td>
            </tr>
            <tr>
                <td colspan="12" class="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="12" class="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="12" class="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="12" class="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="12" class="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="12" class="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center">( <?=$searchModel->NAMA_USER?> )</td>
                <td colspan="6">&nbsp;</td>
                <td colspan="3" style="text-align:center">( <?=$searchModel->NAMA_MANAGER_CABANG?> )</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center">&nbsp;</td>
                <td colspan="6">&nbsp;</td>
                <td colspan="3" style="text-align:center">&nbsp;</td>
            </tr>
        </tbody>
    </table>
    </div>
    
</body>
</html>