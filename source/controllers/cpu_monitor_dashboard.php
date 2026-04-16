<?php

class Cpu_monitor_Dashboard extends ClearOS_Controller
{
    function index()
    {
        $this->lang->load('cpu_monitor');

        $cores = (int) shell_exec("nproc");
        $cpu_model = trim(shell_exec("cat /proc/cpuinfo | grep 'model name' | head -n 1 | cut -d ':' -f2"));

        $data = array(
            'cores' => $cores,
            'cpu_model' => $cpu_model,
        );

        $this->page->view_form('cpu_monitor/dashboard/cpu_monitor', $data, lang('cpu_monitor_app_name'));
    }
}