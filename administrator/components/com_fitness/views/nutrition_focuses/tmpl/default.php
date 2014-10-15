<?php
/**
 * @version     1.0.0
 * @package     com_fitness
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Nikolay Korban <niklug@ukr.net> - http://
 */
// no direct access
defined('_JEXEC') or die;
include JPATH_COMPONENT_ADMINISTRATOR . DS . 'views' . DS . 'dashboard' . DS . 'tmpl' . DS . 'main_menu.php';
JHtml::_('behavior.tooltip');
JHTML::_('script', 'system/multiselect.js', false, true);

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canOrder = $user->authorise('core.edit.state', 'com_fitness');
$saveOrder = $listOrder == 'a.ordering';

require_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_fitness' . DS . 'helpers' . DS . 'fitness.php';

$helper = new FitnessHelper();
?>

<form action="<?php echo JRoute::_('index.php?option=com_fitness&view=nutrition_focuses'); ?>" method="post" name="adminForm" id="adminForm">
    <div  class="container-fluid well">
        <div  class="row-fluid form-inline" role="form">
                <input placeholder="Name" class="search-query" type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('Search'); ?>" />
                <button class="btn btn-primary" type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
                <button class="btn btn-default" type="button" onclick="document.id('filter_search').value = '';
                        this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>

<?php echo $helper->generateSelect($helper->getBusinessProfileList(), 'filter_business_profile_id', 'business_profile_id input-large', $this->state->get('filter.business_profile_id'), 'Business Name', false, "inputbox"); ?>
   

         
                <select name="filter_published" class="input-medium" onchange="this.form.submit()">
                    <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED'); ?></option>
<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true); ?>
                </select>

        </div>
    </div>

    <?php include JPATH_COMPONENT_ADMINISTRATOR . DS . 'views' . DS . 'dashboard' . DS . 'tmpl' . DS . 'left_menu.php'; ?>

<div id="j-main-container" class="well span10">
        <div class="clearfix"> </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="1%">
                        <input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
                    </th>

                    <th class='left'>
<?php echo JHtml::_('grid.sort', 'COM_FITNESS_NUTRITION_FOCUSES_NAME', 'a.name', $listDirn, $listOrder); ?>
                    </th>

                    <th class='left'>
                        Color
                    </th>

                    <th class='left'>
<?php echo JHtml::_('grid.sort', 'Business Name', 'business_name', $listDirn, $listOrder); ?>
                    </th>


<?php if (isset($this->items[0]->state)) { ?>
                        <th width="5%">
                        <?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
                        </th>
                        <?php } ?>
                    <?php if (isset($this->items[0]->ordering)) { ?>
                        <th width="10%">
                        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
                            <?php if ($canOrder && $saveOrder) : ?>
                                <?php echo JHtml::_('grid.order', $this->items, 'filesave.png', 'nutrition_focuses.saveorder'); ?>
                            <?php endif; ?>
                        </th>
                        <?php } ?>
                    <?php if (isset($this->items[0]->id)) { ?>
                        <th width="1%" class="nowrap">
                        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                        </th>
                        <?php } ?>
                </tr>
            </thead>
            <tfoot>
<?php
if (isset($this->items[0])) {
    $colspan = count(get_object_vars($this->items[0]));
} else {
    $colspan = 10;
}
?>
                <tr>
                    <td colspan="<?php echo $colspan ?>">
                <?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>
            </tfoot>
            <tbody>
<?php
foreach ($this->items as $i => $item) :
    $ordering = ($listOrder == 'a.ordering');
    $canCreate = $user->authorise('core.create', 'com_fitness');
    $canEdit = $user->authorise('core.edit', 'com_fitness');
    $canCheckin = $user->authorise('core.manage', 'com_fitness');
    $canChange = $user->authorise('core.edit.state', 'com_fitness');
    ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td class="center">
    <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                        </td>

                        <td>
    <?php if (isset($item->checked_out) && $item->checked_out) : ?>
                                <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'nutrition_focuses.', $canCheckin); ?>
                            <?php endif; ?>
                            <?php if ($canEdit) : ?>
                                <a href="<?php echo JRoute::_('index.php?option=com_fitness&task=nutrition_focus.edit&id=' . (int) $item->id); ?>">
                                <?php echo $this->escape($item->name); ?></a>
                                <?php else : ?>
                                    <?php echo $this->escape($item->name); ?>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div style="width:100px; height:15px;background-color:<?php echo $item->color; ?>;" ></div>
                        </td>

                        <td>
    <?php echo $item->business_name; ?>
                        </td>


    <?php if (isset($this->items[0]->state)) { ?>
                            <td class="center">
                            <?php echo JHtml::_('jgrid.published', $item->state, $i, 'nutrition_focuses.', $canChange, 'cb'); ?>
                            </td>
                            <?php } ?>
                        <?php if (isset($this->items[0]->ordering)) { ?>
                            <td class="order">
                            <?php if ($canChange) : ?>
                                    <?php if ($saveOrder) : ?>
                                        <?php if ($listDirn == 'asc') : ?>
                                            <span><?php echo $this->pagination->orderUpIcon($i, true, 'nutrition_focuses.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                            <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'nutrition_focuses.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                <?php elseif ($listDirn == 'desc') : ?>
                                            <span><?php echo $this->pagination->orderUpIcon($i, true, 'nutrition_focuses.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                            <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'nutrition_focuses.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                <?php endif; ?>
                                    <?php endif; ?>
                                    <?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
                                    <input type="text" name="order[]" size="5" value="<?php echo $item->ordering; ?>" <?php echo $disabled ?> class="text-area-order" />
                                <?php else : ?>
                                    <?php echo $item->ordering; ?>
                                <?php endif; ?>
                            </td>
                            <?php } ?>
                        <?php if (isset($this->items[0]->id)) { ?>
                            <td class="center">
                            <?php echo (int) $item->id; ?>
                            </td>
                            <?php } ?>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
        <?php include JPATH_COMPONENT_ADMINISTRATOR . DS . 'views' . DS . 'settings' . DS . 'tmpl' . DS . 'default_batch.php'; ?>
    </div>



<div>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>

<script type="text/javascript">

    (function ($) {

        $("#reset_filtered").click(function () {
            var limit = $("#limit").val();
            var form = $("#adminForm");
            form.find("select").val('');
            form.find("input").val('');
            $("#limit").val(limit);
            form.submit();
        });

        $("#business_profile_id").on('change', function () {
            var form = $("#adminForm");
            form.submit();
        })

        var batch_options = {
            table: '#__fitness_nutrition_focus',
            ajax_call_url: '<?php echo JURI::root(); ?>administrator/index.php?option=com_fitness&tmpl=component&<?php echo JSession::getFormToken(); ?>=1'
        };

        var batch_copy = $.batch_copy(batch_options);

    })($js);


</script>
