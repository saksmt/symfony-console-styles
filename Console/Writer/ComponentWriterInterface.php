<?php

namespace Smt\Component\Console\Writer;

use Smt\Component\Console\Style\ImprovedStyleInterface;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Represents interface to output complex ui-components
 * @api
 * @package Smt\Component\Console\Writer
 */
interface ComponentWriterInterface
{
    /**
     * @api
     * Formats a list
     * @param array $elements Can be nested
     * @return $this
     */
    public function listing(array $elements);

    /**
     * @api
     * Formats list at some level of nesting
     * @param array $elements Elements, can be nested
     * @param int $level Nesting level
     * @return $this
     */
    public function nestedList(array $elements, $level = 1);

    /**
     * @api
     * Formats a table
     * @param array $headers
     * @param array $rows
     * @return $this
     */
    public function table(array $headers, array $rows);

    /**
     * @api
     * Starts the progress output
     * @param int $max Maximum steps (0 if unknown)
     * @return $this
     */
    public function progressStart($max = 0);

    /**
     * @api
     * Advances the progress output X steps
     * @param int $step Number of steps to advance
     * @return $this
     */
    public function progressAdvance($step = 1);

    /**
     * @api
     * Finishes the progress output
     * @return $this
     */
    public function progressFinish();

    /**
     * @api
     * @inheritdoc
     */
    public function createProgressBar($max = 0);

    /**
     * @api
     * @return ProgressBar
     */
    public function getProgressBar();

    public function setFormatter(OutputFormatterInterface $formatter);

    public function getFormatter();
}