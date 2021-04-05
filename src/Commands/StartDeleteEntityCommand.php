<?php


namespace Dboro\LaravelStart\Commands;



class StartDeleteEntityCommand extends StartCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:delete-entity {module} {entity?}';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $module = $this->argument('module');
        $entity = $this->argument('entity');

        $dirs1 = $this->getDirsType1();
        $dirs2 = $this->getdirsType2();
        $dirs3 = $this->getDirsType3();
        $dirs4 = $this->getdirsType4();

        if ($entity) {
            foreach ($dirs1 as $suffix => $dir) {
                $fileName = $dir . ucfirst($module) . '/' . ucfirst($entity) . $suffix;
                try {
                    if (file_exists($fileName)) {
                        unlink($fileName);
                        $this->info('Delete file:', $fileName);
                    }
                }
                catch (\Exception $exception) {
                    $this->printError($exception, $fileName);
                }
            }

            foreach ($dirs2 as $dir) {
                $dirName = $dir . ucfirst($module) . '/' . ucfirst($entity) ;
                try {
                    $this->removeDirectory($dirName);
                    $this->info('Delete directory: ' . $dirName);
                }
                catch (\Exception $exception) {
                    $this->printError($exception, $dirName);
                }
            }

            foreach ($dirs3 as $dir) {
                $fileName = $dir . $module . '/' . $this->toPlural($entity) . '.js';
                try {
                    if (file_exists($fileName)) {
                        unlink($fileName);
                        $this->info('Delete file:', $fileName);
                    }
                }
                catch (\Exception $exception) {
                    $this->printError($exception, $fileName);
                }
            }

            foreach ($dirs4 as $dir) {
                $dirName = $dir . $module . '/' . $this->toPlural($entity) ;
                try {
                    $this->removeDirectory($dirName);
                    $this->info('Delete directory: ' . $dirName);
                }
                catch (\Exception $exception) {
                    $this->printError($exception, $dirName);
                }
            }
        }
        else {
            foreach (array_merge($dirs1, $dirs2, $dirs3, $dirs4) as $dir) {
                $dirName = $dir . ucfirst($module);
                try {
                    $this->removeDirectory($dirName);
                    $this->info('Delete directory: ' . $dirName);
                }
                catch (\Exception $exception) {
                    $this->printError($exception, $dirName);
                }
            }
        }
    }

    protected function removeDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->removeDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($dir);
    }
}