<?php

namespace AppBundle\Request;

use Swagger\Annotations as SWG;

/**
 * @SWG\Definition()
 */
class Rank
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
    public $military_id;
}
