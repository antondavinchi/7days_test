<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Timezone;

class TimeZoneFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', TextType::class, [
                'label' => 'Date (Y-m-d): ',
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
                        'message' => 'Please enter a valid date in the format Y-m-d.',
                    ]),
                ],
            ])
            ->add('timezone', TextType::class, [
                'label' => 'Timezone: ',
                'constraints' => [
                    new NotBlank(),
                    new Timezone(),
                ],
            ]);
    }
}
