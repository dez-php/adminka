<?php

namespace Adminka;

use Adminka\Core\Module\ModuleException;
use Adminka\Core\Module\ModuleInitializerInterface;
use Adminka\Core\Template\ExtensionCore;
use Dez\Authorizer\Adapter\Session;
use Dez\Authorizer\Models\Auth\SessionModel;
use Dez\Authorizer\Models\Auth\TokenModel;
use Dez\Authorizer\Models\CredentialModel;
use Dez\Config\Config;
use Dez\DependencyInjection\Service;
use Dez\Http\Response;
use Dez\Mvc\Application;

/**
 * @property Session authorizer
 */

class AdminApplication extends Application\ConfigurableApplication {

    /**
     * AdminApplication constructor.
     */
    public function __construct()
    {
        parent::__construct(Config::factory(include_once __DIR__ . '/config/admin.config.php'));

        if(file_exists($this->config->path('application/dev-config', '/'))) {
            $this->config->merge(Config::factory($this->config->path('application/dev-config', '/')));
        }
    }

    /**
     * @return $this
     * @throws ModuleException
     */
    public function initialize()
    {
        $this->configurationErrors()->configurationRoutes();
        $this->view->registerExtension(new ExtensionCore());
        $this->session->start();
        $this->loadModules();
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
     * @return string
     */
    public function memoryUsage()
    {
        $names = ['B', 'K', 'M', 'G', 'T'];
        $bytes = memory_get_usage();
        $scale = (integer) log($bytes, 1024);

        return round($bytes / pow(1024, $scale), 2) . $names[$scale];
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
     * @throws ModuleException
     */
    private function loadModules()
    {
        $iterator = new \DirectoryIterator($this->config->path('application.module.root_directory'));

        foreach($iterator as $directory) {
            $initializerFile = realpath("{$directory->getPathname()}/Initializer.php");
            if(false !== $initializerFile) {
                $module = include_once $initializerFile;
                if(is_object($module)) {
                    if(!($module instanceof ModuleInitializerInterface)) {
                        throw new ModuleException('Initializer was found but it not implemented :interface', [
                            'interface' => ModuleInitializerInterface::class
                        ]);
                    } else {
                        $module->setDi($this->getDi());
                        $module->initialize();
                        $this->view->data()->push('modules', $module);
                    }
                } else {
                    throw new ModuleException('Initializer file [:file] should return object but it null given', [
                        'file' => $initializerFile
                    ]);
                }
            }
        }

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

        $this->view->batch([
            'message' => $message,
            'memory' => $this->memoryUsage(),
            'location' => "$file:$line",
        ]);

        /** @var Service $service */
        foreach($this->getDi() as $service) {
            $this->view->set($service->getName(), $this->getDi()->get($service->getName()));
        }

        $this->response
            ->setContent($this->view->render('error'))
            ->setBodyFormat(Response::RESPONSE_HTML)
            ->send();

        die;
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