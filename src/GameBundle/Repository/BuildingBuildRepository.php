<?php
/**
 * This file is part of the World Of Shinobi (Minegame).
 *
 * Copyright (c) 2017. Vincent Glize <vincent.glize@live.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GameBundle\Repository;

/**
 * BuildingBuildRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BuildingBuildRepository extends \Doctrine\ORM\EntityRepository
{
    public function getBuilding($id) {
        return $this->getEntityManager()
            ->createQuery(
            'SELECT PARTIAL b.{id, endBuild} FROM GameBundle:BuildingBuild b
            WHERE b.building = :building')
            ->setParameter('building', $id)
            ->getOneOrNullResult();
    }
}
