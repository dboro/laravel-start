<?php


namespace Dboro\LaravelStart\Commands;


class StartCopyEntityCommand extends StartCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:copy-entity {from-module} {from-entity} {to-module} {to-entity}';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fromModule = $this->argument('from-module');
        $toModule = $this->argument('to-module');
        $fromEntity = $this->argument('from-entity');
        $toEntity = $this->argument('to-entity');

        $dirs = $this->getDirsType1();

        foreach ($dirs as $suffix => $dir) {

            if (! $this->isDirectory($dir . ucfirst($fromModule))) continue;

            $this->createDirectory($dir . ucfirst($toModule));

            $this->copyFile(
                $dir . ucfirst($fromModule) . '/' . ucfirst($fromEntity) . $suffix,
                $dir . ucfirst($toModule) . '/' . ucfirst($toEntity) . $suffix,
            );
        }

        $dirs = $this->getDirsType2();

        foreach ($dirs as $dir) {

            if (! $this->isDirectory($dir . ucfirst($fromModule). '/' . ucfirst($fromEntity))) continue;

            $this->createDirectory($dir . ucfirst($toModule));
            $this->createDirectory($dir . ucfirst($toModule). '/' . ucfirst($toEntity));

            /* @var \DirectoryIterator $fileInfo */
            foreach ((new \DirectoryIterator($dir . ucfirst($fromModule). '/' . ucfirst($fromEntity))) as $fileInfo) {
                if ($fileInfo->isDot()) {
                    continue;
                }

                $this->copyFile(
                    $fileInfo->getPath() . '/' . $fileInfo->getFilename(),
                    str_replace(
                        [ucfirst($fromModule), ucfirst($fromEntity)],
                        [ucfirst($toModule), ucfirst($toEntity)],
                        $fileInfo->getPath() . '/' . $fileInfo->getFilename())
                );
            }
        }

        $dirs = $this->getDirsType3();

        foreach ($dirs as $dir) {

            if (! $this->isDirectory($dir . $fromModule)) continue;

            $this->createDirectory($dir . $toModule);

            $this->copyFile(
                $dir . $fromModule . '/' . $this->toPlural($fromEntity) . '.js',
                $dir . $toModule . '/' . $this->toPlural($toEntity) . '.js',
            );
        }

        $dirs = $this->getDirsType4();

        foreach ($dirs as $dir) {

            if (! $this->isDirectory($dir . $fromModule. '/' . $this->toPlural($fromEntity))) continue;

            $this->createDirectory($dir . $toModule);
            $this->createDirectory($dir . $toModule. '/' . $this->toPlural($toEntity));

            /* @var \DirectoryIterator $fileInfo */
            foreach ((new \DirectoryIterator($dir . $fromModule . '/' . $this->toPlural($fromEntity))) as $fileInfo) {
                if ($fileInfo->isDot()) {
                    continue;
                }

                if ($fileInfo->isFile()) {
                    $this->copyFile(
                        $fileInfo->getPath() . '/' . $fileInfo->getFilename(),
                        str_replace(
                            [$fromModule, $this->toPlural($fromEntity), ucfirst($this->toPlural($fromEntity))],
                            [$toModule, $this->toPlural($toEntity), ucfirst($this->toPlural($toEntity))],
                            $fileInfo->getPath() . '/' . $fileInfo->getFilename())
                    );
                }

                if ($fileInfo->isDir()) {

                    $subDir = $dir . $fromModule . '/' . $this->toPlural($fromEntity) . '/' . $fileInfo->getFilename();

                    /* @var \DirectoryIterator $subFileInfo */
                    foreach ((new \DirectoryIterator($subDir)) as $subFileInfo) {
                        if ($subFileInfo->isDot()) {
                            continue;
                        }

                        $this->createDirectory($dir . $toModule. '/' . $this->toPlural($toEntity) . '/' . $fileInfo->getFilename());

                        if ($subFileInfo->isFile()) {
                            $this->copyFile(
                                $subFileInfo->getPath() . '/' . $subFileInfo->getFilename(),
                                str_replace(
                                    [$fromModule, $this->toPlural($fromEntity), ucfirst($this->toPlural($fromEntity))],
                                    [$toModule, $this->toPlural($toEntity), ucfirst($this->toPlural($toEntity))],
                                    $subFileInfo->getPath() . '/' . $subFileInfo->getFilename())
                            );
                        }
                    }
                }
            }
        }
    }
}