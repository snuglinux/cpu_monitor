<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'cpu_monitor';
$app['version'] = '0.0.2';
$app['vendor'] = 'Pro777';
$app['packager'] = 'Pro777';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('cpu_monitor_description');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('cpu_monitor_app_name');
$app['category'] = lang('base_category_reports');
$app['subcategory'] = lang('base_subcategory_performance_and_resources');

/////////////////////////////////////////////////////////////////////////////
// Dashboard Widgets
/////////////////////////////////////////////////////////////////////////////

$app['dashboard_widgets'] = array(
    $app['category'] => array(
        'cpu_monitor/cpu_monitor_dashboard' => array(
            'title' => lang('cpu_monitor_app_name'),
            'restricted' => FALSE,
        )
    )
);