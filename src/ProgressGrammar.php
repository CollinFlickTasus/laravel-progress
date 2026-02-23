<?php

namespace CollinFlickTasus\Progress;

use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar;

class ProgressGrammar extends Grammar
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
    }

    /**
     * Compile the "limit" portions of the query.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param int                                $limit
     *
     * @return string
     */
    protected function compileLimit(Builder $query, $limit)
    {
        return '';
    }

    /**
     * Compile the "select *" portion of the query.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param array                              $columns
     *
     * @return string|null
     */
    protected function compileColumns(Builder $query, $columns)
    {
        // If the query is actually performing an aggregating select, we will let that
        // compiler handle the building of the select clauses, as it will need some
        // more syntax that is best handled by that function to keep things neat.
        if (!is_null($query->aggregate)) {
            return;
        }

        if ($query->distinct) {
            $select = 'select distinct ';
        } else {
            $select = 'select ';
        }

        if ($query->limit) {
            // Only use the TOP sql when there is no OFFSET specified, otherwise we get errors.
            if (!isset($query->offset)) {
                $select .= 'top '.(int) $query->limit.' ';
            }
        }

        return $select.$this->columnize($columns);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param mixed                              $offset
     *
     * @return void
     */
    protected function compileOffset(Builder $query, $offset)
    {
        // When the programmer also specified a limit we are going to OFFSET first and FETCH x amount next
        // When the programmer did not specify any limit we just OFFSET.
        if (isset($query->limit)) {
            return 'OFFSET '.$offset.' ROWS FETCH NEXT '.$query->limit.' ROWS ONLY';
        }

        return 'OFFSET '.$offset.' ROW';
    }

    /**
     * Determine if the grammar support schema transactions.
     *
     * @return bool
     */
    public function supportsSchemaTransactions()
    {
        return false;
    }
}