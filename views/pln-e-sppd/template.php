
<!DOCTYPE html>
<html>
<head>
	<title>Rekap Data Perjalanan Dinas</title>
</head>

<body style="border: 0.1pt solid #ccc"> 
    <div class="container-fluid" style="font-family:'Calibri'; font-size: 12px; border-collapse: collapse; padding : 20px;">
    
    <?php
        $sumTotal = 0;
        foreach ($dataArray as $key => $value):
    ?>
        <table align="left" style="width: 100%; margin-bottom:20px; font-size: 14px;">
            <tr>
                <td style="width:120px;"><b>CHARGE CODE</b></td>
                <td style="width:10px;"><b>:</b></td>
                <td><b><?=$value['CHARGE_CODE']?></b></td>
            </tr>
            <tr>
                <td style="width:120px;"><b>BIDANG</b></td>
                <td style="width:10px;"><b>:</b></td>
                <td><b><?=$value['BIDANG']?></b></td>
            </tr>
        </table>
        <br/>
        <table align="left" style="width: 100%; margin-bottom:20px;">
            <tr style="line-height:30px;">
                <th style="border: 1px solid #17202A; text-align:center;"><b>No.</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>No SPPD.</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Nomor Induk</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Nama</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Jabatan</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Jenis SPPD</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Tanggal Nerangkat</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Tanggal Kembali</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Jumlah Hari</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Lumpsum</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Region Tujuan</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Negara/Kota Tujuan</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Jenis Tranportasi</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Uang Konsumsi</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Uang Laundry</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Uang Saku</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Uang Tranportasi</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Total</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Uang Lumpsum</b></th>
                <th style="border: 1px solid #17202A; text-align:center;"><b>Nominal DIbayarkan</b></th>
            </tr>
            <?php
                $sumTotal = 0;
                foreach ($value['data'] as $keydata => $valueData):
            ?>
                <tr>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$keydata+1?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->ID?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->NO_INDUK?></td>
                    <td style="border: 1px solid #17202A; padding-left: 0.5em;"><?=$valueData->NAMA?></td>
                    <td style="border: 1px solid #17202A; padding-left: 0.5em;"><?=$valueData->JABATAN?></td>
                    <td style="border: 1px solid #17202A; padding-left: 0.5em;"><?=$valueData->JENIS_SPPD?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->TGL_BERANGKAT?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->TGL_KEMBALI?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->JUMLAH_HARI?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->isLump?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->WILAYAH?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->TUJUAN?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->JENIS_TRANPORTASI?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->KONSUMSI?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->LAUNDRY?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->UANG_SAKU?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->TRANPORTASI?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->TOTAL?></td>
                    <td style="border: 1px solid #17202A; text-align:center;"><?=$valueData->LUMPSUM?></td>
                    <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><?=$valueData->NOMINAL?></td>
                </tr>
            <?php
                $sumTotal = $sumTotal + $valueData->NOMINAL;
                endforeach;
            ?>
            <tr style="line-height:30px;">
                <td colspan="19" style="border: 1px solid #17202A; text-align:right; padding-right: 0.5em;"><b>TOTAL</b></td>
                <td style="border: 1px solid #17202A; padding-right: 0.5em; text-align: right;"><b><?=$sumTotal?></b></td>
            </tr>

        </table>
    <?php
        endforeach;
    ?>
    </div>
</body>
</html>