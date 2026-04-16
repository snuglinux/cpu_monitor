<?php

class Cpu_monitor extends ClearOS_Controller
{
    function index() {
        $this->lang->load('cpu_monitor');

        $cores = (int) shell_exec("nproc");
	$cpu_model = trim(shell_exec("cat /proc/cpuinfo | grep 'model name' | head -n 1 | cut -d ':' -f2"));

        $data = [
            'cores' => $cores,
	    'cpu_model' => $cpu_model
        ];

        $this->page->view_form('cpu_monitor', $data, lang('cpu_monitor_app_name'));
    }

    private function readProcStat() {
        $lines = @file('/proc/stat');
        $cpus = [];

        foreach ($lines as $line) {
            if (preg_match('/^(cpu\d* )/', $line)) {
                $parts = preg_split('/\s+/', trim($line));
                $label = array_shift($parts);
                $total = array_sum($parts);
                $idle = (int)$parts[3];
                $cpus[$label] = [$total, $idle];
            }
        }

        return $cpus;
    }

    function stats() {
        header('Content-Type: application/json; charset=utf-8');

        $before = $this->readProcStat();

        usleep(500000); // 0.5 секунди

        $after = $this->readProcStat();

        $result = [];

        foreach ($after as $label => $vals2) {
            if (!isset($before[$label])) {
                continue;
            }
            list($total2, $idle2) = $vals2;
            list($total1, $idle1) = $before[$label];

            $totalDiff = $total2 - $total1;
            $idleDiff  = $idle2 - $idle1;

            if ($totalDiff > 0) {
                $usage = (1 - ($idleDiff / $totalDiff)) * 100;
            } else {
                $usage = 0;
            }

            $result[$label] = round($usage, 2);
        }

        $percentTotal = isset($result['cpu']) ? $result['cpu'] : 0;
        unset($result['cpu']);

        echo json_encode([
            'percent' => $percentTotal,
            'cores'   => array_values($result)
        ]);
    }
}