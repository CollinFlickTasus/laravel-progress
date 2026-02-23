<?php

namespace CollinFlickTasus\Progress;

use CollinFlickTasus\Progress\ProgressGrammar;
use Illuminate\Database\Connection;
use Illuminate\Database\Grammar;
use Illuminate\Database\Query\Processors\Processor;

class ProgressConnection extends Connection
{
    /**
     * Get the default query grammar instance.
     *
     * @return Grammar
     */
    protected function getDefaultQueryGrammar()
    {
        $class = $this->config['query_grammar'] ?? ProgressGrammar::class;

        return new $class($this);
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return Grammar
     */
    protected function getDefaultSchemaGrammar()
    {
        $class = $this->config['schema_grammar'] ?? ProgressGrammar::class;

        return new $class($this);
    }

    /**
     * Get the default post processor instance.
     *
     * @return Processor
     */
    protected function getDefaultPostProcessor()
    {
        $class = $this->config['post_processor'] ?? ProgressProcessor::class;

        return new $class;
    }
}