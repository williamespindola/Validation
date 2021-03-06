<?php

/*
 * This file is part of Respect/Validation.
 *
 * (c) Alexandre Gomes Gaigalas <alexandre@gaigalas.net>
 *
 * For the full copyright and license information, please view the "LICENSE.md"
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use PHPUnit\Framework\TestCase;
use Respect\Validation\Validatable;

class PrivClass
{
    public const PROPERTY_VALUE = 'foo';

    private $bar = self::PROPERTY_VALUE;
}

/**
 * @group  rule
 * @covers \Respect\Validation\Rules\Attribute
 * @covers \Respect\Validation\Exceptions\AttributeException
 */
class AttributeTest extends TestCase
{
    public function testAttributeWithNoExtraValidationShouldCheckItsPresence(): void
    {
        $validator = new Attribute('bar');
        $obj = new \stdClass();
        $obj->bar = 'foo';
        $validator->check($obj);
        self::assertTrue($validator->__invoke($obj));
        $validator->assert($obj);
    }

    /**
     * @expectedException \Respect\Validation\Exceptions\AttributeException
     */
    public function testAbsentAttributeShouldRaiseAttributeException(): void
    {
        $validator = new Attribute('bar');
        $obj = new \stdClass();
        $obj->baraaaaa = 'foo';
        self::assertFalse($validator->__invoke($obj));
        $validator->assert($obj);
    }

    /**
     * @expectedException \Respect\Validation\Exceptions\ValidationException
     */
    public function testAbsentAttributeShouldRaiseAttributeException_on_check(): void
    {
        $validator = new Attribute('bar');
        $obj = new \stdClass();
        $obj->baraaaaa = 'foo';
        self::assertFalse($validator->__invoke($obj));
        $validator->check($obj);
    }

    /**
     * @dataProvider providerForInvalidAttributeNames
     * @expectedException \Respect\Validation\Exceptions\ComponentException
     */
    public function testInvalidConstructorArgumentsShouldThrowComponentException($attributeName): void
    {
        $validator = new Attribute($attributeName);
    }

    public function providerForInvalidAttributeNames()
    {
        return [
            [new \stdClass()],
            [123],
            [''],
        ];
    }

    public function testExtraValidatorRulesForAttribute(): void
    {
        $subValidator = new Length(1, 3);
        $validator = new Attribute('bar', $subValidator);
        $obj = new \stdClass();
        $obj->bar = 'foo';
        self::assertTrue($validator->__invoke($obj));
        $validator->assert($obj);
        $validator->check($obj);
    }

    /**
     * @expectedException \Respect\Validation\Exceptions\AttributeException
     */
    public function testShouldNotValidateEmptyString(): void
    {
        $subValidator = new Length(1, 3);
        $validator = new Attribute('bar', $subValidator);
        $obj = new \stdClass();
        $obj->bar = 'foo';

        self::assertFalse($validator->__invoke(''));
        $validator->assert('');
    }

    public function testExtraValidatorRulesForAttribute_should_fail_if_invalid(): void
    {
        $subValidator = new Length(1, 3);
        $validator = new Attribute('bar', $subValidator);
        $obj = new \stdClass();
        $obj->bar = 'foo hey this has more than 3 chars';
        self::assertFalse($validator->__invoke($obj));
    }

    /**
     * @expectedException \Respect\Validation\Exceptions\LengthException
     */
    public function testExtraValidatorRulesForAttribute_should_raise_extra_validator_exception_on_check(): void
    {
        $subValidator = new Length(1, 3);
        $validator = new Attribute('bar', $subValidator);
        $obj = new \stdClass();
        $obj->bar = 'foo hey this has more than 3 chars';
        $validator->check($obj);
    }

    /**
     * @expectedException \Respect\Validation\Exceptions\AttributeException
     */
    public function testExtraValidatorRulesForAttribute_should_raise_AttributeException_on_assert(): void
    {
        $subValidator = new Length(1, 3);
        $validator = new Attribute('bar', $subValidator);
        $obj = new \stdClass();
        $obj->bar = 'foo hey this has more than 3 chars';
        $validator->assert($obj);
    }

    public function testNotMandatoryAttributeShouldNotFailWhenAttributeIsAbsent(): void
    {
        $validator = new Attribute('bar', null, false);
        $obj = new \stdClass();
        self::assertTrue($validator->__invoke($obj));
    }

    public function testNotMandatoryAttributeShouldNotFailWhenAttributeIsAbsent_with_extra_validator(): void
    {
        $subValidator = new Length(1, 3);
        $validator = new Attribute('bar', $subValidator, false);
        $obj = new \stdClass();
        self::assertTrue($validator->__invoke($obj));
    }

    public function testPrivateAttributeShouldAlsoBeChecked(): void
    {
        $obj = new PrivClass();

        $validatable = $this->createMock(Validatable::class);
        $validatable
            ->expects($this->once())
            ->method('assert')
            ->with(PrivClass::PROPERTY_VALUE);

        $validator = new Attribute('bar', $validatable);

        $validator->assert($obj);
    }

    public function testPrivateAttributeShouldFailIfNotValid(): void
    {
        $subValidator = new Length(33333, 888888);
        $validator = new Attribute('bar', $subValidator);
        $obj = new PrivClass();
        self::assertFalse($validator->__invoke($obj));
    }
}
