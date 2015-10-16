<?php

namespace OpenGraph\Controller;
use OpenGraph\Event\OpenGraphEvent;
use OpenGraph\EventListeners\OpenGraphEventListener;
use Thelia\Controller\Admin\BaseAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Tools\URL;


/**
 * Created by PhpStorm.
 * User: openstudio
 * Date: 13/10/15
 * Time: 14:15
 */

class OpenGraphController extends BaseAdminController
{
    protected function redirectToConfigurationPage()
    {
        return RedirectResponse::create(URL::getInstance()->absoluteUrl('/admin/module/OpenGraph'));
    }

    public function editData()
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, ['OpenGraph'], AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm('open.graph.data.edit');
        $error_message = null;

        try {
            $validateForm = $this->validateForm($form);

            $fileCreateOrUpdateEvent = new OpenGraphEvent();

            $fileCreateOrUpdateEvent->setId($validateForm->get('id')->getData());
            $fileCreateOrUpdateEvent->setCompanyName($validateForm->get('company_name')->getData());
            $fileCreateOrUpdateEvent->setTwitterCompanyName($validateForm->get('twitter_company_name')->getData());

            $this->dispatch(
                OpenGraphEventListener::DATA_EDIT,
                $fileCreateOrUpdateEvent
            );

            $response =  $this->redirectToConfigurationPage();

        } catch (FormValidationException $e) {
            $error_message = $this->createStandardFormValidationErrorMessage($e);
        }

        if (null !== $error_message) {
            $this->setupFormErrorContext(
                'data edit',
                $error_message,
                $form
            );

            $response = $this->render("module-configure", ['module_code' => 'OpenGraph']);
        }

        return $response;
    }
}