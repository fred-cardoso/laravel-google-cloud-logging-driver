<?php


namespace FredCardoso\Laravel\Logging\GoogleCloudDriver\Log;

use Google\Cloud\Logging\LoggingClient;
use Monolog\Handler\AbstractProcessingHandler;

/**
 * Class Handler
 *
 * @package     fred-cardoso/laravel-google-cloud-logging-driver
 * @author      Frederico Cardoso <geral@fredcardoso.pt>
 * @license     GPL-3.0-or-later
 *
 */
final class Handler extends AbstractProcessingHandler
{
    /**
     * The Google Cloud Logging logger
     * @var Google\Cloud\Logging\Logger
     */
    private $logger;

    /**
     * Handler constructor
     * @param $labels
     * @param $logName
     * @param int $level
     * @param bool $bubble
     */
    public function __construct($labels, $logName, $level = Logger::DEBUG, $bubble = true)
    {
        $loggerOptions = [
            'labels' => $labels
        ];

        $this->logger = (new LoggingClient())->logger($logName, $loggerOptions);

        parent::__construct($level, $bubble);
    }

    /**
     * @param  array $record
     * @return void
     */
    protected function write(array $record) : void
    {
        $options = [
            'severity' => $record['level_name'],
        ];

        $data = [
            'message' => $record['message'],
        ];

        if ($record['context']) {
            $data['context'] = $record['context'];
        }

        $entry = $this->logger->entry($data, $options);
        $this->logger->write($entry);
    }
}