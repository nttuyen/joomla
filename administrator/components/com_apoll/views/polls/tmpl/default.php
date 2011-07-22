<?php
/**
 * aPoll Voting Component
 *
 * @version     $Id$
 * @package     Joomla
 * @copyright   Copyright (C) 2009 - 2010 aFactory. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

// No Direct Access
defined( '_JEXEC' ) or die;

JHTML::_('behavior.tooltip'); 
JHTML::addIncludePath(JPATH_COMPONENT.DS.'helpers'.DS.'html');
JHTML::_('script', 'system/multiselect.js', false, true);
$user    = JFactory::getUser();
$userId  = $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_apoll.category');
$saveOrder	= $listOrder == 'a.ordering';
?>


<form action="<?php echo JRoute::_('index.php?option=com_apoll&view=polls'); ?>" method="post" name="adminForm" id="adminForm">
    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>:</label>
            <input type="text" name="filter_search" id="filter_search" value="
			<?php echo $this->escape($this->state->get('filter.search')); ?>" title="
			<?php echo JText::_('Search in poll titles'); ?>" />
            <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        </div>
        <div class="filter-select fltrt">
                <select name="filter_published" class="inputbox" onchange="this.form.submit()">
                        <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
                        <?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true);?>
                </select>

                <select name="filter_category_id" class="inputbox" onchange="this.form.submit()">
                        <option value=""><?php echo JText::_('JOPTION_SELECT_CATEGORY');?></option>
                        <?php echo JHtml::_('select.options', JHtml::_('category.options', 'com_weblinks'), 'value', 'text', $this->state->get('filter.category_id'));?>
                </select>

                <select name="filter_access" class="inputbox" onchange="this.form.submit()">
                        <option value=""><?php echo JText::_('JOPTION_SELECT_ACCESS');?></option>
                        <?php echo JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'));?>
                </select>

                <select name="filter_language" class="inputbox" onchange="this.form.submit()">
                        <option value=""><?php echo JText::_('JOPTION_SELECT_LANGUAGE');?></option>
                        <?php echo JHtml::_('select.options', JHtml::_('contentlanguage.existing', true, true), 'value', 'text', $this->state->get('filter.language'));?>
                </select>
        </div>
    </fieldset>
    
    <div class="clr"></div>

    <table class="adminlist">
        <thead>
            <tr>
                <th width="20">
                    <input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
                </th>
                <th class="title">
                    <?php echo JHtml::_('grid.sort',  'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
                </th>
                
                <th width="5%">
                    <?php echo JHtml::_('grid.sort',  'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
                </th>
                <th width="10%">
                    <?php echo JHtml::_('grid.sort',  'JCATEGORY', 'category_title', $listDirn, $listOrder); ?>
                </th>
				
                <th width="10%">
                    <?php echo JHtml::_('grid.sort',  'JGLOBAL_CREATED', 'created', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
                </th>             
				
                <th width="5%">
                    <?php echo JHtml::_('grid.sort',  'COM_APOLL_VOTES', 'votes', $listDirn, $listOrder); ?>
                </th>		
               
                <th width="20" class="nowrap">
                    <?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
		</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="13">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
        <tbody>
        <?php foreach ($this->items as $i => $item) :
            $ordering       = ($listOrder == 'a.ordering');
            $item->cat_link = JRoute::_('index.php?option=com_categories&extension=com_apoll&task=edit&type=other&cid[]='. $item->catid);
            $canCreate      = $user->authorise('core.create',     'com_apoll.category.'.$item->catid);
            $canEdit        = $user->authorise('core.edit',       'com_apoll.category.'.$item->catid);
            $canCheckin     = $user->authorise('core.manage',     'com_checkin') || $item->checked_out==$user->get('id') || $item->checked_out==0;
            $canChange      = $user->authorise('core.edit.state', 'com_apoll.category.'.$item->catid);
            ?>
            <tr class="row<?php echo $i % 2; ?>">
                <td class="center">
                    <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td>
                    <?php if ($item->checked_out) : ?>
                        <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'polls.', $canCheckin); ?>
                    <?php endif; ?>
                         
                    <?php if ($canEdit) : ?>
                        <?php echo JHtml::link('index.php?option=com_apoll&task=poll.edit&id='.(int) $item->id, $this->escape($item->title)); ?>
                    <?php else : ?>
                        <?php echo $this->escape($item->title); ?>
                    <?php endif; ?>

                    <p class="smallsub">
                        <?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias)); ?>
                    </p>
                </td>
                <td class="center">
                    <?php echo JHtml::_('jgrid.published', $item->state, $i, 'polls.', $canChange, 'cb', $item->publish_up, $item->publish_down);?>
                </td>
                <td class="center">
                    <?php echo $this->escape($item->category_title); ?>
                </td>
                <td class="center">
                    <?php echo $this->escape($item->created); ?>
                </td>
               
                <td class="center">
                    <?php echo ($item->votes) ? $item->votes : 0; ?>
                </td>

                <td class="center">
                    <?php echo (int) $item->id; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>