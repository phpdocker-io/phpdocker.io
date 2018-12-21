<?php

namespace Application\Migrations;

use AppBundle\Entity\ORM\Category;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160330171428 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    const CATEGORY_NAME = 'Homepage';

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
    }

    /**
     * Add News category and associate all current posts to it
     *
     * @param Schema $schema
     */
    public function postUp(Schema $schema)
    {
        parent::postUp($schema);

        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');

        // Add homepage category
        $category = new Category();
        $category->setTitle('Homepage');

        $em->persist($category);
        $em->flush();
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');

        $category = $em->getRepository('AppBundle:ORM\Category')->findOneBy(['name' => self::CATEGORY_NAME]);
        if ($category) {
            $em->remove($category);
            $em->flush();
        }
    }
}
