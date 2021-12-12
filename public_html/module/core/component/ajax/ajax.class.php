<?php

defined('AIN') or exit('NO DICE!');

class core_component_ajax_ajax extends AIN_Ajax
{
	
	public function serverCpuStatus()
	{
		$load = sys_getloadavg();
		echo $load[0];
	}
	public function serverMemoryStatus()
	{
		function get_server_memory_usage(){

			$free = shell_exec('free -m');
			$free = (string)trim($free);
			$free_arr = explode("\n", $free);
			$mem = explode(" ", $free_arr[1]);
			$mem = array_filter($mem);
			$mem = array_merge($mem);
			$memory_usage = $mem[2]/$mem[1]*100;

			return floor($memory_usage);
		}
		
		echo get_server_memory_usage();
	}
	
	
	public function iframeUpload()
	{
		///AIN::getLib('module')->getComponent('ad.block.ad-index', array(), 'block');
		AIN::getLib('module')->getComponent('core.iframeUpload', array(), 'block');	
	
	}	
	
	
	
	public function message()
	{
		AIN::getBlock('core.message', array(
			'sMessage' => ''
			)
		);
		$this->call('<script type="text/javascript">$(\'#js_custom_core_message\').html(sCustomMessageString);</script>');
	}
	
	
	
	
	
	
	
	
}
?>