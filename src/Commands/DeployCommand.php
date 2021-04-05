<?php

namespace Dboro\LaravelStart\Commands;

use Illuminate\Console\Command;

class DeployCommand extends Command
{
    protected $dirs = [
        'frontend/dist',
        'backend/app',
        'backend/database',
        'backend/routes',
        'vendor/dboro'
    ];

    protected $localDir = '/var/www/start';

    protected $remoteDevDir = '/var/www/cinc';

    protected $remoteProdDir = '';

    protected $remoteDir = '/var/www/cinc';

    protected $archive = 'archive.zip';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:deploy {--_env=dev} {--vendor=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function init()
    {
        $options = $this->options();

        if ($options['vendor'] == 1) {
            $this->dirs[] = 'new/vendor';
        }

        if ($options['_env'] == 'prod') {
            $this->remoteDir = $this->remoteProdDir;
        }
    }

    protected function getPathDirs()
    {
        $dirs = [];

        foreach ($this->dirs as $dir) {
            $dirs[] = $this->remoteDir . $dir;
        }

        return $dirs;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->init();
        $this->makeZip();
        $this->send();
    }

    protected function makeZip()
    {
        function addFileRecursion($zip, $dir, $locDir = '')
        {
            if ($objs = glob($dir . '/*')) {
                foreach($objs as $obj) {
                    if (is_dir($obj)) {
                        addFileRecursion($zip, $obj, $locDir);
                    } else {
                        $zip->addFile($obj, str_replace($locDir . '/', '', $obj));
                    }
                }
            }
        }

        $zip = new \ZipArchive();
        $zip->open($this->localDir . '/' . $this->archive, \ZipArchive::CREATE|\ZipArchive::OVERWRITE);

        foreach ($this->dirs as $dir) {
            addFileRecursion($zip,  $this->localDir  . '/'. $dir, $this->localDir);
        }

        $zip->close();
    }

    protected function send()
    {
        $dirs = $this->dirs; //$this->getPathDirs();
        $dirsStr = implode(' ', $dirs);

        $connection = ssh2_connect('88.198.221.105', 22);
        ssh2_auth_password($connection, 'user', 'k8cntr');
        ssh2_exec($connection, 'cd ' . $this->remoteDir . ' && rm -r ' . $dirsStr);

        ssh2_scp_send($connection,
            $this->localDir . '/' . $this->archive,
            $this->remoteDir . '/' . $this->archive);

       ssh2_exec($connection, 'cd ' . $this->remoteDir . ' && unzip ' . $this->archive);

        $stream = ssh2_exec($connection, 'cd ' . $this->remoteDir . '/backend && php artisan migrate && php artisan route:cache');
        stream_set_blocking($stream, true);
        $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
        print_r(stream_get_contents($stream_out));

        ssh2_disconnect($connection);
    }
}
