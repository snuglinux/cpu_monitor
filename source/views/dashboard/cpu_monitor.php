<?php

$this->lang->load('cpu_monitor');

echo form_open();
echo form_header(lang('cpu_monitor_app_name'));

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
    fetch('/app/cpu_monitor/cpu_monitor/stats')
        .then(res => res.json())
        .then(data => {
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

echo form_footer();
echo form_close();