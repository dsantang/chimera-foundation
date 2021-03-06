<?php
declare(strict_types=1);

namespace Lcobucci\Chimera\Tests\ReadModelConverter;

use Lcobucci\Chimera\ReadModelConverter\CallbackConverter;

final class CallbackConverterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers \Lcobucci\Chimera\ReadModelConverter\CallbackConverter
     *
     * @uses \Lcobucci\Chimera\Tests\ReadModelConverter\AmazingDomainObject
     * @uses \Lcobucci\Chimera\Tests\ReadModelConverter\FetchStuff
     */
    public function convertShouldNotChangeResultIfMessageIsNotAQuery(): void
    {
        $converter = new CallbackConverter();
        $domainObj = new AmazingDomainObject(1, 'Test');

        /** @var AmazingDomainObject $result */
        $result = $converter->convert(new FetchStuff(1), $domainObj);

        self::assertSame($domainObj, $result);
    }

    /**
     * @test
     *
     * @covers \Lcobucci\Chimera\ReadModelConverter\CallbackConverter
     *
     * @uses \Lcobucci\Chimera\Tests\ReadModelConverter\AmazingDomainObject
     * @uses \Lcobucci\Chimera\Tests\ReadModelConverter\AmazingDto
     * @uses \Lcobucci\Chimera\Tests\ReadModelConverter\AmazingFetchStuff
     */
    public function convertShouldUseTheQueryCallbackToCreateASingleReadModel(): void
    {
        $converter = new CallbackConverter();
        $domainObj = new AmazingDomainObject(1, 'Test');

        /** @var AmazingDto $result */
        $result = $converter->convert(new AmazingFetchStuff(1), $domainObj);

        self::assertInstanceOf(AmazingDto::class, $result);
        self::assertSame($domainObj->id(), $result->id);
        self::assertSame($domainObj->name(), $result->name);
    }

    /**
     * @test
     *
     * @covers \Lcobucci\Chimera\ReadModelConverter\CallbackConverter
     *
     * @uses \Lcobucci\Chimera\Tests\ReadModelConverter\AmazingDomainObject
     * @uses \Lcobucci\Chimera\Tests\ReadModelConverter\AmazingDto
     * @uses \Lcobucci\Chimera\Tests\ReadModelConverter\AmazingFetchStuff
     */
    public function convertShouldUseTheQueryCallbackToCreateMultipleReadModels(): void
    {
        $converter = new CallbackConverter();
        $domainObj = new AmazingDomainObject(1, 'Test');

        /** @var AmazingDto[] $result */
        $result = $converter->convert(new AmazingFetchStuff(1), [$domainObj]);

        self::assertContainsOnlyInstancesOf(AmazingDto::class, $result);
        self::assertCount(1, $result);
    }
}
