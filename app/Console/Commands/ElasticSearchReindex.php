<?php

namespace App\Console\Commands;

use App\Models\Data;
use Illuminate\Console\Command;
use Elastic\Elasticsearch\Client;

class ElasticSearchReindex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all Data to Elasticsearch';

    /** @var Client */
    private $elasticsearch;

    /**
     * Create a new command instance.
     *
     * ElasticSearchReindex constructor.
     * @param Client $elasticsearch
     */
    public function __construct(Client $elasticsearch)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Indexing all Data. This might take a while...');

        foreach (Data::cursor() as $item) {
            $this->elasticsearch->index([
                'index' => $item->getSearchIndex(),
                'type' => $item->getSearchType(),
                'id' => $item->getKey(),
                'body' => $item->toSearchArray(),
            ]);
            $this->output->write('.');
        }
        $this->info('\nDone!');
    }
}
