<?php

namespace App\Lemon\Publishers\Resources\Actions;

use App\Lemon\Publishers\Resources\Actions\MakeResource\AddSpacingOnMappingAction;
use App\Lemon\Publishers\Resources\Actions\MakeResource\FormatColumnsMappingAction;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use App\Lemon\Publishers\Resources\Config\FileResources;
use App\Lemon\Publishers\Resources\Config\VariableResource;

class MakeResourceAction
{
    protected string $name;

    protected string $lcName;

    protected string $pluralName;

    protected string $tbName;

    protected string $basePath;

    protected $resource;

    protected $options;

    protected ?string $absolutePath;

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    protected array $columns;

    protected bool $__hasColumns = false;

    protected array $columnConf;

    public function __construct($name, $options)
    {
        $this->name = $name;

        $this->setName($name);
        $this->setLCName($name);
        $this->setTableName($name);
        $this->setPluralName($name);
        $this->setBasePath();

        $this->options = $options;
        $this->files = new Filesystem();

        $this->setHasColumns();

        $this->setColumnConf();
    }

    public function run($fileResource): string
    {
        $folder = $fileResource['folder'];
        $suffix = $fileResource['suffix'];
        $prefix = $fileResource['prefix'];
        $type = $fileResource['type'];

        $this->setAbsolutePath($fileResource);

        $path = $this->getSourceFilePath($folder, $suffix, $prefix);

        $this->makeDirectory(dirname($path));

        $contents = $this->getStubContents(
            $type,
            $this->getStubPath($fileResource['stub']),
            $this->getVariableResources($this->options)
        );

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            return "File : {$path} created";
        } else {
            return "File : {$path} already exits";
        }
    }

    public function multipleResources($command)
    {
        $type = $this->setStubType();
        $files = $this->getFileResources($type);
        foreach ($files as $file) {
            $status = $this->run($file);
            $command->info($status);
        }
    }

    public function setName($name): string
    {
        $this->lcName = ucwords($name);
        return $this->lcName;
    }

    public function setLCName($name): string
    {
        $this->lcName = strtolower($name);
        return $this->lcName;
    }

    public function setPluralName($name): string
    {
        $this->pluralName = ucwords(Str::plural($name));
        return $this->pluralName;
    }
    public function setTableName($name): string
    {
        $plural = Str::plural($name);
        $snake = Str::snake($plural);
        $this->tbName = $snake;
        return $this->tbName;
    }

    public function setStubType()
    {
        if ($this->isVirtualColumn()) {
            return FileResources::VIRTUAL_COLUMNS;
        }

        return FileResources::STANDARD;
    }

    public function setBasePath($path = 'App\\Packages')
    {
        $this->basePath = base_path($path);
    }

    public function setColumnConf()
    {
        if ($this->hasColumns()) {
            $columns = [];
            $unfilteredColumns = $this->getColumns();
            foreach ($unfilteredColumns as $unfilteredColumn) {
                $columns[] = explode(':', $unfilteredColumn);
            }

            $this->columnConf = $columns;
        }
    }

    public function setHasColumns()
    {
        $this->__hasColumns = isset($this->options['columns']);
    }

    public function setAbsolutePath($resource)
    {
        $this->absolutePath = isset($resource['path'])
            ? $resource['path']
            :  null;
    }

    public function isVirtualColumn()
    {
        $hasVirtual = isset($this->options['has_virtual_column']);

        if ($hasVirtual) {
            return boolval($this->options['has_virtual_column']);
        }
        return $hasVirtual;
    }

    public function hasColumns()
    {
        return $this->__hasColumns;
    }

    public function getColumns()
    {
        return $this->options['columns'];
    }

    public function getSourceFilePath($folder, $suffix = '', $prefix = '')
    {
        $fileName = $prefix
            . $this->name
            . $suffix;
        $path = $this->absolutePath
            ? $this->absolutePath . '\\' . $fileName
            : $this->basePath
                . '\\'
                . $this->pluralName
                . "\\{$folder}\\"
                . $fileName;

        logger(['path' => $path, 'absolutePath' => $this->absolutePath]);

        return $path;
    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    public function getStubContents($type, $stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        if ($this->hasColumns()) {
            $columns = (new FormatColumnsMappingAction)(
                $this->tbName,
                $type,
                $this->columnConf
            );

            $columns = (new AddSpacingOnMappingAction)(
                $this->isVirtualColumn()
                    ? FileResources::VIRTUAL_COLUMNS
                    : FileResources::STANDARD
                ,
                $columns,
                $type
            );

            if ($type == 'dto') {
                $columnsDTO = (new FormatColumnsMappingAction)(
                    $this->tbName,
                    'dtoRequest',
                    $this->columnConf
                );

                $columnsDTO = (new AddSpacingOnMappingAction)(
                    FileResources::STANDARD,
                    $columnsDTO,
                    'dtoRequest'
                );

                $contents = $this->mapColumns($contents, $columnsDTO, '# COLUMNS2 #');
            }

            $contents = $this->mapColumns($contents, $columns);
        }

        return $contents;
    }

    public function mapColumns($contents, $columns, $target = null)
    {
        $bind = implode(PHP_EOL, $columns);

        $target = $target ? $target : $this->getTarget();

        $contents = str_replace($target, $target . PHP_EOL . $bind, $contents);

        // remove bind target
        $contents = str_replace($target, "", $contents);

        return $contents;
    }

    public function getStubPath($stubPath)
    {
        return __DIR__ . '/../' . $stubPath;
    }

    protected function getFileResources($type = FileResources::STANDARD)
    {
        return (new FileResources)($type);
    }

    protected function getVariableResources($options)
    {
        return (new VariableResource)($options);
    }

    public function getTarget()
    {
        return $this->target ?? "# COLUMNS #";
    }
}
