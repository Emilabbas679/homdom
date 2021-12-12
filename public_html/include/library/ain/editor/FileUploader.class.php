<?php


defined('AIN') or exit('NO DICE!');

class AIN_Editor_FileUploader
{
	private $_aParams = array();	
	
	public function setParam($mParam, $mValue = null)
	{
		if (is_string($mParam))
		{
			$this->_aParams[$mParam] = $mValue;
		}
		else
		{
			foreach ($mParam as $mKey => $mValue)
			{
				$this->_aParams[$mKey] = $mValue;
			}
		}
	}
	public function createJs()
	{
	
		$return = '
			<script type="text/javascript">
				$Behavior.FileUploader = function()
				{
					
				
				
				
				
				
				}
			</script>	
		';
		return $return;
	}		
}
?>