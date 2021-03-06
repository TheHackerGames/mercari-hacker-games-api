<?php

namespace AppBundle\Request;

use Swagger\Annotations as SWG;

/**
 * @SWG\Definition()
 */
class User
{
    /**
     * @SWG\Property()
     * @var string
     */
    public $name;

    /**
     * @SWG\Property()
     * @var int
     */
    public $rank_id;

    /**
     * @SWG\Property()
     * @var integer
     */
    public $military_id;
}
