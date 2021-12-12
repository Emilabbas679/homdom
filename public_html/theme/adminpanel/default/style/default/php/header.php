<?php
	function return_bytes($val) 
	{
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			default: 
				$val = (int) $val;
			break;
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
		return $val;
	}
	function readable_filesize($bytes)
	{
		$filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
		return $bytes ? round($bytes/pow(1024, ($i = floor(log($bytes, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
	} 

	function get_true_max_filesize()
	{
		$upload_max_filesize = return_bytes(ini_get('upload_max_filesize'));
		$post_max_size = return_bytes(ini_get('post_max_size'));
		// uploads shouldn't exceed the size limit of the total post
		// $post_max_size = round((100 * $post_max_size) / 100, 0); // Commented since v2.0; confuses customers when we don't show the correct size
		
		$max_size = 0;
		$max_size = ($upload_max_filesize < $post_max_size) ? $upload_max_filesize : $post_max_size;
		
		return $max_size;
	}
	function pm_alert($message = '', $type = 'error', $html_tag = 'div', $custom_attr = array(), $dismissible = false)
	{
		$html = '<'. $html_tag .' class="alert ';
		
		$html .= ($type == '') ? '' : 'alert-'. $type;
		$html .= '"'; 

		if (is_array($custom_attr) && count($custom_attr) > 0)
		{
			foreach ($custom_attr as $attr => $value)
			{
				$html .= ' '. $attr .'="'. $value .'"';
			}
		}
		
		$html .= '>';
		
		if ($dismissible)
		{
			//$html .= '<a href="#" class="close" data-dismiss="alert">&times;</a>';
			$html .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
		}
		
		if (is_array($message))
		{
			if (count($message) > 1)
			{
				$html .= '<ul>';
				foreach ($message as $k => $msg)
				{
					$html .= '<li>'. $msg .'</li>';
				}
				$html .= '</ul>';
			}
			else
			{
				foreach ($message as $k => $msg)
				{
					$html .= $msg;
				}
			}
		}
		else
		{
			$html .= $message;
		}
		$html .= '</'. $html_tag .'>';

		return $html;
	}
	function pm_alert_error($message = '', $custom_attr = array(), $dismissible = false)
	{
		return pm_alert($message, 'error', 'div', $custom_attr, $dismissible);
	}
		
		

	function videoSearch( $where = array() )
	{
		
		
		
		$VideoSearch = AIN::getService('video.search');
		//Video Limit
		$VideoSearch->limit($where['limit']);			
		if( isset( $where['category_id'] ) and $where['category_id'] > 0 )  $VideoSearch->where('v.category_id', "v.category_id='".$where['category_id']."'");
		$VideoSearch->where('v.is_active', "v.is_active='1'");
		
		switch(isset($where['v.added'])?$where['v.added']:'')
		{ 
			case'3days';
				$VideoSearch->where('v.added', 'v.added <= "'.AIN_TIME.'" and v.added >= "'.( AIN_TIME - 3*86400 ).'"');
				$VideoSearch->order( 'v.views desc' ); 	
				//print_r($where);
			break;
		}
		
		
		
		$aRows = $VideoSearch->execute();	
		
		
		
		
		AIN::getLib('template')->assign('aRows', $aRows);
	}
	
	
function validate_item_date($post)
{
	$mon = (int) $post['date_month'];
	$day = (int) $post['date_day'];
	$year = (int) $post['date_year'];
	$hour = (int) $post['date_hour'];
	$min = (int) $post['date_min'];
	$sec = (int) $post['date_sec'];
	$ampm = strtoupper($post['date_ampm']);
	
	if (($mon > 12 || $mon < 1) || ($day > 31 || $day < 1) || ($year < 1970 || $year > 9999) || ($hour > 12 || $hour < 0) || ($min > 60 || $min < 0) || ($sec > 60 || $sec < 0))
	{
		return false;
	}
	
	$days_in_month = date('t', $mm = mktime(1, 0, 0, $mon, 1, $year));
	 
	// the user meant the last day of the month for sure. autofix if mistake was made
	if ($day > $days_in_month)
	{
		$day = $days_in_month;
	}
	
	if ($ampm == 'AM')
	{
		if ($hour == 12)
		{
			$hour = 0;
		}
	}
	
	if ($ampm == 'PM')
	{
		$hour += 12;
		if ($hour == 24)
		{
			$hour = 12;
		}
	}
	
	return array('date_month' => $mon, 
				 'date_day' => $day, 
				 'date_year' => $year, 
				 'date_hour' => $hour, 
				 'date_min' => $min,
				 'date_sec' => $sec,
				 'date_ampm' => $ampm);
}
function pm_mktime($post = array())
{
	return mktime((int) $post['date_hour'], (int) $post['date_min'], (int) $post['date_sec'], (int) $post['date_month'], (int) $post['date_day'], (int) $post['date_year']);
}
function show_form_item_date($timestamp = 0) 
{
	if ( ! $timestamp)
		$timestamp = AIN_TIME;
	
	$months = array(1 => 'Jan',
					2 => 'Feb',
					3 => 'Mar',
					4 => 'Apr',
					5 => 'May',
					6 => 'Jun',
					7 => 'Jul',
					8 => 'Aug',
					9 => 'Sep',
					10 => 'Oct',
					11 => 'Nov',
					12 => 'Dec' 
				);	
	
	$date = date('n,d,Y,h,i,s,A', $timestamp);
	$date = explode(',', $date);
	
	$sel_mon = $date[0];
	$sel_day = $date[1];
	$sel_year = $date[2];
	$sel_hour = $date[3];
	$sel_min = $date[4];
	$sel_sec = $date[5];
	$sel_ampm = $date[6];
	
	$return = '<span class="inline-date">';
	
	$return .= '<select name="val[date_month]" class="pubDate">' . "\n";
	for ($i = 1; $i <= 12; $i++)
	{
		$selected = ($i == $sel_mon) ? 'selected="selected"' : '';
		$return .= '<option value="'. $i .'" '. $selected .'>'. $months[$i] .'</option>' . "\n";
	}
	$return .= '</select>' . "\n";
	
	$return .= '<input type="text" name="val[date_day]" value="'. $sel_day .'" size="2" maxlength="2" class="pubDate" /> ' . "\n";
	$return .= ' , ';
	$return .= '<input type="text" name="val[date_year]" value="'. $sel_year .'" size="4" maxlength="4" class="pubDate" /> ' . "\n";
	$return .= ' @ ';
	$return .= '<input type="text" name="val[date_hour]" value="'. $sel_hour .'"  size="2" maxlength="2" class="pubDate" /> : ' . "\n";
	$return .= '<input type="text" name="val[date_min]" value="'. $sel_min .'" size="2" maxlength="2" class="pubDate" />' . "\n";
	$return .= '<select name="val[date_ampm]" class="pubDate">' . "\n";
	$return .= ' <option value="am"';
	$return .= ($sel_ampm == 'AM') ? ' selected="selected" ' : '';
	$return .= '>AM</option>';
	$return .= ' <option value="pm"';
	$return .= ($sel_ampm == 'PM') ? ' selected="selected" ' : '';
	$return .= '>PM</option>';
	$return .= '</select>' . "\n";
		
	$return .= '<input type="hidden" name="val[date_sec]" value="'. $sel_sec .'" size="2" maxlength="2" class="pubDate" />' . "\n";
	$return .= '</span>';
	
	// explain
	$return .= "\n\n";
	$return .= '';
	return $return;
}




?>