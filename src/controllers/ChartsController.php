<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\controllers;

use nystudio107\webperf\helpers\Permission as PermissionHelper;

use Craft;
use craft\db\Query;
use craft\helpers\ArrayHelper;
use craft\helpers\UrlHelper;
use craft\web\Controller;

use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
class ChartsController extends Controller
{
    // Constants
    // =========================================================================

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array
     */
    protected $allowAnonymous = [];

    // Public Methods
    // =========================================================================

    /**
     * The Dashboard stats average chart
     *
     * @param int    $days
     * @param string $column
     * @param int    $siteId
     *
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionDashboardStatsAverage(
        int $days = 30,
        string $column = 'pageLoad',
        int $siteId = 0
    ): Response {
        PermissionHelper::controllerPermissionCheck('webperf:dashboard');
        $data = [];
        // Different dbs do it different ways
        $stats = null;
        $db = Craft::$app->getDb();
        if ($db->getIsMysql()) {
            // Query the db
            $query = (new Query())
                ->from('{{%webperf_data_samples}}')
                ->select([
                    'AVG('.$column.') AS avg',
                ])
                ->where("dateUpdated >= ( CURDATE() - INTERVAL '{$days}' DAY )")
                ->andWhere(['not', [$column => null]]);
            if ((int)$siteId !== 0) {
                $query->andWhere(['siteId' => $siteId]);
            }
            $stats = $query->all();
        }
        if ($db->getIsPgsql()) {
            // Query the db
            $query = (new Query())
                ->from('{{%webperf_data_samples}}')
                ->select([
                    'AVG("'.$column.'") AS avg',
                ])
                ->where("\"dateUpdated\" >= ( CURRENT_TIMESTAMP - INTERVAL '{$days} days' )")
                ->andWhere(['not', [$column => null]]);
            if ((int)$siteId !== 0) {
                $query->andWhere(['siteId' => $siteId]);
            }
            $stats = $query->all();
        }
        if ($stats) {
            $data = ArrayHelper::getColumn($stats, 'avg');
        }

        return $this->asJson($data);
    }

    /**
     * The Dashboard stats slowest pages list
     *
     * @param int    $days
     * @param string $column
     * @param int    $limit
     * @param int    $siteId
     *
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionDashboardSlowestPages(
        int $days = 30,
        string $column = 'pageLoad',
        int $limit = 3,
        int $siteId = 0
    ): Response {
        PermissionHelper::controllerPermissionCheck('webperf:dashboard');
        $data = [];
        // Different dbs do it different ways
        $stats = null;
        $db = Craft::$app->getDb();
        if ($db->getIsMysql()) {
            // Query the db
            $query = (new Query())
                ->from('{{%webperf_data_samples}}')
                ->select([
                    'url',
                    'MIN(title) AS title',
                    'COUNT(url) AS cnt',
                    'AVG('.$column.') AS avg',
                ])
                ->where("dateUpdated >= ( CURDATE() - INTERVAL '{$days}' DAY )")
                ->andWhere(['not', [$column => null]]);
            if ((int)$siteId !== 0) {
                $query->andWhere(['siteId' => $siteId]);
            }
            $query
                ->orderBy('avg DESC')
                ->groupBy('url')
                ->limit($limit);
            $stats = $query->all();
        }
        if ($db->getIsPgsql()) {
            // Query the db
            $query = (new Query())
                ->from('{{%webperf_data_samples}}')
                ->select([
                    'url',
                    'MIN("title") AS title',
                    'COUNT(url) AS cnt',
                    'AVG("'.$column.'") AS avg',
                ])
                ->where("\"dateUpdated\" >= ( CURRENT_TIMESTAMP - INTERVAL '{$days} days' )")
                ->andWhere(['not', [$column => null]]);
            if ((int)$siteId !== 0) {
                $query->andWhere(['siteId' => $siteId]);
            }
            $query
                ->orderBy('avg DESC')
                ->groupBy('url')
                ->limit($limit);
            $stats = $query->all();
        }
        if ($stats) {
            // Decode any emojis in the title
            foreach ($stats as &$stat) {
                $stat['detailPageUrl'] = UrlHelper::cpUrl('webperf/page-detail', [
                    'pageUrl' => $stat['url'],
                    'siteId' => $siteId,
                ]);
                if (!empty($stat['title'])) {
                    $stat['title'] = html_entity_decode($stat['title'], ENT_NOQUOTES, 'UTF-8');
                }
            }
            $data = $stats;
        }

        return $this->asJson($data);
    }

    /**
     * The Dashboard chart
     *
     * @param int $days
     *
     * @return Response
     */
    public function actionWidget($days = 1): Response
    {
        $data = [];
        return $this->asJson($data);
    }

    // Protected Methods
    // =========================================================================
}
