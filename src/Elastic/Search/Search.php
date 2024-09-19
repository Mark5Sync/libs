<?php

namespace marksync_libs\Elastic\Search;

use Elastica\Query;
use Elastica\Query\MatchPhrase;
use Elastica\Query\MultiMatch;
use Elastica\Query\Term;
use Elastica\Query\Terms;
use Elastica\Query\Range;
use Elastica\Query\Wildcard;
use Elastica\Query\Prefix;
use Elastica\Query\Exists;
use Elastica\Query\Fuzzy;
use Elastica\Query\BoolQuery;
use Elastica\Query\QueryString;
use Elastica\Query\MatchAll;
use Elastica\Query\Ids;
use Elastica\Query\GeoDistance;
use Elastica\Query\MatchQuery;
use marksync\provider\Mark;
use marksync_libs\Elastic\ElasticIndex;

#[Mark(args: ['parent'])]
class Search
{
    private $request = [];


    function __construct(private ElasticIndex $index) {}

    function fetch()
    {

        $boolQuery = new BoolQuery();

        foreach ($this->request as $query) {
            $boolQuery->addMust($query);
        }

        $query = new Query($boolQuery);
        $results = $this->index->index->index->search($query);

        return $this->index->index->resultToArray($results);
    }



    /**
     * Выполняет точный поиск по указанному полю.
     * Поиск происходит по полному совпадению значения в поле.
     *
     * @param string $field Поле для поиска
     * @param string $query Значение для поиска
     * @return $this
     */
    public function match(string $field, string $query)
    {
        $matchQuery = new MatchQuery();
        $matchQuery->setField($field, $query);
        $this->request[] = $matchQuery;
        return $this;
    }

    /**
     * Выполняет поиск фраз по точному вхождению.
     * Полное соответствие фразы в указанном поле.
     *
     * @param string $field Поле для поиска
     * @param string $phrase Фраза для поиска
     * @return $this
     */
    public function matchPhrase(string $field, string $phrase)
    {
        $matchPhraseQuery = new MatchPhrase();
        $matchPhraseQuery->setField($field, $phrase);
        $this->request[] = $matchPhraseQuery;
        return $this;
    }

    /**
     * Выполняет поиск по нескольким полям.
     * Поиск происходит по указанному значению сразу в нескольких полях.
     *
     * @param string $query Значение для поиска
     * @param array $fields Список полей для поиска
     * @return $this
     */
    public function multiMatch(string $query, array $fields)
    {
        $multiMatchQuery = new MultiMatch();
        $multiMatchQuery->setQuery($query)->setFields($fields);
        $this->request[] = $multiMatchQuery;
        return $this;
    }

    /**
     * Выполняет поиск по точному значению в поле.
     * Ищет документы, где указанное поле точно соответствует значению.
     *
     * @param string $field Поле для поиска
     * @param string $value Значение для поиска
     * @return $this
     */
    public function term(string $field, string $value)
    {
        $termQuery = new Term([$field => $value]);
        $this->request[] = $termQuery;
        return $this;
    }

    /**
     * Выполняет поиск по нескольким точным значениям в поле.
     * Документ должен содержать одно из указанных значений.
     *
     * @param string $field Поле для поиска
     * @param array $values Список значений для поиска
     * @return $this
     */
    public function terms(string $field, array $values)
    {
        $termsQuery = new Terms($field, $values);
        $this->request[] = $termsQuery;
        return $this;
    }

    /**
     * Выполняет поиск по диапазону значений.
     * Используется для поиска документов, значения которых находятся в указанном диапазоне (например, даты или числа).
     *
     * @param string $field Поле для поиска
     * @param array $rangeParams Параметры диапазона (gte, lte и т.д.)
     * @return $this
     */
    public function range(string $field, array $rangeParams)
    {
        $rangeQuery = new Range($field, $rangeParams);
        $this->request[] = $rangeQuery;
        return $this;
    }

    /**
     * Выполняет поиск по шаблону.
     * Шаблон поддерживает использование символов подстановки, например "*".
     *
     * @param string $field Поле для поиска
     * @param string $value Значение с использованием подстановки
     * @return $this
     */
    public function wildcard(string $field, string $value)
    {
        $wildcardQuery = new Wildcard($field, $value);
        $this->request[] = $wildcardQuery;
        return $this;
    }

    /**
     * Выполняет поиск по префиксу.
     * Находит документы, где значение поля начинается с указанного префикса.
     *
     * @param string $field Поле для поиска
     * @param string $value Префикс для поиска
     * @return $this
     */
    public function prefix(string $field, string $value)
    {
        $prefixQuery = new Prefix([$field => $value]);
        $this->request[] = $prefixQuery;
        return $this;
    }

    /**
     * Выполняет поиск по существованию значения в поле.
     * Находит документы, в которых указанное поле существует и не является пустым.
     *
     * @param string $field Поле для проверки на существование
     * @return $this
     */
    public function exists(string $field)
    {
        $existsQuery = new Exists($field);
        $this->request[] = $existsQuery;
        return $this;
    }

    /**
     * Выполняет нечеткий поиск по указанному полю.
     * Ищет документы, значения которых могут содержать небольшие опечатки или отклонения.
     *
     * @param string $field Поле для поиска
     * @param string $value Значение для поиска
     * @param int $fuzziness Уровень нечеткости (по умолчанию 2)
     * @return $this
     */
    public function fuzzy(string $field, string $value, int $fuzziness = 2)
    {
        $fuzzyQuery = new Fuzzy($field, ['value' => $value, 'fuzziness' => $fuzziness]);
        $this->request[] = $fuzzyQuery;
        return $this;
    }

    /**
     * Выполняет сложный булевый запрос.
     * Можно задавать условия must, must_not и should для более гибкого поиска.
     *
     * @param array $must Условия, которые должны быть выполнены
     * @param array $mustNot Условия, которые не должны быть выполнены
     * @param array $should Условия, которые желательно выполнить
     * @return $this
     */
    public function boolQuery(array $must = [], array $mustNot = [], array $should = [])
    {
        $boolQuery = new BoolQuery();

        foreach ($must as $query) {
            $boolQuery->addMust($query);
        }
        foreach ($mustNot as $query) {
            $boolQuery->addMustNot($query);
        }
        foreach ($should as $query) {
            $boolQuery->addShould($query);
        }

        $this->request[] = $boolQuery;
        return $this;
    }

    /**
     * Выполняет текстовый поиск по строке запроса.
     * Использует синтаксис query string, поддерживающий логику операций и фильтры.
     *
     * @param string $query Строка запроса
     * @return $this
     */
    public function queryString(string $query)
    {
        $queryStringQuery = new QueryString($query);
        $this->request[] = $queryStringQuery;
        return $this;
    }

    /**
     * Выполняет поиск всех документов.
     * Возвращает все документы из индекса.
     *
     * @return $this
     */
    public function matchAll()
    {
        $matchAllQuery = new MatchAll();
        $this->request[] = $matchAllQuery;
        return $this;
    }

    /**
     * Выполняет поиск по идентификаторам.
     * Находит документы с указанными ID.
     *
     * @param array $ids Список идентификаторов
     * @return $this
     */
    public function ids(array $ids)
    {
        $idsQuery = new Ids();
        $idsQuery->setIds($ids);
        $this->request[] = $idsQuery;
        return $this;
    }

    /**
     * Выполняет географический поиск по расстоянию.
     * Находит документы, находящиеся в пределах указанного расстояния от координат.
     *
     * @param string $field Поле, содержащее координаты
     * @param array $location Параметры географического поиска (например, расстояние и координаты)
     * @return $this
     */
    public function geoDistance(string $field, array $location, string $distance)
    {
        $geoDistanceQuery = new GeoDistance($field, $location, $distance);
        $this->request[] = $geoDistanceQuery;
        return $this;
    }

    /**
     * Возвращает массив с запросами.
     *
     * @return array Список запросов
     */
    public function getRequest()
    {
        return $this->request;
    }
}