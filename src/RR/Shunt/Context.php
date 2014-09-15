<?php

/*!
 * PHP Shunting-yard Implementation
 * Copyright 2012 - droptable <murdoc@raidrush.org>
 *
 * PHP 5.4 required
 *
 * Reference: <http://en.wikipedia.org/wiki/Shunting-yard_algorithm>
 *
 * ----------------------------------------------------------------
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without
 * limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to
 * whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * <http://opensource.org/licenses/mit-license.php>
 */

namespace RR\Shunt;

use Exception;
use RR\Shunt\Exception\RuntimeError;

class Context
{
    protected $fnt = array(), $cst = array('PI' => M_PI, 'π' => M_PI);

    public function fn($name, array $args)
    {
        if (!isset($this->fnt[$name])) {
            throw new RuntimeError('run-time error: undefined function "' . $name . '"');
        }

        return (float) call_user_func_array($this->fnt[$name], $args);
    }

    public function cs($name)
    {
        if (!isset($this->cst[$name])) {
            throw new RuntimeError('run-time error: undefined constant "' . $name . '"');
        }

        return $this->cst[$name];
    }

    public function def($name, $value = null, $type = 'float')
    {
        // wrapper for simple PHP functions
        if ($value === null) {
            $value = $name;
        }

        if (is_callable($value) && $type == 'float') {
            $this->fnt[$name] = $value;
        } elseif (is_numeric($value) && $type == 'float') {
            $this->cst[$name] = (float) $value;
        } elseif (is_string($value) && $type == 'string') {
            $this->cst[$name] = $value;
        } else {
            throw new Exception('function or number expected');
        }
    }
}
