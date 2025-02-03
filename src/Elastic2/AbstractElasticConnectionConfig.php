<?php

namespace marksync_libs\Elastic2;
use Pego\PegoClass;

abstract class AbstractElasticConnectionConfig extends PegoClass 
{
    use ElasticHandler;
    use ElasticPegoHandler;

    protected string $host;
    protected int $port;


}