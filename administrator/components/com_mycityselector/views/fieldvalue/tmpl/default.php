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

$app      = \Joomla\CMS\Factory::getApplication();
$field_id = $app->getUserStateFromRequest('field_id', 'field_id');
$this->form->setValue('field_id', null, $field_id);
$default = $this->item->default;
if ($default)
{
	$this->form->removeField('cities');
	$this->form->removeField('countries');
	$this->form->removeField('provinces');
}

$fieldSet = $this->form->getFieldset('edit');
$id       = $app->getUserStateFromRequest('com_mycityselector.edit.fieldvalue.id', 'id');


\Joomla\CMS\Factory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "fieldvalue.cancel" || document.formvalidator.isValid(document.getElementById("adminForm")))
		{
			Joomla.submitform(task, document.getElementById("adminForm"));

			// @deprecated 4.0  The following js is not needed since 3.7.0.
//			if (task !== "fieldvalue.apply")
//			{
//				window.parent.jQuery("#fieldValueModal' . $id . '").modal("hide");
//			}
		}
	};
	function _ADD_ALL_CITIES() {
	    jQuery("#jform_cities option:not(:disabled)").prop("selected", true);
	    jQuery("#jform_cities").trigger("change");
	    return false;
	}
	function _ADD_ALL_PROVINCES() {
	    jQuery("#jform_provinces option:not(:disabled)").prop("selected", true);
	    jQuery("#jform_provinces").trigger("change");
	}
	function _ADD_ALL_COUNTRIES() {
	    jQuery("#jform_countries option:not(:disabled)").prop("selected", true);
	    jQuery("#jform_countries").trigger("change");
	}
	function _MCS_BIND_SELECT_FILTER(inputId, selectId) {
	    var input = document.getElementById(inputId);
	    var select = document.getElementById(selectId);
	    if (!input || !select) {
	        return;
	    }

	    var applyFilter = function() {
	        var q = (input.value || "").toLowerCase().trim();
	        var options = select.options;

	        for (var i = 0; i < options.length; i++) {
	            var opt = options[i];
	            var txt = (opt.text || "").toLowerCase();
	            var visible = !q || txt.indexOf(q) !== -1 || opt.selected || opt.disabled;
	            opt.hidden = !visible;
	        }
	    };

	    input.addEventListener("keydown", function(e) {
	        if (e.key === "Enter") {
	            e.preventDefault();
	            applyFilter();
	        }
	    });
	    input.addEventListener("input", applyFilter);
	}
	document.addEventListener("DOMContentLoaded", function() {
	    _MCS_BIND_SELECT_FILTER("mcs-filter-cities", "jform_cities");
	    _MCS_BIND_SELECT_FILTER("mcs-filter-provinces", "jform_provinces");
	    _MCS_BIND_SELECT_FILTER("mcs-filter-countries", "jform_countries");
	});
');
?>

<div class="span12">
    <h3><?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_CONTENT') ?></h3>


    <form action="<?php echo \Joomla\CMS\Router\Route::_('index.php?option=com_mycityselector&view=fieldvalue&tmpl=component&id=' . (int) $this->item->id); ?>"
          method="post" name="fieldValue-form" id="adminForm"
          class="form-horizontal">
		<?php foreach ($fieldSet as $key => $field)
		{
			?>
            <div class="control-group">
                <div class="control-label">
					<?= $field->label; ?>
                </div>
                <div class="controls">
					<?php if ($field->fieldname == 'cities') : ?>
                        <input type="text"
                               id="mcs-filter-cities"
                               class="form-control mb-2"
                               placeholder="Поиск по городам..." />
                    <?php endif; ?>
                    <?php if ($field->fieldname == 'provinces') : ?>
                        <input type="text"
                               id="mcs-filter-provinces"
                               class="form-control mb-2"
                               placeholder="Поиск по регионам..." />
                    <?php endif; ?>
                    <?php if ($field->fieldname == 'countries') : ?>
                        <input type="text"
                               id="mcs-filter-countries"
                               class="form-control mb-2"
                               placeholder="Поиск по странам..." />
                    <?php endif; ?>
					<?= $field->input; ?>
					<?php if ($field->fieldname == 'cities') : ?>
                        <a href="#!" onclick="return _ADD_ALL_CITIES()"
                           role="button"
                           class="btn btn-primary"
                           title="<?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_ADD_ALL_CITIES'); ?>"><?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_ADD_ALL_CITIES'); ?>
                        </a>
					<?php endif; ?>
                    <?php if ($field->fieldname == 'provinces') : ?>
                        <a href="#!" onclick="return _ADD_ALL_PROVINCES()"
                           role="button"
                           class="btn btn-primary"
                           title="<?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_ADD_ALL_PROVINCES'); ?>"><?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_ADD_ALL_PROVINCES'); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($field->fieldname == 'countries') : ?>
                        <a href="#!" onclick="return _ADD_ALL_COUNTRIES()"
                           role="button"
                           class="btn btn-primary"
                           title="<?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_ADD_ALL_COUNTRIES'); ?>"><?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_ADD_ALL_COUNTRIES'); ?>
                        </a>
                    <?php endif; ?>
                </div>

            </div>
			<?php
		} ?>
		<?php if ($default) : ?>
            <input type="hidden" name="jform[cities]" value="0"/>
            <input type="hidden" name="jform[provinces]" value="0"/>
            <input type="hidden" name="jform[countries]" value="0"/>
		<?php endif; ?>
        <input type="hidden" name="task" value=""/>
		<?php echo \Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
    </form>
</div>