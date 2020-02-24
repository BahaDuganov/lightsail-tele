<?php
/*
 */

namespace Redgiant\Search\Cron;

use Redgiant\Search\Helper\Data;
use Redgiant\Search\Model\Config\Source\Reindex;

/**
 * Class Job
 * @package Redgiant\Search\Cron
 */
class Job
{
    /**
     * @var \Redgiant\Search\Helper\Data
     */
    protected $helperData;

    /**
     * Job constructor.
     * @param \Redgiant\Search\Helper\Data $helperData
     */
    public function __construct(Data $helperData)
    {
        $this->helperData = $helperData;
    }

    /**
     * execute cron job
     */
    public function execute()
    {
        $reindexConfig = $this->helperData->getConfigGeneral('reindex_search');
        if ($reindexConfig == Reindex::TYPE_CRON_JOB) {
            $this->helperData->createJsonFile();
        }

        return $this;
    }
}