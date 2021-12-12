<?php
/**
 * [Nulled by DarkGoth - NCP TEAM] - 2016
 */

defined('AIN') or exit('NO DICE!');


class AIN_Search
{
	/**
	 * Holds HTML form.
	 *
	 * @var array
	 */
	private $_aHtml = array();	
	
	/**
	 * SQL conditions.
	 *
	 * @var array
	 */
	private $_aConditions = array();
	
	/**
	 * Request object.
	 *
	 * @see AIN_Request
	 * @var object
	 */
	private $_oReq = null;	
	
	/**
	 * URL object.
	 *
	 * @see AIN_Url
	 * @var object
	 */
	private $_oUrl = null;
	
	/**
	 * SQL conditions.
	 *
	 * @var array
	 */
	private $_aConds = array();
	
	/**
	 * Current page the search is on.
	 *
	 * @var int
	 */
	private $_iSearchPage = 0;
	
	/**
	 * Total search results.
	 *
	 * @var int
	 */
	private $_iSearchTotal = 0;
	
	/**
	 * Check if a search has been performed.
	 *
	 * @var bool
	 */
	private $_bIsSearch = false;
	
	/**
	 * Type of search we are performing.
	 *
	 * @var string
	 */
	private $_sType;
	
	/**
	 * Search results.
	 *
	 * @var array
	 */
	private $_aSearch = array();
	
	/**
	 * Define if we should cache the search results.
	 *
	 * @var bool
	 */
	private $_bCache = false;
	
	/**
	 * Search results as a string.
	 *
	 * @var string
	 */
	private $_sSearchResults;
	
	/**
	 * Search settings.
	 *
	 * @var array
	 */
	private $_aParams = array();
	
	/**
	 * Perform a live search with no caching or storage.
	 *
	 * @var bool
	 */
	private $_bLiveQuery = false;
	
	/**
	 * Array of search params
	 *
	 * @var array
	 */
	private $_aSearchTool = array();
	
	/**
	 * Total amount of items this search returned
	 *
	 * @var int
	 */
	private $_iTotalCount = 0;
	
	/**
	 * Holds if a section has been sorted
	 *
	 * @var bool
	 */
	private $_bIsSorted = false;	
	
	/**
	 * Custom search date
	 * 
	 * @var bool
	 */
	private $_bIsCustomSearchDate = false;
	
	/**
	 * Check to see if the form is being reset
	 *
	 * @var bool
	 */
	private $_bIsReset = false;
	
	/**
	 * Class constructor that loads request and url objects.
	 *
	 */
	public function __construct()
	{		
		$this->_oReq = AIN_Request::instance();
		$this->_oUrl = AIN_Url::instance();
	}

	/**
	 * @return AIN_Search
	 */
	public static function instance() {
		return AIN::getLib('search');
	}
	
	/**
	 * Build the search form.
	 *
	 * @param array $aParams Search fields and settings.
	 * @return AIN_Search
	 */
	public function set($aParams)
	{	
		/* Search for Inputs */
		if (AIN::isModule('input') && isset($aParams['search_tool']) )
		{
			if (!isset($aParams['search_tool']['custom_filters']))
			{
				$aParams['search_tool']['custom_filters'] = array();
			}
			
			$sThisUrl = AIN_Module::instance()->getModuleName();
			$aInputs = AIN::getService('input')->getInputsForSearch($sThisUrl);
			
			if (!empty($aInputs))
			{
				AIN_Template::instance()
					->setHeader(array(
						'search.js' => 'static_script'
					))
					->assign(array(
						'bHasInputs' => true,
						'sModuleForInput' => $sThisUrl
				));				
			}
		}
		/* Search for Inputs end*/
		$this->_aParams = $aParams;
		
		if (isset($this->_aParams['redirect']) && $this->_aParams['redirect'] && ($aVals = $this->_oReq->getArray('search')))
		{			
			if (isset($aVals['reset']))
			{
				$this->_oUrl->send($this->_aParams['redirect_url']);
			}
						
			$this->_oUrl->send($this->_aParams['redirect_url'], array_merge(array('searching' => 'true'), $aVals));
		}		
		
		if (!count($this->_aSearch))
		{
			$this->_aSearch = $this->_oReq->getArray('search');
		}
		if (isset($this->_aSearch['reset']))
		{
			$this->_reset();
		}
		
		if (isset($aParams['filters']))
		{
        	$this->_aConditions = $aParams['filters'];
		}

        $this->_sType = $aParams['type'];
		
        if (isset($aParams['cache']))
        {
        	$this->_bCache = $aParams['cache'];
        }        
     
        if (!isset($aParams['prepare']))
        {
			$this->_prepare();
        }

        if ($this->_bCache && ($iSearchId = $this->_oReq->getInt('search-id')))
        {
        	$this->getSearch($iSearchId, $this->_oReq->getInt('page'), $this->getDisplay());
        }

		AIN_Template::instance()->assign(array(
				'aFilters' => $this->_aHtml
			)
		);		
		
		$bIsCanonical = false;
		/*
		if (
				$this->_oReq->getInt('page')
				|| $this->_oReq->getInt('sort')
				|| $this->_oReq->getInt('show')
				|| $this->_oReq->getInt('when')
			)
		{
			$bIsCanonical = true;
		}
		
		if ($bIsCanonical)
		{
			AIN_Template::instance()->setHeader(array(
					'<link rel="canonical" href="' . AIN_Url::instance()->makeUrl(AIN_Request::instance()->get('req1')) . '" />'
				)
			);
		}
		*/

		if (isset($this->_aParams['search_tool']))
		{
			$iSortCnt = 0;
			$aSort = array();
			if (isset($this->_aParams['search_tool']['sort'])) {
				foreach ($this->_aParams['search_tool']['sort'] as $sSortKey => $aSortPhrase) {
					$iSortCnt++;
					if ($iSortCnt === 1) {
						$this->_aParams['search_tool']['sort']['default_sort'] = $aSortPhrase[0];
						if (isset($aSortPhrase[2])) {
							$this->_aParams['search_tool']['sort']['default_sort_order'] = $aSortPhrase[2];
						}
					} else {
						if (isset($aSortPhrase[2])) {
							$this->_aParams['search_tool']['sort'][ $sSortKey ]['default_sort_order'] = $aSortPhrase[2];
						}
					}

					$aSort[] = [
							'link'   => $sSortKey,
							'phrase' => $aSortPhrase[1]
					];
				}
			}

			$iDisplayCnt = 0;
			$aDisplayData = array();
			$sDefaultPager = '';
			if (isset($this->_aParams['search_tool']['show'])) {
				foreach ($this->_aParams['search_tool']['show'] as $iPageDisplay) {
					$iDisplayCnt++;

					if ($iDisplayCnt === 1) {
						$this->_aSearch['display'] = $iPageDisplay;
						$sDefaultPager = AIN::getPhrase('core.per_page', ['total' => $iPageDisplay]);
					}

					$aDisplayData[] = [
							'nofollow' => true,
							'link'     => $iPageDisplay,
							'phrase'   => AIN::getPhrase('core.per_page', ['total' => $iPageDisplay])
					];
				}
			}

			$aWhens = array(
				array(
					'nofollow' => true,
					'link' => 'all-time',
					'phrase' => AIN::getPhrase('core.all_time')							
				),
				array(
					'nofollow' => true,
					'link' => 'this-month',
					'phrase' => AIN::getPhrase('core.this_month')							
				),
				array(
					'nofollow' => true,
					'link' => 'this-week',
					'phrase' => AIN::getPhrase('core.this_week')							
				),
				array(
					'nofollow' => true,
					'link' => 'today',
					'phrase' => AIN::getPhrase('core.today')							
				)						
			);
						
			if (isset($this->_aParams['search_tool']['when_upcoming']))
			{
				$aWhens[] = array(
					'link' => 'upcoming',
					'phrase' => AIN::getPhrase('core.upcoming')
				);	
			}
			
			$this->_aSearchTool = array(
				'search' => (isset($this->_aParams['search_tool']['search']) ? $this->_aParams['search_tool']['search'] : null),
				'filters' => array(
					AIN::getPhrase('core.sort') => array(
						'param' => 'sort',
						'default_phrase' => ($aSort) ? $aSort[0]['phrase'] : '',
						'data' => $aSort				
					),					
					AIN::getPhrase('core.show') => array(
						'param' => 'show',
						'default_phrase' => $sDefaultPager,
						'data' => $aDisplayData
					),
					AIN::getPhrase('core.when') => array(
						'param' => 'when',
						'default_phrase' => AIN::getPhrase('core.all_time'),
						'data' => $aWhens
					)					
				)
			);

			if (isset($this->_aParams['search_tool']['custom_filters']))
			{
				$this->_aSearchTool['filters'] = array_merge($this->_aParams['search_tool']['custom_filters'], $this->_aSearchTool['filters']);	
			}
			
			foreach ($this->_aSearchTool as $sSearchKey => $aSearchToolArray)
			{			
				if ($sSearchKey == 'filters')
				{
					foreach ($aSearchToolArray as $sFilterName => $aData)
					{
						if (isset($aData['param']) && AIN_Request::instance()->get($aData['param'])) {
							$default = AIN_Url::instance()->makeUrl('current');
							$default = preg_replace('/page=([0-9]+)/i', '', $default);
							$default = preg_replace('/&' . $aData['param'] . '=([a-zA-Z0-9]+)/i', '', $default);
							$this->_aSearchTool[$sSearchKey][$sFilterName]['default'] = [
								'url' => $default,
								'phrase' => 'Reset <i class="fa fa-undo"></i>'
							];
						}

						if (isset($aData['data']))
						{
							foreach ($aData['data'] as $iDataKey => $aLink)
							{
								$sLink = AIN_Url::instance()->makeUrl('current');
								$sLink = preg_replace('/page=([0-9]+)/i', '', $sLink);

								$parts = parse_url($sLink);

								$aQuery = (!empty($parts['query'])) ? $parts['query'] : '';
								parse_str($aQuery, $query);
								$query['s'] = 1;
								$query[$aData['param']] = $aLink['link'];
								$sLink = $parts['scheme'].'://'.$parts['host'].$parts['path'].'?'.http_build_query($query);
//								$parts = explode('/?s=1', $sLink);
//
//								$sLink = $parts[0] . '/?s=1' . (isset($parts[1]) ? '' . $parts[1] : '');
//								$sLink = str_replace('&' . $aData['param'] . '=' . AIN_Request::instance()->get($aData['param']) . '', '', $sLink);
//
//								$sLink = $sLink . '&' . $aData['param'] . '=' . $aLink['link'];
							//	d($sLink); exit;
								$this->_aSearchTool[$sSearchKey][$sFilterName]['data'][$iDataKey]['link'] = $sLink;
								
								if (AIN_Request::instance()->get($aData['param']) == $aLink['link'])
								{
									$this->_bIsSorted = true;

									$this->_aSearchTool[$sSearchKey][$sFilterName]['data'][$iDataKey]['is_active'] = true;	
									$this->_aSearchTool[$sSearchKey][$sFilterName]['active_phrase'] = $aLink['phrase'];
								}
								else 
								{									
									if (!AIN_Request::instance()->get($aData['param']) && isset($this->_aParams['search_tool']['default_when']) && $this->_aParams['search_tool']['default_when'] == $aLink['link'])
									{
										$this->_bIsSorted = true;
										$this->_bIsCustomSearchDate = $aLink['link'];
										
										$this->_aSearchTool[$sSearchKey][$sFilterName]['data'][$iDataKey]['is_active'] = true;	
										$this->_aSearchTool[$sSearchKey][$sFilterName]['active_phrase'] = $aLink['phrase'];
									}
								}
							}
						}
					}
				}
			}

			if ($this->isSearch())
			{
				$this->_aSearchTool['search']['actual_value'] = $this->get($this->_aSearchTool['search']['name']);				
				if (!empty($this->_aSearchTool['search']['actual_value']) && ($this->_aSearchTool['search']['actual_value'] != $this->_aSearchTool['search']['default_value']))
				{
					$this->setCondition('AND (' . AIN_Database::instance()->searchKeywords($this->_aSearchTool['search']['field'], $this->_aSearchTool['search']['actual_value']) . ')');
				}
			}

			if (isset($this->_aSearchTool['search']) && isset($this->_aSearchTool['search']['action'])) {
				$newUrl = '';
				$orig = $this->_aSearchTool['search']['action'];
				$current = AIN_Url::instance()->current();
				$url = explode('/', $orig);
				foreach ($url as $part) {
					if (substr($part, 0, 1) == '?') {
						break;
					}

					$newUrl .= $part . '/';
				}

				/*
				$final = str_replace($newUrl, '', $orig);
				$final = trim($final, '?');
				$final = $newUrl . '?s=1&' . str_replace('s=1', '', $final);
				*/
				$final = str_replace($newUrl, '', $orig);

				$hidden = '';
				$params = explode('&', trim(str_replace($newUrl, '', $current), '?'));
				if ($final) {
					$finalParams = explode('&', trim($final, '?'));
					if ($finalParams) {
						$params = array_merge($finalParams, $params);
					}
				}

				// d($params); exit;

				$hidden .= '<input type="hidden" name="s" value="1">';
				if (isset($this->_aSearchTool['search']['hidden'])) {
					$hidden .= $this->_aSearchTool['search']['hidden'];
				}

				$cache = [];
				foreach ($params as $param) {
					$part = explode('=', $param);
					if (!isset($part[1])) {
						$part[1] = '';
					}

					if (isset($cache[$part[0]]) || $part[0] == 's' || $part[0] == 'search[search]') {
						continue;
					}

					$part[1] = htmlspecialchars($part[1]);
					if (substr($part[0], 0, 7) == 'http://' || substr($part[0], 0, 8) == 'https://') {
						continue;
					}

					$cache[$part[0]] = true;

					$hidden .= '<input type="hidden" name="' . $part[0] . '" value="' . $part[1] . '">';
				}

				$this->_aSearchTool['search']['action'] = rtrim($newUrl, '/');

				$this->_aSearchTool['search']['hidden'] = $hidden;
			}

			AIN_Template::instance()->assign(array(
					'aSearchTool' => $this->_aSearchTool
				)
			);
		}

		if (AIN::getLib('session')->get('search_fail'))
		{
			AIN::getLib('session')->remove('search_fail');
			
			AIN_Template::instance()->assign(array(
					'bSearchFailed' => true
				)
			);
		}
		
		unset($this->_aConds['sort_by'], $this->_aConds['display'], $this->_aConds['sort']);

		return $this;
	}		
	
	/**
	 * Set the total number of items this search returned.
	 *
	 * @param int $iTotalCount
	 */
	public function setCount($iTotalCount)
	{
		$this->_iTotalCount = $iTotalCount;
	}
	
	/**
	 * Get the total of items this search returned.
	 *
	 * @see self::setCount()
	 * @return int
	 */
	public function getCount()
	{
		return $this->_iTotalCount;
	}
	
	/**
	 * Check to see if the page is being sorted
	 *
	 * @return bool TRUE yes, FALSE no
	 */
	public function isSorted()
	{
		return (bool) $this->_bIsSorted;
	}
	
	/**
	 * Reset the search form URL.
	 *
	 * @param string $sUrl Full URL to point the search form.
	 */
	public function setFormUrl($sUrl)
	{
		$this->_aSearchTool['search']['action'] = $sUrl;
		AIN_Template::instance()->assign(array(
				'aSearchTool' => $this->_aSearchTool
			)
		);
	}	
	
	/**
	 * Get the form URL.
	 *
	 * @return string Return the forms URL.
	 */
	public function getFormUrl()
	{
		return $this->_aSearchTool['search']['action'];	
	}
	
	/**
	 * Define that this is a live search.
	 *
	 * @return AIN_Search
	 */
	public function live()
	{
		$this->_bLiveQuery = true;
		
		return $this;
	}
	
	/**
	 * Force to set search requests.
	 *
	 * @return AIN_Search
	 */
	public function setRequests()
	{		
		foreach ($this->_oReq->getRequests() as $mKey => $mValue)
		{
			$this->_aSearch[$mKey] = $mValue;
		}
		
		return $this;
	}
	
	/**
	 * Check to see if we are currently trying to perform a search.
	 *
	 * @return bool TRUE we are searching, FALSE if we are not.
	 */
	public function isSearching()
	{
		return ($this->_oReq->get('searching') ? true : false);
	}	
	
	/**
	 * Check if we submitted the search form.
	 *
	 * @return bool TRUE if form submitted, FALSE if not.
	 */
	public function isSearch()
	{		
		if ($this->_oReq->getArray('search')) {
			return true;
		}
		return false;
	}	
	
	/**
	 * Set the sorting order of the search.
	 *
	 * @param string $sSort
	 */
	public function setSort($sSort)
	{
		$this->_aSearch['sort'] = $sSort;		
	}

	/**
	 * Get the current sorting order.
	 *
	 * @return string
	 */
	public function getSort()
	{		
		if (isset($this->_aParams['search_tool']['sort']))
		{
			$sSort = '';
			if (($sSearchSort = $this->_oReq->get('sort')) && isset($this->_aParams['search_tool']['sort'][$sSearchSort]))
			{
				// http://www.AIN.com/tracker/view/15390/
				if(isset($this->_aParams['search_tool']['sort'][$sSearchSort][2]))
				{
					$this->_aParams['search_tool']['sort'][$sSearchSort]['default_sort_order'] = $this->_aParams['search_tool']['sort'][$sSearchSort][2];
				}
				
				$sSort .= $this->_aParams['search_tool']['sort'][$sSearchSort][0] . ' ' . (isset($this->_aParams['search_tool']['sort'][$sSearchSort]['default_sort_order']) ? $this->_aParams['search_tool']['sort'][$sSearchSort]['default_sort_order'] : 'DESC');
			}
			else 
			{
				$sSort .= $this->_aParams['search_tool']['sort']['default_sort'] . ' ' . (isset($this->_aParams['search_tool']['sort']['default_sort_order']) ? $this->_aParams['search_tool']['sort']['default_sort_order'] : 'DESC');
			}
			
			return $sSort;
		}
		
		if ($this->_getVar('sort'))
		{
			$iCnt = 0;
			foreach ($this->_aConditions['sort']['options'] as $mKey => $mValue)
			{
				if ($mKey == $this->_getVar('sort'))
				{
					$iCnt++;
				}
			}
			
			if ($iCnt === 0)
			{
				unset($this->_aSearch['sort']);				
			}
		}	
		
		$sSort = (isset($this->_aConditions['sort']['alias']) ? trim($this->_aConditions['sort']['alias']) . '.' : '') . ($this->_getVar('sort') ? $this->_getVar('sort') : $this->_aConditions['sort']['default']);
		$sSort .= ' ' . ($this->_getVar('sort_by') ? ($this->_getVar('sort_by') == 'ASC' ? 'ASC' : 'DESC') : $this->_aConditions['sort_by']['default']);

		return $sSort;
	}
	
	/**
	 * Get the display.
	 *
	 * @return string
	 */
	public function getDisplay()
	{
		if ($this->_oReq->get('show'))
		{
			$iReturn = 20;
			if ($this->_aParams['search_tool'] && isset($this->_aParams['search_tool']['show']))
			{	
				$iNew = (int) $this->_oReq->get('show');
				foreach ($this->_aParams['search_tool']['show'] as $iTotal)
				{
					if ((int) $iTotal == (int) $iNew)
					{
						return $iNew;
					}
				}
			}
			
			return $iReturn;
		}
		
		return (int) ($this->_getVar('display') ? $this->_getVar('display') : (isset($this->_aConditions['display']['default']) ? $this->_aConditions['display']['default'] : 8));
	}
	
	/**
	 * Set an SQL condition.
	 *
	 * @param string $sValue
	 */
	public function setCondition($sValue)
	{
		$this->_aConds[] = $sValue;	
	}
	
	public function clearConditions()
	{
		$this->_aConds = array();
	}	
	
	/**
	 * Get all SQL conditions.
	 *
	 * @return array
	 */
	public function getConditions()
	{			
		
		if ($this->_getParam('cache') && !empty($this->_sSearchResults))
		{
			$mField = $this->_getParam('field');
			
			if (is_array($mField))
			{
				if (isset($mField['depend']))
				{
					$sDepend = $this->get($mField['depend']);			
					
					$mField = ($sDepend ? $mField['fields'][0] : $mField['fields'][1]);					
				}
			}
			
			return array('AND ' . $mField . ' IN(' . $this->_sSearchResults . ')');
		}				
		
		static $aConds = null;
		
		if ($this->_bIsReset)
		{
			$aConds = null;
			$this->_bIsReset = false;	
		}
		
		if ($aConds !== null)
		{
			return $aConds;
		}

		if ($this->_oReq->get('when') || $this->_bIsCustomSearchDate)
		{
			$iTimeDisplay = AIN::getLib('date')->mktime(0, 0, 0, AIN::getTime('m'), AIN::getTime('d'), AIN::getTime('Y'));
			
			$sWhenField = (isset($this->_aParams['search_tool']['when_field']) ? $this->_aParams['search_tool']['when_field'] : 'time_stamp');
			$sSwitch = ($this->_oReq->get('when') ? $this->_oReq->get('when') : $this->_bIsCustomSearchDate);

			switch ($sSwitch)
			{
				case 'today':					
					$iEndDay = AIN::getLib('date')->mktime(23, 59, 0, AIN::getTime('m'), AIN::getTime('d'), AIN::getTime('Y'));				
					
					$this->_aConds[] = ' AND (' . $this->_aParams['search_tool']['table_alias'] . '.' . $sWhenField . ' >= \'' . AIN::getLib('date')->convertToGmt($iTimeDisplay) . '\' AND ' . $this->_aParams['search_tool']['table_alias'] . '.' . $sWhenField . ' < \'' . AIN::getLib('date')->convertToGmt($iEndDay) . '\')';
					break;
				case 'this-week':
					$this->_aConds[] = ' AND ' . $this->_aParams['search_tool']['table_alias'] . '.' . $sWhenField . ' >= ' . (int) AIN::getLib('date')->convertToGmt(AIN::getLib('date')->getWeekStart());
					$this->_aConds[] = ' AND ' . $this->_aParams['search_tool']['table_alias'] . '.' . $sWhenField . ' <= ' . (int) AIN::getLib('date')->convertToGmt(AIN::getLib('date')->getWeekEnd());
					break;
				case 'this-month':
					$this->_aConds[] = ' AND ' . $this->_aParams['search_tool']['table_alias'] . '.' . $sWhenField . ' >= \'' . AIN::getLib('date')->convertToGmt(AIN::getLib('date')->getThisMonth()) . '\'';
					$iLastDayMonth = AIN::getLib('date')->mktime(0, 0, 0, date('n'), AIN::getLib('date')->lastDayOfMonth(date('n')), date('Y'));
					$this->_aConds[] = ' AND ' . $this->_aParams['search_tool']['table_alias'] . '.' . $sWhenField . ' <= \'' . AIN::getLib('date')->convertToGmt($iLastDayMonth) . '\'';
					break;		
				case 'upcoming':
					$this->_aConds[] = ' AND ' . $this->_aParams['search_tool']['table_alias'] . '.' . $sWhenField . ' >= \'' . AIN::getLib('date')->convertToGmt($iTimeDisplay) . '\'';
					break;
				default:
					
					break;			
			}
		}

		if (!count($this->_aConds))
		{
			return array();
		}

		$oDb = AIN_Database::instance();
		$aConds = array();		
		foreach ($this->_aConds as $mKey => $mValue)
		{
			if (defined('AIN_SEARCH_MODE_CONVERT') && AIN_SEARCH_MODE_CONVERT) {
				$aConds[] = (is_numeric($mKey) ? $mValue : str_replace('[VALUE]', AIN::getLib('parse.input')->convert($oDb->escape($mValue)), $mKey));
			}
			else {
				$aConds[] = (is_numeric($mKey) ? $mValue : str_replace('[VALUE]', AIN::getLib('parse.input')->clean($oDb->escape($mValue)), $mKey));
			}
		}

		return $aConds;
	}
	
	/**
	 * Clear the current search form.
	 *
	 */
	public function clear()
	{
		$this->_aConds = array();
		$this->_aHtml = array();
	}
	
	/**
	 * Build a search ARRAY based on the SQL driver.
	 *
	 * @param string $sType Type of search we are performing.
	 * @param mixed $mFields SQL fields to check.
	 * @param string $sSearch Search value.
	 */
	public function search($sType, $mFields, $sSearch)
	{
		if (!is_array($mFields))
		{
			$mFields = array($mFields);
		}		
		
		$this->_aConds[] = AIN_Database::instance()->search($sType, $mFields, AIN::getLib('parse.input')->clean($sSearch));
	}
	
	public function getPhrase($sName, $sValue)
	{
		return ((isset($this->_aParams['search_tool'][$sName]) && isset($this->_aParams['search_tool'][$sName][$sValue])) ? $this->_aParams['search_tool'][$sName][$sValue] : false);
	}
	
	/**
	 * Cache a search into the database.
	 *
	 * @param string $sSearch Search value.
	 * @param array $aIds ARRAY of value IDs.
	 * @param array $aExtraParams Extra params you want to store in the database.
	 * @return mixed If the 2nd argument is empty we return FALSE, otherwise we return NULL.
	 */
	public function cacheResults($sSearch, $aIds, $aExtraParams = null)
	{		
		if (!count($aIds))
		{
			AIN::getLib('session')->set('search_fail', true);
			
			$this->_oUrl->send($this->getFormUrl());			
		}		
	
		unset($this->_aSearch['submit']);
		
		$aInsert = array(
			'user_id' => AIN::getUserId(),
			'search_array' => serialize($this->_aSearch),
			'search_ids' => implode(',', $aIds),
			'time_stamp' => AIN_TIME
		);
		
		if (is_array($sSearch))
		{
			$aSearches = array();
			foreach ($sSearch as $sKeySearch)
			{
				if ($sCacheSearch = $this->_getVar($sKeySearch))
				{
					$aSearches[] = $sCacheSearch;
				}
			}
			
			if (count($aSearches))
			{
				$aInsert['search_query'] = serialize($aSearches);
			}
		}
		else 
		{
			if ($sSearch = $this->_getVar($sSearch))
			{
				$aInsert['search_query'] = $sSearch;
			}		
		}
		
		$iSearchIds = AIN_Database::instance()->insert(AIN::getT('search'), $aInsert);
		
		$this->_oUrl->setParam('search-id', $iSearchIds);
		if ($aExtraParams !== null && is_array($aExtraParams))
		{
			foreach ($aExtraParams as $sKey => $sValue)
			{
				$this->_oUrl->setParam($sKey, $sValue);		
			}
		}
		
		$this->_oUrl->forward($this->_oUrl->getFullUrl());
	}
	
	/**
	 * Get the search we cached in the database.
	 *
	 * @param int $iId Search ID#.
	 * @param int $iPage Current page we are on.
	 * @param int $iPageSize How many rows to display per page.
	 * @return mixed If the search is invalid it returns FALSE, otherwise NULL.
	 */
	public function getSearch($iId, $iPage, $iPageSize)
	{
		$aRow = AIN_Database::instance()->select('search_query, search_ids')
			->from(AIN::getT('search'))
			->where("search_id = " . (int) $iId . " AND user_id = " . AIN::getUserId())
			->execute('getSlaveRow');			

		if (!isset($aRow['search_ids']))
		{
			return AIN_Error::set(AIN::getPhrase('core.invalid_search_id'));
		}

		if (empty($aRow['search_ids']))
		{
			return AIN_Error::set(AIN::getPhrase('core.search_results_found'));
		}

		if (!empty($aRow['search_query']))
		{
			if (AIN::getLib('parse.format')->isSerialized($aRow['search_query']))
			{
				$aSearchQuery = unserialize($aRow['search_query']);
				
				$aRow['search_query'] = '';
				foreach ($aSearchQuery as $sSearchString)
				{
					$aRow['search_query'] .= $sSearchString . ', ';
				}
				$aRow['search_query'] = rtrim($aRow['search_query'], ', ');
			}
			
			AIN_Template::instance()->setBreadCrumb(AIN::getPhrase('core.search_results_for') . ': ' . $aRow['search_query'], $this->_oUrl->makeUrl('current'), true)->setTitle(AIN::getPhrase('core.search_results_for') . ': ' . $aRow['search_query']);
		}
		
		$aSearchIds = explode(',', $aRow['search_ids']);		
		$iOffSet = AIN_Pager::instance()->getOffset($iPage, $iPageSize, count($aSearchIds));
		$iCnt = 0;
		foreach ($aSearchIds as $iKey => $sValue)
		{
			if ($iKey < $iOffSet)
			{
				continue;
			}
					
			$iCnt++;					
			if ($iCnt > $iPageSize)
			{
				break;
			}
					
			$this->_sSearchResults .= $sValue . ',';
		}
		$this->_sSearchResults = rtrim($this->_sSearchResults, ',');		
		
		$this->_iSearchTotal = count($aSearchIds);
		$this->_iSearchPage = 0;
		$this->_bIsSearch = true;
	}	
	
	/**
	 * Get a specific search value.
	 *
	 * @param string $sName Search name.
	 * @return mixed If search value is found it will return the value, otherwise NULL.
	 */
	public function get($sName = null)
	{
		if (empty($sName)) return $this->_aSearch;
		return (isset($this->_aSearch[$sName]) ? $this->_aSearch[$sName] : null);		
	}
	
	/**
	 * Get the current page we are on.
	 *
	 * @return int
	 */
	public function getPage()
	{		
		return ($this->_bIsSearch ? $this->_iSearchPage : $this->_oReq->getInt('page'));
	}
	
	/**
	 * Get the search total.
	 *
	 * @param int $iDef Default search total.
	 * @return int
	 */
	public function getSearchTotal($iDef)
	{
		return ($this->_bIsSearch ? $this->_iSearchTotal : $iDef);
	}
	
	/**
	 * Highlight a search string.
	 *
	 * @param string $sSearch Search value.
	 * @param string $sStr String to find and highlight the search value.
	 * @return string Text with highlighted search string is returned.
	 */
	public function highlight($sSearch, $sStr)
	{
		if (!$this->_getVar($sSearch))
		{
			return $sStr;
		}
		
		$sFind = $this->_getVar($sSearch);
		if (!empty($sFind))
		{
			$aParts = explode(' ', $sFind);
			if (is_array($aParts) && count($aParts))
			{
				foreach ($aParts as $sPart)
				{
					$sStr = preg_replace('/(' . preg_quote($sPart, '/') . ')/siU', '<span class="highlight">\\1</span>', $sStr);
				}		
			}
		}
		
		return $sStr;
	}
	
	/**
	 * Shorten a search result.
	 *
	 * @param string $sSearch Search value.
	 * @param string $sStr Search string.
	 * @param int $iStart Define when to look into the search.
	 * @param int $iEnd Define when to end the search.
	 * @return string Shortened search result.
	 */
	public function shorten($sSearch, $sStr, $iStart, $iEnd)
	{		
		if (!$this->_getVar($sSearch))
		{
			return $sStr;
		}
		
		$aParts = explode($this->_getVar($sSearch), $sStr);		
		
		preg_match("/^(.*?)" . $this->_getVar($sSearch) . "(.*?)$/i", $sStr, $aMatches);
		
		$sStart = substr(trim($aMatches[1]), -16);
		$sEnd = substr(trim($aMatches[2]), 0, $iEnd);
		
		return '...' . $sStart . ' ' . $this->_getVar($sSearch) . ' ' . $sEnd . '...';
	}
	
	/**
	 * Get custom search results.
	 *
	 * @return array
	 */
	public function getCustom()
	{
		if (count($this->_aSearch))
		{
			$aCustom = array();
			foreach ($this->_aSearch as $sKey => $mValue)
			{
				if (!preg_match('/custom_search_(.*)/i', $sKey, $aMatches))
				{
					continue;
				}
												
				$aCustom[$aMatches[1]] = $mValue;
			}
			
			return $aCustom;
		}
		
		return array();
	}
	
    /**
     * Extends the browse object.
     *
     * @see AIN_Search_Browse
     * @return AIN_Search_Browse
     */        
    public function browse()
    {
    	return AIN::getLib('search.browse');
    }	
    
    /**
     * Reset the search
     *
     */
    public function reset()
    {
    	$this->_aConditions = array();
    	$this->_aParams = array();
    	$this->_aSearchTools = array();
    	$this->_aConds = array();
    	$this->_bIsReset = true;
    }
	
	/**
	 * Get a search param.
	 *
	 * @param string $sVar Param name.
	 * @return string Param value.
	 */
	private function _getParam($sVar)
	{
		return (isset($this->_aParams[$sVar]) ? $this->_aParams[$sVar] : '');
	}
	
	/**
	 * Reset a search.
	 *
	 */
	private function _reset()
	{		
		unset($_SESSION[AIN::getParam('core.session_prefix')]['search'][$this->_sType]);
		
		$this->_oUrl->forward($this->_oUrl->getFullUrl());
	}
	
	/**
	 * Process the search routine.
	 *
	 */
	private function _getQueries()
	{
		if ($this->_bLiveQuery === true)
		{
			return;
		}
		
		if (AIN::isModule('input') && 
			($aVals = AIN_Request::instance()->getArray('val')) &&
			isset($aVals['searchByInputs']) && $aVals['searchByInputs'])
		{
			$this->_aSearch['input'] = array();
			
			foreach ($aVals as $sName => $mValue)
			{
				if (empty($mValue)) continue;
				if (strpos($sName, 'input_') !== false)
				{
					$this->_aSearch['input'][substr($sName,6)] = $mValue;					
				}
			}
		}
		
		if ($this->_bCache)
		{
			if ($this->_oReq->get('search-id') || $this->_oReq->get('search-rid'))
			{
				if (isset($_SESSION[AIN::getParam('core.session_prefix')]['search']))
				{
					$this->_aSearch = $_SESSION[AIN::getParam('core.session_prefix')]['search'][$this->_sType];
				}
				unset($this->_aSearch['submit']);
			}
			else 
			{
				if (count($this->_aSearch))
				{
					$_SESSION[AIN::getParam('core.session_prefix')]['search'][$this->_sType] = $this->_aSearch;

					if (!$this->isSearch())
					{					
						$this->_oUrl->setParam('search-rid', md5(uniqid(rand(), true)));
						$this->_oUrl->forward($this->_oUrl->getFullUrl());
					}
				}
			}
			return;
		}

		// Search form posted
		if (is_array($this->_aSearch) && count($this->_aSearch))
		{
			if (isset($this->_aParams['custom_search']))
			{
				$aCustomSearch = $this->_oReq->getArray('custom');
				if (count($aCustomSearch))
				{
					foreach ($aCustomSearch as $iCustomKey => $mCustomValue)
					{
						if (empty($mCustomValue))
						{
							continue;
						}
						
						$this->_aSearch['custom_search_' . $iCustomKey] = $mCustomValue;
					}			
				}
			}
			
			// Created MD5 search hash which is unique to the search query.
			//$iId = md5(implode('', array_values($this->_aSearch)) . implode('', array_keys($this->_aSearch)));
			$iId = md5(uniqid());
			// Make sure no such search exists before creating it
			if (!isset($_SESSION[AIN::getParam('core.session_prefix')]['search'][$this->_sType][$iId]))
			{
				// Destroy any older searches for this specific search group
				unset($_SESSION[AIN::getParam('core.session_prefix')]['search'][$this->_sType]);
				
				foreach ($this->_aSearch as $sKey => $mValue)
				{
					if (empty($mValue))
					{
						continue;
					}

					if (is_array($mValue))
					{
						foreach ($mValue as $iKey => $sVal)
						{
							$this->_aSearch[$sKey][$sVal] = AIN::getLib('parse.input')->clean($sVal);
						}
					}
					else
					{
						$this->_aSearch[$sKey] = AIN::getLib('parse.input')->clean($mValue);
					}
				}

				// Store the search in a session array
				/*
				if (!isset($this->_aParams['no_session_search']))
				{
					$_SESSION[AIN::getParam('core.session_prefix')]['search'][$this->_sType][$iId] = $this->_aSearch;

					$this->_oUrl->setParam('search-id', $iId);
					$this->_oUrl->forward($this->_oUrl->getFullUrl());
				}
				*/
			}
		}

		if (($sSearchId = $this->_oReq->get('search-id')) && isset($_SESSION[AIN::getParam('core.session_prefix')]['search'][$this->_sType][$sSearchId]))
		{
			$this->_aSearch = $_SESSION[AIN::getParam('core.session_prefix')]['search'][$this->_sType][$sSearchId];
		}
		else
		{
			unset($_SESSION[AIN::getParam('core.session_prefix')]['search'][$this->_sType]);
		}
	}
	
	/**
	 * Get a search value.
	 *
	 * @param string $sName Search name.
	 * @return string Search value.
	 */
	private function _getVar($sName)
	{
		return (isset($this->_aSearch[$sName]) ? $this->_aSearch[$sName] : null);
	}

	/**
	 * Prepare and build the search form.
	 *
	 */
	private function _prepare()
	{
		$this->_getQueries();

		$oFilterOutput = AIN::getLib('parse.output');

		foreach ($this->_aConditions as $iKey => $aValue)
		{
			switch ($aValue['type'])
			{
				case 'multiselect':
				case 'select':
				
					if (isset($aValue['clone']))
					{
						if ($this->_getVar($iKey))
						{
							$this->_aConds[$aValue['search']] = $this->_getVar($iKey);
						}
					}
					else
					{
						$this->_aHtml[$iKey] = '<select class="form-control" '. ($aValue['type'] == 'multiselect' ? 'multiple ' :'') . (isset($aValue['id']) ? 'id="' . $aValue['id'] . '" ' : '') . 'name="search[' . $iKey . ']"' . (isset($aValue['style']) ? ' style="' . $aValue['style'] . '"' : '') . '>';
	
						if (isset($aValue['add_select']))
						{
							$this->_aHtml[$iKey] .= '<option value="">' . AIN::getPhrase('core.select') . ':</option>';	
						}
						
						if (isset($aValue['add_any']))
						{
							$this->_aHtml[$iKey] .= '<option value="">' . AIN::getPhrase('core.any') . '</option>';	
						}

						if (isset($aValue['select_value']))
						{
							$this->_aHtml[$iKey] .= '<option value="">' . $aValue['select_value'] . ':</option>';
						}
						
						$bIsChecked = 0;
						
						foreach ($aValue['options'] as $iKey2 => $sValue)
						{
							$bIsSelected = false;
							$bIsDefault = false;
							
							if (is_array($sValue))
							{
								$sValue = $sValue[0];							
							}
							
							if ($this->_getVar($iKey) == $iKey2)
							{
								if (isset($aValue['depend']) && $this->_getVar($aValue['depend']) != '')
								{
									$this->_aConds[$aValue['options'][$iKey2][1]] = $this->_getVar($aValue['depend']);	
								}
								else 
								{
									if (isset($aValue['search']))
									{
										$this->_aConds[$aValue['search']] = $this->_getVar($iKey);	
									}
								}								
	
								$bIsSelected = true;
								$bIsChecked++;
							}
							
							if ((isset($aValue['default']) && $aValue['default'] == $iKey2) || (isset($aValue['default_view']) && $aValue['default_view'] == $iKey2))
							{
								$bIsDefault = true;
							}						
												
							$this->_aHtml[$iKey] .= '<option value="' . $iKey2 . '"' . ($bIsSelected ? ' selected="selected"' : '') . '' . ($bIsDefault ? '[DEFAULT]' : '') . '>' . $sValue . '</option>' . "\n";
						}
	
						$this->_aHtml[$iKey] = str_replace('[DEFAULT]', ($bIsChecked ? '' : ' selected="selected"'), $this->_aHtml[$iKey]);
						$this->_aHtml[$iKey] .= '</select>';
		
						if (isset($this->_aConditions[$iKey]['default']) && !isset($this->_aConds[$iKey]))
						{
							$this->_aConds[$iKey] = $this->_aConditions[$iKey]['default'];
						}
					}
					
					break;			
				case 'input:text':				
					
					if ($this->_getVar($iKey) && isset($aValue['search']))
					{
						$this->_aConds[$aValue['search']] = $this->_getVar($iKey);
					}
					
					$sInputValue = $this->_getVar($iKey);
					if (isset($aValue['base64']) && !empty($sInputValue))
					{
						$sInputValue = AIN_Url::instance()->decode($sInputValue);
					}
					
					$this->_aHtml[$iKey] = '<input class="form-control" type="text" name="search[' . $iKey . ']" value="' . $oFilterOutput->clean($sInputValue) . '"';
					
					if (isset($aValue['size']))
					{
						$this->_aHtml[$iKey] .= ' size="' . $aValue['size'] . '"';
					}
					
					if (isset($aValue['onclick']))
					{
						$this->_aHtml[$iKey] = str_replace('value=""', '', $this->_aHtml[$iKey]);
						$this->_aHtml[$iKey] .= ' value="' . $aValue['onclick'] . '" onclick="if (this.value == \'' . str_replace("'", "\'", $aValue['onclick']) . '\') { this.value = \'\'; }" onblur="if (this.value == \'\') { this.value = \'' . str_replace("'", "\'", $aValue['onclick']) . '\'; }"';
					}
					
					if (isset($aValue['class']))
					{
						$this->_aHtml[$iKey] .= ' class="' . $aValue['class'] . '"';
					}
					
					$this->_aHtml[$iKey] .= ' />';
					
					break;		
				case 'input:checkbox':
					$this->_aHtml[$iKey] = '<input type="checkbox" name="search[' . $iKey . ']" value="1" />';
					
					if (isset($aValue['search']))
					{
						$this->_aConds[$aValue['search']] = $this->_getVar($iKey);
					}
					break;								
				case 'input:radio':

					$this->_aHtml[$iKey] = '';
					$bIsChecked = 0;
					foreach ($aValue['options'] as $mKey => $mValue)
					{
						$bIsSelected = false;
						$bIsDefault = false;	
						
						$iSearchKey = $iKey;
						if (is_array($mValue))
						{
							$mValue = $mValue[0];
						}

						// if ((int) $this->_getVar($iSearchKey) === $mKey)
						if ($this->_getVar($iSearchKey) == $mKey)
						{							
							if (isset($aValue['search']) && $this->_getVar($iSearchKey) != '')
							{
								$this->_aConds[$aValue['search']] = $this->_getVar($iSearchKey);
							}
							else 
							{
								if (isset($aValue['depend']) && isset($aValue['options'][$mKey][1]) && $this->_getVar($aValue['depend']) != '')
								{								
									$this->_aConds[$aValue['options'][$mKey][1]] = $this->_getVar($aValue['depend']);									
								}
							}						
								
							$bIsSelected = true;			
							$bIsChecked++;																			
						}
						else 
						{
							if ((isset($aValue['default_view']) && $aValue['default_view'] == $mKey))
							{								
								$bIsDefault = true;									
							}							
						}
										
						$this->_aHtml[$iKey] .= '<div class="radio">'. (isset($aValue['prefix']) ? $aValue['prefix'] : '') . '<label><input type="radio" name="search[' . $iKey . ']" ' . (isset($aValue['size']) ? ' size="' . (int) $aValue['size'] . '"' : '') . 'value="' . $mKey . '"' . ($bIsSelected ? ' checked="checked"' : '') . '' . ($bIsDefault ? '[DEFAULT]' : '') . ' class="v_middle" />' . $mValue. '</label>' . (isset($aValue['suffix']) ? $aValue['suffix'] : '') . '</div>';
					}
					
					$this->_aHtml[$iKey] = str_replace('[DEFAULT]', ($bIsChecked ? '' : ' checked="checked"'), $this->_aHtml[$iKey]);					
					
					break;
			}
		}
	}
}

?>
