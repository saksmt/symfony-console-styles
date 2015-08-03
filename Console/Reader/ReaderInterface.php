<?php

namespace Smt\Component\Console\Reader;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;

/**
 * @api
 * @package Smt\Component\Console\Reader
 * Represents interface to interact with user
 */
interface ReaderInterface
{
    /**
     * Asks a question.
     *
     * @param string        $question
     * @param string|null   $default
     * @param callable|null $validator
     *
     * @return string
     * @api
     */
    public function ask($question, $default = null, $validator = null);

    /**
     * Asks a question with the user input hidden.
     *
     * @param string        $question
     * @param callable|null $validator
     *
     * @return string
     * @api
     */
    public function askHidden($question, $validator = null);

    /**
     * Asks for confirmation.
     *
     * @param string $question
     * @param bool   $default
     *
     * @return bool
     * @api
     */
    public function confirm($question, $default = true);

    /**
     * Asks a choice question.
     *
     * @param string          $question
     * @param array           $choices
     * @param string|int|null $default
     *
     * @return string
     * @api
     */
    public function choice($question, array $choices, $default = null);

    /**
     * Sets output formatter.
     *
     * @param OutputFormatterInterface $formatter
     *
     * @api
     */
    public function setFormatter(OutputFormatterInterface $formatter);

    /**
     * Returns current output formatter instance.
     *
     * @return OutputFormatterInterface
     *
     * @api
     */
    public function getFormatter();
}