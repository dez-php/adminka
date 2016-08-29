<?php

namespace Adminka;

use Dez\Authorizer\Adapter\Session;
use Dez\Authorizer\Models\Auth\SessionModel;
use Dez\Authorizer\Models\Auth\TokenModel;
use Dez\Authorizer\Models\CredentialModel;
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

        $this->session->start();

        return $this;
    }

    /**
     * @return $this
     */
    public function injection()
    {
        $this->getDi()->set('authorizer', function () {
            CredentialModel::setTableName('admin_credentials');
            SessionModel::setTableName('admin_sessions');
            TokenModel::setTableName('admin_tokens');

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
        $this->router->add('/:action.html', ['controller' => 'index',]);

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
                $this->createErrorResponse($message, $exception->getFile(), $exception->getLine());
            } else {
                $this->createErrorResponse('Debug mode disabled. Message hidden', 'null', 0);
            }
        });

        register_shutdown_function(function () {
            $lastPhpError = error_get_last();
            if (null !== $lastPhpError) {
                $this->response->setStatusCode(403);
                if ($this->config->path('application.debug.php_errors') == 1) {
                    $this->createErrorResponse($this->formatPhpError($lastPhpError),
                        $lastPhpError['file'], $lastPhpError['line']);
                } else {
                    $this->createErrorResponse("Debug mode disabled. Message hidden", 'null', 0);
                }
            }
        });

        return $this;
    }

    /**
     * @param $message
     * @param $file
     * @param $line
     *
     * @return Response
     * @throws \Dez\Http\Exception
     */
    private function createErrorResponse($message, $file = null, $line = null)
    {
        ob_clean();

        $this->view->setRendered(false);
        $this->view->setMainLayout('error');

        $this->view->set('message', $message);
        $this->view->set('location', "$file:$line");

        $this->response
            ->setContent($this->view->render())
            ->setBodyFormat(Response::RESPONSE_HTML)
            ->send();
        die();
    }

    /**
     * @param array $lastPhpError
     * @return string
     */
    private function formatPhpError(array $lastPhpError = [])
    {
        $phpVersion = PHP_VERSION;
        return "PHP {$phpVersion}\n{$this->friendlyErrorType($lastPhpError['type'])} [{$lastPhpError['message']}]";
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