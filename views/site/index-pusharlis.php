<?php
use yii\helpers\Html;
use app\models\PegawaiSearch;
use app\models\PusharlisSppdSearch;
use app\models\PusharlisLemburSearch;

//pegawai
$pegawai = new PegawaiSearch();
$countPeg = $pegawai->search(Yii::$app->request->queryParams)->getTotalCount();

//SPPD
$sppdPengajuan = new PusharlisSppdSearch();
$sppdPengajuan->CREATED_AT = date('Y-m-01 - Y-m-t');
$sppdPengajuan->STATUS_PENGAJUAN = "1";
$countSppdPengajuan = $sppdPengajuan->search(Yii::$app->request->queryParams)->getTotalCount();

$sppdRekomendasi = new PusharlisSppdSearch();
$sppdRekomendasi->CREATED_AT = date('Y-m-01 - Y-m-t');
$sppdRekomendasi->STATUS_PENGAJUAN = "2";
$countSppdRekomendasi = $sppdRekomendasi->search(Yii::$app->request->queryParams)->getTotalCount();

$sppdDisetujui = new PusharlisSppdSearch();
$sppdDisetujui->CREATED_AT = date('Y-m-01 - Y-m-t');
$sppdDisetujui->STATUS_PENGAJUAN = "3";
$countSppdDisetujui = $sppdDisetujui->search(Yii::$app->request->queryParams)->getTotalCount();

$sppdDitolak = new PusharlisSppdSearch();
$sppdDitolak->CREATED_AT = date('Y-m-01 - Y-m-t');
$sppdDitolak->STATUS_PENGAJUAN = "4";
$countSppdDitolak = $sppdDitolak->search(Yii::$app->request->queryParams)->getTotalCount();

$linkSppdPengajuan = "/web/pusharlis-sppd/index.html?PusharlisSppdSearch[CREATED_AT]=".date('Y-m-01 - Y-m-d')."&PusharlisSppdSearch[STATUS_PENGAJUAN]=1";
$linkSppdRekomendasi = "/web/pusharlis-sppd/index.html?PusharlisSppdSearch[CREATED_AT]=".date('Y-m-01 - Y-m-d')."&PusharlisSppdSearch[STATUS_PENGAJUAN]=2";
if(Yii::$app->user->identity->JENIS == "11"):
	$linkSppdPengajuan = "/web/pusharlis-sppd/index-app.html?PusharlisSppdSearch[CREATED_AT]=".date('Y-m-01 - Y-m-d');
elseif(Yii::$app->user->identity->JENIS == "10"):
	$linkSppdRekomendasi = "/web/pusharlis-sppd/index-app.html?PusharlisSppdSearch[CREATED_AT]=".date('Y-m-01 - Y-m-d');
endif;

//Lembur
$lemburPengajuan = new PusharlisLemburSearch();
$lemburPengajuan->CREATED_AT = date('Y-m-01 - Y-m-t');
$lemburPengajuan->STATUS_PENGAJUAN = "2";
$countLemburPengajuan = $lemburPengajuan->search(Yii::$app->request->queryParams)->getTotalCount();

$lemburRekomendasi = new PusharlisLemburSearch();
$lemburRekomendasi->CREATED_AT = date('Y-m-01 - Y-m-t');
$lemburRekomendasi->STATUS_PENGAJUAN = "3";
$countLemburRekomendasi = $lemburRekomendasi->search(Yii::$app->request->queryParams)->getTotalCount();

$lemburDisetujui = new PusharlisLemburSearch();
$lemburDisetujui->CREATED_AT = date('Y-m-01 - Y-m-t');
$lemburDisetujui->STATUS_PENGAJUAN = "4";
$countLemburDisetujui = $lemburDisetujui->search(Yii::$app->request->queryParams)->getTotalCount();

$lemburDitolak = new PusharlisLemburSearch();
$lemburDitolak->CREATED_AT = date('Y-m-01 - Y-m-t');
$lemburDitolak->STATUS_PENGAJUAN = "5";
$countLemburDitolak = $lemburDitolak->search(Yii::$app->request->queryParams)->getTotalCount();

$linkLemburPengajuan = "/web/pusharlis-lembur/index.html?PusharlisLemburSearch[CREATED_AT]=".date('Y-m-01 - Y-m-d')."&PusharlisLemburSearch[STATUS_PENGAJUAN]=2";
$linkLemburRekomendasi = "/web/pusharlis-lembur/index.html?PusharlisLemburSearch[CREATED_AT]=".date('Y-m-01 - Y-m-d')."&PusharlisLemburSearch[STATUS_PENGAJUAN]=3";
if(Yii::$app->user->identity->JENIS == "11"):
	$linkLemburPengajuan = "/web/pusharlis-lembur/index-app.html?PusharlisLemburSearch[CREATED_AT]=".date('Y-m-01 - Y-m-d');
elseif(Yii::$app->user->identity->JENIS == "10"):
	$linkLemburRekomendasi = "/web/pusharlis-lembur/index-app.html?PusharlisLemburSearch[CREATED_AT]=".date('Y-m-01 - Y-m-d');
endif;

?>
<div class="site-index">
	<h2 style="text-align: left; font-size: 3.5rem; font-weight: 700; margin: 20px 0 10px; padding: 0; white-space: nowrap; color:#222D32;"><i class="fa fa-area-chart"></i> Dashboard Periode <?= date('F Y'); ?></h2>
	<h3 style="text-align: left; font-weight: 700; margin: 20px 0 10px; padding: 0; white-space: nowrap; color:#222D32;"><span class="iconify" data-icon="raphael:users"></span> Tenaga Kerja</h3>
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
					<span class="iconify" data-icon="mdi:user-badge-outline"></span> 
				</div>
				<a href="/web/pegawai/index.html" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
	<h3 style="text-align: left; font-weight: 700; margin: 0px 0 10px; padding: 0; white-space: nowrap; color:#222D32;"><span class="iconify" data-icon="mdi:car-traction-control"></span> Perjalanan Dinas</h3>
	<div class="row">
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-biru">
				<div class="inner">
					<h3>
                        <?=$countSppdPengajuan?>
					</h3>
					<p>
						Pengajuan
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="mdi:comment-plus-outline"></span>
				</div>
				<a href="<?=$linkSppdPengajuan?>" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-biru-tua">
				<div class="inner">
					<h3>
                        <?=$countSppdRekomendasi?>
					</h3>
					<p>
						Rekomendasi
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="mdi:comment-alert-outline"></span>
				</div>
				<a href="<?=$linkSppdRekomendasi?>" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-hijau">
				<div class="inner">
					<h3>
                        <?=$countSppdDisetujui?>
					</h3>
					<p>
						Disetujui
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="mdi:comment-check-outline"></span>
				</div>
				<a href="/web/pusharlis-sppd/index.html?PusharlisSppdSearch[CREATED_AT]=<?=date('Y-m-01 - Y-m-d')?>&PusharlisSppdSearch[STATUS_PENGAJUAN]=3" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-merah">
				<div class="inner">
					<h3>
                        <?=$countSppdDitolak?>
					</h3>
					<p>
						Ditolak
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="mdi:comment-remove-outline"></span>
				</div>
				<a href="/web/pusharlis-sppd/index.html?PusharlisSppdSearch[CREATED_AT]=<?=date('Y-m-01 - Y-m-d')?>&PusharlisSppdSearch[STATUS_PENGAJUAN]=4" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
	<h3 style="text-align: left; font-weight: 700; margin: 0px 0 10px; padding: 0; white-space: nowrap; color:#222D32;"><span class="iconify" data-icon="fluent-mdl2:date-time-2"></span> Overtime</h3>
	<div class="row">
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-biru">
				<div class="inner">
					<h3>
                        <?=$countLemburPengajuan?>
					</h3>
					<p>
						Pengajuan
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="mdi:comment-plus-outline"></span>
				</div>
				<a href="<?=$linkLemburPengajuan?>" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-biru-tua">
				<div class="inner">
					<h3>
                        <?=$countLemburRekomendasi?>
					</h3>
					<p>
						Rekomendasi
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="mdi:comment-alert-outline"></span>
				</div>
				<a href="<?=$linkLemburRekomendasi?>" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-hijau">
				<div class="inner">
					<h3>
                        <?=$countLemburDisetujui?>
					</h3>
					<p>
						Disetujui
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="mdi:comment-check-outline"></span>
				</div>
				<a href="/web/pusharlis-lembur/index.html?PusharlisLemburSearch[CREATED_AT]=<?=date('Y-m-01 - Y-m-d')?>&PusharlisLemburSearch[STATUS_PENGAJUAN]=4" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-md-3 col-xs-6" style="margin-bottom:10px;">
			<div class="my-small-box bg-merah">
				<div class="inner">
					<h3>
                        <?=$countLemburDitolak?>
					</h3>
					<p>
						Ditolak
					</p>
				</div>
				<div class="icon">
					<span class="iconify" data-icon="mdi:comment-remove-outline"></span>
				</div>
				<a href="/web/pusharlis-lembur/index.html?PusharlisLemburSearch[CREATED_AT]=<?=date('Y-m-01 - Y-m-d')?>&PusharlisLemburSearch[STATUS_PENGAJUAN]=5" target="_blank" class="my-small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
</div>
