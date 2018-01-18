<?php

namespace AppBundle\Request;

use Swagger\Annotations as SWG;

/**
 * @SWG\Definition()
 */
class Job
{
    /**
     * @SWG\Property()
     * @var int
     */
    public $user_id;

    /**
     * @SWG\Property()
     * @var string
     */
    public $title;

    /**
     * @SWG\Property()
     * @var string
     */
    public $description;

    /**
     * @SWG\Property()
     * @var int
     */
    public $salary;

    /**
     * @SWG\Property()
     * @var string
     */
    public $location;
}
