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
 * InfantryBuildRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InfantryBuildRepository extends \Doctrine\ORM\EntityRepository
{
    public function createInfantry($infantry, $toCreate, $town) {
        return $this->getEntityManager()
            ->createQuery(
            'UPDATE GameBundle:InfantryBuild i SET i.nb = i.nb - :nombre, i.beginFormation = :begin WHERE i.town = :town AND i.infantry = :infantry'
            )
            ->setParameters(array('nombre' => $toCreate, 'begin' => time(), 'town' => $town, 'infantry'=>$infantry))
            ->execute();
    }
}
