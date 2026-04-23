<?php

$this->lang->load('cpu_monitor');

$options['action'] = button_set(
    array(anchor_custom('/app/cpu_monitor', lang('base_view')))
);

echo chart_container(lang('cpu_monitor_app_name'), 'cpu_monitor_dashboard', $options);

echo "
<script>
var lang_cpu_usage_cpu_monitor = '" . lang("cpu_monitor_total_cpu_usage") . "';
var lang_cpu_temp_cpu_monitor = '" . lang("cpu_monitor_cpu_temperature") . "';
var lang_loading_cpu_monitor = '" . lang("cpu_monitor_loading") . "';
var lang_no_info_cpu_monitor = '" . lang("cpu_monitor_no_information_found") . "';
</script>
";