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
     * Set logger
     *
     * @param LoggerInterface $logger
     *
     * @since 1.01 Method is made public
     * @since 1.00
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

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
     * Log exception
     *
     * @param Exception $e      exception
     * @param string    $action failed action short description
     * @param mixed     $level  log level (default to ERROR)
     *
     * @since x.xx default log level is ERROR
     * @since 1.00
     */
    protected function logException(Exception $e, $action = null, $level = LogLevel::ERROR)
    {
        $message = $action
            ? sprintf('%s failed: %s', $action, $e->getMessage())
            : sprintf('%s: %s', get_class($e), $e->getMessage());
        $this->getLogger()->log($level, $message, ['backtrace' => $e->getTraceAsString()]);
    }
}
