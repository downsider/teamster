<?php

namespace Lexide\Teamster\Pool\Pid;

/**
 *
 */
interface PidInterface 
{

    /**
     * @param bool $recheck
     * @return int
     */
    public function getPid($recheck = false);

    /**
     * @return bool
     */
    public function cleanPid();

} 
