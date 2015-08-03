<?php

namespace Smt\Component\Console\Style;

use Smt\Component\Console\Helper\GentooQuestionHelper;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * Gentoo distribution style
 * @api
 * @package Smt\Component\Console\Style
 */
class GentooStyle extends AbstractLinuxDistributionStyle
{
    /**
     * @inheritdoc
     */
    public function title($message)
    {
        return $this
            ->writeln('')
            ->writeln(sprintf('<title>%s</title>', $message));
    }

    /**
     * @inheritdoc
     */
    public function section($message)
    {
        return $this
            ->writeln('')
            ->writeln(sprintf('<success>%s</success>', $message));
    }

    /**
     * @inheritdoc
     */
    protected function nestedListElement($element, $level = 1)
    {
        return $this->writeln(sprintf('%s<question>%s</question>', str_repeat(' ', $level * 4), $element));
    }

    /**
     * @inheritdoc
     */
    public function note($message)
    {
        return $this->message($message, 'info', '<info>NOTE: </info>');
    }

    /**
     * @inheritdoc
     */
    public function caution($message)
    {
        return $this->message($message, 'error', '<error>CAUTION: </error>');
    }

    /**
     * @inheritdoc
     */
    public function important($message)
    {
        return $this->message($message, 'warning', '<warning>IMPORTANT: </warning>');
    }

    /**
     * @inheritdoc
     */
    protected function getMessageSymbol()
    {
        return '*';
    }

    /**
     * @inheritdoc
     */
    protected function getQuestionHelper()
    {
        return new GentooQuestionHelper();
    }

    /**
     * @inheritdoc
     */
    protected function customizeFormatter(OutputFormatterInterface $formatter)
    {
        $formatter->setStyle('success', new OutputFormatterStyle('green'));
        $formatter->setStyle('info', new OutputFormatterStyle('cyan'));
        $formatter->setStyle('warning', new OutputFormatterStyle('yellow'));
        $formatter->setStyle('error', new OutputFormatterStyle('red'));
        $formatter->setStyle('question', new OutputFormatterStyle('white', null, ['bold']));
        $formatter->setStyle('title', new OutputFormatterStyle('green', null, ['bold']));
        return $formatter;
    }

    /**
     * @inheritdoc
     */
    protected function addPrefixes(OutputFormatterInterface $formatter)
    {
        $this->prefixes['question'] = $formatter->format('<question>>>></question> ');
    }
}