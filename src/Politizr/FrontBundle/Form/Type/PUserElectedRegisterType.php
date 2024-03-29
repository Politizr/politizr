<?php

namespace Politizr\FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Rollerworks\Bundle\PasswordStrengthBundle\Validator\Constraints\PasswordStrength;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Politizr\Constant\UserConstants;

/**
 * Elected inscription form step 1
 *
 * @author Lionel Bouzonville
 */
class PUserElectedRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'hidden', array(
            'attr'     => array( 'value' => '' )
        ));

        $builder->add('email', 'email', array(
            'required' => true,
            'label' => 'Renseignez votre email',
            'constraints' => array(
                new NotBlank(array('message' => 'Email obligatoire.')),
                new Email(array('message' => 'Le format de l\'email n\'est pas valide.')),
            ),
            'attr' => array('placeholder' => 'Email')
        ));
        
        $builder->add('plainPassword', 'password', array(
            'required' => true,
            'label' => 'Choisissez votre mot de passe (min. 8 caratères)',
            'constraints' => array(
                new NotBlank(array('message' => 'Mot de passe obligatoire.')),
                new PasswordStrength(
                    array(
                        'message' => 'Le mot de passe doit contenir au moins 8 caractères',
                        'minLength' => 8,
                        'minStrength' => 1
                    )
                ),
            ),
            'attr' => array('placeholder' => 'Mot de passe')
        ));
        
        $builder->add('elected', 'checkbox', array(
            'required' => true,
            'mapped' => false,
            'constraints' => new IsTrue(
                array(
                    'message' => 'Vous devez certifier exercer — ou avoir exercé — un mandat électif*.'
                )
            )
        ));

        $builder->add('cgu', 'checkbox', array(
            'required' => true,
            'mapped' => false,
            'constraints' => new IsTrue(
                array(
                    'message' => 'Vous devez accepter les conditions générales d\'utilisation.'
                )
            )
        ));

        // update username same as email field
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            if (isset($data['email'])) {
                $data['username'] = $data['email'];
            }
            $event->setData($data);
        });
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'user_elected_register';
    }
    
    /**
     *
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Politizr\Model\PUser',
        ));
    }
}
