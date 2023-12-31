<?php declare(strict_types=1);
/*
 * This file is part of phpcov.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianBergmann\PHPCOV;

use SebastianBergmann\Version;
use Symfony\Component\Console\Application as AbstractApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * TextUI frontend for php-code-coverage.
 */
class Application extends AbstractApplication
{
    public function __construct()
    {
        $version = new Version('6.0.1', \dirname(__DIR__));
        parent::__construct('phpcov', $version->getVersion());

        $this->add(new ExecuteCommand);
        $this->add(new MergeCommand);
        $this->add(new PatchCoverageCommand);
    }

    /**
     * Runs the current application.
     *
     * @param InputInterface  $input  An Input instance
     * @param OutputInterface $output An Output instance
     *
     * @return int 0 if everything went fine, or an error code
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        if (!$input->hasParameterOption('--quiet')) {
            $output->write(
                \sprintf(
                    "phpcov %s by Sebastian Bergmann.\n\n",
                    $this->getVersion()
                )
            );
        }

        if ($input->hasParameterOption('--version') ||
            $input->hasParameterOption('-V')) {
            exit;
        }

        parent::doRun($input, $output);
    }
}
