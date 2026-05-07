<?php
/**
 * MyCitySelector
 * @author   Konstantin Kutsevalov
 * @version  2.0.0
 *
 * @formatter:off
 *
 * @var $this
 * @var $sidebar string
 * @var $data    array
 * @var $model   CountryModel
 */

defined('_JEXEC') or die(header('HTTP/1.0 403 Forbidden') . 'Restricted access');

\Joomla\CMS\HTML\HTMLHelper::_('behavior.formvalidator');
\Joomla\CMS\HTML\HTMLHelper::_('jquery.framework');
\Joomla\CMS\HTML\HTMLHelper::_('behavior.multiselect');
\Joomla\CMS\HTML\HTMLHelper::_('script', 'system/modal-fields-uncompressed.js', array('version' => 'auto', 'relative' => true));
$mcsFieldModalJs = JPATH_ADMINISTRATOR . '/components/com_mycityselector/assets/js/field-value-modals.js';
\Joomla\CMS\Factory::getDocument()->addScript(
	\Joomla\CMS\Uri\Uri::root(true) . '/administrator/components/com_mycityselector/assets/js/field-value-modals.js?v=' . (is_file($mcsFieldModalJs) ? (string) filemtime($mcsFieldModalJs) : '1')
);
$user      = \Joomla\CMS\Factory::getUser();
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$colSpan   = 8;

$app = \Joomla\CMS\Factory::getDocument();

\Joomla\CMS\Factory::getDocument()->addScriptDeclaration("
	Joomla.submitbutton = function(task)
	{
		if (task == 'field.cancel' || document.formvalidator.isValid(document.getElementById('adminForm')))
		{
			Joomla.submitform(task, document.getElementById('adminForm'));
		}
	};
");

$fieldSet = $this->form->getFieldset('edit');
$id  = (int) $this->item->id;

?>
<div id="j-main-container" class="span10 fields-page">
    <h3><?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_FIELDS') ?></h3>

    <form action="<?= \Joomla\CMS\Router\Route::_('index.php?option=com_mycityselector&layout=edit&id=' . (int) $this->item->id); ?>"
          method="post" name="adminForm" id="adminForm"
          class="form-horizontal">
		<?php foreach ($fieldSet as $field) {
			?>
            <div class="control-group">
                <div class="control-label span2">
					<?= $field->label; ?>
                </div>
                <div class="controls span7">
					<?= $field->input; ?>
                </div>
            </div>
			<?php
		}

		if ($id) {
			$fieldValues = $this->get('FieldValues');
			?>
            <table class="table table-striped" id="fieldvalueList">
                <thead>
                    <tr>
                        <th width="1%" class="nowrap center">
                            <?php echo \Joomla\CMS\HTML\HTMLHelper::_('grid.checkall'); ?>
                        </th>
                        <th class="locations">
                            <?php echo \Joomla\CMS\HTML\HTMLHelper::_('searchtools.sort', 'COM_MYCITYSELECTOR_LOCATIONS', 'locations', $listDirn, $listOrder); ?>
                        </th>
                        <th class="value">
                            <?php echo \Joomla\CMS\HTML\HTMLHelper::_('searchtools.sort', 'COM_MYCITYSELECTOR_FIELD_VALUES', 'value', $listDirn, $listOrder); ?>
                        </th>
                        <th width="1%" class="nowrap center hidden-phone">
                            <?php echo \Joomla\CMS\HTML\HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'id', $listDirn, $listOrder); ?>
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="<?= $colSpan ?>"></td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php

                    foreach ($fieldValues as $i => $item)  {

                        $ordering = ($listOrder == 'a.ordering');
                        $canCreate = $user->authorise('core.create', 'com_mycityselector');
                        $canEdit = $user->authorise('core.edit', 'com_mycityselector.field.edit.' . $item['id']);
                        $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
                        $canChange = $user->authorise('core.edit.state', 'com_mycityselector.field.edit.' . $item['id']) && $canCheckin;
                        $link = \Joomla\CMS\Router\Route::_('index.php?option=com_mycityselector&view=fieldvalue&tmpl=component&field_id=' . $this->state->get('field.id') . '&id=' . $item['id']);
                        echo \Joomla\CMS\HTML\HTMLHelper::_(
                            'bootstrap.renderModal',
                            'fieldValueModal' . $item['id'],
                            array(
                                'url'         => $link,
                                'title'       => \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_FIELD_VALUES'),
                                'closeButton' => false,
                                'width'       => '800px',
                                'height'      => '300px',
                                'modalWidth'  => '80',
                                'bodyHeight'  => '70',
                                'footer'      => '<a role="button" class="btn" aria-hidden="true"'
                                    . ' onclick="window.processModalEdit(this, \'fieldValue\', \'add\', \'field\', \'cancel\', \'adminForm\'); location.reload(true); return false;">'
                                    . \Joomla\CMS\Language\Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</a>'
                                    . '<a role="button" class="btn btn-primary" aria-hidden="true"'
                                    . ' onclick="window.processModalEdit(this, \'fieldValue\', \'add\', \'fieldvalue\', \'save\', \'adminForm\'); location.reload(true); return false;">'
                                    . \Joomla\CMS\Language\Text::_('JSAVE') . '</a>'
                                    . '<a role="button" class="btn btn-success" aria-hidden="true"'
                                    . ' onclick="window.processModalEdit(this, \'fieldValue\', \'add\', \'fieldvalue\', \'apply\', \'adminForm\'); return false;">'
                                    . \Joomla\CMS\Language\Text::_('JAPPLY') . '</a>',
                            )
                        );
                        ?>
                        <tr class="row<?= $i % 2; ?>" sortable-group-id="1" item-id="<?= $item['id']; ?>">
                            <td class="center">
                                <?php
                                if ($item['default'] != 1) {
                                    echo \Joomla\CMS\HTML\HTMLHelper::_('grid.id', $i, $item['id']);
                                }
                                ?>
                            </td>
                            <td class="small">
                                <div class="name break-word">
                                    <?php
                                    $title = \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_DEFAULTVALUE');
                                    if ($item['default'] == 0) {

                                        $cities = array_filter(explode(',', $item['cities']));
                                        $provinces = array_filter(explode(',', $item['provinces']));
                                        $countries = array_filter(explode(',', $item['countries']));

                                        $locations = [];

                                        if(!empty($cities)) {
                                            $locations = array_merge($locations, $cities);
                                        }

                                        if(!empty($provinces)) {
                                            $locations = array_merge($locations, $provinces);
                                        }

                                        if(!empty($countries)) {
                                            $locations = array_merge($locations, $countries);
                                        }

                                        if (count($locations) > 3) {
                                            $count = count($locations) - 3;
                                            $locations = array_slice($locations, 0, 3);
                                            $locations[] = \Joomla\CMS\Language\Text::sprintf('COM_MYCITYSELECTOR_MORE_CITIES_ALSO', $count);
                                        }
                                        $title = implode(',', $locations);
                                    }
                                    if ($canEdit) {
                                        ?>
                                        <a href="#fieldValueModal<?= $item['id'] ?>" data-bs-toggle="modal"
                                           data-bs-target="#fieldValueModal<?= $item['id'] ?>"
                                           title="<?= $this->escape($title) ?>">
                                            <?= $title ?>
                                        </a>
                                        <?php
                                    } else {
                                        echo $title;
                                    }
                                    ?>
                                </div>
                            </td>
                            <td class="small">
                                <div class="name break-word">
                                    <?= $this->escape(mb_substr($item['value'], 0, 100, 'UTF-8')) . '...' ?>
                                </div>
                            </td>
                            <td class="hidden-phone">
                                <a href="#fieldValueModal<?= $item['id'] ?>" data-bs-toggle="modal"
                                   data-bs-target="#fieldValueModal<?= $item['id'] ?>"
                                   title="<?= (int) $item['id']; ?>">
                                    <?= (int) $item['id']; ?></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

            <div class="field-values">
				<?php
				$link = \Joomla\CMS\Router\Route::_('index.php?option=com_mycityselector&view=fieldvalue&tmpl=component&field_id=' . $this->state->get('field.id') . '&id=');
				?>
				<?=
				\Joomla\CMS\HTML\HTMLHelper::_(
					'bootstrap.renderModal',
					'fieldValueModal',
					array(
						'url'         => $link,
						'title'       => \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_FIELD_VALUES'),
						'closeButton' => false,
						'width'       => '800px',
						'height'      => '300px',
						'modalWidth'  => '80',
						'bodyHeight'  => '70',
						'footer'      => '<a role="button" class="btn" aria-hidden="true"'
							. ' onclick="window.processModalEdit(this, \'fieldValue\', \'add\', \'field\', \'cancel\', \'adminForm\'); location.reload(true); return false;">'
							. \Joomla\CMS\Language\Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</a>'
							. '<a role="button" class="btn btn-primary" aria-hidden="true"'
							. ' onclick="window.processModalEdit(this, \'fieldValue\', \'add\', \'fieldvalue\', \'save\', \'adminForm\'); location.reload(true); return false;">'
							. \Joomla\CMS\Language\Text::_('JSAVE') . '</a>'
							. '<a role="button" class="btn btn-success" aria-hidden="true"'
							. ' onclick="window.processModalEdit(this, \'fieldValue\', \'add\', \'fieldvalue\', \'apply\', \'adminForm\'); return false;">'
							. \Joomla\CMS\Language\Text::_('JAPPLY') . '</a>',
					)
				);
				?>
                <a href="#fieldValueModal" role="button" class="btn btn-primary" data-bs-toggle="modal"
                   data-bs-target="#fieldValueModal"
                   title="<?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_ADDFORM'); ?>">
                <span class="icon-list icon-white"
                      aria-hidden="true"></span><?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_ADDFORM'); ?>
                </a>
                <input type="hidden" id="fieldValue_id" name="fieldValue_id">
                <input type="hidden" id="fieldValue_name" name="fieldValue_name">
            </div>
		    <?php
		} else {
			echo \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_SAVE_TO_ADD');
		}
		?>
        <input type="hidden" name="boxchecked" value="0"/>
        <input type="hidden" name="task" value=""/>
		<?php echo \Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
    </form>
</div>

