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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');


$helper = new FitnessHelper();
?>
<style type="text/css">
    #jform_terms_conditions-lbl {
        float: none;
    }
    .adminformlist li {
        clear: both;
    }

</style>
<form action="<?php echo JRoute::_('index.php?option=com_fitness&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="business_profile-form" class="form-validate">

    <div class="row-fluid">
        <div class="span6 well">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('name'); ?></div>
                    </div>

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('group_id'); ?></div>
                        <div class="controls"><?php echo $helper->generateSelect($helper->getGroupList(), 'jform[group_id]', 'group_id', $this->item->group_id, '', "required", true); ?></div>
                    </div>

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('primary_administrator'); ?></div>
                        <div class="controls"><select id="jform_primary_administrator" class="inputbox" name="jform[primary_administrator]"></select></div>
                    </div>

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('secondary_administrator'); ?></div>
                        <div class="controls"><select id="jform_secondary_administrator" class="inputbox" name="jform[secondary_administrator]"></select></div>
                    </div>

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('terms_conditions'); ?></div>
                    </div>

                    <?php echo $this->form->getInput('terms_conditions'); ?>
                </fieldset>
            </div>
        </div>
        <div class="span6 well">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('header_image'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('header_image'); ?></div>
                    </div>
                    (header must not exceed maximum width 570 pixels and maximum height 150 pixels)

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('facebook_url'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('facebook_url'); ?></div>
                    </div>

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('twitter_url'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('twitter_url'); ?></div>
                    </div>

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('youtube_url'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('youtube_url'); ?></div>
                    </div>

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('instagram_url'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('instagram_url'); ?></div>
                    </div>

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('google_plus_url'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('google_plus_url'); ?></div>
                    </div>

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('linkedin_url'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('linkedin_url'); ?></div>
                    </div>

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('website_url'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('website_url'); ?></div>
                    </div>

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('email'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('email'); ?></div>
                    </div>

                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('contact_number'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('contact_number'); ?></div>
                    </div>
                    
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('state'); ?></div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
    <div class="clr"></div>
</form>



<script type="text/javascript">

    (function ($) {

        all_secondary_administrator_options = '';


        $("#jform_primary_administrator").live('change', function () {
            if (!all_secondary_administrator_options) {
                all_secondary_administrator_options = $('#jform_secondary_administrator').html();
            }
            var value = $(this).val();
            hideSelectOption(value, '#jform_secondary_administrator', all_secondary_administrator_options);

        });



        function hideSelectOption(value, element, all_options) {

            $(element).html(all_options);

            $(element + " option[value=" + value + "]").remove();
        }



        $("#group_id").on('change', function () {
            var group_id = $(this).val();

            var data = {};
            var url = '<?php echo JURI::root(); ?>administrator/index.php?option=com_fitness&tmpl=component&<?php echo JSession::getFormToken(); ?>=1';
            var view = 'business_profile';
            var task = 'checkUniqueGroup';
            var table = '#__fitness_business_profiles';
            data.value = group_id;
            data.column = 'group_id';

            $.AjaxCall(data, url, view, task, table, function (output) {
                var group_exists = output;

                if (group_exists) {
                    alert('Business Profile already created for this User Group!');
                    $("#group_id").val('');
                }
            });

            getUsersByGroup(group_id);

        });



        function getUsersByGroup(group_id) {
            var url = '<?php echo JUri::base() ?>index.php?option=com_fitness&tmpl=component&<?php echo JSession::getFormToken(); ?>=1'
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    view: 'goals',
                    format: 'text',
                    task: 'getUsersByGroup',
                    user_group: group_id
                },
                dataType: 'json',
                success: function (response) {
                    if (!response.status.success) {
                        alert(response.status.message);
                        $("#jform_primary_administrator, #jform_secondary_administrator").html('');
                        return;
                    }
                    var primary_administrator = '<?php echo $this->item->primary_administrator; ?>';

                    var html = '<option  value="">-Select-</option>';
                    $.each(response.data, function (index, value) {
                        if (index) {
                            var selected = '';
                            if (primary_administrator == index) {
                                selected = 'selected';
                            }
                            html += '<option ' + selected + ' value="' + index + '">' + value + '</option>';
                        }
                    });
                    $("#jform_primary_administrator").html(html);




                    var secondary_administrator = '<?php echo $this->item->secondary_administrator; ?>';

                    var html = '<option  value="">-Select-</option>';
                    $.each(response.data, function (index, value) {
                        if (index) {
                            var selected = '';
                            if (secondary_administrator == index) {
                                selected = 'selected';
                            }
                            html += '<option ' + selected + ' value="' + index + '">' + value + '</option>';
                        }
                    });
                    $("#jform_secondary_administrator").html(html);

                },
                error: function (XMLHttpRequest, textStatus, errorThrown)
                {
                    alert("error");
                }
            });
        }

        var group_id = $("#group_id").find(':selected').val();
        if (group_id) {
            getUsersByGroup(group_id);
        }



        Joomla.submitbutton = function (task)
        {
            if (task == 'business_profile.cancel') {
                Joomla.submitform(task, document.getElementById('business_profile-form'));
            }
            else {

                if (task != 'business_profile.cancel' && document.formvalidator.isValid(document.id('business_profile-form'))) {

                    Joomla.submitform(task, document.getElementById('business_profile-form'));
                }
                else {
                    alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                }
            }
        }



    })($js);



</script>