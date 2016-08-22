<?php

namespace Adminka;

use Dez\Authorizer\Adapter\Session;
use Dez\Config\Config;
use Dez\Http\Response;
use Dez\Mvc\Application;
use Dez\Mvc\Application\Configurable;
use Dez\Mvc\Controller\MvcException;
use Dez\Mvc\MvcEvent;
use Dez\View\View;

/**
 * @property Session authorizer
 */

class AdminApplication extends Configurable {

    /**
     * AdminApplication constructor.
     */
    public function __construct()
    {
        parent::__construct(Config::factory(include_once __DIR__ . '/config/admin.config.php'));

        if(file_exists($this->config['application']['dev-config'])) {
            $this->config->merge(Config::factory($this->config['application']['dev-config']));
        }
    }

    /**
     * @return $this
     */
    public function initialize()
    {
        $this->configurationErrors()->configurationRoutes();
        $this->setOrmConnectionName($this->config['db']['connection_name']);

        return $this;
    }

    /**
     * @return $this
     */
    public function injection()
    {
        $this->getDi()->set('authorizer', function () {
            $authorizerSession = new Session();
            $authorizerSession->setDi($this->getDi());
            return $authorizerSession->initialize();
        });

        return $this;
    }

    /**
     * @return $this
     */
    private function configurationRoutes()
    {
        /*
        $this->router
            ->add('/:hash', [
                'controller' => 'file',
                'action' => 'index',
            ])->regex('hash', '[a-f0-9]{32}');
        */
        return $this;
    }

    /**
     * @return $this
     */
    private function configurationErrors()
    {
        set_exception_handler(function (\Exception $exception) {
            if ($this->config->path('application.debug.exceptions') == 1) {
                $message = get_class($exception) . ": {$exception->getMessage()}";
                $this->createSystemErrorResponse($message, 'uncaught_exception', $exception->getFile(),
                    $exception->getLine());
            } else {
                $this->createSystemErrorResponse('Debug mode disabled. Message hidden', 'uncaught_exception', 'null', 0);
            }
        });

        register_shutdown_function(function () {
            $lastPhpError = error_get_last();
            if (null !== $lastPhpError && $lastPhpError['type'] === E_ERROR) {
                if ($this->config->path('application.debug.php_errors') == 1) {
                    $this->createSystemErrorResponse($this->formatPhpError($lastPhpError), 'php_fatal_error',
                        $lastPhpError['file'], $lastPhpError['line']);
                } else {
                    $this->createSystemErrorResponse("Debug mode disabled. Message hidden",
                        $this->friendlyErrorType($lastPhpError['type']), 'null', 0);
                }
            }
        });

        $this->event->addListener(MvcEvent::ON_AFTER_APP_RUN, function () {
            $lastPhpError = error_get_last();
            if (null !== $lastPhpError) {
                throw new MvcException($this->formatPhpError($lastPhpError));
            }
        });

        $this->setErrorHandler(function (Application $application) {
            $this->view->set('application', $application);
        });

        return $this;
    }

    /**
     * @param $message
     * @param $type
     * @param $file
     * @param $line
     *
     * @return Response
     * @throws \Dez\Http\Exception
     */
    private function createSystemErrorResponse($message, $type, $file, $line)
    {

        $responseData = [
            'status' => 'error',
            'error_type' => $type,
            'response' => [
                'message' => $message
            ],
            'location' => "{$file}:{$line}"
        ];

        $this->view->setMainLayout('error');
        $this->view->set('data', $responseData);

        $response = new Response(null);

        $this->view->set('response', $response);

        return $response
            ->setStatusCode(503)
            ->setContent($this->view->render())
            ->setDi($this->getDi())
            ->setBodyFormat(Response::RESPONSE_HTML)
            ->send();
    }

    /**
     * @param array $lastPhpError
     * @return string
     */
    private function formatPhpError(array $lastPhpError = [])
    {
        $phpVersion = PHP_VERSION;
        $exceptionMessage = "PHP {$phpVersion}\n{$this->friendlyErrorType($lastPhpError['type'])} [{$lastPhpError['message']}]";
        $exceptionMessage = $exceptionMessage . PHP_EOL . "{$lastPhpError['file']}:{$lastPhpError['line']}";

        return $exceptionMessage;
    }

    /**
     * @param $type
     * @return integer
     */
    private function friendlyErrorType($type)
    {
        $types = [];

        $typeNames = [
            E_ERROR => 'E_ERROR',
            E_WARNING => 'E_WARNING',
            E_PARSE => 'E_PARSE',
            E_NOTICE => 'E_NOTICE',
            E_CORE_ERROR => 'E_CORE_ERROR',
            E_CORE_WARNING => 'E_CORE_WARNING',
            E_COMPILE_ERROR => 'E_COMPILE_ERROR',
            E_COMPILE_WARNING => 'E_COMPILE_WARNING',
            E_USER_ERROR => 'E_USER_ERROR',
            E_USER_WARNING => 'E_USER_WARNING',
            E_USER_NOTICE => 'E_USER_NOTICE',
            E_STRICT => 'E_STRICT',
            E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
            E_DEPRECATED => 'E_DEPRECATED',
            E_USER_DEPRECATED => 'E_USER_DEPRECATED',
        ];

        foreach (array_keys($typeNames) as $phpType) {
            if($type & $phpType) {
                $types[] = $typeNames[$phpType];
            }
        }

        return implode(' & ', $types);
    }

}