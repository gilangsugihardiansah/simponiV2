<?php
    use app\models\SppdDetailSearch;

    // print_r($dataProvider->getModels());die;
    // print_r($tgl);die;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Rekap Perjalanan Dinas</title>
</head>

<body style="border: 0.1pt solid #ccc"> 
    <?php
    foreach ($dataProvider->getModels() as $key => $value):
        $searchModelDetail= new SppdDetailSearch();
        $searchModelDetail->NO_INDUK=$value->NO_INDUK;
        $searchModelDetail->TGL=$searchModel->PERIODE;
        $searchModelDetail->PENEMPATAN=$searchModel->PENEMPATAN;
        $dataProviderDetail = $searchModelDetail->search(Yii::$app->request->queryParams);
        echo $this->renderAjax('template-perorang', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelDetail' => $searchModelDetail,
            'dataProviderDetail' => $dataProviderDetail,
            'tgl' => $tgl,
            'nama' =>$value->NAMA,
            'penempatan' =>$value->PENEMPATAN,
            'jabatan' =>$value->JABATAN,
            // 'tglAwal'=>$tglAwal,
            // 'tglAkhir'=>$tglAkhir
        ]);
        echo '<br>';
    endforeach;
    ?>
</body>
</html>