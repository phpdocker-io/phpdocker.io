<?php
/**
 * Copyright 2016 Luis Alberto Pabon Flores
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace AppBundle\Controller;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for simpler pages.
 *
 * @package AppBundle\Controller
 * @author  Luis A. Pabon Flores
 */
class PagesController extends AbstractController
{
    /**
     * Homepage
     *
     * @return Response
     */
    public function homeAction()
    {
        $categories = [
            $this->container->getParameter('news_category_slug'),
            $this->container->getParameter('homepage_category_slug'),
        ];

        $content = [];
        foreach ($categories as $slug) {
            $content[$slug] = $this
                ->getHomepageContentQueryBuilder()
                ->setParameter('slug', $slug)
                ->getQuery()
                ->getResult(Query::HYDRATE_SIMPLEOBJECT);
        }

        return $this->render('AppBundle:Pages:home.html.twig', ['content' => $content]);
    }

    /**
     * Returns a pre-configured query builder for homepage contents. You'll need to setParameter slug on the
     * returned object.
     *
     * @return QueryBuilder
     */
    private function getHomepageContentQueryBuilder()
    {
        $queryBuilder = $this
            ->getDatabaseTable('AppBundle:ORM\Post')
            ->createQueryBuilder('p')
            ->innerJoin('AppBundle:ORM\Category', 'c', Query\Expr\Join::WITH, 'p.category = c.id')
            ->where('p.active = :active')
            ->andWhere('c.slug = :slug')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($this->container->getParameter('homepage_item_limit'))
            ->setParameter('active', true);

        return $queryBuilder;
    }
}
