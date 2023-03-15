<?php

namespace App\ValueObjects;

use InvalidArgumentException;

/**
 * 値クラス作成時に意識していること
 *
 * - できる限りイミュータブルにする
 *   - 例ではphp8.2で利用可能になったreadonly classを利用
 * - 値クラスが持つ責務を明確にし、責務に関する処理を値クラスに集約する
 */
readonly class DeleteFile
{
    public string $servicePath;

    /**
     * @param string $servicePath
     */
    public function __construct(string $servicePath)
    {
        //正規表現を含んでいる場合意図しないファイルの削除が発生する可能性があるので許可しない
        if ($this->isContainsRegex($servicePath)) {
            throw new InvalidArgumentException('invalid argument.');
        }
        $this->servicePath = $servicePath;
    }

    /**
     * 正規表現文字を含んでいるか
     *
     * @param string $servicePath
     * @return bool
     */
    private function isContainsRegex(string $servicePath): bool
    {
        return preg_match('/[*.+?{}\[\]|\\\]/', $servicePath);
    }
}
