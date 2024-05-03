<?php

use yii\helpers\Url; 

?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/files/default/user.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->NAMA?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    [
                        'label' => 'Menu Aplikasi', 
                        'options' => ['class' => 'header']
                    ],
                    [
                        'label' => 'Beranda', 
                        'icon' => 'home', 
                        'visible'=> !isset(Yii::$app->user->identity->accessToken),
                        'url' => ['/site/index']
                    ],
                    [
                        'label' => 'Tenaga Kerja', 
                        'icon' => 'users', 
                        'visible'=> !isset(Yii::$app->user->identity->accessToken),
                        'url' => ['/pegawai/index']
                    ],
                    [
                        'label' => 'SPPD', 
                        'icon' => 'plane', 
                        'visible'=> Yii::$app->user->identity->COMPANY == "JATENG", 
                        'items' => [
                            [
                                'label' => 'Data SPPD', 
                                'url' => ['/sppd/index'],
                            ],
                            [
                                'label' => 'Data Pengajuan', 
                                'url' => ['/sppd/index-app'],
                            ],
                            [
                                'label' => 'Data Rekap', 
                                'url' => ['/sppd/index-report'],
                            ],
                        ],
                    ],
                    [
                        'label' => 'SPPD', 
                        'icon' => 'plane', 
                        'visible'=> Yii::$app->user->identity->COMPANY == "PUSHARLIS", 
                        'items' => [
                            [
                                'label' => 'Data SPPD', 
                                'url' => ['/pusharlis-sppd/index'],
                            ],
                            [
                                'label' => 'Data Pengajuan', 
                                'url' => ['/pusharlis-sppd/index-app'],
                                // 'visible'=>(Yii::$app->user->identity->JENIS == "10" || Yii::$app->user->identity->JENIS == "11")
                            ],
                            // [
                            //     'label' => 'Data Rekap', 
                            //     'url' => ['/pusharlis-sppd/index-report'],
                            // ],
                        ],
                    ],
                    [
                        'label' => 'SPPD', 
                        'icon' => 'plane', 
                        'visible'=> Yii::$app->user->identity->COMPANY == "PLN E", 
                        'items' => [
                            [
                                'label' => 'Data SPPD', 
                                'url' => ['/pln-e-sppd/index'],
                            ],
                            [
                                'label' => 'Data Pengajuan', 
                                'url' => ['/pln-e-sppd/index-app'],
                                // 'visible'=>(Yii::$app->user->identity->JENIS == "10" || Yii::$app->user->identity->JENIS == "11")
                            ],
                            [
                                'label' => 'Data Rekap', 
                                'url' => ['/pln-e-sppd/index-report'],
                                'visible'=>(Yii::$app->user->identity->JENIS == "12" || Yii::$app->user->identity->JENIS == "14")
                            ],
                        ],
                    ],
                    [
                        'label' => 'Lembur', 
                        'icon' => 'clock-o', 
                        'visible'=> Yii::$app->user->identity->COMPANY == "PUSHARLIS", 
                        'items' => [
                            [
                                'label' => 'Data Lembur', 
                                'url' => ['/pusharlis-lembur/index'],
                            ],
                            [
                                'label' => 'Data Pengajuan', 
                                'url' => ['/pusharlis-lembur/index-app'],
                            ],
                        ],
                    ],
                    [
                        'label' => 'Reimburse', 
                        'icon' => 'refresh', 
                        'visible'=> Yii::$app->user->identity->COMPANY == "ASTRO", 
                        'items' => [
                            [
                                'label' => 'Data Reimburse', 
                                'url' => ['/astro-reimburse/index'],
                            ],
                            [
                                'label' => 'Data Pengajuan', 
                                'url' => ['/astro-reimburse/index-app'],
                            ],
                        ],
                    ],
                    [
                        'label' => 'Lembur', 
                        'icon' => 'clock-o', 
                        'visible'=> Yii::$app->user->identity->COMPANY == "HP", 
                        'items' => [
                            [
                                'label' => 'Data Lembur', 
                                'url' => ['/lembur/index'],
                            ],
                            [
                                'label' => 'Data Pengajuan', 
                                'url' => ['/lembur/index-app'],
                            ],
                        ],
                    ],
                    [
                        'label' => 'Data Master', 
                        'icon' => 'cog',
                        'visible'=> (Yii::$app->user->identity->JENIS == "1" OR Yii::$app->user->identity->JENIS == "2" OR Yii::$app->user->identity->JENIS == "4" OR Yii::$app->user->identity->JENIS == "6" OR Yii::$app->user->identity->JENIS == "12" OR Yii::$app->user->identity->JENIS == "14"), 
                        'items' => [
                            [
                                'label' => 'Admin Aplikasi',
                                'url' => ['/admin/index'],
                                'visible'=> (Yii::$app->user->identity->JENIS == "1"), 
                            ],
                            [
                                'label' => 'Jenis User', 
                                'url' => ['/jenis-user/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "1", 
                            ],
                            [
                                'label' => 'Unit PLN', 
                                'url' => ['/unit-pln/index'],
                                'visible'=> (Yii::$app->user->identity->JENIS == "1" OR Yii::$app->user->identity->JENIS == "2" OR Yii::$app->user->identity->JENIS == "4" OR Yii::$app->user->identity->JENIS == "6"), 
                            ],
                            [
                                'label' => 'Tarif SPPD', 
                                'url' => ['/tarif-sppd/index'],
                                'visible'=> (Yii::$app->user->identity->JENIS == "1" OR Yii::$app->user->identity->JENIS == "2" OR Yii::$app->user->identity->JENIS == "4" OR Yii::$app->user->identity->JENIS == "6"), 
                            ],
                            [
                                'label' => 'Detail Tarif', 
                                'url' => ['/tarif-detail/index'],
                                'visible'=> (Yii::$app->user->identity->JENIS == "1" OR Yii::$app->user->identity->JENIS == "2" OR Yii::$app->user->identity->JENIS == "4" OR Yii::$app->user->identity->JENIS == "6"), 
                            ],
                            [
                                'label' => 'VP',
                                'url' => ['/pln-e-vp/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "12" OR Yii::$app->user->identity->JENIS == "14", 
                            ],
                            [
                                'label' => 'MSB',
                                'url' => ['/pln-e-msb/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "12" OR Yii::$app->user->identity->JENIS == "14", 
                            ],
                            [
                                'label' => 'Charge Code',
                                'url' => ['/pln-e-charge-code/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "12" OR Yii::$app->user->identity->JENIS == "14", 
                            ],
                            [
                                'label' => 'Tarif SPPD', 
                                'visible'=> Yii::$app->user->identity->JENIS == "12" OR Yii::$app->user->identity->JENIS == "14", 
                                'items' => [
                                    [
                                        'label' => 'Nasional', 
                                        'url' => ['/pln-e-tarif-sppd/index'],
                                        'visible'=> Yii::$app->user->identity->JENIS == "12" OR Yii::$app->user->identity->JENIS == "14", 
                                    ],
                                    [
                                        'label' => 'Internasional', 
                                        'url' => ['/pln-e-tarif-sppd-inter/index'],
                                        'visible'=> Yii::$app->user->identity->JENIS == "12" OR Yii::$app->user->identity->JENIS == "14", 
                                    ],
                                ],
                            ],
                            [
                                'label' => 'Tarif Lumpsum',
                                'url' => ['/pln-e-lumpsum/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "12" OR Yii::$app->user->identity->JENIS == "14", 
                            ],
                            [
                                'label' => 'Region',
                                'url' => ['/pln-e-region/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "12" OR Yii::$app->user->identity->JENIS == "14", 
                            ],
                            [
                                'label' => 'Negara',
                                'url' => ['/pln-e-negara/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "12" OR Yii::$app->user->identity->JENIS == "14", 
                            ],
                            [
                                'label' => 'No. WhatsApp',
                                'url' => ['/pln-e-d-val/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "12" OR Yii::$app->user->identity->JENIS == "14", 
                            ],
                                
                        ],
                    ],
                    [
                        'label' => 'Data Master PLN E', 
                        'icon' => 'cog',
                        'visible'=> (Yii::$app->user->identity->JENIS == "1"), 
                        'items' => [
                            [
                                'label' => 'VP',
                                'url' => ['/pln-e-vp/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "1", 
                            ],
                            [
                                'label' => 'MSB',
                                'url' => ['/pln-e-msb/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "1", 
                            ],
                            [
                                'label' => 'Charge Code',
                                'url' => ['/pln-e-charge-code/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "1", 
                            ],
                            [
                                'label' => 'Tarif SPPD', 
                                'visible'=> Yii::$app->user->identity->JENIS == "1", 
                                'items' => [
                                    [
                                        'label' => 'Nasional', 
                                        'url' => ['/pln-e-tarif-sppd/index'],
                                        'visible'=> Yii::$app->user->identity->JENIS == "1", 
                                    ],
                                    [
                                        'label' => 'Internasional', 
                                        'url' => ['/pln-e-tarif-sppd-inter/index'],
                                        'visible'=> Yii::$app->user->identity->JENIS == "1", 
                                    ],
                                ],
                            ],
                            [
                                'label' => 'Tarif Lumpsum',
                                'url' => ['/pln-e-lumpsum/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "1", 
                            ],
                            [
                                'label' => 'Region',
                                'url' => ['/pln-e-region/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "1", 
                            ],
                            [
                                'label' => 'Negara',
                                'url' => ['/pln-e-negara/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "1", 
                            ],
                            [
                                'label' => 'No. WhatsApp',
                                'url' => ['/pln-e-d-val/index'],
                                'visible'=> Yii::$app->user->identity->JENIS == "1", 
                            ],
                                
                        ],
                    ],
                    [
                        'label' => 'Option', 
                        'icon' => 'cog', 
                        'visible'=> isset(Yii::$app->user->identity->accessToken) OR (yii::$app->session['creator'] == "creator"),
                        'url' => ['/site/creator']
                    ],
                    [
                        'label' => 'Logout', 
                        'icon' => 'sign-out', 
                        'url' => ['/site/logout'], 
                        'template'=>'<a href="{url}" data-method="post">{icon}{label}</a>'
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
