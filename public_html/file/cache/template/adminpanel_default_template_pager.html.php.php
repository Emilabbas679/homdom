<?php defined('AIN') or exit('NO DICE!'); ?>
<?php /* Cached: December 12, 2021, 5:29 pm */ ?>
<?php if (isset ( $this->_aVars['aPager'] ) && $this->_aVars['aPager']['totalPages'] > 1): ?>
<div class="pagination pull-right">
    <ul>
<?php if (isset ( $this->_aVars['aPager']['firstUrl'] )): ?><li class="first"><a <?php if ($this->_aVars['sAjax']): ?>href="<?php echo $this->_aVars['aPager']['firstUrl']; ?>"
                onclick="$(this).parent().parent().parent().parent().find('.sJsPagerDisplayCount').html($.ajaxProcess('<?php echo AIN::getPhrase('homdom.loading'); ?>')); $.ajaxCall('<?php echo $this->_aVars['sAjax']; ?>', 'page=<?php echo $this->_aVars['aPager']['firstAjaxUrl'];  echo $this->_aVars['aPager']['sParams']; ?>'); $homdom.addUrlPager(this); return false;"
<?php else: ?>href="<?php echo $this->_aVars['aPager']['firstUrl']; ?>" <?php endif; ?>><?php echo AIN::getPhrase('homdom.first'); ?></a> </li><?php endif; ?> <?php if (isset ( $this->_aVars['aPager']['prevUrl'] )): ?><li><a href='<?php echo $this->_aVars['aPager']['prevUrl']; ?>'><i class="fa fa-arrow-left"></i></a></li><?php endif; ?>
<?php if (count((array)$this->_aVars['aPager']['urls'])):  $this->_aAINVars['iteration']['pager'] = 0;  foreach ((array) $this->_aVars['aPager']['urls'] as $this->_aVars['sLink'] => $this->_aVars['sPage']):  $this->_aAINVars['iteration']['pager']++; ?>

        <li <?php if ($this->_aVars['aPager']['current'] == $this->_aVars['sPage']): ?> class="active" <?php endif; ?>><a href="<?php echo $this->_aVars['sLink']; ?>"><?php echo $this->_aVars['sPage']; ?></a></li>
<?php endforeach; endif; ?>
<?php if (isset ( $this->_aVars['aPager']['lastUrl'] )): ?><li><a href="<?php echo $this->_aVars['aPager']['nextUrl']; ?>"><i class="fa fa-arrow-right"></i></a></li><?php endif; ?>
<?php if (isset ( $this->_aVars['aPager']['lastUrl'] )): ?><li><a <?php if ($this->_aVars['sAjax']): ?>href="<?php echo $this->_aVars['aPager']['lastUrl']; ?>"
                onclick="$(this).parent().parent().parent().parent().find('.sJsPagerDisplayCount').html($.ajaxProcess('<?php echo AIN::getPhrase('homdom.loading'); ?>')); $.ajaxCall('<?php echo $this->_aVars['sAjax']; ?>', 'page=<?php echo $this->_aVars['aPager']['lastAjaxUrl'];  echo $this->_aVars['aPager']['sParams']; ?>'); $homdom.addUrlPager(this); return false;"
<?php else: ?>href="<?php echo $this->_aVars['aPager']['lastUrl']; ?>" <?php endif; ?>><?php echo AIN::getPhrase('homdom.last'); ?></a> </li><?php endif; ?> </ul> </div> <?php endif; ?>
