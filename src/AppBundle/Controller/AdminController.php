<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Doctrine\ORM\QueryBuilder;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Form;

/**
 * Overrides for Admin panel.
 *
 * @package   AppBundle\Controller
 * @copyright Auron Consulting Ltd
 */
class AdminController extends BaseAdminController
{
    /**
     * Customise admin form for slideshow items
     *
     * @param Post  $entity
     * @param array $fields
     *
     * @return Form
     */
    public function createPostNewForm(Post $entity, array $fields) : Form
    {
        $form = parent::createNewForm($entity, $fields);

        $form
            ->add('active', ChoiceType::class, [
                'label'    => 'Is it active?',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    'Yes' => true,
                    'No'  => false,
                ]
            ]);

        return $form;
    }

    /**
     * Customise SlideshowItem list to add default sorting of portfolioItem AND position
     *
     * @param string $entityClass
     * @param string $sortDirection
     * @param string $sortField
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createPostListQueryBuilder(string $entityClass, string $sortDirection, $sortField) : QueryBuilder
    {
        $queryBuilder = $this->createListQueryBuilder($entityClass, $sortDirection, $sortField);

        if ($sortField === 'id') {
            $queryBuilder->orderBy('entity.createdAt', 'DESC');
        }

        return $queryBuilder;
    }
}
