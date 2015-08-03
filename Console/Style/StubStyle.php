<?php

namespace Smt\Component\Console\Style;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class StubStyle extends AbstractLinuxDistributionStyle
{

    public function __construct()
    {
        parent::__construct(new NullOutput(), new ArrayInput([]));
    }

    /** @inheritdoc */
    protected function getMessageSymbol()
    {
        return '';
    }

    /** @inheritdoc */
    protected function getQuestionHelper()
    {
        return new QuestionHelper();
    }

    /** @inheritdoc */
    protected function customizeFormatter(OutputFormatterInterface $formatter)
    {
        return $formatter;
    }

    /** @inheritdoc */
    public function title($message)
    {
        return $this;
    }

    /** @inheritdoc */
    public function section($message)
    {
        return $this;
    }

    /** @inheritdoc */
    protected function nestedListElement($element, $level = 1)
    {
        return $this;
    }

    /** @inheritdoc */
    public function note($message)
    {
        return $this;
    }

    /** @inheritdoc */
    public function caution($message)
    {
        return $this;
    }

    /** @inheritdoc */
    public function important($message)
    {
        return $this;
    }
}