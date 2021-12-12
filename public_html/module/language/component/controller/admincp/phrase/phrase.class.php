<?php

defined('AIN') or exit('NO DICE!');

class Language_Component_Controller_Admincp_Phrase_Phrase extends AIN_Component 
{
	/**
	 * Controller
	 */
	public function process()
	{
		AIN::getUserParam('language.can_manage_lang_packs', true);
		
		$aForms = array();
		$iPage = $this->request()->getInt('page');
		$oPhraseProcess = AIN::getService('language.phrase.process');
		$oCache = AIN::getLib('cache');
		$iPageSize = 15;
		$oUrl = AIN::getLib('url');
		
		
		if ($this->request()->get('save') && ($aTexts = $this->request()->getArray('text')))
		{
			foreach ($aTexts as $iKey => $sText)
			{			
				$oPhraseProcess->update($iKey, $sText);
			}
			
			$oCache->remove('locale', 'substr');
			
			$this->url()->send('current', null, AIN::getPhrase('language.phrase_s_updated'));
		}
		
		
		
		
		if ($iLangId = $this->request()->get('lang-id'))
		{
			
			

		}
		
		
		$where = array();
		if ($aVals = $this->request()->getArray('val'))	
		{	
			$aForms = $aVals;
			if( isset($aVals['search']) and strlen($aVals['search']) > 1  )
			{
				$where[] = '(lp.var_name LIKE "%'.$aVals['search'].'%" or lp.text LIKE "%'.$aVals['search'].'%" or lp.text_default LIKE "%'.$aVals['search'].'%")';
				$oUrl->setParam('val[search]', $aVals['search']);
			}	
	
			if( isset($aVals['language_id']) and strlen($aVals['language_id']) > 1  )
			{
				$where[] = '(lp.language_id = "'.$aVals['language_id'].'")';
				$oUrl->setParam('val[language_id]', $aVals['language_id']);
			}
			
	
			if( isset($aVals['module_id']) and strlen($aVals['module_id']) > 1  )
			{
				$where[] = '(lp.module_id = "'.$aVals['module_id'].'")';
				$oUrl->setParam('val[module_id]', $aVals['module_id']);
			}
	
		}
		
		if( isset($where) and count($where) > 0 )
		{
			$where = implode(" AND ", $where);
		}
		
		list($iCnt, $aRows) = AIN::getService('language.phrase')->get($where, 'lp.phrase_id DESC', $iPage, $iPageSize);
		
		$aOut = array();
		foreach ($aRows as $iKey => $aRow)
		{
			$aOut[$aRow['phrase_id']] = $aRow;
			$aOut[$aRow['phrase_id']]['sample_text'] = $aRow['text_default'];	
			$aOut[$aRow['phrase_id']]['is_translated'] = (md5($aRow['text_default']) != md5($aRow['text']) ? true : false);
		}
		$aRows = $aOut;		
		
		
		AIN::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt ));
		
		$this->template()->assign(array(
			'aForms' => $aForms,
			'aRows' => $aRows,
			'iPage' => $iPage,
			'iLangId' => $iLangId,
			'aLanguages' => AIN::getService('language')->getAll(),
			'aModules' => AIN::getLib('module')->getModules(),
			)
		);
	}
}
?>