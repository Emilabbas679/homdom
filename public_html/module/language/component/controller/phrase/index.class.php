<?php

defined('AIN') or exit('NO DICE!');

class language_component_controller_phrase_index extends AIN_Component
{
	/**
	 * Controller
	 */
	public function process()
{

		$aForms = array();
		$iPage = $this->request()->getInt('page');
		$oPhraseProcess = AIN::getService('language.phrase.process');
		$oCache = AIN::getLib('cache');
		$iPageSize = 10;
		$oUrl = AIN::getLib('url');

		if ($this->request()->get('save') && ($aTexts = $this->request()->getArray('text')))
		{
			foreach ($aTexts as $iKey => $sText)
			{
				$oPhraseProcess->update($iKey, $sText);
			}

			$oCache->remove('locale', 'substr');

			$this->url()->send('current', array(), AIN::getPhrase('language.phrase_s_updated'));
		}


        if ($this->request()->get('delete') && ($aIds = $this->request()->getArray('id')))
        {
            foreach ($aIds as $iId)
            {
                $oPhraseProcess->delete($iId);
            }

            $oCache->removeGroup('locale');

			$this->url()->send('current', null, AIN::getPhrase('language.selected_phrase_s_successfully_deleted'));
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




			$aForms = array_merge($aVals,$aForms);
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



		$table = AIN::getService('video.func.table');
		foreach($aRows as $key => $aRow)
		{
			$table->add(
				array(
					'sabit' => '<input type="checkbox" name="id[]" class="checkbox" value="'.$aRow['phrase_id'].'" id="js_id_row'.$aRow['phrase_id'].'" />',
					AIN::getPhrase('language.variable') => '<input type="text" name="null" value="'.$aRow['name'].'.'.$aRow['var_name'].'" size="25" style="width:95%;"/>',
					AIN::getPhrase('language.language') => $aRow['language_id'],
					AIN::getPhrase('language.original') => $aRow['sample_text'],
					AIN::getPhrase('language.text') => '<textarea id="editor-full" class="editor-full" cols="80" rows="6" name="text['.$aRow['phrase_id'].']" class="text" style="width:95%;">'.$aRow['text'].'</textarea>',
				)
			);
		}

		$this->template()->assign(array('aTables' => $table->execute() ));

		$this->template()->assign(array(
			'aForms' => $aForms,
			'aRows' => $aRows,
			'iPage' => $iPage,
			'iLangId' => $iLangId,
			'aLanguages' => AIN::getService('language')->getAll(),
			)
		);
	}
}
?>