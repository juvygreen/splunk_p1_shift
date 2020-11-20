<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'libs/jqueryui/ui-lightness/jquery-ui-1.10.4.custom.min.css',
        'libs/font-awesome/css/font-awesome.min.css',
        'libs/fontello/css/fontello.css',
        'libs/animate-css/animate.min.css',
        'libs/nifty-modal/css/component.css',
        'libs/magnific-popup/magnific-popup.css',
        'libs/ios7-switch/ios7-switch.css',
        'libs/pace/pace.css',
        'libs/sortable/sortable-theme-bootstrap.css',
        'libs/bootstrap-datepicker/css/datepicker.css',
        'libs/jquery-icheck/skins/all.css',
        'libs/jquery-notifyjs/styles/metro/notify-metro.css',
        'libs/prettify/github.css',
        'css/style.css',
        'css/style-responsive.css',
    ];
    public $js = [
        'libs/jquery/jquery-1.11.1.min.js',
        'libs/bootstrap/js/bootstrap.min.js',
        'libs/jqueryui/jquery-ui-1.10.4.custom.min.js',
        'libs/jquery-ui-touch/jquery.ui.touch-punch.min.js',
        'libs/jquery-detectmobile/detect.js',
        'libs/jquery-animate-numbers/jquery.animateNumbers.js',
        'libs/ios7-switch/ios7.switch.js',
        'libs/fastclick/fastclick.js',
        'libs/jquery-blockui/jquery.blockUI.js',
        'libs/bootstrap-bootbox/bootbox.min.js',
        'libs/jquery-slimscroll/jquery.slimscroll.js',
        'libs/jquery-sparkline/jquery-sparkline.js',
        'libs/nifty-modal/js/classie.js',
        'libs/nifty-modal/js/modalEffects.js',
        'libs/sortable/sortable.min.js',
        'libs/bootstrap-fileinput/bootstrap.file-input.js',
        'libs/bootstrap-select/bootstrap-select.min.js',
        'libs/bootstrap-select2/select2.min.js',
        'libs/magnific-popup/jquery.magnific-popup.min.js',
        'libs/pace/pace.min.js',
        'libs/jquery-notifyjs/notify.min.js',
        'libs/jquery-notifyjs/styles/metro/notify-metro.js',
        'libs/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'libs/jquery-icheck/icheck.min.js',
        //'js/apps/chat.js',
        'libs/prettify/prettify.js',
        'libs/jquery-icheck/icheck.min.js',
        'js/init.js',
        'libs/jquery-datatables/js/jquery.dataTables.min.js',
        'libs/jquery-datatables/js/dataTables.bootstrap.js',
        'libs/jquery-datatables/extensions/TableTools/js/dataTables.tableTools.min.js',
        'js/pages/datatables.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
