<?php

namespace Tests\Unit\ValueObjects;

use InvalidArgumentException;
use App\ValueObjects\DeleteFile;
use PHPUnit\Framework\TestCase;

/**
 * テスト作成時に意識していること
 *
 * - 基本的に正常・異常ケースを分ける
 * - 振る舞いではなく結果に対してテストを書く
 *   - リファクタリング耐性をあげるため
 *   - 振る舞いに関する処理が多く、その処理に多くのケースが存在する場合は振る舞いに対する個別テストを書く
 * - テストケースが多い場合などはdataProviderを利用する
 * - AAAパターンを利用
 * - デグレ防止やドキュメントとしての役割も果たすため、出来てはならないことなどもテストで表現する
 */
class DeleteFileTest extends TestCase
{
    /**
     * 正常ケース
     *
     * @return void
     */
    public function testServicePath(): void
    {
        $expected = 'service-path/files';

        $actual = new DeleteFile($expected);

        $this->assertSame($expected, $actual->servicePath);
    }

    /**
     * エラーケース
     *
     * @param string $servicePath
     * @dataProvider dataServicePath
     */
    public function testServicePathForInvalidArgument(string $servicePath): void
    {
        try {
            new DeleteFile($servicePath);
        } catch (InvalidArgumentException $exception) {
            $this->assertSame('invalid argument.', $exception->getMessage());
            return;
        }

        $this->fail('InvalidArgumentException was not thrown.');
    }

    public static function dataServicePath(): array
    {
        return [
            '*' => [
                'servicePath' => '*',
            ],
            '.*' => [
                'servicePath' => '.*',
            ],
            '[0-9]' => [
                'servicePath' => '[0-9]',
            ],
            '[' => [
                'servicePath' => '[',
            ],
            ']' => [
                'servicePath' => ']',
            ],
            '{' => [
                'servicePath' => '{',
            ],
            '\\' => [
                'servicePath' => '\\',
            ],
            '*/' => [
                'servicePath' => '*/',
            ],
        ];
    }
}
