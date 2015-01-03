<?php

// src/JCV/UploadBundle/Form/Type/DataPickerType.php

namespace JCV\UploadBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatePickerType extends AbstractType {

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'widget' => 'single_text'
        ));
    }

    public function getParent() {
        return 'date';
    }

    public function getName() {
        return 'datePicker';
    }

}
