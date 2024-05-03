<?php

use yii\helpers\Html;

// print_r($model);die;

$tglLembur = substr($model->JAM_AWAL_LEMBUR,0,10);
$jamAwal = substr($model->JAM_AWAL_LEMBUR,11,5);
$jamAkhir = substr($model->JAM_AKHIR_LEMBUR,11,5);

?>

<div style="width:900px;margin:0 auto; padding:0;font-weight: 500;font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;font-size: 12px;background-color: transparent;">

    <div class="row" style="margin:10px; 0px;">
		<table class="table-borderles" style="width:100%; border-top: 3px double #000; border-right: 3px double #000; border-left: 3px double #000;">
			<tbody>
				<tr>
					<td rowspan ="5" style="width:250px;">&nbsp;</td>
					<td rowspan ="5" style="text-align: center; width:400px;"><h4><b>SURAT PERINTAH KERJA LEMBUR</b></h4></td>
					<td><h6 style="font-size:11px; margin-bottom:0px; width:90px;">Nomor</h6></td>
					<td><h6 style="font-size:11px; margin-bottom:0px; width:160px;"><?=$model->ID?></h6></td>
				</tr>
				<tr>
					<td><h6 style="font-size:11px; margin-top:0px;">Tanggal Terbit</h6></td>
					<td><h6 style="font-size:11px; margin-top:0px;"><?=$model->CREATED_AT?></h6></td>
				</tr>
				<tr>
					<td colspan ="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan ="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan ="2">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<table class="table-borderles" style="width:100%; border-top: 3px double #000; border-right: 3px double #000; border-left: 3px double #000; border-collapse: collapse;">
			<tbody>
				<tr style="line-height: 12px;">
					<td style="border-bottom: 1px solid #000; font-size:11px;"><div style="padding-left:5px;">Tanggal SPKL</div></td>
					<td style="border-bottom: 1px solid #000; font-size:11px;"><div>:</div></td>
					<td style="border-bottom: 1px solid #000; font-size:11px; border-right:  1px solid #000;"><div><?=$tglLembur?></div></td>
					<td style="border-bottom: 1px solid #000; font-size:11px;"><div>Lembur pada waktu</div></td>
					<td style="border-bottom: 1px solid #000; font-size:11px;"><div>:</div></td>
					<td style="border-bottom: 1px solid #000; font-size:11px;"><?=$model->JENIS_LEMBUR?></td>
				</tr>
				<tr style="line-height: 12px;">
					<td style="border-bottom: 1px solid #000; font-size:11px;"><div style="margin-left:5px;">Bagian</div></td>
					<td style="border-bottom: 1px solid #000; font-size:11px;"><div>:</div></td>
					<td style="border-bottom: 1px solid #000; font-size:11px; border-right:  1px solid #000;"><div></div></td>
					<td style="border-bottom: 1px solid #000; font-size:11px;"><div style="margin-left:5px;">Lembur pada hari/tanggal</div></td>
					<td style="border-bottom: 1px solid #000; font-size:11px;"><div>:</div></td>
					<td style="border-bottom: 1px solid #000; font-size:11px;">&nbsp;</td>
				</tr>
				<tr style="line-height: 12px;">
					<td style="font-size:11px;"><div style="margin-left:5px;">Uraian Tugas Lembur</div></td>
					<td style="font-size:11px;"><div>:</div></td>
					<td style="font-size:11px;" colspan="4"><div><?=ucwords(strtolower($model->PEKERJAAN_LEMBUR))?></div></td>
				</tr>
				<tr style="line-height: 12px;">
					<td style="font-size:11px;"><div style="margin-left:5px;">Alamat / Lokasi</div></td>
					<td style="font-size:11px;"><div>:</div></td>
					<td style="font-size:11px;" colspan="4"><div><?=!empty($model->ALAMAT)?ucwords(strtolower($model->ALAMAT)):null?></div></td>
				</tr>
				<tr style="line-height: 12px;">
					<td style="font-size:11px;" colspan="6">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<table class="table-borderles " style="width:100%; border-top: 3px double #000; border-right: 3px double #000; border-left: 3px double #000; border-collapse: collapse;">
			<tbody>
				<tr style="line-height: 12px; border: 1px solid #000;">
					<td colspan="8" style="border: 1px solid #000;"><div style="margin-left:5px;">Diperintahkan  Kepada :</div></>
				</tr>
				<tr style="line-height: 15px; text-align:center; border: 1px solid #000;">
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" rowspan="2">No</td>
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" rowspan="2">No. Induk</td>
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" rowspan="2">NAMA</td>
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" rowspan="2">Jabatan</td>
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" colspan="2">Jam Lembur</td>
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" rowspan="2">Jumlah Jam</td>
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" rowspan="2">Paraf</td>
				</tr>
				<tr style="line-height: 12px; text-align:center; border: 1px solid #000;">
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" >Mulai</td>
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" >Selesai</td>
				</tr>
				<tr style="line-height: 12px;">
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" ><div style="margin-left:5px; text-align:center; ">1.</div></td>
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" ><div style="margin-left:5px; "><?=$model->NO_INDUK?></div></td>
					<td style="border: 1px solid #000; text-align:left; font-size:11px;" ><div style="margin-left:5px; "><?=$model->NAMA?></div></td>
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" ><div style="margin-left:5px; "><?=$model->JABATAN?></div></td>
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" ><div style="margin-left:5px; text-align:center;"><?=$jamAwal?></div></td>
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" ><div style="margin-left:5px; text-align:center;"><?=$jamAkhir?></div></td>
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" ><div style="margin-left:5px; text-align:center;"><?=$model->JUMLAH_JAM?></div></td>
					<td style="border: 1px solid #000; text-align:center; font-size:11px;" >&nbsp;</td>
				</tr>
			</tbody>
		</table>
    </div>

</div>