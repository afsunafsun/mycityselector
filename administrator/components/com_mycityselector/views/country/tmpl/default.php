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
		if (task == 'country.cancel' || document.formvalidator.isValid(document.getElementById('item-form')))
		{
			Joomla.submitform(task, document.getElementById('item-form'));
		}
	};
");

$fieldSet = $this->form->getFieldset('edit');
?>

<div class="span12">
    <h3><?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_COUNTRY') ?></h3>


    <form action="<?php echo \Joomla\CMS\Router\Route::_('index.php?option=com_mycityselector&view=country&layout=edit&id=' . (int) $this->item->id); ?>"
          method="post" name="adminForm" id="item-form"
          class="form-validate form-horizontal">
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

