<?php

namespace OpenGraph\Form;

use OpenGraph\OpenGraph;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class DataEditForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'id',
                'hidden',
                [
                    'required' => true,
                ]
            )
            ->add(
                'company_name',
                'text',
                [
                    'required' => false,
                    'label' => $this->translator->trans('Your company name'),
                    'label_attr' => [	'for' => 'company_name_field']
                ]
            )
            ->add(
                'twitter_company_name',
                'text',
                [
                    'required' => false,
                    'label' => $this->translator->trans('Your company name on twitter'),
                    'label_attr' => [	'for' => 'twitter_company_name_field']
                ]
            );
    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return "open_graph_data_edit";
    }
}