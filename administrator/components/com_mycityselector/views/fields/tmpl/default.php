<?php


defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.tooltip');
\Joomla\CMS\HTML\HTMLHelper::_('behavior.multiselect');

$clientId  = (int) $this->state->get('client_id', 0);
$user      = \Joomla\CMS\Factory::getUser();
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$isDbRepl = (bool) isset($_GET['db_replacement']);

$colSpan = $clientId === 1 ? 8 : 10;
?>
<form action="<?= \Joomla\CMS\Router\Route::_('index.php?option=com_mycityselector&view=fields'); ?>" method="post" name="adminForm"
      id="adminForm">
	<?php if (!empty($this->sidebar)) { ?>
    <div id="j-sidebar-container" class="span2">
		<?= $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
    <?php } else { ?>
        <div id="j-main-container">
    <?php } ?>
			<?= LayoutHelper::render('joomla.searchtools.default', ['view' => $this]); ?>
			<?php if ($this->total > 0) { ?>
                <table class="table table-striped" id="cityList">
                    <thead>
                    <tr>
                        <th width="1%" class="nowrap center">
							<?= \Joomla\CMS\HTML\HTMLHelper::_('grid.checkall'); ?>
                        </th>
                        <?php if ($this->mode == 'page') { ?>
                        <th width="1%" class="nowrap center" style="min-width:55px">
							<?= \Joomla\CMS\HTML\HTMLHelper::_('searchtools.sort', 'Jpublished', 'published', $listDirn, $listOrder); ?>
                        </th>
                        <?php } ?>
                        <th class="title">
							<?= \Joomla\CMS\HTML\HTMLHelper::_('searchtools.sort', 'JGLOBAL_TITLE', 'name', $listDirn, $listOrder); ?>
                        </th>
                        <th class="country">
		                    <?= \Joomla\CMS\HTML\HTMLHelper::_('searchtools.sort', 'COM_MYCITYSELECTOR_COUNTRY', 'country', $listDirn, $listOrder); ?>
                        </th>
                        <th class="province">
		                    <?= \Joomla\CMS\HTML\HTMLHelper::_('searchtools.sort', 'COM_MYCITYSELECTOR_PROVINCE', 'province', $listDirn, $listOrder); ?>
                        </th>
                        <th class="city">
		                    <?= \Joomla\CMS\HTML\HTMLHelper::_('searchtools.sort', 'COM_MYCITYSELECTOR_CITY', 'city', $listDirn, $listOrder); ?>
                        </th>
                        <th width="1%" class="nowrap center hidden-phone">
							<?= \Joomla\CMS\HTML\HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'id', $listDirn, $listOrder); ?>
                        </th>
                        <?php if ($this->mode == 'popup') { ?>
                            <th class="nowrap center">
                                &nbsp;
                            </th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($this->items as $i => $item) {
                        $canCreate = $user->authorise('core.create', 'com_mycityselector');
                        $canEdit = $user->authorise('core.edit', 'com_mycityselector.cities.' . $item->id);
                        $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
                        $canChange = $user->authorise('core.edit.state', 'com_mycityselector.cities.' . $item->id) && $canCheckin;
                        $name = str_replace(['[', ']', '"', "'"], ['', '', '', ''], $item->name);
                        ?>
                        <tr class="row<?= $i % 2; ?>"
                            sortable-group-id="1" item-id="<?= $item->id; ?>">
                            <td class="center">
								<?= \Joomla\CMS\HTML\HTMLHelper::_('grid.id', $i, $item->id); ?>
                            </td>
                            <?php if ($this->mode == 'page') { ?>
                            <td class="center">
                                <div class="btn-group">
									<?= \Joomla\CMS\HTML\HTMLHelper::_('jgrid.published', $item->published, $i, 'fields.', $canChange, 'cb'); ?>
                                </div>
                            </td>
                            <?php } ?>
                            <td class="small">
                                <div class="name break-word">
                                    <?php
                                    if ($this->mode == 'page') {
                                        if ($canEdit) {
                                            $_url = \Joomla\CMS\Router\Route::_(
                                                    'index.php?option=com_mycityselector&task=field.edit&id='
                                                . (int) $item->id
                                                . ($isDbRepl ? '&db_replacement=1' : '')
                                            );
                                            ?>
                                            <a href="<?= $_url ?>"
                                               title="<?= $this->escape($item->name) ?>">
                                                <?= $this->escape($item->name) ?>
                                            </a>
                                            <?php
                                        } else {
                                            echo $this->escape($item->name);
                                        }
                                    } else {
                                        ?>
                                        <a href="#" title="<?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_INSERT_CODE') ?>"
                                           onclick="window.parent.insertMCS('[mcs-<?= $item->id ?> <?= $name ?>]'); return false;">
                                            <?= $this->escape($item->name) ?>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </td>
                            <td class="small">
                                <div class="name break-word">
			                        <?= $this->escape($item->country); ?>
                                </div>
                            </td>
                            <td class="small">
                                <div class="name break-word">
			                        <?= $this->escape($item->province); ?>
                                </div>
                            </td>
                            <td class="small">
                                <div class="name break-word">
			                        <?= $this->escape($item->city); ?>
                                </div>
                            </td>
                            <?php if ($this->mode == 'popup') { ?>
                                <td class="nowrap center">
                                    <a href="#" title="" onclick="window.parent.insertMCS('[mcs-<?= $item->id ?> <?= $name ?>]'); return false;">
                                        <?= \Joomla\CMS\Language\Text::_('COM_MYCITYSELECTOR_INSERT_CODE') ?>
                                    </a>
                                </td>
                            <?php } else { ?>
                                <td class="hidden-phone">
                                    <?php if ($canEdit) {
                                        $_url = \Joomla\CMS\Router\Route::_(
                                            'index.php?option=com_mycityselector&task=field.edit&id='
                                            . (int) $item->id
                                            . ($isDbRepl ? '&db_replacement=1' : '')
                                        );
                                        ?>
                                        <a href="<?= $_url ?>" title="<?= $this->escape((int) $item->id); ?>">
                                            <?= $this->escape((int) $item->id); ?>
                                        </a>
                                    <?php } else { ?>
                                        <?= $this->escape((int) $item->id); ?>
                                    <?php } ?>
                                </td>
                            <?php } ?>
                        </tr>
					<?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="<?= $colSpan; ?>">
                                <?= $this->pagination->getListFooter(); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
			<?php } ?>

            <input type="hidden" name="task" value=""/>
            <input type="hidden" name="boxchecked" value="0"/>
			<?= \Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
        </div>
</form>
