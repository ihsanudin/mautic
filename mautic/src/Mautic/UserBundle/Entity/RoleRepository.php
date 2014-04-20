<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic, NP. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\UserBundle\Entity;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mautic\CoreBundle\Entity\CommonRepository;

/**
 * RoleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RoleRepository extends CommonRepository
{
    /**
     * Retrieves a list of roles
     *
     * @param array $args [start, limit, filter, orderBy, orderByDir]
     * @return Paginator
     */
    public function getEntities($args = array())
    {
        $start      = array_key_exists('start', $args) ? $args['start'] : 0;
        $limit      = array_key_exists('limit', $args) ? $args['limit'] : 30;
        $filter     = array_key_exists('filter', $args) ? $args['filter'] : '';
        $orderBy    = array_key_exists('orderBy', $args) ? $args['orderBy'] : 'r.name';
        $orderByDir = array_key_exists('orderByDir', $args) ? $args['orderByDir'] : "ASC";

        $q = $this
            ->createQueryBuilder('r')
            ->setFirstResult($start)
            ->setMaxResults($limit);

        if (!empty($orderBy)) {
            $q->orderBy($orderBy, $orderByDir);
        }

        if (!empty($filter)) {
            $q->where('r.name LIKE :filter')
                ->orWhere('r.description LIKE :filter')
                ->setParameter(':filter', '%'.$filter.'%');
        }
        $query = $q->getQuery();
        $result = new Paginator($query);
        return $result;
    }
}