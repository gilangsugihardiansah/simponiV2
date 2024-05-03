<?php
use yii\helpers\Html;
use app\models\PegawaiSearch;
use app\models\LemburSearch;

$pegawai = new PegawaiSearch();
$countPeg = $pegawai->search(Yii::$app->request->queryParams)->getTotalCount();

$lembur = new LemburSearch();
$countLembur = $lembur->search(Yii::$app->request->queryParams)->getTotalCount();

$lemburPengajuan = new LemburSearch();
$lemburPengajuan->STATUS_PENGAJUAN = "Pengajuan";
$lemburPengajuan->APP = "APP";
$countLemburPengajuan = $lemburPengajuan->search(Yii::$app->request->queryParams)->getTotalCount();

$lemburUpload = new LemburSearch();
$lemburUpload->STATUS_PENGAJUAN = "Menunggu Upload Realisasi";
$countLemburUpload = $lemburUpload->search(Yii::$app->request->queryParams)->getTotalCount();

$lemburDitolak = new LemburSearch();
$lemburDitolak->STATUS_PENGAJUAN = "Ditolak";
$countLemburDitolak = $lemburDitolak->search(Yii::$app->request->queryParams)->getTotalCount();

$lemburDisetujui = new LemburSearch();
$lemburDisetujui->STATUS_PENGAJUAN = "Selesai";
$countLemburDisetujui = $lemburDisetujui->search(Yii::$app->request->queryParams)->getTotalCount();

?>
<div class="site-index">
	<h2 style="text-align: left; font-size: 3.5rem; font-weight: 700; margin: 20px 0 10px; padding: 0; white-space: nowrap; color:#222D32;"><i class="fa fa-area-chart"></i> DASHBOARD AMANDA </h2>
	<br/>
	<div class="row">
		<div class="col-md-4 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-biru">
				<div class="inner">
					<h3>
                        <?=$countPeg?>
					</h3>
					<p>
						Tenaga Kerja
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="raphael:users"></span> 
				</div>
				<a href="/web/pegawai/index.html" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-4 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-biru">
				<div class="inner">
					<h3>
                        <?=$countLembur?>
					</h3>
					<p>
						Lembur
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="healthicons:travel-alt"></span>
				</div>
				<a href="/web/lembur/index.html" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-4 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-kuning">
				<div class="inner">
					<h3>
                        <?=$countLemburPengajuan?>
					</h3>
					<p>
					    lembur (Pengajuan)
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="material-symbols:approval-delegation"></span>
				</div>
				<a href="/web/lembur/index-app.html" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-4 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-kuning">
				<div class="inner">
					<h3>
                        <?=$countLemburUpload?>
					</h3>
					<p>
					    lembur (Menunggu Upload)
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="material-symbols:upload"></span>
				</div>
				<a href="/web/lembur/index.html?LemburSearch[CREATED_AT]=<?=date('Y-m-01 - Y-m-d')?>&LemburSearch[STATUS_PENGAJUAN]=Menunggu Upload Realisasi" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-4 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-merah">
				<div class="inner">
					<h3>
                        <?=$countLemburDitolak?>
					</h3>
					<p>
					    lembur (Ditolak)
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="icon-park-outline:reject"></span>
				</div>
				<a href="/web/lembur/index.html?LemburSearch[CREATED_AT]=<?=date('Y-m-01 - Y-m-d')?>&LemburSearch[STATUS_PENGAJUAN]=Ditolak" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-4 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-hijau">
				<div class="inner">
					<h3>
                        <?=$countLemburDisetujui?>
					</h3>
					<p>
					    lembur (Selesai)
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="material-symbols:order-approve-outline-sharp"></span>
				</div>
				<a href="/web/lembur/index.html?LemburSearch[CREATED_AT]=<?=date('Y-m-01 - Y-m-d')?>&LemburSearch[STATUS_PENGAJUAN]=Selesai" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
</div>
