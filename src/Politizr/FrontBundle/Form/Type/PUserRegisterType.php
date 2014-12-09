<?php

namespace Politizr\FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

use Propel\PropelBundle\Validator\Constraints\UniqueObject;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Politizr\Model\PUser;
use Politizr\Model\PUStatus;
use Politizr\Model\PUType;

/**
 * TODO: commentaires
 * 
 * @author Lionel Bouzonville
 */
class PUserRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('p_u_type_id', 'hidden', array(
            'attr'     => array( 'value' => PUType::TYPE_CITOYEN )
            )
        );
        $builder->add('p_u_status_id', 'hidden', array(
            'attr'     => array( 'value' => PUStatus::ACTIVED )
            )
        );
        $builder->add('online', 'hidden', array(
            'attr'     => array( 'value' => false )
            )
        );

        $builder->add('username', 'text', array(
            'required' => true,
            'label' => 'Identifiant', 
            'constraints' => new NotBlank(array('message' => 'Identifiant obligatoire.')),
            'attr' => array('placeholder' => 'Identifiant')
            )
        );
        
        # TODO > contraintes en plus mot de passe "fort"
        $builder->add('plainPassword', 'repeated', array(
            'required' => true,
            'first_options' =>   array(
                'label' => 'Mot de passe',
                'attr' => array('placeholder' => 'Mot de passe') 
                ),
            'second_options' =>   array(
                'label' => 'Confirmation',
                'attr' => array('placeholder' => 'Mot de passe') 
                ),
            'type' => 'password',
            'constraints' => new NotBlank(array('message' => 'Mot de passe obligatoire.'))
            )
        );

        $builder->add('actions', 'form_actions', [
            'buttons' => [
                'save' => ['type' => 'submit', 'options' => ['label' => 'Valider', 'attr' => [ 'class' => 'btn-success' ] ]],
                ]
            ]);
        
    }

    /**
     * 
     * @return string
     */
    public function getName()
    {
        return 'register';
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