<?php
/**
 * Webperf plugin for Craft CMS 3.x
 *
 * Monitor the performance of your webpages through real-world user timing data
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\webperf\base;

use yii\behaviors\AttributeTypecastBehavior;

/**
 * @author    nystudio107
 * @package   Webperf
 * @since     1.0.0
 */
abstract class DbErrors extends FluentModel
{
    // Traits
    // =========================================================================

    use DbErrorsTrait {
        rules as dbRules;
    }

    // Constants
    // =========================================================================

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            $this->dbRules(),
            [
            ]
        );
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'typecast' => [
                    'class' => AttributeTypecastBehavior::class,
                    // 'attributeTypes' will be composed automatically according to `rules()`
                ],
            ]
        );
    }
}
