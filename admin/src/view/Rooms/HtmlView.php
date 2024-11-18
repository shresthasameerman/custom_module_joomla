<?php
namespace YourNamespace\Component\Hotelbooking\Administrator\View\Rooms;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Language\Text;

class HtmlView extends BaseHtmlView
{
    protected $items;
    protected $pagination;
    protected $state;

    public function display($tpl = null)
    {
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');

        $this->addToolbar();

        parent::display($tpl);
    }

    protected function addToolbar()
    {
        ToolbarHelper::title(Text::_('COM_HOTELBOOKING_ROOMS_TITLE'), 'room');
        ToolbarHelper::addNew('room.add');
        ToolbarHelper::editList('room.edit');
        ToolbarHelper::deleteList('', 'rooms.delete');
    }
}