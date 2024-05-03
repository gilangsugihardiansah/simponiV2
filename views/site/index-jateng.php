<?php
use yii\helpers\Html;
use app\models\PegawaiSearch;
use app\models\SppdSearch;

$pegawai = new PegawaiSearch();
$countPeg = $pegawai->search(Yii::$app->request->queryParams)->getTotalCount();

$sppdPengajuan = new SppdSearch();
$sppdPengajuan->TGL_PENGAJUAN = date('Y-m-01 - Y-m-t');
$sppdPengajuan->STATUS_PENGAJUAN = "Pengajuan";
$countsppdPengajuan = $sppdPengajuan->search(Yii::$app->request->queryParams)->getTotalCount();

$sppdDikonfirmasi = new SppdSearch();
$sppdDikonfirmasi->TGL_PENGAJUAN = date('Y-m-01 - Y-m-t');
$sppdDikonfirmasi->STATUS_PENGAJUAN = "Dikonfirmasi";
$countsppdDikonfirmasi = $sppdDikonfirmasi->search(Yii::$app->request->queryParams)->getTotalCount();

$sppdDitolak = new SppdSearch();
$sppdDitolak->TGL_PENGAJUAN = date('Y-m-01 - Y-m-t');
$sppdDitolak->STATUS_PENGAJUAN = "Ditolak";
$countsppdDitolak = $sppdDitolak->search(Yii::$app->request->queryParams)->getTotalCount();

?>
<div class="site-index">
	<h2 style="text-align: left; font-size: 3.5rem; font-weight: 700; margin: 20px 0 10px; padding: 0; white-space: nowrap; color:#222D32;"><i class="fa fa-area-chart"></i> DASHBOARD AMANDA <?= date('F Y'); ?></h2>
	<br/>
	<div class="row">
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
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
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-kuning">
				<div class="inner">
					<h3>
                        <?=$countsppdPengajuan?>
					</h3>
					<p>
						SPPD (Pengajuan)
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="healthicons:travel-alt"></span>
				</div>
				<a href="/web/sppd/index-app.html?SppdSearch[TGL_PENGAJUAN]=<?=date('Y-m-01 - Y-m-d')?>" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-hijau">
				<div class="inner">
					<h3>
                        <?=$countsppdDikonfirmasi?>
					</h3>
					<p>
						SPPD (Konfirmasi)
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="material-symbols:approval-delegation"></span>
				</div>
				<a href="/web/sppd/index.html?SppdSearch[TGL_PENGAJUAN]=<?=date('Y-m-01 - Y-m-d')?>&SppdSearch[STATUS_PENGAJUAN]=Dikonfirmasi" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-merah">
				<div class="inner">
					<h3>
                        <?=$countsppdDitolak?>
					</h3>
					<p>
						SPPD (Ditolak)
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="icon-park-outline:reject"></span>
				</div>
				<a href="/web/sppd/index.html?SppdSearch[TGL_PENGAJUAN]=<?=date('Y-m-01 - Y-m-d')?>&SppdSearch[STATUS_PENGAJUAN]=Ditolak" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
</div>
