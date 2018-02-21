<?php

namespace Lexide\Teamster\Pool\Pid;

/**
 *
 */
interface PidFactoryInterface 
{

    /**
     * @param string $pidFile
     * @param int|null $pid
     * @return PidInterface
     */
    public function create($pidFile, $pid = null);

    /**
     * @param string $command
     * @return string
     */
    public function generatePidFileName($command);

} 
