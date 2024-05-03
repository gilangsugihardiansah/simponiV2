<?php
use yii\helpers\Html;
use app\models\PegawaiSearch;
use app\models\SppdSearch;

$pegawai = new PegawaiSearch();
$countPeg = $pegawai->search(Yii::$app->request->queryParams)->getTotalCount();

$sppd = new SppdSearch();
$sppd->TGL_PENGAJUAN = date('Y-m-01 - Y-m-t');
$countSpd = $sppd->search(Yii::$app->request->queryParams)->getTotalCount();

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
	</div>
</div>
