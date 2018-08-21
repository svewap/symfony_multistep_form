<?php

namespace App\Form\Booking;

use App\Entity\Booking;
use App\Form\ParticipantType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;

class ParticipantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('participants', CollectionType::class, [
                'entry_type' => ParticipantType::class,
                'entry_options' => ['label' => false, 'entityManager' => $options['entityManager']],
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'constraints' => [
                    new Count([
                        'min' => 1,
                        'max' => 400,
                        'minMessage' => 'You must specify at least one participant',
                        'maxMessage' => 'You cannot specify more than {{ limit }} participants',
                    ])
                ],
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
        $resolver->setRequired('entityManager');
    }
}