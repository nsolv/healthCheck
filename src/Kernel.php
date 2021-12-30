<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @return string
     */
    public function getCacheDir()
    {
        if (in_array($this->environment, array('vagrant'))) {
            return '/dev/shm/healthCheck/cache/' .  $this->environment;
        }

        return $this->getProjectDir().'/var/cache/'.$this->environment;
    }

    /**
     * @return string
     */
    public function getLogDir()
    {
        if (in_array($this->environment, array('vagrant'))) {
            return '/dev/shm/healthCheck/logs/' . $this->environment;
        }

        return $this->getProjectDir().'/var/log';
    }
}
