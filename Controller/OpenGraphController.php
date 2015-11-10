<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace OpenGraph\Controller;

use OpenGraph\OpenGraph;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Model\ConfigQuery;
use Thelia\Tools\URL;

/**
 * Class OpenGraphController
 * @package OpenGraph\Controller
 * @author Thomas Arnaud <tarnaud@openstudio.fr>
 */
class OpenGraphController extends BaseAdminController
{
    /**
     * Redirect to the configuration page
     *
     */
    protected function redirectToConfigurationPage()
    {
        return RedirectResponse::create(URL::getInstance()->absoluteUrl('/admin/module/OpenGraph'));
    }

    /**
     * Fill the form with the configuration data
     */
    public function saveAction()
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, [OpenGraph::DOMAIN_NAME], AccessManager::UPDATE)) {
            return $response;
        }

        // Create the form from the request
        $form = $this->createForm('open.graph.configuration.form');

        // Initialize the potential error
        $error_message = null;

        try {
            // Check the form against constraints violations
            $validateForm = $this->validateForm($form);

            // Get the form field values
            $data = $validateForm->getData();

            foreach ($data as $name => $value) {
                if (!$form->isTemplateDefinedHiddenFieldName($name)) {
                    ConfigQuery::write("opengraph_" . $name, $value, false, true);
                }
            }

            // Redirect to the configuration page if everything is OK
            return $this->redirectToConfigurationPage();
        } catch (FormValidationException $e) {
            // Form cannot be validated. Create the error message using
            // the BaseAdminController helper method.
            $error_message = $this->createStandardFormValidationErrorMessage($e);
        }

        if (null !== $error_message) {
            $this->setupFormErrorContext(
                'configuration',
                $error_message,
                $form
            );

            $response = $this->render("module-configure", ['module_code' => 'OpenGraph']);
        }

        return $response;
    }
}