<?php

defined('AIN') or exit('NO DICE!');

class Language_Service_Process extends AIN_Service
{
    private $_aFile = [];

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->_sTable = AIN::getT('language');
    }

	
    public function add($aVals)
    {
        $aCheck = [
            'parent_id'     => [
                'type'    => 'string:required',
                'message' => AIN::getPhrase('language.select_a_language_package_to_clone')
            ],
            'title'         => [
                'type'    => 'string:required',
                'message' => AIN::getPhrase('language.provide_a_name_for_your_language_package')
            ],
            'language_code' => [
                'type'    => 'string:required',
                'message' => AIN::getPhrase('language.provide_an_abbreviation_code')
            ],
        ];

        $aVals = $this->validator()->process($aCheck, $aVals);

        if (!AIN_Error::isPassed()) {
            return false;
        }
		
        $aOlds = $this->database()->select('title')
            ->from($this->_sTable)
            ->where("title LIKE '%" . $this->database()->escape($aVals['title']) . "%'")
            ->execute('getRows');

        $iTotal = 0;
        foreach ($aOlds as $aOld) {
            if (preg_replace("/(.*?)\([0-9]\)/i", "$1", $aOld['title']) === $aVals['title']) {
                $iTotal++;
            }
        }

        $aOldsId = $this->database()->select('language_id')
            ->from($this->_sTable)
            ->where("language_id LIKE '%" . $this->database()->escape($aVals['language_code']) . "%'")
            ->execute('getRows');

        $iTotalId = 0;
        foreach ($aOldsId as $aOldId) {
            if (preg_replace("/(.*?)-[0-9]/i", "$1", $aOldId['language_id']) === $aVals['language_code']) {
                $iTotalId++;
            }
        }

        $sLanguageId = $aVals['language_code'] . ($iTotalId > 0 ? '-' . ($iTotalId + 1) . '' : '');

		
        $this->database()->insert($this->_sTable, [
                'language_id'   => $sLanguageId,
                'parent_id'     => $aVals['parent_id'],
                'title'         => $aVals['title'] . ($iTotal > 0 ? '(' . ($iTotal + 1) . ')' : ''),
                'is_default'    => 0,
                'is_master'     => 0
            ]
        );
		
        $this->cache()->remove('locale', 'substr');

        return $sLanguageId;
	}	
    public function update($sLangId, $aVals)
    {
        $aCheck = [
            'title'         => [
                'type'    => 'string:required',
                'message' => AIN::getPhrase('language.provide_a_name_for_your_language_package')
            ]
        ];
        $aVals = $this->validator()->process($aCheck, $aVals);
		
        if (!AIN_Error::isPassed()) {
            return false;
        }
		
        $aVals['title'] = $this->preParse()->clean($aVals['title']);

        $this->database()->update(AIN::getT('language'), $aVals, 'language_id = \'' . $this->database()->escape($sLangId) . '\'');

        $this->cache()->remove('locale', 'substr');

        return true;
	}
	
}
?>