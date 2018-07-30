<?php

namespace App\Form\Extension\Validator;

use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Symfony\Component\Form\AbstractExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorTypeGuesser;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Extension supporting the Symfony Validator component in forms.
 *
 * @author Sven Wappler
 */
class ValidatorExtension extends AbstractExtension
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $metadata = $validator->getMetadataFor('Symfony\Component\Form\Form');

        // Register the form constraints in the validator programmatically.
        // This functionality is required when using the Form component without
        // the DIC, where the XML file is loaded automatically. Thus the following
        // code must be kept synchronized with validation.xml

        /* @var $metadata ClassMetadata */
        $metadata->addConstraint(new Form());
        $metadata->addPropertyConstraint('children', new Valid());

        $this->validator = $validator;
    }

    public function loadTypeGuesser()
    {
        return new ValidatorTypeGuesser($this->validator);
    }

    protected function loadTypeExtensions()
    {
        return array(
            new Type\FormTypeValidatorExtension($this->validator),
            new \Symfony\Component\Form\Extension\Validator\Type\RepeatedTypeValidatorExtension(),
            new \Symfony\Component\Form\Extension\Validator\Type\SubmitTypeValidatorExtension(),
        );
    }
}
