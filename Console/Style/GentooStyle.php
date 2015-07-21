<?php

namespace Smt\Component\Console\Style;

use Smt\Component\Console\Helper\GentooQuestionHelper;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class GentooStyle extends AbstractLinuxDistributionStyle
{
    /**
     * @inheritdoc
     * @return $this
     */
    public function title($message)
    {
        $this->writeln('');
        $this->writeln(sprintf('<title>%s</title>', $message));
        return $this;
    }

    /**
     * @inheritdoc
     * @return $this
     */
    public function section($message)
    {
        $this->writeln('');
        $this->writeln(sprintf('<success>%s</success>', $message));
        return $this;
    }

    /**
     * @inheritdoc
     * @return $this
     */
    public function listing(array $elements)
    {
        $this->writeln(array_map(function ($element) {
            return sprintf(' <question>%s</question>', $element);
        }, $elements));
        return $this;
    }

    /**
     * @inheritdoc
     * @return $this
     */
    public function note($message)
    {
        $this->message($message, 'info', '<info>NOTE: </info>');
        return $this;
    }

    /**
     * @inheritdoc
     * @return $this
     */
    public function caution($message)
    {
        $this->message($message, 'error', '<error>CAUTION: </error>');
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function important($message)
    {
        $this->message($message, 'warning', '<warning>IMPORTANT: </warning>');
        return $this;
    }

    /**
     * @return string
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
     * @param OutputFormatterInterface $formatter
     * @return OutputFormatterInterface
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