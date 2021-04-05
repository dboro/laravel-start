<?php


namespace Dboro\LaravelStart\Commands;


use Illuminate\Console\Command;

class StartCommand extends Command
{
    protected function isDirectory($path)
    {
        if (file_exists($path)) {
            return true;
        }
        else {
            $this->warn('Do not exist: ' . $path);
            return false;
        }
    }

    protected function createDirectory($path)
    {
        if (! file_exists($path)) {
            try {
                mkdir($path);
                $this->info('Create directory: ' . $path);
            }
            catch (\Exception $exception) {
                $this->printError($exception, $path);
            }
        }
    }

    protected function copyFile($from, $to)
    {
        $fromModule = $this->argument('from-module');
        $toModule = $this->argument('to-module');
        $fromEntity = $this->argument('from-entity');
        $toEntity = $this->argument('to-entity');

        $fromContent = file_get_contents($from);
        $toContent = str_replace(
            array_merge($this->toForms($fromModule), $this->toForms($fromEntity)),
            array_merge($this->toForms($toModule), $this->toForms($toEntity)),
            $fromContent
        );

        try {
            file_put_contents($to, $toContent);
            $this->info('Create file: ' . $to);
        }
        catch (\Exception $exception) {
            $this->printError($exception, $to);
        }
    }

    protected function printError(\Exception $exception, $subject = '')
    {
        $this->warn('---------- Error ---------');
        $this->warn($exception->getMessage());
        if ($subject) {
            $this->warn($subject);
        }
        $this->warn('--------------------------');
    }

    protected function toForms($word)
    {
        return [$word, ucfirst($word), $this->toPlural($word), $this->toPlural(ucfirst($word))];
    }

    protected function toPlural($singular)
    {
        $lastLetter = $singular[strlen($singular) - 1];

        switch($lastLetter) {
            case 'y':
                return substr($singular,0,-1).'ies';
            case 's':
                return $singular.'es';
            default:
                return $singular.'s';
        }
    }

    protected function appDir()
    {
        return config('app.dir');
    }

    protected function frontDir()
    {
        return config('app.front_dir');
    }

    protected function getDirsType1()
    {
        return [
            'Controller.php' => $this->appDir() . '/app/Http/Controllers/',
            'Repository.php' => $this->appDir() . '/app/Repositories/',
            'Resource.php' => $this->appDir() . '/app/Http/Resources/',
        ];
    }

    protected function getDirsType2()
    {
        return [
            $this->appDir() . '/app/Http/Requests/',
            $this->appDir() . '/app/Actions/',
        ];
    }

    protected function getDirsType3()
    {
        return [
            $this->frontDir() . '/store/',
        ];
    }

    protected function getDirsType4()
    {
        return [
            $this->frontDir() . '/pages/',
            $this->frontDir() . '/components/',
        ];
    }
}