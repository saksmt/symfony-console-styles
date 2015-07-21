<?php

namespace Smt\Component\Console\Helper;

use Smt\Component\Console\Style\GentooStyle;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class GentooQuestionHelper extends QuestionHelper
{
    /**
     * {@inheritdoc}
     */
    public function ask(InputInterface $input, OutputInterface $output, Question $question)
    {
        $validator = $question->getValidator();
        $question->setValidator(function ($value) use ($validator) {
            if (null !== $validator && is_callable($validator)) {
                $value = $validator($value);
            }
            if (!is_array($value) && !is_bool($value) && 0 === strlen($value)) {
                throw new \Exception('A value is required.');
            }
            return $value;
        });

        return parent::ask($input, $output, $question);
    }

    /**
     * {@inheritdoc}
     */
    protected function writePrompt(OutputInterface $output, Question $question)
    {
        $text = $question->getQuestion();
        $default = $question->getDefault();

        switch (true) {
            case null === $default:
                break;

            case $question instanceof ConfirmationQuestion:
                $ans = '<success>No</success>/<error>Yes</error>';
                if ($default) {
                    $ans = '<success>Yes</success>/<error>No</error>';
                }
                $text = sprintf('%s [%s] ', $text, $ans);
                break;

            case $question instanceof ChoiceQuestion:
                $choices = $question->getChoices();
                $text = sprintf('%s [<info>%s</info>] ', $text, $choices[$default]);
                break;

            default:
                $text = sprintf('%s [<info>%s</info>]:', $text, $default);
        }

        $output->write(sprintf('<question>>>> %s</question> ', $text));

        if ($question instanceof ChoiceQuestion) {
            $output->writeln('');
            $width = max(array_map('strlen', array_keys($question->getChoices())));

            foreach ($question->getChoices() as $key => $value) {
                $output->writeln(sprintf("  [<info>%-${width}s</info>] %s", $key, $value));
            }
            $output->write(' > ');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function writeError(OutputInterface $output, \Exception $error)
    {
        if ($output instanceof GentooStyle) {
            $output->error($error->getMessage());
            $output->newLine();

            return;
        }

        parent::writeError($output, $error);
    }
}