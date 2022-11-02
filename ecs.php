<?php declare(strict_types=1);

/*
 * This file is part of the zerai/cf application
 *
 * @copyright (c) Zerai Teclai <teclaizerai@googlemail.com>.
 * @copyright (c) Francesca Bonadonna <francescabonadonna@googlemail.com>.
 *
 * This software consists of voluntary contributions made by many individuals
 * {@link https://github.com/zerai/cf/graphs/contributors developer} and is licensed under the MIT license.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestAnnotationFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/_iam/src',
        __DIR__ . '/_iam/tests',
        __DIR__ . '/_vehiclereporting/src',
        __DIR__ . '/_vehiclereporting/tests',
        __DIR__ . '/ecs.php',
        __DIR__ . '/phparkitect.php',
        __DIR__ . '/phparkitect-iam.php',
        __DIR__ . '/phparkitect-vehiclereporting.php',
    ]);

    $ecsConfig->skip([
        __DIR__ . '/src/Kernel.php',
        __DIR__ . '/tests/bootstrap.php',
        BlankLineAfterOpeningTagFixer::class,
        HeaderCommentFixer::class => [
            __DIR__ . '/tests',
            __DIR__ . '/_iam/tests',
            __DIR__ . '/_vehiclereporting/tests',
        ],
    ]);

    $ecsConfig->rules([
        DeclareStrictTypesFixer::class,
        BlankLineAfterNamespaceFixer::class,
        NoUnusedImportsFixer::class,
        OrderedImportsFixer::class,
        NativeFunctionInvocationFixer::class,
        FullyQualifiedStrictTypesFixer::class,
        StrictComparisonFixer::class,

    ]);

    $ecsConfig->ruleWithConfiguration(ArraySyntaxFixer::class, [
        'syntax' => 'short',
    ]);

    $ecsConfig->sets([
        SetList::SPACES,
        SetList::ARRAY,
        SetList::DOCBLOCK,
        SetList::PSR_12,
        SetList::NAMESPACES,
        SetList::PHPUNIT,
    ]);

    $header = <<<'EOF'
    This file is part of the zerai/cf application
        
    @copyright (c) Zerai Teclai <teclaizerai@googlemail.com>.
    @copyright (c) Francesca Bonadonna <francescabonadonna@googlemail.com>.
        
    This software consists of voluntary contributions made by many individuals
    {@link https://github.com/zerai/cf/graphs/contributors developer} and is licensed under the MIT license.

    For the full copyright and license information, please view the LICENSE
    file that was distributed with this source code.
    EOF;

    $ecsConfig->ruleWithConfiguration(HeaderCommentFixer::class, [
        'comment_type' => 'comment',
        'header' => trim($header),
        'location' => 'after_declare_strict',
        'separate' => 'both',
    ]);
    $ecsConfig->ruleWithConfiguration(PhpUnitTestAnnotationFixer::class, [
        'style' => 'annotation',
    ]);
};
