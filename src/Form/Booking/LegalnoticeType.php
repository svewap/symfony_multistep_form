<?php

namespace App\Form\Booking;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\IdenticalTo;

class LegalnoticeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('acceptTermsAndConditions', CheckboxType::class, [
                'constraints' => [
                    new EqualTo([
                        'value' => 1,
                        'message' => 'Sie müssen zustimmen'
                    ])
                ],
            ])->add('acceptDataProcessing', CheckboxType::class, [
                'constraints' => [
                    new EqualTo([
                        'value' => 1,
                        'message' => 'Sie müssen zustimmen'
                    ])
                ],
            ])->add('dummy', HiddenType::class, [
                'data' => '1',
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}