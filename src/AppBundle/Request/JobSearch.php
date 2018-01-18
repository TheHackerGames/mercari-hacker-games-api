<?php

namespace AppBundle\Request;

use Swagger\Annotations as SWG;

/**
 * @SWG\Definition()
 */
class JobSearch
{
    /**
     * @SWG\Property(
     *     @SWG\Items(type="integer")
     * )
     * @var array
     */
    public $skillIds;

    /**
     * @SWG\Property()
     * @var integer
     */
    public $limit;

    /**
     * @SWG\Property()
     * @var integer
     */
    public $offset;
}
