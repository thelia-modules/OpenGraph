<?php

namespace OpenGraph\EventListeners;

use OpenGraph\Event\OpenGraphEvent;
use OpenGraph\Model\OpengraphDataQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OpenGraphEventListener implements EventSubscriberInterface
{
    const DATA_EDIT = 'action.data.edit';

    public static function getSubscribedEvents()
    {
        return array(
            self::DATA_EDIT => array("dataEdit", 128),
        );
    }

    public function dataEdit(OpenGraphEvent $event)
    {
        $data = OpengraphDataQuery::create()->findOneById($event->getId());

        $data->setCompanyName($event->getCompanyName());
        $data->setTwitterCompanyName($event->getTwitterCompanyName());

        $data->save();
    }
}