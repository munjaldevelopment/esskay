<?php

declare(strict_types=1);

namespace PackageVersions;

/**
 * This class is generated by ocramius/package-versions, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 */
final class Versions
{
    public const ROOT_PACKAGE_NAME = 'laravel/laravel';
    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    public const VERSIONS          = array (
  'asm89/stack-cors' => 'v2.0.1@23f469e81c65e2fb7fc7bce371fbdc363fe32adf',
  'backpack/backupmanager' => 'v3.0.2@7e8dc4d32238befd7fe78d28c1ddb9e49779f17c',
  'backpack/crud' => '4.1.25@23fb1ed5153d5465d49d2fe1ca265a5985c78877',
  'backpack/filemanager' => '1.1.4@f3fbea46ee3bcb0dcd753d2de8362f955008e0f7',
  'backpack/logmanager' => 'v4.0.2@1ddc98de9f0f9aa9a3a0d338af547052e1aae522',
  'backpack/pagemanager' => '3.0.3@5e5f22ed13d2ecd2f72bc0731cc29a78ebea223f',
  'backpack/permissionmanager' => '6.0.3@2cd6d24b87a3f93da8ab054bef6c1816ac699424',
  'backpack/settings' => '3.0.7@1e004daf818f62c10c64de422a6380e28bc38f06',
  'barryvdh/elfinder-flysystem-driver' => 'v0.2.1@1f323056495fdce019b6ef1621be697f2945c609',
  'barryvdh/laravel-elfinder' => 'v0.4.6@d3bc80dfa61d7bf8e76747ea26615b3f51bc0780',
  'brick/math' => '0.9.1@283a40c901101e66de7061bd359252c013dcc43c',
  'cocur/slugify' => 'v4.0.0@3f1ffc300f164f23abe8b64ffb3f92d35cec8307',
  'creativeorange/gravatar' => 'v1.0.20@8c2c1a3a59fdf05f50c9d9413dd9d2d50835e017',
  'cviebrock/eloquent-sluggable' => '7.0.1@4e5a961965f92ef0e3c10ec4ebc073a6ab6bc4f0',
  'dnoegel/php-xdg-base-dir' => 'v0.1.1@8f8a6e48c5ecb0f991c2fdcf5f154a47d85f9ffd',
  'doctrine/cache' => '1.10.2@13e3381b25847283a91948d04640543941309727',
  'doctrine/dbal' => '2.11.1@6e6903cd5e3a5be60a79439e3ee8fe126f78fe86',
  'doctrine/event-manager' => '1.1.1@41370af6a30faa9dc0368c4a6814d596e81aba7f',
  'doctrine/inflector' => '2.0.3@9cf661f4eb38f7c881cac67c75ea9b00bf97b210',
  'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042',
  'dragonmantank/cron-expression' => 'v2.3.0@72b6fbf76adb3cf5bc0db68559b33d41219aba27',
  'egulias/email-validator' => '2.1.22@68e418ec08fbfc6f58f6fd2eea70ca8efc8cc7d5',
  'fideloper/proxy' => '4.4.0@9beebf48a1c344ed67c1d36bb1b8709db7c3c1a8',
  'fruitcake/laravel-cors' => 'v2.0.2@4b19bfc3bd422948af37a42a62fad7f49025894a',
  'guzzlehttp/guzzle' => '6.5.5@9d4290de1cfd701f38099ef7e183b64b4b7b0c5e',
  'guzzlehttp/promises' => '1.4.0@60d379c243457e073cff02bc323a2a86cb355631',
  'guzzlehttp/psr7' => '1.7.0@53330f47520498c0ae1f61f7e2c90f55690c06a3',
  'intervention/image' => '2.5.1@abbf18d5ab8367f96b3205ca3c89fb2fa598c69e',
  'laravel/framework' => 'v7.28.3@b0942c391975972b1a54b2dc983e33a239f169a9',
  'laravel/tinker' => 'v2.4.2@58424c24e8aec31c3a3ac54eb3adb15e8a0a067b',
  'league/commonmark' => '1.5.5@45832dfed6007b984c0d40addfac48d403dc6432',
  'league/flysystem' => '1.1.3@9be3b16c877d477357c015cec057548cf9b2a14a',
  'league/flysystem-cached-adapter' => '1.1.0@d1925efb2207ac4be3ad0c40b8277175f99ffaff',
  'league/mime-type-detection' => '1.5.0@ea2fbfc988bade315acd5967e6d02274086d0f28',
  'monolog/monolog' => '2.1.1@f9eee5cec93dfb313a38b6b288741e84e53f02d5',
  'nesbot/carbon' => '2.40.1@d9a76d8b7eb0f97cf3a82529393245212f40ba3b',
  'nikic/php-parser' => 'v4.10.2@658f1be311a230e0907f5dfe0213742aff0596de',
  'ocramius/package-versions' => '1.5.1@1d32342b8c1eb27353c8887c366147b4c2da673c',
  'opis/closure' => '3.5.7@4531e53afe2fc660403e76fb7644e95998bff7bf',
  'paragonie/random_compat' => 'v9.99.99@84b4dfb120c6f9b4ff7b3685f9b8f1aa365a0c95',
  'phpoption/phpoption' => '1.7.5@994ecccd8f3283ecf5ac33254543eb0ac946d525',
  'prologue/alerts' => '0.4.8@a6412e318c0171526bc8b25ef597f2cc61f5b800',
  'psr/cache' => '1.0.1@d11b50ad223250cf17b86e38383413f5a6764bf8',
  'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
  'psr/event-dispatcher' => '1.0.0@dbefd12671e8a14ec7f180cab83036ed26714bb0',
  'psr/http-message' => '1.0.1@f6561bf28d520154e4b0ec72be95418abe6d9363',
  'psr/log' => '1.1.3@0f73288fd15629204f9d42b7055f72dacbe811fc',
  'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
  'psy/psysh' => 'v0.10.4@a8aec1b2981ab66882a01cce36a49b6317dc3560',
  'ralouphie/getallheaders' => '3.0.3@120b605dfeb996808c31b6477290a714d356e822',
  'ramsey/collection' => '1.1.1@24d93aefb2cd786b7edd9f45b554aea20b28b9b1',
  'ramsey/uuid' => '4.1.1@cd4032040a750077205918c86049aa0f43d22947',
  'spatie/db-dumper' => '2.17.0@d23bcb566443e862a8dbb6dbd5e8da03aaf98e2a',
  'spatie/laravel-backup' => '6.11.4@3aea94ae9a326871b702ccc358e91683d7782666',
  'spatie/laravel-permission' => '3.17.0@35d40a45e49f5713f477823b571e05ef6a3a0394',
  'spatie/temporary-directory' => '1.2.4@8efe8e61e0ca943d84341f10e51ef3a9606af932',
  'studio-42/elfinder' => '2.1.57@087524b1d7a4d76cfd848dee2093cd8daf987f78',
  'swiftmailer/swiftmailer' => 'v6.2.3@149cfdf118b169f7840bbe3ef0d4bc795d1780c9',
  'symfony/console' => 'v5.1.6@04c3a31fe8ea94b42c9e2d1acc93d19782133b00',
  'symfony/css-selector' => 'v5.1.6@e544e24472d4c97b2d11ade7caacd446727c6bf9',
  'symfony/deprecation-contracts' => 'v2.2.0@5fa56b4074d1ae755beb55617ddafe6f5d78f665',
  'symfony/error-handler' => 'v5.1.6@d2f1d4996d5499f1261164d10080e4120001f041',
  'symfony/event-dispatcher' => 'v5.1.6@d5de97d6af175a9e8131c546db054ca32842dd0f',
  'symfony/event-dispatcher-contracts' => 'v2.2.0@0ba7d54483095a198fa51781bc608d17e84dffa2',
  'symfony/finder' => 'v5.1.6@2c3ba7ad6884e6c4451ce2340e2dc23f6fa3e0d8',
  'symfony/http-client-contracts' => 'v2.2.0@3a5d0fe7908daaa23e3dbf4cee3ba4bfbb19fdd3',
  'symfony/http-foundation' => 'v5.1.6@6cca6b2e4b69fc5bace160d14cf1ee5f71483db4',
  'symfony/http-kernel' => 'v5.1.6@17227644c3c66dcf32bdfeceff4364d090cd6756',
  'symfony/mime' => 'v5.1.6@4404d6545125863561721514ad9388db2661eec5',
  'symfony/polyfill-ctype' => 'v1.18.1@1c302646f6efc070cd46856e600e5e0684d6b454',
  'symfony/polyfill-iconv' => 'v1.18.1@6c2f78eb8f5ab8eaea98f6d414a5915f2e0fce36',
  'symfony/polyfill-intl-grapheme' => 'v1.18.1@b740103edbdcc39602239ee8860f0f45a8eb9aa5',
  'symfony/polyfill-intl-idn' => 'v1.18.1@5dcab1bc7146cf8c1beaa4502a3d9be344334251',
  'symfony/polyfill-intl-normalizer' => 'v1.18.1@37078a8dd4a2a1e9ab0231af7c6cb671b2ed5a7e',
  'symfony/polyfill-mbstring' => 'v1.18.1@a6977d63bf9a0ad4c65cd352709e230876f9904a',
  'symfony/polyfill-php70' => 'v1.18.1@0dd93f2c578bdc9c72697eaa5f1dd25644e618d3',
  'symfony/polyfill-php72' => 'v1.18.1@639447d008615574653fb3bc60d1986d7172eaae',
  'symfony/polyfill-php73' => 'v1.18.1@fffa1a52a023e782cdcc221d781fe1ec8f87fcca',
  'symfony/polyfill-php80' => 'v1.18.1@d87d5766cbf48d72388a9f6b85f280c8ad51f981',
  'symfony/process' => 'v5.1.6@d3a2e64866169586502f0cd9cab69135ad12cee9',
  'symfony/routing' => 'v5.1.6@d36e06eb02a55522a8eed070c1cbc3dc3c389876',
  'symfony/service-contracts' => 'v2.2.0@d15da7ba4957ffb8f1747218be9e1a121fd298a1',
  'symfony/string' => 'v5.1.6@4a9afe9d07bac506f75bcee8ed3ce76da5a9343e',
  'symfony/translation' => 'v5.1.6@e3cdd5119b1b5bf0698c351b8ee20fb5a4ea248b',
  'symfony/translation-contracts' => 'v2.2.0@77ce1c3627c9f39643acd9af086631f842c50c4d',
  'symfony/var-dumper' => 'v5.1.6@c976c115a0d788808f7e71834c8eb0844f678d02',
  'tijsverkoyen/css-to-inline-styles' => '2.2.3@b43b05cf43c1b6d849478965062b6ef73e223bb5',
  'vlucas/phpdotenv' => 'v4.1.8@572af79d913627a9d70374d27a6f5d689a35de32',
  'voku/portable-ascii' => '1.5.3@25bcbf01678930251fd572891447d9e318a6e2b8',
  'backpack/generators' => 'v3.1.3@17a37c917abbee9f86d419914c1a805377018993',
  'doctrine/instantiator' => '1.3.1@f350df0268e904597e3bd9c4685c53e0e333feea',
  'facade/flare-client-php' => '1.3.6@451fadf38e9f635e7f8e1f5b3cf5c9eb82f11799',
  'facade/ignition' => '2.3.8@e8fed9c382cd1d02b5606688576a35619afdf82c',
  'facade/ignition-contracts' => '1.0.1@aeab1ce8b68b188a43e81758e750151ad7da796b',
  'filp/whoops' => '2.7.3@5d5fe9bb3d656b514d455645b3addc5f7ba7714d',
  'fzaninotto/faker' => 'v1.9.1@fc10d778e4b84d5bd315dad194661e091d307c6f',
  'hamcrest/hamcrest-php' => 'v2.0.1@8c3d0a3f6af734494ad8f6fbbee0ba92422859f3',
  'laracasts/generators' => '2.0.0@0b8b3d300cc948217f7547502b6de5db6fbafa70',
  'mockery/mockery' => '1.4.2@20cab678faed06fac225193be281ea0fddb43b93',
  'myclabs/deep-copy' => '1.10.1@969b211f9a51aa1f6c01d1d2aef56d3bd91598e5',
  'nunomaduro/collision' => 'v4.2.0@d50490417eded97be300a92cd7df7badc37a9018',
  'phar-io/manifest' => '1.0.3@7761fcacf03b4d4f16e7ccb606d4879ca431fcf4',
  'phar-io/version' => '2.0.1@45a2ec53a73c70ce41d55cedef9063630abaf1b6',
  'phpdocumentor/reflection-common' => '2.2.0@1d01c49d4ed62f25aa84a747ad35d5a16924662b',
  'phpdocumentor/reflection-docblock' => '5.2.2@069a785b2141f5bcf49f3e353548dc1cce6df556',
  'phpdocumentor/type-resolver' => '1.4.0@6a467b8989322d92aa1c8bf2bebcc6e5c2ba55c0',
  'phpspec/prophecy' => '1.12.1@8ce87516be71aae9b956f81906aaf0338e0d8a2d',
  'phpunit/php-code-coverage' => '7.0.10@f1884187926fbb755a9aaf0b3836ad3165b478bf',
  'phpunit/php-file-iterator' => '2.0.2@050bedf145a257b1ff02746c31894800e5122946',
  'phpunit/php-text-template' => '1.2.1@31f8b717e51d9a2afca6c9f046f5d69fc27c8686',
  'phpunit/php-timer' => '2.1.2@1038454804406b0b5f5f520358e78c1c2f71501e',
  'phpunit/php-token-stream' => '3.1.1@995192df77f63a59e47f025390d2d1fdf8f425ff',
  'phpunit/phpunit' => '8.5.8@34c18baa6a44f1d1fbf0338907139e9dce95b997',
  'scrivo/highlight.php' => 'v9.18.1.2@efb6e445494a9458aa59b0af5edfa4bdcc6809d9',
  'sebastian/code-unit-reverse-lookup' => '1.0.1@4419fcdb5eabb9caa61a27c7a1db532a6b55dd18',
  'sebastian/comparator' => '3.0.2@5de4fc177adf9bce8df98d8d141a7559d7ccf6da',
  'sebastian/diff' => '3.0.2@720fcc7e9b5cf384ea68d9d930d480907a0c1a29',
  'sebastian/environment' => '4.2.3@464c90d7bdf5ad4e8a6aea15c091fec0603d4368',
  'sebastian/exporter' => '3.1.2@68609e1261d215ea5b21b7987539cbfbe156ec3e',
  'sebastian/global-state' => '3.0.0@edf8a461cf1d4005f19fb0b6b8b95a9f7fa0adc4',
  'sebastian/object-enumerator' => '3.0.3@7cfd9e65d11ffb5af41198476395774d4c8a84c5',
  'sebastian/object-reflector' => '1.1.1@773f97c67f28de00d397be301821b06708fca0be',
  'sebastian/recursion-context' => '3.0.0@5b0cd723502bac3b006cbf3dbf7a1e3fcefe4fa8',
  'sebastian/resource-operations' => '2.0.1@4d7a795d35b889bf80a0cc04e08d77cedfa917a9',
  'sebastian/type' => '1.1.3@3aaaa15fa71d27650d62a948be022fe3b48541a3',
  'sebastian/version' => '2.0.1@99732be0ddb3361e16ad77b68ba41efc8e979019',
  'theseer/tokenizer' => '1.2.0@75a63c33a8577608444246075ea0af0d052e452a',
  'webmozart/assert' => '1.9.1@bafc69caeb4d49c39fd0779086c03a3738cbb389',
  'laravel/laravel' => 'No version set (parsed as 1.0.0)@',
);

    private function __construct()
    {
    }

    /**
     * @throws \OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     */
    public static function getVersion(string $packageName) : string
    {
        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new \OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }
}
