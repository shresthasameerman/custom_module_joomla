<?php
namespace HotelBooking\Component\Hotelbooking\Administrator\Table;

defined('_JEXEC') or die;

use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;

class RoomTable extends Table
{
    public function __construct(DatabaseDriver $db)
    {
        parent::__construct('#__hotelbooking_rooms', 'id', $db);
    }

    public function check()
    {
        // Generate alias if empty
        if (empty($this->alias)) {
            $this->alias = $this->title;
        }

        $this->alias = \JFilterOutput::stringURLSafe($this->alias);

        return true;
    }
}