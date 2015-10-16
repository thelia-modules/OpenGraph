<?php

namespace OpenGraph\Model\Base;

use \Exception;
use \PDO;
use OpenGraph\Model\OpengraphData as ChildOpengraphData;
use OpenGraph\Model\OpengraphDataQuery as ChildOpengraphDataQuery;
use OpenGraph\Model\Map\OpengraphDataTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'opengraph_data' table.
 *
 *
 *
 * @method     ChildOpengraphDataQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOpengraphDataQuery orderByCompanyName($order = Criteria::ASC) Order by the company_name column
 * @method     ChildOpengraphDataQuery orderByTwitterCompanyName($order = Criteria::ASC) Order by the twitter_company_name column
 *
 * @method     ChildOpengraphDataQuery groupById() Group by the id column
 * @method     ChildOpengraphDataQuery groupByCompanyName() Group by the company_name column
 * @method     ChildOpengraphDataQuery groupByTwitterCompanyName() Group by the twitter_company_name column
 *
 * @method     ChildOpengraphDataQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOpengraphDataQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOpengraphDataQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOpengraphData findOne(ConnectionInterface $con = null) Return the first ChildOpengraphData matching the query
 * @method     ChildOpengraphData findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOpengraphData matching the query, or a new ChildOpengraphData object populated from the query conditions when no match is found
 *
 * @method     ChildOpengraphData findOneById(int $id) Return the first ChildOpengraphData filtered by the id column
 * @method     ChildOpengraphData findOneByCompanyName(string $company_name) Return the first ChildOpengraphData filtered by the company_name column
 * @method     ChildOpengraphData findOneByTwitterCompanyName(string $twitter_company_name) Return the first ChildOpengraphData filtered by the twitter_company_name column
 *
 * @method     array findById(int $id) Return ChildOpengraphData objects filtered by the id column
 * @method     array findByCompanyName(string $company_name) Return ChildOpengraphData objects filtered by the company_name column
 * @method     array findByTwitterCompanyName(string $twitter_company_name) Return ChildOpengraphData objects filtered by the twitter_company_name column
 *
 */
abstract class OpengraphDataQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \OpenGraph\Model\Base\OpengraphDataQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\OpenGraph\\Model\\OpengraphData', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOpengraphDataQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOpengraphDataQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \OpenGraph\Model\OpengraphDataQuery) {
            return $criteria;
        }
        $query = new \OpenGraph\Model\OpengraphDataQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildOpengraphData|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OpengraphDataTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OpengraphDataTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildOpengraphData A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, COMPANY_NAME, TWITTER_COMPANY_NAME FROM opengraph_data WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildOpengraphData();
            $obj->hydrate($row);
            OpengraphDataTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildOpengraphData|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildOpengraphDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OpengraphDataTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildOpengraphDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OpengraphDataTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOpengraphDataQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(OpengraphDataTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OpengraphDataTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OpengraphDataTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the company_name column
     *
     * Example usage:
     * <code>
     * $query->filterByCompanyName('fooValue');   // WHERE company_name = 'fooValue'
     * $query->filterByCompanyName('%fooValue%'); // WHERE company_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $companyName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOpengraphDataQuery The current query, for fluid interface
     */
    public function filterByCompanyName($companyName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($companyName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $companyName)) {
                $companyName = str_replace('*', '%', $companyName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OpengraphDataTableMap::COMPANY_NAME, $companyName, $comparison);
    }

    /**
     * Filter the query on the twitter_company_name column
     *
     * Example usage:
     * <code>
     * $query->filterByTwitterCompanyName('fooValue');   // WHERE twitter_company_name = 'fooValue'
     * $query->filterByTwitterCompanyName('%fooValue%'); // WHERE twitter_company_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $twitterCompanyName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOpengraphDataQuery The current query, for fluid interface
     */
    public function filterByTwitterCompanyName($twitterCompanyName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($twitterCompanyName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $twitterCompanyName)) {
                $twitterCompanyName = str_replace('*', '%', $twitterCompanyName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OpengraphDataTableMap::TWITTER_COMPANY_NAME, $twitterCompanyName, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOpengraphData $opengraphData Object to remove from the list of results
     *
     * @return ChildOpengraphDataQuery The current query, for fluid interface
     */
    public function prune($opengraphData = null)
    {
        if ($opengraphData) {
            $this->addUsingAlias(OpengraphDataTableMap::ID, $opengraphData->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the opengraph_data table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OpengraphDataTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OpengraphDataTableMap::clearInstancePool();
            OpengraphDataTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildOpengraphData or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildOpengraphData object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OpengraphDataTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OpengraphDataTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        OpengraphDataTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OpengraphDataTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // OpengraphDataQuery
