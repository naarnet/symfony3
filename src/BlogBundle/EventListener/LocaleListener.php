<?php

namespace BlogBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Description of LocaleListener
 *
 * @author ronaldinho
 */
class LocaleListener implements EventSubscriberInterface
{

    private $_defaultLocale;

    public function __construct($defaultLocale = "en")
    {
        $this->_defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }
        if ($locale = $request->attributes->get("_locale")) {
            $request->getSession()->set("_locale", $locale);
        } else {
            $request->setLocale($request->getSession()->get("_locale", $this->_defaultLocale));
        }
    }

    //put your code here
    public static function getSubscribedEvents()
    {
        return array(KernelEvents::REQUEST => array(array("onKernelRequest", 17)));
    }

}
