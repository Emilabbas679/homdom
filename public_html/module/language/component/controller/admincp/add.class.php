<?php

defined('AIN') or exit('NO DICE!');

class Language_Component_Controller_Admincp_Add extends AIN_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		AIN::getUserParam('language.can_manage_lang_packs', true);
		
		$bIsEdit = false;
		
		if (($sLangId = $this->request()->get('id')))
		{
			if (($aLanguage = AIN::getService('language')->getLanguage($sLangId)) && isset($aLanguage['language_id']))
			{
				$bIsEdit = true;
				
				$aLanguage['language_code'] = $sLangId;
				
				$this->template()->assign(array(
						'aForms' => $aLanguage
					)
				);
			}
		}
		
		if (($sLanguageId = $this->request()->get('import-phrase')))
		{
			$iPage = $this->request()->getInt('page', 0);
			$iLimit = 500;
			
			$iCnt = AIN::getService('language.phrase.process')->importPhrases($sLanguageId, $iPage, $iLimit);			
			
			AIN::getLib('pager')->set(array('page' => $iPage, 'size' => $iLimit, 'count' => $iCnt));

			$iTotalPages = (int) AIN::getLib('pager')->getTotalPages();
			$iCurrentPage = (int) AIN::getLib('pager')->getCurrentPage();
			$iPage = (int) AIN::getLib('pager')->getNextPage();
			
			if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
			{
				$this->url()->send('language', null, AIN::getPhrase('language.language_package_successfully_added'));
			}	
			
			$this->template()
				->setHeader('<meta http-equiv="refresh" content="2;url=' . $this->url()->makeUrl('language.add', array('import-phrase' => $sLanguageId, 'page' => $iPage)) . '">')
				->assign(array(
					'bImportingPhrases' => true,
					'iCurrentPage' => $iCurrentPage,
					'iTotalPages' => $iTotalPages
				)
			);		
		}
		else 
		{
			if (($aVals = $this->request()->getArray('val')))
			{
				if ($bIsEdit)
				{
					if (AIN::getService('language.process')->update($sLangId, $aVals))
					{
						$this->url()->send('language.add', array('id' => $sLangId), AIN::getPhrase('language.language_package_successfully_updated'));
					}				
				}
				else 
				{
					if (($sLanguageId = AIN::getService('language.process')->add($aVals)))
					{
						$this->url()->send('language.add', array('import-phrase' => $sLanguageId));
					}	
				}
			}		
		}		
		$this->template()->setTitle(($bIsEdit ? AIN::getPhrase('language.editing_language_package') . ': ' . $aLanguage['title'] : AIN::getPhrase('language.create_a_new_language_package')))
			->assign(array(
					'aLanguages' => AIN::getService('language')->getAll(),
					'bIsEdit' => $bIsEdit
				)
			);
	}
}
?>