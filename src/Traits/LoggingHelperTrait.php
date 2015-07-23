<?php
/**
 * Class helpers
 */
namespace Mekras\ClassHelpers\Traits;

use Exception;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;

/**
 * Logging helper
 *
 * - Logger setter/getter.
 * - getLogger return NullLogger when no logger set — you can omit logger checks.
 * - Shortcut method to log exceptions.
 *
 * @since 1.00
 */
trait LoggingHelperTrait
{
    /**
     * Logger
     *
     * @var LoggerInterface|null
     */
    private $logger = null;

    /**
     * Return logger
     *
     * @return LoggerInterface
     *
     * @since 1.00
     */
    protected function getLogger()
    {
        if (!$this->logger instanceof LoggerInterface) {
            $this->logger = new NullLogger();
        }

        return $this->logger;
    }

    /**
     * Set logger
     *
     * @param LoggerInterface $logger
     *
     * @since 1.00
     */
    protected function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Log exception
     *
     * @param Exception $e      exception
     * @param string    $action failed action short description
     * @param mixed     $level  log level
     *
     * @since 1.00
     */
    protected function logException(Exception $e, $action = null, $level = LogLevel::CRITICAL)
    {
        $message = $action
            ? sprintf('%s failed: %s', $action, $e->getMessage())
            : sprintf('%s: %s', get_class($e), $e->getMessage());
        $this->getLogger()->log($level, $message, ['backtrace' => $e->getTraceAsString()]);
    }
}
