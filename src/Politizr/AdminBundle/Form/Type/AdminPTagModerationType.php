<?php

namespace Politizr\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Propel\Bundle\PropelBundle\Form\Type\ModelType;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Politizr\Model\PTag;

use Politizr\Model\PMModerationTypeQuery;

/**
 * Tag moderation
 *
 * @author Lionel Bouzonville
 */
class AdminPTagModerationType extends AbstractType
{
    protected $tag;

    /**
     *
     */
    public function __construct(PTag $tag)
    {
        $this->tag = $tag;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tag_id', HiddenType::class, array(
            'data' => $this->tag->getId(),
        ));

        // Moderation type list
        $builder->add('p_m_moderation_type', ModelType::class, array(
                'required' => true,
                'label' => 'Type de modération',
                'class' => 'Politizr\\Model\\PMModerationType',
                'query' => PMModerationTypeQuery::create()->orderById('asc'),
                'empty_data'  => null,
                'index_property' => 'id',
                'multiple' => false,
                'expanded' => false,
            ));
        
        $builder->add('score_evolution', TextType::class, array(
            'required' => false,
            'label' => 'Evolution de réputation',
            'constraints' => array(
                new Range(array('max' => '0', 'maxMessage' => 'Nombre négatif')),
            ),
            'attr' => array('placeholder' => 'Nombre négatif soustrait à la réputation, par exemple "-10"'),
        ));

        $builder->add('ban', CheckboxType::class, array(
            'label'    => 'Utilisateur banni',
            'required' => false,
        ));

        $builder->add('moderation_level', ChoiceType::class, array(
            'label'    => 'Niveau',
            'required' => true,
            'choices'  => array(
                'Modération partielle' => 1,
                'Modération totale' => 2,
            ),
            'choices_as_values' => true,
        ));

        $builder->add('title', TextType::class, array(
            'label'    => 'Titre',
            'required' => false,
            'data' => $this->tag->getTitle(),
        ));

        $builder->add('send_email', CheckboxType::class, array(
            'label'    => 'Envoyer email',
            'required' => false,
        ));
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'admin_tag_moderation';
    }
}
