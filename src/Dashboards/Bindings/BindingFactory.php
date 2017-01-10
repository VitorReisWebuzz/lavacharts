<?php

namespace Khill\Lavacharts\Dashboards\Bindings;

use \Khill\Lavacharts\Dashboards\Wrappers\ChartWrapper;
use \Khill\Lavacharts\Dashboards\Wrappers\ControlWrapper;
use \Khill\Lavacharts\Exceptions\InvalidBindings;

/**
 * BindingFactory Class
 *
 * Creates new bindings for dashboards.
 *
 * @package   Khill\Lavacharts\Dashboards\Bindings
 * @since     3.0.0
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2017, KHill Designs
 * @link      http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link      http://lavacharts.com                   Official Docs Site
 * @license   http://opensource.org/licenses/MIT      MIT
 */
class BindingFactory
{
    use \Khill\Lavacharts\Support\Traits\ArrayValuesTestTrait;

    /**
     * Create a new Binding for the dashboard.
     *
     * @param  mixed $controlWraps One or array of many ControlWrappers
     * @param  mixed $chartWraps   One or array of many ChartWrappers
     * @throws \Khill\Lavacharts\Exceptions\InvalidBindings
     * @return \Khill\Lavacharts\Dashboards\Bindings\Binding
     */
    public function create($controlWraps, $chartWraps)
    {
        $chartWrapCheck   = $this->arrayValuesTest($chartWraps, 'class', 'ChartWrapper');
        $controlWrapCheck = $this->arrayValuesTest($controlWraps, 'class', 'ControlWrapper');

        if ($controlWraps instanceof ControlWrapper && $chartWraps instanceof ChartWrapper) {
            return new OneToOne($controlWraps, $chartWraps);
        }

        if ($controlWraps instanceof ControlWrapper && $chartWrapCheck) {
            return new OneToMany($controlWraps, $chartWraps);
        }

        if ($controlWrapCheck && $chartWraps instanceof ChartWrapper) {
            return new ManyToOne($controlWraps, $chartWraps);
        }

        if ($controlWrapCheck && $chartWrapCheck) {
            return new ManyToMany($controlWraps, $chartWraps);
        }

        throw new InvalidBindings;
    }
}
