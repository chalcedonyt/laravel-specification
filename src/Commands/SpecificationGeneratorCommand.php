<?php namespace Chalcedonyt\Specification\Commands;

use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem as File;
use Illuminate\View\Factory as View;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class SpecificationGeneratorCommand
 *
 * @package Chalcedony\Specification\Commands
 */
class SpecificationGeneratorCommand extends Command
{

    const NO_CLASS_SPECIFIED = 'mixed';
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:specification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new specification class';
    /**
     * @var
     */
    private $view;
    /**
     * @var
     */
    private $namespace;
    /**
     * @var
     */
    private $directory;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var File
     */
    private $file;

    /**
     * @param View $view
     */
    function __construct(Config $config, View $view, File $file)
    {
        parent::__construct();
        $this->config = $config;
        $this->view = $view;
        $this->file = $file;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {

            // replace all space after ucwords
            $classname = preg_replace('/\s+/', '', ucwords($this->argument('name')));


            //retrieves store directory configuration
            $directory = $this->option('directory') ? $this->appPath($this->option('directory')) : $this->appPath($this->config->get('specification.directory'));

            //retrieves namespace configuration
            $namespace = $this->option('namespace') ? $this->option('namespace') : $this->config->get('specification.namespace');
            is_dir($directory) ?: $this->file->makeDirectory($directory, 0755, true);

            $create = true;
            $object_class = $this->ask("[optional] What type should the candidate passed to isSatisfiedBy be? E.g. \App\User",
                self::NO_CLASS_SPECIFIED );

            $object_variable = '$candidate';
            if( $object_class != self::NO_CLASS_SPECIFIED ){
                /**
                 * Extract the last element of the class after "\", e.g. App\User -> $user    
                 */
                $derive_variable_name = function() use ($object_class){
                    $parts = explode("\\", $object_class);
                    return end( $parts );
                };
                $object_variable = '$'.strtolower( $derive_variable_name() );
            }
            if ($this->file->exists("{$directory}/{$classname}.php")) {
                if ($usrResponse = strtolower($this->ask("The file ['{$classname}'] already exists, overwrite? [y/n]",
                    null))
                ) {
                    switch ($usrResponse) {
                        case 'y' :
                            $tempFileName = "{$directory}/{$classname}.php";

                            $prefix = '_';
                            while ($this->file->exists($tempFileName)) {
                                $prefix .= '_';
                                $tempFileName = "{$directory}/{$prefix}{$classname}.php";
                            }
                            rename("{$directory}/{$classname}.php", $tempFileName);
                            break;
                        default:
                            $this->info('No file has been created.');
                            $create = false;
                    }
                }

            }

            // loading template from views
            $view = $this->view->make('specification::specification',
                ['namespace' => $namespace,
                'classname' => $classname,
                'object_class' => $object_class,
                'object_variable' => $object_variable ]);


            if ($create) {
                $this->file->put("{$directory}/{$classname}.php", $view->render());
                $this->info("The class {$classname} generated successfully.");
            }


        } catch (\Exception $e) {
            $this->error('Specification creation failed: '.$e -> getMessage());
        }


    }

    /**
     * get application path
     *
     * @param $path
     *
     * @return string
     */
    private function appPath($path)
    {
        return base_path('/app/' . $path);
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'Name of the specification class'),
        );
    }

    /**
     * @return array
     */
    protected function getOptions()
    {

        return array(
            array(
                'directory',
                null,
                InputOption::VALUE_OPTIONAL,
                'specification store directory (relative to App\)',
                null
            ),
            array(
                'namespace',
                null,
                InputOption::VALUE_OPTIONAL,
                'specification namespace',
                null
            ),
        );
    }


}
