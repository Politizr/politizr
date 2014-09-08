<?php

namespace Politizr\FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

use Propel\PropelBundle\Validator\Constraints\UniqueObject;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Politizr\Model\PUser;
use Politizr\Model\PUType;
use Politizr\Model\PUStatus;

/**
 * TODO: commentaires
 * 
 * @author Lionel Bouzonville
 */
class PUserStep2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden', array(
            'required' => true
            )
        );
        $builder->add('p_u_type_id', 'hidden', array(
            'attr'     => array( 'value' => PUType::TYPE_CITOYEN )
            )
        );
        $builder->add('p_u_status_id', 'hidden', array(
            'attr'     => array( 'value' => PUStatus::STATUS_ACTIV )
            )
        );
        $builder->add('online', 'hidden', array(
            'attr'     => array( 'value' => true )
            )
        );


        $builder->add('gender', 'choice', array(
            'required' => true,
            'label' => 'Genre', 
            'choices' => array('Madame' => 'Madame', 'Monsieur' => 'Monsieur'),
            'empty_value' => 'Civilité',
            'constraints' => new NotBlank(array('message' => 'Civilité obligatoire.'))
        ));

        $builder->add('name', 'text', array(
            'required' => true,
            'label' => 'Nom', 
            'constraints' => new NotBlank(array('message' => 'Nom obligatoire.'))
            )
        );
        $builder->add('firstname', 'text', array(
            'required' => true,
            'label' => 'Prénom', 
            'constraints' => new NotBlank(array('message' => 'Prénom obligatoire.'))
            )
        );
        $builder->add('birthday', 'date', array(
            'required' => true,
            'label' => 'Date de naissance', 
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'invalid_message' => 'La date de naissance doit être au format JJ/MM/AAAA',
            'constraints' => new NotBlank(array('message' => 'Date de naissance obligatoire.'))
            )
        );

        $builder->add('email', 'repeated', array(
            'required' => true,
            'first_options' =>   array(
                'label' => 'Email', 
                ),
            'second_options' =>   array(
                'label' => 'Confirmation email', 
                ),
            'type' => 'email',
            'constraints' => new NotBlank(array('message' => 'Email obligatoire.'))
            )
        );

        $builder->add('newsletter', 'checkbox', array(  
            'required' => false,
            'label' => 'Je souhaite recevoir les news de Politizr', 
            'attr'     => array( 'checked' => 'checked', 'align_with_widget' => true )
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
        return 'pUser';
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
