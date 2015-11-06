<?php

namespace OpenGraph\Form;

use OpenGraph\OpenGraph;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Thelia\Model\ConfigQuery;

/**
 * Class ConfigurationForm
 * @package OpenGraph\Form
 * @author Thomas Arnaud <tarnaud@openstudio.fr>
 */
class OpenGraphConfigurationForm extends BaseForm {

    protected function buildForm()
    {
        $form = $this->formBuilder;

        // TODO add constraints to test twitter username and add a description / help for the fields
        $definitions = array(
            array(
                "id" => "company_name",
                "label" => Translator::getInstance()->trans("Your company's name", array(), OpenGraph::DOMAIN_NAME)
            ),
            array(
                "id" => "twitter_company_name",
                "label" => Translator::getInstance()->trans("Your company's name on twitter", array(), OpenGraph::DOMAIN_NAME)
            ),
            array(
                "id" => "twitter_creator_name",
                "label" => Translator::getInstance()->trans("The creator's name on twitter", array(), OpenGraph::DOMAIN_NAME)
            )
        );

        foreach ($definitions as $field){
            $value = ConfigQuery::read("opengraph_" . $field["id"], "");
            $form->add(
                $field["id"],
                "text",
                array(
                    'data'  => $value,
                    'label' => $field["label"],
                    'label_attr' => array(
                        'for' => $field["id"]
                    ),
                )
            );
        }
    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return "opengraph";
    }
} 