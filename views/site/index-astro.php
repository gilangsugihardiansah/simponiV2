<?php
use yii\helpers\Html;
use app\models\PegawaiSearch;
use app\models\AstroReimburseSearch;

$pegawai = new PegawaiSearch();
$countPeg = $pegawai->search(Yii::$app->request->queryParams)->getTotalCount();

$sppdPengajuan = new AstroReimburseSearch();
$sppdPengajuan->CREATED_AT = date('Y-m-01 - Y-m-t');
$sppdPengajuan->STATUS_PENGAJUAN = "0";
$countPengajuan = $sppdPengajuan->search(Yii::$app->request->queryParams)->getTotalCount();

$sppdDisetujui = new AstroReimburseSearch();
$sppdDisetujui->CREATED_AT = date('Y-m-01 - Y-m-t');
$sppdDisetujui->STATUS_PENGAJUAN = "1";
$countDisetujui = $sppdDisetujui->search(Yii::$app->request->queryParams)->getTotalCount();

$sppdDitolak = new AstroReimburseSearch();
$sppdDitolak->CREATED_AT = date('Y-m-01 - Y-m-t');
$sppdDitolak->STATUS_PENGAJUAN = "2";
$countDitolak = $sppdDitolak->search(Yii::$app->request->queryParams)->getTotalCount();

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
                        <?=$countPengajuan?>
					</h3>
					<p>
					Reimburse (Pengajuan)
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="material-symbols:approval-delegation"></span>
				</div>
				<a href="/web/astro-reimburse/index-app.html" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-hijau">
				<div class="inner">
					<h3>
                        <?=$countDisetujui?>
					</h3>
					<p>
					Reimburse (Disetujui)
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="material-symbols:order-approve-outline-sharp"></span>
				</div>
				<a href="/web/astro-reimburse/index.html?AstroReimburseSearch[CREATED_AT]=<?=date('Y-m-01 - Y-m-d')?>&AstroReimburseSearch[STATUS_PENGAJUAN]=1" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-merah">
				<div class="inner">
					<h3>
                        <?=$countDitolak?>
					</h3>
					<p>
					Reimburse (Ditolak)
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="material-symbols:order-approve-outline-sharp"></span>
				</div>
				<a href="/web/astro-reimburse/index.html?AstroReimburseSearch[CREATED_AT]=<?=date('Y-m-01 - Y-m-d')?>&AstroReimburseSearch[STATUS_PENGAJUAN]=2" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
</div>
