<?php

namespace Core\Db\Profiler;

interface ProfilerAwareInterface
{
    public function setProfiler(ProfilerInterface $profiler);
}
