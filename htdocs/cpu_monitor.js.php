<?php

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// T R A N S L A T I O N S
///////////////////////////////////////////////////////////////////////////////

clearos_load_language('cpu_monitor');

///////////////////////////////////////////////////////////////////////////////
// J A V A S C R I P T
///////////////////////////////////////////////////////////////////////////////

header('Content-Type:application/x-javascript');
?>

$(document).ready(function() {
    $('#cpu_monitor_dashboard')[0].innerHTML = `
	<p id='cpu_usage'><b>${lang_cpu_usage_cpu_monitor}:</b> ${lang_loading_cpu_monitor}</p>
	<p id='cpu_temperature'><b>${lang_cpu_temp_cpu_monitor}:</b> ${lang_loading_cpu_monitor}</p>
	<div id='bars'></div>

	<style>

	#cpu_usage, #cpu_temperature {
	    display: flex;
	    overflow-x: auto;
	    white-space: nowrap;
	    scrollbar-width: thin;
	}

	#cpu_usage::-webkit-scrollbar, #cpu_temperature::-webkit-scrollbar {
	    height: 6px;
	}

	#bars {
	    display: flex;
	    overflow-x: auto;
	    white-space: nowrap;
	    gap: 20px;
	    outline: 2px solid #A9A9A9;
	    border-radius: 8px;
	    margin-top: 5px;
	    padding: 20px 20px 20px 20px;
	    margin-bottom: 10px;
	}

	.bar {
	    width: 20px;
	    height: 100px;
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
    `;

    function loadCPU() {
        let usage_pretext = '<b>' + lang_cpu_usage_cpu_monitor + ':</b> ';
        let temperature_pretext = '<b>' + lang_cpu_temp_cpu_monitor + ':</b> ';
        fetch('/app/cpu_monitor/cpu_monitor/stats')
            .then(res => res.json())
            .then(data => {
                document.getElementById('cpu_usage').innerHTML = usage_pretext + Math.round(data.percent) + '%';
                if (data.temp) {
            	    document.getElementById('cpu_temperature').innerHTML = temperature_pretext + data.temp + '°C';
        	} else {
            	    document.getElementById('cpu_temperature').innerHTML = temperature_pretext + lang_no_info_cpu_monitor;
        	}

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
});
