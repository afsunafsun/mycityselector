<?php
/**
 * MyCitySelector
 * @author   Konstantin Kutsevalov
 * @version  2.0.0
 *
 * @formatter:off
 *
 * @var $this    \adamasantares\jxmvc\JxView
 * @var $sidebar string
 * @var $data    array
 * @var $model   CountryModel
 */

defined('_JEXEC') or die(header('HTTP/1.0 403 Forbidden') . 'Restricted access');

\Joomla\CMS\HTML\HTMLHelper::_('behavior.formvalidator');

\Joomla\CMS\Factory::getDocument()->addScriptDeclaration("
	Joomla.submitbutton = function(task)
	{
		if (task == 'province.cancel' || document.formvalidator.isValid(document.getElementById('province-form')))
		{
			Joomla.submitform(task, document.getElementById('province-form'));
		}
	};
");

$fieldSet = $this->form->getFieldset('edit');
?>

<div class="span12">
    <h3><?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_PROVINCE') ?></h3>


    <form action="<?php echo \Joomla\CMS\Router\Route::_('index.php?option=com_mycityselector&layout=edit&id=' . (int) $this->item->id); ?>"
          method="post" name="province-form" id="province-form"
          class="form-horizontal">
		<?php foreach ($fieldSet as $field)
		{
			?>
            <div class="control-group">
                <div class="control-label">
					<?= $field->label; ?>
                </div>
                <div class="controls">
					<?= $field->input; ?>
                </div>
            </div>
			<?php
		} ?>
        <input type="hidden" name="task" value=""/>
		<?php echo \Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
    </form>
</div>

