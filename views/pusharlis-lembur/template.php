<?php
use app\models\Sppd;

$model = new Sppd();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Rekap Perjalanan Dinas</title>
</head>

<body>
    <div class="container-fluid" style="font-family:'Calibri'; font-size: 12px; border-collapse: collapse; padding : 20px;">
    <table align="left" style="width: 100%; margin-bottom:20px; font-size: 14px;">
        <tr>
            <td colspan="3" align="left"><b>Lampiran surat</b></td>
        </tr>
        <tr>
            <td style="width:50px;"><b>Nomor</b></td>
            <td style="width:10px;"><b>:</b></td>
            <td><b><?=$searchModel->NOMOR_SURAT?></b></td>
        </tr>
        <tr>
            <td style="width:50px;"><b>Perihal</b></td>
            <td style="width:10px;"><b>:</b></td>
            <td><b><?=$searchModel->PERIHAL?></b></td>
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
            <th style="border: 1px solid #17202A; text-align:center;"><b>Jumlah</b></th>
        </tr>
        <?php
            $sumTotal = 0;
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
        </tr>
        <?php
            $sumTotal = $sumTotal + $value->TOTAL;
            endforeach;
        ?>
        <tr style="line-height:30px;">
            <td colspan="7" style="border: 1px solid #17202A; text-align:center;"><b>TOTAL</b></td>
            <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><b><?=Yii::$app->formatter->asDecimal($sumTotal, 0)?></b></td>
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
                <td>&nbsp;</td>
                <td colspan="3" style="text-align:center">Yogyakarta, <?=$model->getFormatTgl(date('Y-m-d'))?></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center"><?=$searchModel->PENEMPATAN?></td>
                <td>&nbsp;</td>
                <td colspan="3" style="text-align:center">PT. HALEYORA POWERINDO</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center">&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3" style="text-align:center">MANAGER CABANG</td>
            </tr>
            <tr>
                <td colspan="8" class="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" class="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" class="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" class="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" class="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" class="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center">( <?=$searchModel->NAMA_USER?> )</td>
                <td>&nbsp;</td>
                <td colspan="3" style="text-align:center">( <?=$searchModel->NAMA_MANAGER_CABANG?> )</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center">&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3" style="text-align:center">&nbsp;</td>
            </tr>
        </tbody>
    </table>
    </div>
</body>
</html>