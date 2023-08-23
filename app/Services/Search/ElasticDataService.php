<?php

namespace App\Services\Search;

use App\Models\Data;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;

class ElasticDataService implements DataService
{
    /** @var Client; */
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(array $search = []): Collection
    {
        $items = $this->searchOnElasticsearch($search);

        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch(array $search)
    {
        $model = new Data;

        $simpleFields = [
            'bedrooms',
            'bathrooms',
            'storeys',
            'garages',
        ];

        $filledSearch = $this->getSearchFields($search, $simpleFields);

        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                "query" => [
                    'bool' => [
                        'must' => $filledSearch
                    ],
                ],
            ],
        ]);

        return $items;
    }

    private function buildCollection($items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Data::findMany($ids)
            ->sortBy(function ($article) use ($ids) {
                return array_search($article->getKey(), $ids);
            });
    }

    private function getSearchFields(array $search, array $simpleFields): array
    {
        $filledSearch = [];

        if ($name = Arr::get($search, 'name')) {
            $filledSearch[] = [
                'match' => [
                    'name' => [
                        'query' => $name,
                        "fuzziness" => "AUTO",
                        'operator' => 'and'
                    ]
                ]
            ];
        }

        if (isset($search['from']) || isset($search['to'])) {
            $filledSearch[] = [
                'range' => [
                    'price' => [
                        'gte' => Arr::get($search, 'from', 0),
                        'lte' => Arr::get($search, 'to'),
                    ]
                ]
            ];
        }

        foreach ($simpleFields as $field) {
            if ($value = Arr::get($search, $field)) {
                $filledSearch[] = [
                    'term' => [
                        $field => $search[$field]
                    ]
                ];
            }
        }
        return $filledSearch;
    }
}
