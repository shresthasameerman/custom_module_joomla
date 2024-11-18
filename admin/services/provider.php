<?php
namespace HotelBooking\Component\Hotelbooking\Administrator\Service\Provider;

defined('_JEXEC') or die;

use Joomla\CMS\Component\Router\RouterFactoryInterface;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\Extension\Service\Provider\RouterFactory;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

class HotelbookingProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container->registerServiceProvider(new MVCFactory('\\HotelBooking\\Component\\Hotelbooking'));
        $container->registerServiceProvider(new ComponentDispatcherFactory('\\HotelBooking\\Component\\Hotelbooking'));
        $container->registerServiceProvider(new RouterFactory('\\HotelBooking\\Component\\Hotelbooking'));

        $container->set(
            ComponentInterface::class,
            function (Container $container) {
                $component = new HotelbookingComponent($container->get(ComponentDispatcherFactoryInterface::class));
                $component->setMVCFactory($container->get(MVCFactoryInterface::class));
                $component->setRouterFactory($container->get(RouterFactoryInterface::class));

                return $component;
            }
        );
    }
}