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
     * @var string
     */
    public $rank;

    /**
     * @SWG\Property()
     * @var integer
     */
    public $military_id;
}
