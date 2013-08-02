<?php

namespace Core\Db\Profiler;

interface ProfilerInterface
{
    /**
     * @param string|\Core\Db\StatementContainerInterface $target
     * @return mixed
     */
    public function profilerStart($target);
    public function profilerFinish();
}
