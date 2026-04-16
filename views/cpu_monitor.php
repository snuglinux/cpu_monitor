<?php

$this->lang->load('cpu_monitor');

echo "<h2>" . lang('cpu_monitor_app_name') . "</h2>";

echo "<h3>" . lang('cpu_monitor_statistics') . "</h3>";
echo "<p><b>" . lang('cpu_monitor_processor_model') . ":</b> " . $cpu_model . "</p>";
echo "<p><b>" . lang('cpu_monitor_number_cores') . ":</b> " . $cores . "</p>";
echo "<p id='cpu'><b>" . lang('cpu_monitor_total_cpu_usage') . ":</b> " . lang('cpu_monitor_loading') . "</p>";
echo "<h3>" . lang('cpu_monitor_usage_each_core') . "</h3>";
echo "

<div id='bars'></div>

<style>
#bars {
    display: flex;
    overflow-x: auto;
    white-space: nowrap;
    gap: 20px;
    outline: 2px solid #A9A9A9;
    border-radius: 8px;
    margin-top: 25px;
    padding: 20px 20px 20px 20px;
}

.bar {
    width: 20px;
    height: 150px;
    border: 2px solid #A9A9A9;
    margin-right: 5px;
    position: relative;
    border-radius: 6px;
    transform: translateY(-10px);
    flex: 0 0 auto;
}

.fill {
    bottom: 0px;
    width: 100%;
    background: lime;
    position: absolute;
    border-radius: 4px;
}
.label {
    position: absolute;
    text-align: center;
    bottom: -40px;
    padding: 0 0 0 0 !important;
}
</style>

<script>
function loadCPU() {
    let pretext = '<b>" . lang('cpu_monitor_total_cpu_usage') . ":</b> '
    fetch('/app/cpu_monitor/cpu_monitor/stats')
        .then(res => res.json())
        .then(data => {
            document.getElementById('cpu').innerHTML = pretext + Math.round(data.percent) + '%';

            let container = document.getElementById('bars');
            container.innerHTML = '';
	    data.cores.forEach((val, i) => {
		let bar = document.createElement('div');
		bar.className = 'bar';

                let label = document.createElement('p');
                label.className = 'label';
                label.textContent = Math.round(val) + '%';

		let fill = document.createElement('div');
		fill.className = 'fill';
		fill.style.height = val + '%';
		fill.style.background =
		    val > 80 ? 'red' :
		    val > 40 ? 'orange' :
		    'lime';

		bar.appendChild(fill);
                bar.appendChild(label);
		bar.title = 'CPU ' + (i + 1) + ': ' + Math.round(val) + '%';
		container.appendChild(bar);

		label.style.transform = 'translateX(-' + Math.round(label.textContent.length / 2) + '0%)';
	    });
        });
}

loadCPU();
setInterval(loadCPU, 5000);
</script>
";