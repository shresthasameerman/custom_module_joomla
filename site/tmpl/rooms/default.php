<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('jquery.framework');
HTMLHelper::_('bootstrap.tooltip');
?>

<div class="hotel-booking rooms-list">
    <h1><?php echo Text::_('COM_HOTELBOOKING_AVAILABLE_ROOMS'); ?></h1>

    <!-- Search Form -->
    <form action="<?php echo Route::_('index.php?option=com_hotelbooking&view=rooms'); ?>" method="post" class="form-inline mb-4">
        <div class="filters row">
            <div class="col-md-3">
                <div class="form-group">
                    <label><?php echo Text::_('COM_HOTELBOOKING_CHECK_IN'); ?></label>
                    <?php echo HTMLHelper::_('calendar', $this->state->get('filter.check_in'), 'check_in', 'check_in', '%Y-%m-%d', ['class' => 'form-control']); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><?php echo Text::_('COM_HOTELBOOKING_CHECK_OUT'); ?></label>
                    <?php echo HTMLHelper::_('calendar', $this->state->get('filter.check_out'), 'check_out', 'check_out', '%Y-%m-%d', ['class' => 'form-control']); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><?php echo Text::_('COM_HOTELBOOKING_GUESTS'); ?></label>
                    <select name="capacity" class="form-control">
                        <option value="">All</option>
                        <?php for ($i = 1; $i <= 10; $i++) : ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?> Guests</option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    <?php echo Text::_('COM_HOTELBOOKING_SEARCH'); ?>
                </button>
            </div>
        </div>
    </form>

    <!-- Rooms List -->
    <div class="rooms-grid row">
        <?php if (!empty($this->items)) : ?>
            <?php foreach ($this->items as $item) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if (!empty($item->images)) : ?>
                            <img src="<?php echo $item->images[0]; ?>" class="card-img-top" alt="<?php echo $this->escape($item->title); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $this->escape($item->title); ?></h5>
                            <p class="card-text">
                                <strong><?php echo Text::_('COM_HOTELBOOKING_CAPACITY'); ?>:</strong> 
                                <?php echo $item->capacity; ?> guests
                            </p>
                            <p class="card-text">
                                <strong><?php echo Text::_('COM_HOTELBOOKING_PRICE'); ?>:</strong> 
                                <?php echo number_format($item->base_price, 2); ?> per night
                            </p>
                            <a href="<?php echo Route::_('index.php?option=com_hotelbooking&view=room&id=' . $item->id); ?>" 
                               class="btn btn-primary">
                                <?php echo Text::_('COM_HOTELBOOKING_VIEW_DETAILS'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="alert alert-info">
                <?php echo Text::_('COM_HOTELBOOKING_NO_ROOMS_AVAILABLE'); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
</div>