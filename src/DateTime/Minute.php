<?php
declare(strict_types=1);

/**
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 * Copyright (c) 2018 Yuuki Takezawa
 */

namespace ValueObjects\DateTime;

use ValueObjects\Exception\InvalidNativeArgumentException;
use ValueObjects\Number\Natural;
use ValueObjects\ValueObjectInterface;

/**
 * Class Minute.
 */
class Minute extends Natural
{
    const MIN_MINUTE = 0;

    const MAX_MINUTE = 59;

    public static $format = "i";

    /**
     * Returns a new Minute object.
     *
     * @param int $value
     * @param string    $format
     */
    public function __construct(int $value, string $format = null)
    {
        $this->setFormat($format);

        $options = [
            'options' => ['min_range' => self::MIN_MINUTE, 'max_range' => self::MAX_MINUTE],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['int (>=0, <=59)']);
        }

        parent::__construct($value);
    }

    /**
     * @param  string   $format
     */
    public function setFormat(string $format = null)
    {
        if (isset($format)) {
            self::$format = $format;
        }
    }

    /**
     * Returns a new Minute from native int value.
     *
     * @param ...int $value
     *
     * @return Minute|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns the current minute.
     *
     * @return Minute
     */
    public static function now(): Minute
    {
        $now = new \DateTime('now');
        $minute = \intval($now->format(self::$format));

        return new static($minute);
    }
}
