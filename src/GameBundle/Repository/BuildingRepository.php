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
 * BuildingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BuildingRepository extends \Doctrine\ORM\EntityRepository
{
    public function getBuilding($id) {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT PARTIAL b.{id, lvl, add, addHabitant, addPoint, time},
                      PARTIAL r.{id, buildingFather,lvl},
                      PARTIAL bf.{id, buildingChild, lvl},
                      PARTIAL bf2.{id, lvl, buildingType},
                      PARTIAL bt2.{id, name},
                      PARTIAL bc.{id, lvl},
                      PARTIAL re.{id, nb},
                      PARTIAL bt.{id, name, descr, isRessource}, PARTIAL r.{id}
                      FROM GameBundle:Building b
                     LEFT JOIN b.required r
                     LEFT JOIN b.buildingFather bf
                     LEFT JOIN r.buildingFather bf2
                     LEFT JOIN bf2.buildingType bt2
                     LEFT JOIN bf.buildingChild bc
                     JOIN b.ressources re
                     JOIN b.buildingType bt
                     LEFT JOIN bt.ressource r2
                     WHERE b.id = :id'
            )
            ->setParameter('id', $id)
            ->getOneOrNullResult();
    }
    public function getBuildings(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT b, r, bt FROM GameBundle:Building b
                     LEFT JOIN b.required r
                     JOIN b.buildingType bt
                     ORDER BY b.id'
            )
            ->getResult();
    }

    public function getBuildingsByType($id) {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT b, r, bt FROM GameBundle:Building b
                     LEFT JOIN b.required r
                     JOIN b.buildingType bt
                     WHERE b.buildingType = :type
                     ORDER BY b.id'
            )
            ->setParameter('type', $id)
            ->getResult();
    }


}
