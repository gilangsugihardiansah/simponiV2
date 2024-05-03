<?php

namespace app\components;

use Yii;
use Yii\base\Component;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\helpers\Url; 
use app\modules\hpi\models\LogAplikasi;
use miloschuman\highcharts\Highcharts;


/**
* 
*/
class MyComponent extends Component
{
    public function checkloginwith()
    {

        //Detect special conditions devices
        $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
        $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
        $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

        //do something with this information
        if( $iPod || $iPhone ):
            return 'IOS';
        elseif($iPad):
            return 'iPad';
        elseif($Android):
            return 'Android';
        elseif($webOS):
            return 'WebOS';
        else:
            return 'WEB BROWSER';
        endif;
    }

}

?>