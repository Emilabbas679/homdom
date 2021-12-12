<?php
defined('AIN') or exit('NO DICE!');

class AIN_Template_Cache extends AIN_Template
{

    private $_aForeachElseStack = array();
    //private $_aSectionelseStack = array();
    //private $_aModuleBlocks = array();
    // PLugin Baza Include olur
    private $_aRequireStack = array();

    private $_sDbQstrRegexp = '"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"';

    private $_sSiQstrRegexp = '\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'';

    private $_sVarBracketRegexp = '\[[\$|\#]?\w+\#?\]';


    // If tag ayarlarini burdan chekirn
    private $_sSvarRegexp = '\%\w+\.\w+\%';
    // If functisayalarin controlu buradan ayarlayir
    private $_sFuncRegexp = '[a-zA-Z_]+';
	



    private $_sCurrentFile = '';

    public function __construct()
    {
        $this->_sQstrRegexp = '(?:' . $this->_sDbQstrRegexp . '|' . $this->_sSiQstrRegexp . ')';

        $this->_sDvarRegexp = '\$[a-zA-Z0-9_]{1,}(?:' . $this->_sVarBracketRegexp . ')*(?:\.\$?\w+(?:' . $this->_sVarBracketRegexp . ')*)*';

        $this->_sCvarRegexp = '\#[a-zA-Z0-9_]{1,}(?:' . $this->_sVarBracketRegexp . ')*(?:' . $this->_sVarBracketRegexp . ')*\#';

        $this->_sVarRegexp = '(?:(?:' . $this->_sDvarRegexp . '|' . $this->_sCvarRegexp . ')|' . $this->_sQstrRegexp . ')';

        $this->_sModRegexp = '(?:\|@?[0-9a-zA-Z_]+(?::(?>-?\w+|' . $this->_sDvarRegexp . '|' . $this->_sQstrRegexp .'))*)';
    }

    public function compile($sName, $sData = null, $bRemoveHeader = false, $bSkipDbCheck = false)
    {
        $sData = $this->_parse($sData, $bRemoveHeader);

        if (defined('AIN_INSTALLER_NO_TMP'))
        {
            return $sData;
        }

        $sContent = '';
        $aLines = explode("\n", $sData);


        foreach ($aLines as $sLine)
        {
            if (preg_match("/<\?php(.*?)\?>/i", $sLine))
            {

                if (substr(trim($sLine), 0, 5) == '<?php')
                {
                    $sContent .= trim($sLine) . "\n";

                }
                else
                {
                    $sContent .= $sLine . "\n";
                }
            }
            else
            {
                $sContent .= $sLine . "\n";
            }
        }
        $sContent = preg_replace("/defined\('AIN'\) or exit\('NO DICE!'\);/is", "", $sContent);

        $sContent = "<?php defined('AIN') or exit('NO DICE!'); ?>\n" . $sContent;

        if ($rFile = @fopen($sName, 'w+'))
        {
            fwrite($rFile, $sContent);
            fclose($rFile);
        }
        else
        {
            return AIN_Error::trigger('Unable to cache template file: ' . $sName, E_USER_NOTICE);
        }
    }

    public function getAll()
    {
        if ($hDir = @opendir(AIN_DIR_CACHE))
        {
            $aFiles = array();
            while ($sFile = readdir($hDir))
            {
                if (substr($sFile, 0, 9) != 'template_')
                {
                    continue;
                }

                $aFiles[] = array(
                    'id' => md5($sFile),
                    'name' => $sFile,
                    'size' => filesize(AIN_DIR_CACHE . $sFile),
                    'date' => filemtime((AIN_DIR_CACHE . $sFile)),
                    'type' => 'Template'
                );
            }
            closedir($hDir);

            return $aFiles;
        }

        return array();
    }
    public function remove($sName = null)
    {
        if ($sName === null)
        {
            foreach ($this->getAll() as $aFile)
            {
                @unlink(AIN_DIR_CACHE . $aFile['name']);
            }
            return true;
        }

        if (file_exists(AIN_DIR_CACHE . $sName))
        {
            @unlink(AIN_DIR_CACHE . $sName);
            return true;
        }

        return false;
    }
    public function parse($sData, $bRemoveHeader = false)
    {
        $sData = $this->_parse($sData, $bRemoveHeader);

        return $sData;
    }
    private function _parseForm($aMatches)
    {
        $sForm = $aMatches[1];
        $sData = $aMatches[2];

        $sForm = '<form' . stripslashes($sForm) . ">";
        $sForm .= stripslashes($sData) . "\n";
        $sForm .= '</form>' . "\n";

        return $sForm;
    }



    private function _parse($sData, $bRemoveHeader = false)
    {
        $sLdq = preg_quote($this->sLeftDelim);
        $sRdq = preg_quote($this->sRightDelim);

        $aText = array();
        $sCompiledText = '';
        // Remove AIN SVN headers
        $sData = preg_replace("/\<\!AIN(.*?)\>/is", "", $sData);

        // Add a security token in a form
        $sData = preg_replace_callback("/<form(.*?)>(.*?)<\/form>/is", array($this, '_parseForm'), $sData);

        // remove all comments
        $sData = preg_replace("/{$sLdq}\*(.*?)\*{$sRdq}/s", "", $sData);

        // remove literal blocks
		$sData = preg_replace_callback("/{$sLdq}literal{$sRdq}(.*?){$sLdq}\/literal{$sRdq}/is", function($data){return "<?php echo '" . str_replace("'", "\'", $data[1]) . "'; ?>"; }, $sData);
		//PhP faylını icra edir.
		$sData = preg_replace_callback("/{$sLdq}php{$sRdq}(.*?){$sLdq}\/php{$sRdq}/is", function($data){return '<?php '.trim($data[1]).' ?>'; }, $sData);
		
		
		//yield
        $sData = preg_replace_callback('/@yield\(\'(.*?)\'\)/', function ($yieldName) { return "<?php \$this->_yield('{$yieldName[1]}') ?>";}, $sData);			
		$sData = preg_replace_callback('/@section\(\'(.*?)\'\)(.*?)@endsection/s', function ($sectionName) { return AIN::getLib('template')->getBuiltSectionFile($sectionName); }, $sData);	
			
        $aText = preg_split("!{$sLdq}.*?{$sRdq}!s", $sData);
        preg_match_all("!{$sLdq}\s*(.*?)\s*{$sRdq}!s", $sData, $aMatches);
        $aTags = $aMatches[1];

        $aCompiledTags = array();
        $iCompiledTags = count($aTags);
        for ($i = 0, $iForMax = $iCompiledTags; $i < $iForMax; $i++)
        {
            $aCompiledTags[] = $this->_compileTag($aTags[$i]);
        }
        $iCountCompiledTags = count($aCompiledTags);
        for ($i = 0, $iForMax = $iCountCompiledTags; $i < $iForMax; $i++)
        {
            if ($aCompiledTags[$i] == '')
            {
                $aText[$i+1] = preg_replace('~^(\r\n|\r|\n)~', '', $aText[$i+1]);
            }
            $sCompiledText .= $aText[$i].$aCompiledTags[$i];
        }

        $sCompiledText .= $aText[$i];

        foreach ($this->_aRequireStack as $mKey => $mValue)
        {
            $sCompiledText = '<?php require_once(\''. AIN_DIR_TPL_PLUGIN . $mKey . '\'); $this->_register("' . $mValue[0] . '", "' . $mValue[1] . '", "' . $mValue[2] . '"); ?>' . $sCompiledText;
        }

        $sCompiledText = preg_replace('!\?>\n?<\?php!', '', $sCompiledText);

        $sCompiledText = '<?php /* Cached: ' . date("F j, Y, g:i a", time()) . ' */ ?>' . "\n" . $sCompiledText;

        return $sCompiledText;
    }
    /**
     *
     * @param string $sTag Name of the tag to parse.
     * @return string Converted block of code based on the tag.
     */
    private function _compileTag($sTag, $bKeepOriginalOnError = false)
    {
        preg_match_all('/(?:(' . $this->_sVarRegexp . '|' . $this->_sSvarRegexp . '|\/?' . $this->_sFuncRegexp . ')(' . $this->_sModRegexp . '*)(?:\s*[,\.]\s*)?)(?:\s+(.*))?/xs', $sTag, $aMatches);

        if ($aMatches[1][0][0] == '$' || $aMatches[1][0][0] == "'" || $aMatches[1][0][0] == '"')
        {
            return "<?php echo " . $this->_parseVariables($aMatches[1], $aMatches[2]) . "; ?>";
        }

        $sTagCommand = $aMatches[1][0];
        $sTagModifiers = !empty($aMatches[2][0]) ? $aMatches[2][0] : null;
        $sTagArguments = !empty($aMatches[3][0]) ? $aMatches[3][0] : null;

        $result = $this->_parseFunction($sTagCommand, $sTagModifiers, $sTagArguments, $bKeepOriginalOnError);


        return $result;
    }
    /**
     * Compile IF statments.
     *
     * @param string $sArguments If statment arguments.
     * @param bool $bElseif TRUE if this is an ELSEIF.
     * @param bool $bWhile TRUE of this is a WHILE loop.
     * @return string Returns the converted PHP if statment code.
     */
    private function _compileIf($sArguments, $bElseif = false, $bWhile = false)
    {
        $aAllowed = array(
            'defined', 'is_array', 'isset', 'empty', 'count', '=',
        );

        $sResult = "";
        $aArgs = array();
        $aArgStack	= array();

        preg_match_all('/(?>(' . $this->_sVarRegexp . '|\/?' . $this->_sSvarRegexp . '|\/?' . $this->_sFuncRegexp . ')(?:' . $this->_sModRegexp . '*)?|\-?0[xX][0-9a-fA-F]+|\-?\d+(?:\.\d+)?|\.\d+|!==|===|==|!=|<>|<<|>>|<=|>=|\&\&|\|\||\(|\)|,|\!|\^|=|\&|\~|<|>|\%|\+|\-|\/|\*|\@|\b\w+\b|\S+)/x', $sArguments, $aMatches);
        $aArgs = $aMatches[0];

        $iCountArgs = count($aArgs);
        for ($i = 0, $iForMax = $iCountArgs; $i < $iForMax; $i++)
        {
            $sArg = &$aArgs[$i];
            switch (strtolower($sArg))
            {
                case '!':
                case '%':
                case '!==':
                case '==':
                case '===':
                case '>':
                case '<':
                case '!=':
                case '<>':
                case '<<':
                case '>>':
                case '<=':
                case '>=':
                case '&&':
                case '||':
                case '^':
                case '&':
                case '~':
                case ')':
                case ',':
                case '+':
                case '-':
                case '*':
                case '/':
                case '@':
                    break;
                case 'eq':
                    $sArg = '==';
                    break;
                case 'ne':
                case 'neq':
                    $sArg = '!=';
                    break;
                case 'lt':
                    $sArg = '<';
                    break;
                case 'le':
                case 'lte':
                    $sArg = '<=';
                    break;
                case 'gt':
                    $sArg = '>';
                    break;
                case 'ge':
                case 'gte':
                    $sArg = '>=';
                    break;
                case 'and':
                    $sArg = '&&';
                    break;
                case 'or':
                    $sArg = '||';
                    break;
                case 'not':
                    $sArg = '!';
                    break;
                case 'mod':
                    $sArg = '%';
                    break;
                case '(':
                    array_push($aArgStack, $i);
                    break;
                case 'is':
                    $iIsArgCount = count($aArgs);
                    $sIsArg = implode(' ', array_slice($aArgs, 0, $i - 0));
                    $aArgTokens = $this->_compileParseIsExpr($sIsArg, array_slice($aArgs, $i+1));
                    array_splice($aArgs, 0, count($aArgs), $aArgTokens);
                    $i = $iIsArgCount - count($aArgs);
                    break;
                default:
                    preg_match('/(?:(' . $this->_sVarRegexp . '|' . $this->_sSvarRegexp . '|' . $this->_sFuncRegexp . ')(' . $this->_sModRegexp . '*)(?:\s*[,\.]\s*)?)(?:\s+(.*))?/xs', $sArg, $aMatches);

                    if (isset($aMatches[0][0]) && ($aMatches[0][0] == '$' || $aMatches[0][0] == "'" || $aMatches[0][0] == '"'))
                    {
                        $sArg = $this->_parseVariables(array($aMatches[1]), array($aMatches[2]));
                    }

                    if ( preg_match('/frontend_([a-zA-Z0-9]+)_template/i', $this->_sCurrentFile) )
                    {
                        if (strtolower($sArg) != 'ain'
                            && !in_array(trim($sArg, "'"), $aAllowed)
                            && substr($sArg, 0, 2) != '::'
                            && substr($sArg, 0, 5) != '$this'
                        )
                        {
                            if (function_exists($sArg))
                            {
                                $sArg = '';
                            }
                        }
                    }

                    break;
            }
        }

        if($bWhile)
        {
            return implode(' ', $aArgs);
        }
        else
        {
            if ($bElseif)
            {
                return '<?php elseif ('.implode(' ', $aArgs).'): ?>';
            }
            else
            {
                return '<?php if ('.implode(' ', $aArgs).'): ?>';
            }
        }

        return $sResult;
    }
    /**
     * Parse variables.
     *
     * @param array $aVariables ARRAY of variables.
     * @param array $aModifiers ARRAY of modifiers.
     * @return string Converted variable.
     */
    private function _parseVariables($aVariables, $aModifiers)
    {
        $sResult = "";
        foreach($aVariables as $mKey => $mValue)
        {
            if (empty($aModifiers[$mKey]))
            {
                $sResult .= $this->_parseVariable(trim($aVariables[$mKey])).'.';
            }
            else
            {
                $sResult .= $this->_parseModifier($this->_parseVariable(trim($aVariables[$mKey])), $aModifiers[$mKey]).'.';
            }
        }
        return substr($sResult, 0, -1);
    }
    /**
     * Parse a specific variable.
     *
     * @param string $sVariable Name of the variable we are parsing.
     * @return string Converted variable.
     */
    private function _parseVariable($sVariable)
    {
        if ($sVariable[0] == "\$")
        {
            return $this->_compileVariable($sVariable);
        }
        else
        {
            return $sVariable;
        }
    }
    /**
     * Compile all variables.
     *
     * @param string $sVariable Variable name.
     * @return string Converted variable.
     */
    private function _compileVariable($sVariable)
    {
        $sResult = '';
        $sVariable = substr($sVariable, 1);

        preg_match_all('!(?:^\w+)|(?:' . $this->_sVarBracketRegexp . ')|\.\$?\w+|\S+!', $sVariable, $aMatches);
        $aVariables = $aMatches[0];
        $sVarName = array_shift($aVariables);

        if ($sVarName == $this->sReservedVarname)
        {
            if ($aVariables[0][0] == '[' || $aVariables[0][0] == '.')
            {
                $aFind = array("[", "]", ".");
                switch(strtoupper(str_replace($aFind, "", $aVariables[0])))
                {
                    case 'GET':
                        $sResult = "\$_GET";
                        break;
                    case 'POST':
                        $sResult = "\$_POST";
                        break;
                    case 'COOKIE':
                        $sResult = "\$_COOKIE";
                        break;
                    case 'ENV':
                        $sResult = "\$_ENV";
                        break;
                    case 'SERVER':
                        $sResult = "\$_SERVER";
                        break;
                    case 'SESSION':
                        $sResult = "\$_SESSION";
                        break;
                    default:
                        $sVar = str_replace($aFind, "", $aVariables[0]);
                        $sResult = "\$this->_aAINVars['$sVar']";
                        break;
                }
                array_shift($aVariables);
            }
            else
            {
                AIN_Error::trigger('$' . $sVarName.implode('', $aVariables) . ' is an invalid AIN reference', E_USER_ERROR);
            }
        }
        else
        {
            $sResult = "\$this->_aVars['$sVarName']";
            // $sResult = "\$this->getVar('$sVarName')";
        }

        foreach ($aVariables as $sVar)
        {
            if ($sVar[0] == '[')
            {
                $sVar = substr($sVar, 1, -1);
                if (is_numeric($sVar))
                {
                    $sResult .= "[$sVar]";
                }
                elseif ($sVar[0] == '$')
                {
                    $sResult .= "[" . $this->_compileVariable($sVar) . "]";
                }
                else
                {
                    $parts = explode('.', $sVar);
                    $section = $parts[0];
                    $section_prop = isset($parts[1]) ? $parts[1] : 'index';
                    $sResult .= "[\$this->_aSections['$section']['$section_prop']]";
                }
            }
            elseif ($sVar[0] == '.')
            {
                $sResult .= "['" . substr($sVar, 1) . "']";
            }
            elseif (substr($sVar,0,2) == '->')
            {
                AIN_Error::trigger('Call to object members is not allowed', E_USER_ERROR);
            }
            else
            {
                AIN_Error::trigger('$' . $sVarName.implode('', $aVariables) . ' is an invalid reference', E_USER_ERROR);
            }
        }
        return $sResult;
    }
    /**
     * Remove quotes from PHP variables.
     *
     * @param string $string PHP variable to work with.
     * @return string Converted PHP variable.
     */
    private function _removeQuote($string)
    {
        if (($string[0] == "'" || $string[0] == '"') && $string[strlen($string)-1] == $string[0])
        {
            return substr($string, 1, -1);
        }
        else
        {
            return $string;
        }
    }
    /**
     * Parse all the custom tags used within templates. In templates we
     * do not use conventional PHP code as we seperate PHP logic from the
     * template. The tags we use work similar to that off SMARTY.
     *
     * @param string $sFunction Name of the function.
     * @param string $sModifiers Modifiers.
     * @param string $sArguments Any arguments we are passing.
     * @return string Converted PHP value of the function.
     */
    private function _parseFunction($sFunction, $sModifiers, $sArguments)
    {
        switch ($sFunction)
        {
            /**
             * SMARTY
             */
            case 'ldelim':
                return $this->sLeftDelim;
                break;
            case 'rdelim':
                return $this->sRightDelim;
                break;


            case 'iterate':
                $aArgs = $this->_parseArgs($sArguments);
                return '<?php ' . $aArgs['int'] . '++; ?>';
                break;
            case 'for':
                $sArguments = preg_replace_callback("/\\$([A-Za-z0-9]+)/is", function($matches) {
                    return $this->_parseVariable($matches[0]);
                }, $sArguments);

                return '<?php for (' . $sArguments . '): ?>';
                break;
            case '/for':
                return "<?php endfor; ?>";
                break;



            case 'l':
                return '{';
                break;
            case 'r':
                return '}';
                break;
            case 'assign':
                $aArgs = $this->_parseArgs($sArguments);
                if (!isset($aArgs['var']))
                {
                    return '';
                }
                if (!isset($aArgs['value']))
                {
                    return '';
                }
                return '<?php $this->assign(\'' . $this->_removeQuote($aArgs['var']) . '\', ' . $aArgs['value'] . '); ?>';
                break;
            case 'url':
                $aArgs = $this->_parseArgs($sArguments);
                if (!isset($aArgs['link']))
                {
                    return '';
                }
                $sLink = $aArgs['link'];
                unset($aArgs['link']);
                $sArray = '';
                if (count($aArgs))
                {
                    $sArray = ', array(';
                    foreach ($aArgs as $sKey => $sValue)
                    {
                        $sArray .= '\'' . $sKey . '\' => ' . $sValue . ',';
                    }
                    $sArray = rtrim($sArray, ',') . ')';
                }
                return '<?php echo AIN::getLib(\'url\')->makeUrl(' . $sLink . $sArray . '); ?>';
                break;





            case 'token':
                return '<?php echo AIN::getLib(\'request\')->getIdHash(); ?>';
                break;

            case 'unset':
                $aArgs = $this->_parseArgs($sArguments);
                return '<?php unset(' . implode(', ', $aArgs) . '); ?>';
                break;
            case 'if':
                return $this->_compileIf($sArguments);
                break;
            case 'else':
                return "<?php else: ?>";
                break;
            case 'elseif':
                return $this->_compileIf($sArguments, true);
                break;
            case '/if':
                return "<?php endif; ?>";
                break;

            case 'foreach':
                array_push($this->_aForeachElseStack, false);
                $aArgs = $this->_parseArgs($sArguments);
                if (!isset($aArgs['from']))
                {
                    return '';
                }
                if (!isset($aArgs['value']) && !isset($aArgs['item']))
                {
                    return '';
                }
                if (isset($aArgs['value']))
                {
                    $aArgs['value'] = $this->_removeQuote($aArgs['value']);
                }
                elseif (isset($aArgs['item']))
                {
                    $aArgs['value'] = $this->_removeQuote($aArgs['item']);
                }

                (isset($aArgs['key']) ? $aArgs['key'] = "\$this->_aVars['".$this->_removeQuote($aArgs['key'])."'] => " : $aArgs['key'] = '');

                $bIteration = (isset($aArgs['name']) ? true : false);

                $sResult = '<?php if (count((array)' . $aArgs['from'] . ')): ?>' . "\n";
                if ($bIteration)
                {
                    $sResult .= '<?php $this->_aAINVars[\'iteration\'][\'' . $aArgs['name'] . '\'] = 0; ?>' . "\n";
                }
                $sResult .= '<?php foreach ((array) ' . $aArgs['from'] . ' as ' . $aArgs['key'] . '$this->_aVars[\'' . $aArgs['value'] . '\']): ?>';
                if ($bIteration)
                {
                    $sResult .= '<?php $this->_aAINVars[\'iteration\'][\'' . $aArgs['name'] . '\']++; ?>' . "\n";
                }
                return $sResult;
                break;
            case 'foreachelse':
                $this->_aForeachElseStack[count($this->_aForeachElseStack)-1] = true;
                return "<?php endforeach; else: ?>";
                break;
            case '/foreach':
                if (array_pop($this->_aForeachElseStack))
                {
                    return "<?php endif; ?>";
                }
                else
                {
                    return "<?php endforeach; endif; ?>";
                }
                break;
            case 'value':
                $aArgs = $this->_parseArgs($sArguments);
                $aArgs = array_map(array($this, '_removeQuote'), $aArgs);
                // Accept variables in ids
                if (substr($aArgs['id'], 0, 14) == '$this->_aVars[')
                {
                    $aArgs['id'] = '\'.' . $aArgs['id'] .'.\'';
                }

                switch($aArgs['type'])
                {
                    case 'input':
                        $sContent = '<?php $aParams = (isset($aParams) ? $aParams : AIN::getLib(\'request\')->getArray(\'val\')); echo (isset($aParams[\'' . $aArgs['id'] . '\']) ? AIN::getLib(\'parse.output\')->clean($aParams[\'' . $aArgs['id'] . '\']) : (isset($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\']) ? AIN::getLib(\'parse.output\')->clean($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\']) : ' . (isset($aArgs['default']) ? '\'' . $aArgs['default'] . '\'' : '\'\'' ) . ')); ?>' . "\n";
                        break;
                    case 'radio':
                        $sContent = '<?php $aParams = (isset($aParams) ? $aParams : AIN::getLib(\'request\')->getArray(\'val\'));';
                        $sContent .= "\n".'if (isset($this->_aVars[\'aForms\']) && is_numeric(\''.$aArgs["id"].'\') && in_array(\''.$aArgs["id"].'\', $this->_aVars[\'aForms\']) ){echo \' checked="checked"\';}';
                        $sContent .= "\n".'if ((isset($aParams[\'' . $aArgs['id'] . '\']) && $aParams[\'' . $aArgs['id'] . '\'] == \'' . $aArgs['default'] . '\'))';
                        $sContent .= "\n".'{echo \' checked="checked" \';}';
                        $sContent .= "\n".'else';
                        $sContent .= "\n".'{';
                        $sContent .= "\n".' if (isset($this->_aVars[\'aForms\']) && isset($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\']) && !isset($aParams[\'' . $aArgs['id'] . '\']) && $this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\'] == \'' . $aArgs['default'] . '\')';
                        $sContent .= "\n".' {';
                        $sContent .= "\n".'    echo \' checked="checked" \';}';
                        $sContent .= "\n".' else';
                        $sContent .= "\n".' {';
                        if (isset($aArgs['selected']))
                        {
                            $sContent .= "\n".' if (!isset($this->_aVars[\'aForms\']) || ((isset($this->_aVars[\'aForms\']) && !isset($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\']) && !isset($aParams[\'' . $aArgs['id'] . '\']))))';
                            $sContent .= "\n".'{';
                            $sContent .= "\n".' echo \' checked="checked"\';';
                            $sContent .= "\n".'}';
                        }

                        $sContent .= "\n".' }';
                        $sContent .= "\n".'}';
                        $sContent .= "\n".'?>' . " \n";
                        break;
                    case 'checkbox':
                    case 'multiselect':
                    case 'select':
                        $bIsCheckbox = ($aArgs['type'] == 'checkbox' ? 'checked="checked"' : 'selected="selected"');
                        $aArgs['default'] = $this->_removeQuote($aArgs['default']);
                        if (substr($aArgs['default'], 0, 1) == '$')
                        {
                            $sDefault = $aArgs['default'];
                        }
                        elseif (substr($aArgs['default'], 0, 2) == ".\$")
                        {
                            $sDefault = trim($aArgs['default'], '.');
                        }
                        else
                        {
                            $sDefault = "'{$aArgs['default']}'";
                        }

                        $sContent = '<?php $aParams = (isset($aParams) ? $aParams : AIN::getLib(\'request\')->getArray(\'val\'));'.
                            "\n" . '';
                        $sContent .= "\n\n".'if (isset($this->_aVars[\'aField\']) && isset($this->_aVars[\'aForms\'][$this->_aVars[\'aField\'][\'field_id\']]) && !is_array($this->_aVars[\'aForms\'][$this->_aVars[\'aField\'][\'field_id\']]))
							{
								$this->_aVars[\'aForms\'][$this->_aVars[\'aField\'][\'field_id\']] = array($this->_aVars[\'aForms\'][$this->_aVars[\'aField\'][\'field_id\']]);
							}';
                        $sContent .= "\n\n".'if (isset($this->_aVars[\'aForms\']'. (isset($aArgs['parent']) ? '[\''.$aArgs["parent"].'\']' : '') .')';
                        $sContent .= "\n".' && is_numeric(\''.$aArgs["id"].'\') && in_array(\''.$aArgs["id"].'\', $this->_aVars[\'aForms\']'. (isset($aArgs['parent']) ? '[\''.$aArgs["parent"].'\']' : '') .'))
							'."\n".'{
								echo \' ' . $bIsCheckbox . ' \';
							}'."\n".'
							if (isset($aParams[\'' . $aArgs['id'] . '\'])
								&& $aParams[\'' . $aArgs['id'] . '\'] == ' . $sDefault . ')'."\n".'
							{'."\n".'
								echo \' ' . $bIsCheckbox . ' \';'."\n".'
							}'."\n".'
							else'."\n".'
							{'."\n".'
								if (isset($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\'])
									&& !isset($aParams[\'' . $aArgs['id'] . '\'])
									&& $this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\'] == ' . $sDefault . ')
								{
								 echo \' ' . $bIsCheckbox . ' \';
								}
								else
								{
									echo ' . (isset($aArgs['selected']) ? '" ' . str_replace('"', '\"', $bIsCheckbox) . '"' : '""') . ';
								}
							}
							?>' . "\n";
                        break;
                    case 'wysiwyg':
                    case 'textarea':
                        $sContent = '<?php $aParams = (isset($aParams) ? $aParams : AIN::getLib(\'request\')->getArray(\'val\')); echo (isset($aParams[\'' . $aArgs['id'] . '\']) ? AIN::getLib(\'parse.output\')->clean($aParams[\'' . $aArgs['id'] . '\']) : (isset($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\']) ? AIN::getLib(\'parse.output\')->clean($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\']) : \'\')); ?>' . "\n";
                        break;
                }
                return $sContent;
                break;


            /**
             * AIN
             */
            case 'title':
                return '<?php echo $this->getTitle(); ?>';
                break;

            case 'header':
                return '<?php echo $this->getHeader(); ?>';
                break;

            case 'loadjs':
                return '<?php echo $this->_sFooter; ?>';
                break;

            case 'error':
                $sContent = '<?php if (!$this->bIsSample): ?>';
                $sContent .= '<?php $this->getLayout(\'error\'); ?>';
                $sContent .= '<?php endif; ?>';
                return $sContent;
                break;

            case 'breadcrumb':
                $sContent = '<div class="_block_breadcrumb"><?php if (!$this->bIsSample): ?>';
                $sContent .= '<?php $this->getLayout(\'breadcrumb\'); ?>';
                $sContent .= '<?php endif; ?></div>';
                return $sContent;
                break;


            case 'content':
                $sContent = '<?php if (!$this->bIsSample): ?><div id="site_content">';
                $sContent .= '<?php AIN::getLib(\'module\')->getControllerTemplate(); ?>';
                $sContent .= '</div>';
                $sContent .= '<?php endif; ?>';
                return $sContent;
                break;
				

            case 'layout':
                $aArgs = $this->_parseArgs($sArguments);
                return '<?php $this->getLayout(' . $aArgs['file'] . '); ?>';
                break;

            case 'pager':
                $sReturn = '<?php if (!isset($this->_aVars[\'aPager\'])): AIN::getLib(\'pager\')->set(array(\'page\' => AIN::getLib(\'request\')->getInt(\'page\'), \'size\' => AIN::getLib(\'search\')->getDisplay(), \'count\' => AIN::getLib(\'search\')->getCount())); endif; ?>';
                $sReturn .= '<?php $this->getLayout(\'pager\'); ?>';
                return $sReturn;
                break;





            case 'add_script':
                $aArgs = $this->_parseArgs($sArguments);
                return '<?php echo AIN::getLib(\'template\')->addScript(' . $aArgs['key'] . ', ' . $aArgs['value'] . ', false ); ?>';
                break;
				
				
				



            case 'img':
                $aArgs = $this->_parseArgs($sArguments);
                $sArray = '';
                foreach ($aArgs as $sKey => $sValue)
                {
                    $sArray .= '\'' . $sKey . '\' => ' . $sValue . ',';
                }
                return '<?php echo AIN::getLib(\'image.helper\')->display(array(' . rtrim($sArray, ',') . ')); ?>';
                break;






            case 'module':
                $aArgs = $this->_parseArgs($sArguments);
                $sModule = $aArgs['name'];
                unset($aArgs['name']);
                $sArray = '';

                foreach ($aArgs as $sKey => $sValue)
                {
                    if (substr($sValue, 0, 1) != '$' && $sValue !== 'true' && $sValue !== 'false')
                    {
                        $sValue = '\'' . $this->_removeQuote($sValue) . '\'';
                    }
                    $sArray .= '\'' . $sKey . '\' => ' . $sValue . ',';
                }

                return '<?php AIN::getBlock(' . $sModule . ', array(' . rtrim($sArray, ',') . ')); ?>';
                break;

            case 'phrase':
                $aArgs = $this->_parseArgs($sArguments);
                if (!isset($aArgs['var']))
                {
                    return '';
                }
                $sVar = $aArgs['var'];
                unset($aArgs['var']);
                $sArray = '';
                $sLanguage = '';
                if (count($aArgs))
                {
                    $sArray = ', array(';
                    foreach ($aArgs as $sKey => $sValue)
                    {
                        if ($sKey == 'language')
                        {
                            $sLanguage = $sValue;
                        }
                        $sArray .= '\'' . $sKey . '\' => ' . $sValue . ',';
                    }
                    $sArray = rtrim($sArray, ',') . ')';
                }
                return '<?php echo AIN::getPhrase(' . $sVar . '' . $sArray . ($sLanguage != '' ? ',false,null,'.$sLanguage : '') .'); ?>';
                break;


            case 'template':
                $aArgs = $this->_parseArgs($sArguments);
                $sFile = $this->_removeQuote($aArgs['file']);
                return '<?php
						AIN::getLib(\'template\')->getBuiltFile(\'' . $sFile . '\');
						?>';
                break;

            case 'select_date':
                $aArgs = $this->_parseArgs($sArguments);

                $sPrefix = '';
                if (isset($aArgs['prefix']))
                {
                    $sPrefix = $this->_removeQuote($aArgs['prefix']);
                }

                $bUseJquery = AIN::getParam('core.use_jquery_datepicker');
                if (isset($aArgs['bUseDatepicker']) && $aArgs['bUseDatepicker'] == 'false')
                {
                    $bUseJquery = false;
                }

                $sMonth = '<select  name="val[' . $sPrefix . 'month]" id="' . $sPrefix . 'month" class="form-control js_datepicker_month" >' . "\n";
                if (!isset($aArgs['default_all']))
                {
                    $sMonth .= "\t\t" . '<option value=""><?php echo AIN::getPhrase(\'core.month\'); ?>:</option>'  . "\n";
                }

                $aMonths = array(
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December'
                );
                $i = 0;
                foreach ($aMonths as $sNewMonth)
                {
                    $i++;
                    $sMonth .= "\t\t\t" . '<option value="' . $i . '"' . $this->_parseFunction('value', '', "type='select' id='{$sPrefix}month' default='{$i}'") . (isset($aArgs['default_all']) ? '<?php echo (!isset($this->_aVars[\'aForms\'][\'' . $sPrefix . 'month\']) ? (\'' . $i . '\' == AIN::getTime(\'n\') ? \' selected="selected"\' : \'\') : \'\'); ?>' : '') . '><?php echo AIN::getPhrase(\'core.' . strtolower($sNewMonth) . '\'); ?></option>' . "\n";
                }
                $sMonth .= "\t\t" . '</select>' . "\n";

                $sDay = "\t\t" . '<select name="val[' . $sPrefix . 'day]" id="' . $sPrefix . 'day" class="form-control js_datepicker_day">' . "\n";
                if (!isset($aArgs['default_all']))
                {
                    $sDay .= "\t\t" . '<option value=""><?php echo AIN::getPhrase(\'core.day\'); ?>:</option>' . "\n";
                }

                for ($i = 1; $i <= 31; $i++)
                {
                    $sDay .= "\t\t\t" . '<option value="' . $i . '"' . $this->_parseFunction('value', '', "type='select' id='{$sPrefix}day' default='{$i}'") . (isset($aArgs['default_all']) ? '<?php echo (!isset($this->_aVars[\'aForms\'][\'' . $sPrefix . 'day\']) ? (\'' . $i . '\' == ' . (isset($aArgs['start_hour']) ? '((AIN::getTime(\'H\') == 23 && (AIN::getTime(\'H\') + ' . $aArgs['start_hour'] . ') >= 00) ? (AIN::getTime(\'j\') + 1) : AIN::getTime(\'j\'))' : 'AIN::getTime(\'j\')') . ' ? \' selected="selected"\' : \'\') : \'\'); ?>' : '') . '>' . $i . '</option>'  . "\n";
                }
                $sDay .= "\t\t" . '</select>' . "\n";

                if ($this->_removeQuote($aArgs['start_year']) == 'current_year')
                {
                    $aArgs['start_year'] = date('Y');
                }
                else if (preg_match('/[a-z]+\.{1}[a-z0-9\_]+/', $this->_removeQuote($aArgs['start_year']), $aMatch) > 0)
                {
                    $aArgs['start_year'] = AIN::getParam($aMatch[0]);
                }

                if (substr($this->_removeQuote($aArgs['end_year']), 0, 1) == '+')
                {
                    $aArgs['end_year'] = (date('Y') + substr_replace($this->_removeQuote($aArgs['end_year']), '', 0, 1));
                }
                else if (preg_match('/[a-z]+\.{1}[a-z0-9\_]+/', $this->_removeQuote($aArgs['end_year']), $aMatch) > 0)
                {
                    $aArgs['end_year'] = AIN::getParam($aMatch[0]);
                }

                if (isset($aArgs['sort_years']) && $aArgs['sort_years'] == '\'DESC\'')
                {
                    $sTemp = $aArgs['start_year'];
                    $aArgs['start_year'] = $aArgs['end_year'];
                    $aArgs['end_year'] = $sTemp;
                }

                $sYear = '<?php $aYears = range(' . $aArgs['start_year'] . ', ' . $aArgs['end_year'] . ');  ?>';
                $sYear .= '<?php $aParams = (isset($aParams) ? $aParams : AIN::getLib(\'AIN.request\')->getArray(\'val\')); ?>';
                $sYear .= "\t\t" . '<select name="val[' . $sPrefix . 'year]" id="' . $sPrefix . 'year" class="form-control js_datepicker_year">' . "\n";
                if (!isset($aArgs['default_all']))
                {
                    $sYear .= "\t\t" . '<option value=""><?php echo AIN::getPhrase(\'core.year\'); ?>:</option>' . "\n";
                }
                $sYear .= '<?php foreach ($aYears as $iYear): ?>';
                $sYear .= "\t\t\t" . '<option value="<?php echo $iYear; ?>"<?php echo ((isset($aParams[\'' . $sPrefix . 'year\']) && $aParams[\'' . $sPrefix . 'year\'] == $iYear) ? \' selected="selected"\' : (!isset($this->_aVars[\'aForms\'][\'' . $sPrefix . 'year\']) ? ($iYear == AIN::getTime(\'Y\') ? \' selected="selected"\' : \'\') : ($this->_aVars[\'aForms\'][\'' . $sPrefix . 'year\'] == $iYear ? \' selected="selected"\' : \'\'))); ?>><?php echo $iYear; ?></option>'  . "\n";
                $sYear .= '<?php endforeach; ?>';
                $sYear .= "\t\t" . '</select>' . "\n";

                $aSep = '<span class="field_separator">' . $this->_removeQuote($aArgs['field_separator']) . '</span>';

                $sReturn = '';
                switch (AIN::getParam('core.date_field_order'))
                {
                    case 'DMY':
                        $sReturn = $sDay . $aSep . $sMonth . $aSep . $sYear;
                        break;
                    case 'YMD':
                        $sReturn = $sYear . $aSep . $sMonth . $aSep . $sDay;
                        break;
                    // MDY
                    default:
                        $sReturn = $sMonth . $aSep . $sDay . $aSep . $sYear;
                        break;
                }

                if ($bUseJquery)
                {
                    $sValue = '';
                    $sValue .= '<?php if (isset($aParams[\'' . $sPrefix . 'month\'])): ?>';
                    $sValue .= '<?php echo $aParams[\'' . $sPrefix . 'month\'] . \'/\'; ?>';
                    $sValue .= '<?php echo $aParams[\'' . $sPrefix . 'day\'] . \'/\'; ?>';
                    $sValue .= '<?php echo $aParams[\'' . $sPrefix . 'year\']; ?>';
                    $sValue .= '<?php elseif (isset($this->_aVars[\'aForms\'])): ?>';
                    $sValue .= '<?php if (isset($this->_aVars[\'aForms\'][\'' . $sPrefix . 'month\'])): ?>';

                    $sValue .= '<?php switch(AIN::getParam("core.date_field_order")){ ?>';
                    $sValue .= '<?php case "DMY": ?>';
                    $sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'day\'] . \'/\'; ?>';
                    $sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'month\'] . \'/\'; ?>';
                    $sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'year\']; ?>';
                    $sValue .= '<?php break; ?>';
                    $sValue .= '<?php case "MDY": ?>';
                    $sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'month\'] . \'/\'; ?>';
                    $sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'day\'] . \'/\'; ?>';
                    $sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'year\']; ?>';
                    $sValue .= '<?php break; ?>';
                    $sValue .= '<?php case "YMD": ?>';
                    $sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'year\'] . \'/\'; ?>';
                    $sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'month\'] . \'/\'; ?>';
                    $sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'day\']; ?>';
                    $sValue .= '<?php break; ?>';
                    $sValue .= '<?php } ?>';

                    $sValue .= '<?php endif; ?>';
                    $sValue .= '<?php else: ?>';
                    $sValue .= '<?php switch(AIN::getParam("core.date_field_order")){';
                    $sValue .= '	case "DMY": echo AIN::getTime(\'j\') . \'/\' . AIN::getTime(\'n\') . \'/\' . AIN::getTime(\'Y\'); break;';
                    $sValue .= '	case "MDY": echo AIN::getTime(\'n\') . \'/\' . AIN::getTime(\'j\') . \'/\' . AIN::getTime(\'Y\'); break;';
                    $sValue .= '	case "YMD": echo AIN::getTime(\'Y\') . \'/\' . AIN::getTime(\'n\') . \'/\' . AIN::getTime(\'j\'); break;';
                    $sValue .= '}?>';
                    $sValue .= '<?php endif; ?>';

                    $sReturn = '<div class="js_datepicker_core'. (isset($aArgs['id']) ? str_replace(array('"',"'"),'',$aArgs['id']) : '')  .'"><span class="js_datepicker_holder"><div style="display:none;">' . $sReturn . '</div><input type="text" name="js_' . $sPrefix . '_datepicker" value="' . $sValue . '" class="form-control js_date_picker" /><div class="js_datepicker_image"></div></span> ';
                }

                if (isset($aArgs['add_time']))
                {
                    $sReturn.='<span class="form-inline js_datepicker_selects">';
                    $aHours = range(0, 23);
                    $sReturn .= "\t\t" . '<select class="form-control" name="val[' . $sPrefix . 'hour]" id="' . $sPrefix . 'hour">' . "\n";
                    foreach ($aHours as $iHour)
                    {
                        if (isset($aArgs['start_hour']))
                        {
                            if (substr($this->_removeQuote($aArgs['start_hour']), 0, 1) == '+')
                            {
                                $aArgs['start_hour'] = substr_replace($this->_removeQuote($aArgs['start_hour']), '', 0, 1);
                            }
                        }

                        if (strlen($iHour) < 2)
                        {
                            $iHour = '0' . $iHour;
                        }

                        $sReturn .= "\t\t\t" . '<option value="' . $iHour . '"' . $this->_parseFunction('value', '', "type='select' id='{$sPrefix}hour' default='{$iHour}'") . (isset($aArgs['default_all']) ? '<?php echo (!isset($this->_aVars[\'aForms\'][\'' . $sPrefix . 'hour\']) ? (\'' . $iHour . '\' == ' . (isset($aArgs['start_hour']) ? '(AIN::getLib(\'date\')->modifyHours(\'+' . $aArgs['start_hour'] . '\'))' : 'AIN::getTime(\'H\')') . ' ? \' selected="selected"\' : \'\') : \'\'); ?>' : '') . '>' . $iHour . '</option>'  . "\n";
                    }
                    $sReturn .= "\t\t" . '</select><span class="select-date-separator">:</span>' . "\n";

                    $aMinutes = range(0, 59);
                    $sReturn .= "\t\t" . '<select class="form-control" name="val[' . $sPrefix . 'minute]" id="' . $sPrefix . 'minute">' . "\n";
                    foreach ($aMinutes as $iMinute)
                    {
                        if (strlen($iMinute) < 2)
                        {
                            $iMinute = '0' . $iMinute;
                        }
                        $sReturn .= "\t\t\t" . '<option value="' . $iMinute . '"' . $this->_parseFunction('value', '', "type='select' id='{$sPrefix}minute' default='{$iMinute}'") . (isset($aArgs['default_all']) ? '<?php echo (!isset($this->_aVars[\'aForms\'][\'' . $sPrefix . 'minute\']) ? (\'' . $iMinute . '\' == AIN::getTime(\'i\') ? \' selected="selected"\' : \'\') : \'\'); ?>' : '') . '>' . $iMinute . '</option>'  . "\n";
                    }
                    $sReturn .= "\t\t" . '</select>' . "\n";

                    $sReturn .= '</span>';
                }

                if ($bUseJquery)
                {
                    $sReturn .= '</div>';
                }

                return '<div class="form-inline select_date">'. $sReturn . '</div>';
                break;
            case 'select_location':
                $aArgs = $this->_parseArgs($sArguments);
                if (isset($aArgs['value_title']) && strpos($aArgs['value_title'], 'phrase var=') !== false)
                {
                    $aArgs['value_title'] = AIN::getPhrase(str_replace(array('phrase var=','"',"'"),'',$aArgs['value_title']));
                }
                $bIsMultiple = isset($aArgs['multiple']) && !empty($aArgs['multiple']);

                $sCountries = '<select class="form-control" '. ( $bIsMultiple ? 'multiple="multiple" ' : '') .'name="val[' . (isset($aArgs['name']) ? $this->_removeQuote($aArgs['name']) : 'country_iso') . ']'. ($bIsMultiple ? '[]':'') .'" id="' . (isset($aArgs['name']) ? $this->_removeQuote($aArgs['name']) : 'country_iso') . '"' . (isset($aArgs['style']) ? ' style=' . $aArgs['style'] . '' : '') . '>' . "\n";
                $sCountries .= "\t\t" . '<option value="">' . (isset($aArgs['value_title']) ? $this->_removeQuote($aArgs['value_title']) : '<?php echo AIN::getPhrase(\'core.select\'); ?>:') . '</option>' . "\n";
                foreach (AIN::getService('core.country')->get() as $sIso => $sCountry)
                {
                    $sCountries .= "\t\t\t" . '<option class="js_country_option" id="js_country_iso_option_'. $sIso . '" value="' . $sIso . '"'. '><?php echo (AIN::getLib(\'locale\')->isPhrase(\'core.translate_country_iso_' . strtolower($sIso) . '\') ? AIN::getPhrase(\'core.translate_country_iso_' . strtolower($sIso) . '\') : \'' . str_replace("'", "\'", $sCountry) . '\'); ?></option>' . "\n";
                }
                $sCountries .= "\t\t" . '</select>';
                $sCountries .= "\n" . '<?php if (isset($this->_aVars[\'aForms\'][\'country_iso\']))';
                $sCountries .= "\n" .'{ ';
                $sCountries .= "\n" . 'echo \'<script type="text/javascript"> $Behavior.setCountry = function() {';
                $sCountries .= '$("#js_country_iso_option_\' . $this->_aVars[\'aForms\'][\'country_iso\'] . \'").prop("selected", true); } </script>\';  }';
                $sCountries .= "\n" . '?>';
                return $sCountries;
                break;


            case 'required':
                return '<?php if (AIN::getParam(\'core.display_required\')): ?><span class="required"><?php echo AIN::getParam(\'core.required_symbol\'); ?></span><?php endif; ?>';
                break;
            case 'debug':
                $css = '<link rel="stylesheet" type="text/css" href="/theme/adminpanel/default/style/default/css/debug.css?v=' . AIN_TIME . '" />';
                //return $css.AIN_Debug::getDetails();
                break;

            default:
                if ($this->_compileCustomFunction($sFunction, $sModifiers, $sArguments, $sResult))
                {
                    return $sResult;
                }
                else
                {
                    AIN_Error::trigger('Invalid function: ' . $sFunction);
                }
                return $sResult;
        }
    }
    private function _compileCustomFunction($sFunction, $sModifiers, $sArguments, &$sResult)
    {
        if ($sFunction = $this->_plugin($sFunction, "function"))
        {
            $aArgs = $this->_parseArgs($sArguments);
            foreach($aArgs as $mKey => $mValue)
            {
                if (is_bool($mValue))
                {
                    $mValue = $mValue ? 'true' : 'false';
                }
                if (is_null($mValue))
                {
                    $mValue = 'null';
                }
                $aArgs[$mKey] = "'$mKey' => $mValue";
            }
            $sResult = '<?php echo ';
            if (!empty($sModifiers))
            {
                $sResult .= $this->_parseModifier($sFunction . '(array(' . implode(',', (array)$aArgs) . '), $this)', $sModifiers) . '; ';
            }
            else
            {
                $sResult .= $sFunction . '(array(' . implode(',', (array)$aArgs) . '), $this);';
            }
            $sResult .= '?>';

            return true;
        }
        else
        {
            return false;
        }
    }
    /**
     * Parse arguments. (eg. {for bar1=sample1 bar2=sample2}
     *
     * @param string $sArguments Arguments to parse.
     * @return array ARRAY of all the arguments.
     */
    private function _parseArgs($sArguments)
    {
        $aResult	= array();
        preg_match_all('/(?:' . $this->_sQstrRegexp . ' | (?>[^"\'=\s]+))+|[=]/x', $sArguments, $aMatches);

        $iState = 0;
        foreach($aMatches[0] as $mValue)
        {
            switch($iState)
            {
                case 0:
                    if (is_string($mValue))
                    {
                        $sName = $mValue;
                        $iState = 1;
                    }
                    else
                    {
                        AIN_Error::trigger("Invalid Attribute Name", E_USER_ERROR);
                    }
                    break;
                case 1:
                    if ($mValue == '=')
                    {
                        $iState = 2;
                    }
                    else
                    {
                        AIN_Error::trigger("Expecting '=' After '{$sLastValue}'", E_USER_ERROR);
                    }
                    break;
                case 2:
                    if ($mValue != '=')
                    {
                        if(!preg_match_all('/(?:(' . $this->_sVarRegexp . '|' . $this->_sSvarRegexp . ')(' . $this->_sModRegexp . '*))(?:\s+(.*))?/xs', $mValue, $aVariables))
                        {
                            $aResult[$sName] = $mValue;
                        }
                        else
                        {
                            $aResult[$sName] = $this->_parseVariables($aVariables[1], $aVariables[2]);
                        }
                        $iState = 0;
                    }
                    else
                    {
                        AIN_Error::trigger("'=' cannot be an attribute value", E_USER_ERROR);
                    }
                    break;
            }
            $sLastValue = $mValue;
        }

        if($iState != 0)
        {
            if($iState == 1)
            {
                AIN_Error::trigger("expecting '=' after attribute name '{$sLastValue}'", E_USER_ERROR);
            }
            else
            {
                AIN_Error::trigger("missing attribute value", E_USER_ERROR);
            }
        }

        return $aResult;
    }
    private function _parseModifier($sVariable, $sModifiers)
    {
        $aMods = array();
        $aArgs = array();

        $aMods = explode('|', $sModifiers);
        unset($aMods[0]);
        foreach ($aMods as $sMod)
        {
            $aArgs = array();
            if (strpos($sMod, ':'))
            {
                $aParts = explode(':', $sMod);
                $iCnt = 0;

                foreach ($aParts as $iKey => $sPart)
                {
                    if ($iKey == 0)
                    {
                        continue;
                    }

                    if ($iKey > 1)
                    {
                        $iCnt++;
                    }

                    $aArgs[$iCnt] = $this->_parseVariable($sPart);
                }

                $sMod = $aParts[0];
            }

            if ($sMod[0] == '@')
            {
                $sMod = substr($sMod, 1);
                $bMapArray = false;
            }
            else
            {
                $bMapArray = true;
            }

            $sArg = ((count($aArgs) > 0) ? ', '.implode(', ', $aArgs) : '');

            if ($this->_plugin($sMod, 'modifier'))
            {
                $sVariable = "\$this->_runModifier($sVariable, '$sMod', 'plugin', $sArg)";
            }
            else
            {
                switch ($sMod)
                {
                    case 'lower':
                        $sVariable = 'strtolower('.$sVariable.')';
                        break;
                    default:
                        if (function_exists($sMod))
                        {
                            $sVariable = '' . $sMod . '(' . $sVariable . $sArg . ')';
                        }
                        else
                        {
                            $sVariable = "AIN_Error::trigger(\"'" . $sMod . "' modifier does not exist\", E_USER_ERROR)";
                        }
                }
            }
        }

        return $sVariable;
    }
    private function _plugin($sFunction, $sType)
    {
        if (isset($this->_aPlugins[$sType][$sFunction]) && is_array($this->_aPlugins[$sType][$sFunction]) && is_object($this->_aPlugins[$sType][$sFunction][0]) && method_exists($this->_aPlugins[$sType][$sFunction][0], $this->_aPlugins[$sType][$sFunction][1]))
        {
            return '$this->_aPlugins[\'' . $sType . '\'][\'' . $sFunction . '\'][0]->' . $this->_aPlugins[$sType][$sFunction][1];
        }

        if (isset($this->_aPlugins[$sType][$sFunction]) && function_exists($this->_aPlugins[$sType][$sFunction]))
        {
            return $this->_aPlugins[$sType][$sFunction];
        }

        if (function_exists('AIN_' . $sType . '_' . $sFunction))
        {
            $this->_aRequireStack[$sType . '.' . $sFunction . '.php'] = array($sType, $sFunction, 'AIN_' . $sType . '_' . $sFunction);

            return 'AIN_' . $sType . '_' . $sFunction;
        }

        if (file_exists(AIN_DIR_TPL_PLUGIN . $sType . '.' . $sFunction . '.php'))
        {
            require_once(AIN_DIR_TPL_PLUGIN . $sType . '.' . $sFunction . '.php');

            if (function_exists('AIN_' . $sType . '_' . $sFunction))
            {
                $this->_aRequireStack[$sType . '.' . $sFunction . '.php'] = array($sType, $sFunction, 'AIN_' . $sType . '_' . $sFunction);

                return 'AIN_' . $sType . '_' . $sFunction;
            }
        }
        return false;
    }

}
?>