<?php

namespace Smt\Component\Console\Writer;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Represents interface to output styled messages
 * @package Smt\Component\Console\Writer
 */
interface WriterInterface
{
    /**
     * Check if verbosity level is quiet
     * @return bool
     * @api
     */
    public function isQuiet();

    /**
     * Check if verbosity level is verbose
     * @return bool
     * @api
     */
    public function isVerbose();

    /**
     * Check if verbosity level is very verbose
     * @return bool
     * @api
     */
    public function isVeryVerbose();

    /**
     * Check if verbosity level is debug
     * @return bool
     * @api
     */
    public function isDebug();

    /**
     * @api
     * Formats a command title.
     * @param string $message
     * @return $this
     */
    public function title($message);

    /**
     * @api
     * Formats a section title.
     * @param string $message
     * @return $this
     */
    public function section($message);

    /**
     * @api
     * Formats message
     * @param string|array $message
     * @param string $type
     * @param string $prefix
     * @return $this
     */
    public function message($message, $type, $prefix = '');

    /**
     * @api
     * Formats informational text.
     * @param string|array $message
     * @return $this
     */
    public function info($message);

    /**
     * @api
     * Formats informational text.
     * @param string|array $message
     * @return $this
     */
    public function text($message);

    /**
     * @api
     * Formats success message
     * @param string|array $message
     * @return $this
     */
    public function success($message);

    /**
     * @api
     * @inheritdoc
     * @return $this
     */
    public function error($message);

    /**
     * @api
     * Formats warning message
     * @param string|array $message
     * @return $this
     */
    public function warning($message);

    /**
     * @api
     * Formats note message
     * @param string|array $message
     * @return $this
     */
    public function note($message);

    /**
     * @api
     * Formats caution message
     * @param string|array $message
     * @return $this
     */
    public function caution($message);

    /**
     * @api
     * Formats important message
     * @param string|array $message
     * @return $this
     */
    public function important($message);

    /**
     * @api
     * Add newline(s).
     * @param int $count The number of newlines
     * @return $this
     */
    public function newLine($count = 1);

    /**
     * Writes a message to the output.
     *
     * @param string|array $messages The message as an array of lines or a single string
     * @param bool         $newline  Whether to add a newline
     * @param int          $type     The type of output (one of the OUTPUT constants)
     *
     * @throws \InvalidArgumentException When unknown output type is given
     *
     * @api
     * @return $this
     */
    public function write($messages, $newline = false, $type = OutputInterface::OUTPUT_NORMAL);

    /**
     * Writes a message to the output and adds a newline at the end.
     *
     * @param string|array $messages The message as an array of lines of a single string
     * @param int          $type     The type of output (one of the OUTPUT constants)
     *
     * @throws \InvalidArgumentException When unknown output type is given
     *
     * @api
     * @return $this
     */
    public function writeln($messages, $type = OutputInterface::OUTPUT_NORMAL);

    /**
     * Gets the current verbosity of the output.
     *
     * @return int The current level of verbosity (one of the VERBOSITY constants)
     *
     * @api
     */
    public function getVerbosity();

    /**
     * Sets the decorated flag.
     *
     * @param bool $decorated Whether to decorate the messages
     *
     * @api
     */
    public function setDecorated($decorated);

    /**
     * Gets the decorated flag.
     *
     * @return bool true if the output will decorate messages, false otherwise
     *
     * @api
     */
    public function isDecorated();

    /**
     * Sets the verbosity of the output.
     *
     * @param int $level The level of verbosity (one of the VERBOSITY constants)
     *
     * @api
     */
    public function setVerbosity($level);

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